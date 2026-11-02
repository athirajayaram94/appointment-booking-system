<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Appointment Slots - MediCare Hospital</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">


<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>Appointment Slot Management</h2>

    <a href="{{ route('admin.appointment-slots.create') }}"
       class="btn btn-primary">
        + Create New Slot
    </a>

</div>

<!-- Success Message -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- Appointment Slots Table -->
<div class="card shadow">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Doctor Name</th>
                        <th>Appointment Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Capacity</th>
                        <th>Total Bookings</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($slots as $slot)

                        <tr>
                            <td>{{ $slot->id }}</td>
                            <td>{{ $slot->doctor_name }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($slot->date)->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}
                            </td>

                            <td>{{ $slot->capacity }}</td>

                            <td>{{ $slot->appointments_count }}</td>

                            <td>
                                @if($slot->is_available)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                           <td>
    <!-- Edit Button -->
    <a href="{{ route('admin.appointment-slots.edit', $slot->id) }}"
       class="btn btn-primary btn-sm mb-1">

        <i class="bi bi-pencil-square"></i>
        Edit
    </a>

    <!-- Activate / Deactivate Button -->
    <form action="{{ route('admin.appointment-slots.toggle-status', $slot->id) }}"
          method="POST"
          class="d-inline">

        @csrf
        @method('PATCH')

        @if($slot->is_available)

            <button type="submit" class="btn btn-danger btn-sm">
                Deactivate
            </button>

        @else

            <button type="submit" class="btn btn-success btn-sm">
                Activate
            </button>

        @endif

    </form>
</td>
                        </tr>

                    @empty

                        <tr>
                           <td colspan="9" class="text-center">
                                No appointment slots found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->
      <div class="mt-3">
    {{ $slots->links('pagination::bootstrap-5') }}
</div>
    </div>
</div>

</div>

</body>
</html>

