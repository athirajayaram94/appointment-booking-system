<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    /**
     * Display appointments for administrators and customers.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | ADMIN APPOINTMENT LIST
        |--------------------------------------------------------------------------
        */

        if (strtolower(trim($user->role ?? '')) === 'admin') {

            $query = Appointment::with(['customer', 'slot']);

            // Filter by appointment status.
            $allowedStatuses = [
                'Pending',
                'Approved',
                'Rejected',
                'Cancelled',
                'Completed',
            ];

            if (
                $request->filled('status') &&
                in_array($request->status, $allowedStatuses, true)
            ) {
                $query->where('status', $request->status);
            }

            // Filter by starting date.
            if ($request->filled('start_date')) {
                $request->validate([
                    'start_date' => 'nullable|date',
                ]);

                $startDate = $request->input('start_date');

                $query->whereHas('slot', function ($slotQuery) use ($startDate) {
                    $slotQuery->whereDate('date', '>=', $startDate);
                });
            }

            // Filter by ending date.
            if ($request->filled('end_date')) {
                $request->validate([
                    'end_date' => 'nullable|date|after_or_equal:start_date',
                ]);

                $endDate = $request->input('end_date');

                $query->whereHas('slot', function ($slotQuery) use ($endDate) {
                    $slotQuery->whereDate('date', '<=', $endDate);
                });
            }

            // Search by customer name or email.
            if ($request->filled('customer')) {

                $customerSearch = trim($request->input('customer'));

                $query->whereHas('customer', function ($customerQuery) use ($customerSearch) {

                    $customerQuery->where('name', 'like', '%' . $customerSearch . '%')
                        ->orWhere('email', 'like', '%' . $customerSearch . '%');

                });
            }

            // Newest appointments first, 10 per page.
            $appointments = $query
                ->orderByDesc('created_at')
                ->paginate(10)
                ->withQueryString();

            return view('appointments.index', compact('appointments'));
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER APPOINTMENTS
        |--------------------------------------------------------------------------
        */

        // Upcoming Pending and Approved appointments belonging to this customer.
        $upcomingAppointments = Appointment::with(['slot'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['Pending', 'Approved'])
            ->whereHas('slot', function ($query) {

                $query->whereDate('date', '>', today())
                    ->orWhere(function ($todayQuery) {

                        $todayQuery->whereDate('date', today())
                            ->where('start_time', '>=', now()->format('H:i:s'));

                    });

            })
            ->orderByDesc('created_at')
            ->get();

        // Number of appointments waiting for approval.
        $pendingRequests = Appointment::where('user_id', $user->id)
            ->where('status', 'Pending')
            ->count();

        // Previous appointments, including appointments whose scheduled
        // time has passed, even if their status is still Pending or Approved.
        $appointmentHistory = Appointment::with(['slot'])
            ->where('user_id', $user->id)
            ->where(function ($query) {

                $query->whereIn('status', [
                    'Rejected',
                    'Cancelled',
                    'Completed',
                ])
                ->orWhereHas('slot', function ($slotQuery) {

                    $slotQuery->whereDate('date', '<', today())
                        ->orWhere(function ($todayQuery) {

                            $todayQuery->whereDate('date', today())
                                ->where('start_time', '<', now()->format('H:i:s'));

                        });

                });

            })
            ->orderByDesc('created_at')
            ->get();

        return view('appointments.index', compact(
            'upcomingAppointments',
            'pendingRequests',
            'appointmentHistory'
        ));
    }


    /**
     * Display the appointment booking form.
     */
    public function create()
{
    $slots = AppointmentSlot::withCount([
        'appointments as active_bookings_count' => function ($query) {
            $query->whereIn('status', ['Pending', 'Approved']);
        }
    ])
        ->whereDate('date', '>=', today())
        ->orderBy('date')
        ->orderBy('start_time')
        ->get();

    return view('appointments.create', compact('slots'));
}


    /**
     * Create a new appointment request.
     */
      public function store(Request $request)
{
    $validated = $request->validate([
        'slot_id' => 'required|integer|exists:appointment_slots,id',
        'reason' => 'required|string|max:1000',
    ]);

    DB::transaction(function () use ($validated) {

        $slot = AppointmentSlot::whereKey($validated['slot_id'])
            ->lockForUpdate()
            ->firstOrFail();

        // Check whether the slot is active.
        if (!$slot->is_available || !$slot->date) {
            throw ValidationException::withMessages([
                'slot_id' => 'This appointment slot is unavailable.',
            ]);
        }

        // Check whether the appointment date and time are in the future.
        $slotStart = \Carbon\Carbon::parse(
            $slot->date->format('Y-m-d') . ' ' . $slot->start_time
        );

        if ($slotStart->lte(now())) {
            throw ValidationException::withMessages([
                'slot_id' => 'You cannot book an appointment for a past date or time.',
            ]);
        }

        // Count existing pending and approved bookings.
        $bookingCount = $slot->appointments()
            ->whereIn('status', ['Pending', 'Approved'])
            ->count();

        // Check whether the slot has reached its capacity.
if ($bookingCount >= $slot->capacity) {
    throw ValidationException::withMessages([
        'slot_id' => 'Sorry, this appointment slot has just become unavailable. Please select another slot.',
    ]);
}

// Prevent the same customer from booking the same slot twice.
$alreadyBooked = $slot->appointments()
    ->where('user_id', auth()->id())
    ->whereIn('status', ['Pending', 'Approved'])
    ->exists();

if ($alreadyBooked) {
    throw ValidationException::withMessages([
        'slot_id' => 'You have already booked this appointment slot.',
    ]);
}

        Appointment::create([
            'user_id' => auth()->id(),
            'slot_id' => $slot->id,
            'reason' => $validated['reason'],
            'status' => 'Pending',
            'rejection_reason' => null,
        ]);

    }, 3);

    return redirect()
        ->route('appointments.index')
        ->with('success', 'Appointment request submitted successfully!');
}


    /**
     * Approve a pending appointment.
     * Admin only.
     */
    public function approve(Appointment $appointment)
    {
        $this->ensureAdmin();

        DB::transaction(function () use ($appointment) {

            $lockedAppointment = Appointment::whereKey($appointment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedAppointment->status !== 'Pending') {
                throw ValidationException::withMessages([
                    'status' => 'Only pending appointments can be approved.',
                ]);
            }

            $lockedAppointment->update([
                'status' => 'Approved',
                'rejection_reason' => null,
            ]);
        }, 3);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment approved successfully.');
    }


    /**
     * Reject a pending appointment.
     * Admin only. A rejection reason is mandatory.
     */
    public function reject(Request $request, Appointment $appointment)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        DB::transaction(function () use ($appointment, $validated) {

            $lockedAppointment = Appointment::whereKey($appointment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedAppointment->status !== 'Pending') {
                throw ValidationException::withMessages([
                    'status' => 'Only pending appointments can be rejected.',
                ]);
            }

            $lockedAppointment->update([
                'status' => 'Rejected',
                'rejection_reason' => $validated['rejection_reason'],
            ]);
        }, 3);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment rejected successfully.');
    }


    /**
     * Cancel an appointment.
     * Customers can cancel only their own Pending or Approved appointments.
     */
    public function cancel(Appointment $appointment)
    {
        DB::transaction(function () use ($appointment) {

            $lockedAppointment = Appointment::whereKey($appointment->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Ensure the customer owns the appointment.
            if ((int) $lockedAppointment->user_id !== (int) auth()->id()) {
                abort(403, 'You cannot cancel another customer\'s appointment.');
            }

            if (!in_array(
                $lockedAppointment->status,
                ['Pending', 'Approved'],
                true
            )) {
                throw ValidationException::withMessages([
                    'status' => 'Only pending or approved appointments can be cancelled.',
                ]);
            }

            $lockedAppointment->update([
                'status' => 'Cancelled',
            ]);
        }, 3);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment cancelled successfully.');
    }


    /**
     * Mark an approved appointment as completed.
     * Admin only.
     */
    public function complete(Appointment $appointment)
    {
        $this->ensureAdmin();

        DB::transaction(function () use ($appointment) {

            $lockedAppointment = Appointment::whereKey($appointment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedAppointment->status !== 'Approved') {
                throw ValidationException::withMessages([
                    'status' => 'Only approved appointments can be marked as completed.',
                ]);
            }

            $lockedAppointment->update([
                'status' => 'Completed',
            ]);
        }, 3);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment marked as completed.');
    }


    /**
     * Delete an appointment.
     * Admin only.
     */
    public function destroy(Appointment $appointment)
    {
        $this->ensureAdmin();

        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Appointment deleted successfully!');
    }


    /**
     * Display dashboard statistics for admins
     * and appointment summaries for customers.
     */
    public function dashboard()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | ADMIN DASHBOARD
        |--------------------------------------------------------------------------
        */

        if (strtolower(trim($user->role ?? '')) === 'admin') {

            $totalAppointments = Appointment::count();

            $pendingAppointments = Appointment::where('status', 'Pending')
                ->count();

            $approvedAppointments = Appointment::where('status', 'Approved')
                ->count();

            $rejectedAppointments = Appointment::where('status', 'Rejected')
                ->count();

            $cancelledAppointments = Appointment::where('status', 'Cancelled')
                ->count();

            $todaysAppointments = Appointment::whereHas('slot', function ($query) {
                $query->whereDate('date', today());
            })->count();

            return view('dashboard', compact(
                'totalAppointments',
                'pendingAppointments',
                'approvedAppointments',
                'rejectedAppointments',
                'cancelledAppointments',
                'todaysAppointments'
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER DASHBOARD
        |--------------------------------------------------------------------------
        */

        $upcomingAppointments = Appointment::with('slot')
            ->where('user_id', $user->id)
            ->whereIn('status', ['Pending', 'Approved'])
            ->whereHas('slot', function ($query) {

                $query->whereDate('date', '>', today())
                    ->orWhere(function ($todayQuery) {

                        $todayQuery->whereDate('date', today())
                            ->where('start_time', '>=', now()->format('H:i:s'));

                    });

            })
            ->orderByDesc('created_at')
            ->get();

        $pendingRequests = Appointment::where('user_id', $user->id)
            ->where('status', 'Pending')
            ->count();

        $appointmentHistory = Appointment::with('slot')
            ->where('user_id', $user->id)
            ->where(function ($query) {

                $query->whereIn('status', [
                    'Rejected',
                    'Cancelled',
                    'Completed',
                ])
                ->orWhereHas('slot', function ($slotQuery) {

                    $slotQuery->whereDate('date', '<', today())
                        ->orWhere(function ($todayQuery) {

                            $todayQuery->whereDate('date', today())
                                ->where('start_time', '<', now()->format('H:i:s'));

                        });

                });

            })
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard', compact(
            'upcomingAppointments',
            'pendingRequests',
            'appointmentHistory'
        ));
    }


    /**
     * Verify that the logged-in user is an administrator.
     */
    private function ensureAdmin(): void
    {
        abort_unless(
            strtolower(trim(auth()->user()->role ?? '')) === 'admin',
            403,
            'Only administrators can perform this action.'
        );
    }
}