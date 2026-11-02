<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppointmentSlot;
use Illuminate\Http\Request;

class AppointmentSlotController extends Controller
{
    // Display all appointment slots
    public function index()
    {
        $this->ensureAdmin();

        $slots = AppointmentSlot::withCount('appointments')
            ->orderBy('date', 'desc')
            ->orderBy('start_time')
            ->paginate(10);

        return view('admin.appointment_slots.index', compact('slots'));
    }

    // Display the create slot form
    public function create()
    {
        $this->ensureAdmin();

        return view('admin.appointment_slots.create');
    }
    /**
 * Store a new appointment slot.
 */
public function store(Request $request)
{
    $this->ensureAdmin();

    // Validate the submitted data
    $validated = $request->validate([
        'doctor_name' => 'required|string|max:255',
        'date' => 'required|date|after_or_equal:today',
        'start_time' => 'required|date_format:H:i',
        'end_time' => 'required|date_format:H:i|after:start_time',
        'capacity' => 'required|integer|min:1',
    ]);

    // Check for overlapping active slots on the same date
    $overlappingSlot = AppointmentSlot::where('date', $validated['date'])
        ->where('is_available', true)
        ->where('start_time', '<', $validated['end_time'])
        ->where('end_time', '>', $validated['start_time'])
        ->exists();

    if ($overlappingSlot) {
        return back()
            ->withInput()
            ->withErrors([
                'start_time' => 'This time overlaps with an existing active appointment slot.'
            ]);
    }

    // Create the appointment slot
    AppointmentSlot::create([
         'doctor_name' => $validated['doctor_name'],
        'date' => $validated['date'],
        'start_time' => $validated['start_time'],
        'end_time' => $validated['end_time'],
        'capacity' => $validated['capacity'],
        'is_available' => true,
    ]);

    return redirect()
        ->route('admin.appointment-slots.index')
        ->with('success', 'Appointment slot created successfully.');
}

    // Check administrator access
    private function ensureAdmin(): void
    {
        abort_unless(
            auth()->check() &&
            auth()->user()->role === 'Admin',
            403,
            'Only administrators can manage appointment slots.'
        );
    }
    public function toggleStatus($slot)
{
    $this->ensureAdmin();

    $appointmentSlot = AppointmentSlot::findOrFail($slot);

    $appointmentSlot->update([
        'is_available' => !$appointmentSlot->is_available,
    ]);

    return redirect()
        ->route('admin.appointment-slots.index')
        ->with('success', 'Appointment slot status updated successfully.');
}
public function edit($id)
{
    $this->ensureAdmin();

    $slot = AppointmentSlot::findOrFail($id);

    return view('admin.appointment_slots.edit', compact('slot'));
}
public function update(Request $request, $id)
{
    $this->ensureAdmin();

    $slot = AppointmentSlot::findOrFail($id);

    $validated = $request->validate([
        'doctor_name' => 'required|string|max:255',
        'date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required|after:start_time',
        'capacity' => 'required|integer|min:1',
        'is_available' => 'required|boolean',
    ]);

    $slot->update($validated);

    return redirect()
        ->route('admin.appointment-slots.index')
        ->with('success', 'Appointment slot updated successfully.');
}
}
