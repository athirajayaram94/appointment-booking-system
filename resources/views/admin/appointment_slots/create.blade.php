<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Create Appointment Slot - MediCare Hospital</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

<div class="card shadow mx-auto" style="max-width: 650px;">

    <a href="{{ route('admin.appointment-slots.create') }}"
   class="btn btn-admin-light-blue btn-lg fw-bold">
    <i class="bi bi-plus-circle me-1"></i>
    Create Appointment Slot
</a>
    <div class="card-body">

        <form action="{{ route('admin.appointment-slots.store') }}" method="POST">

            @csrf
            <div class="mb-3">
    <label class="form-label">Doctor Name</label>

    <input type="text"
           name="doctor_name"
           class="form-control @error('doctor_name') is-invalid @enderror"
           value="{{ old('doctor_name') }}"
           placeholder="Enter doctor name"
           required>

    @error('doctor_name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
            <!-- Appointment Date -->
            <div class="mb-3">
                <label class="form-label">Appointment Date</label>

                <input type="date"
                       name="date"
                       class="form-control @error('date') is-invalid @enderror"
                       value="{{ old('date') }}"
                       min="{{ now()->toDateString() }}"
                       required>

                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Start Time -->
            <div class="mb-3">
                <label class="form-label">Start Time</label>

                <input type="time"
                       name="start_time"
                       class="form-control @error('start_time') is-invalid @enderror"
                       value="{{ old('start_time') }}"
                       required>

                @error('start_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- End Time -->
            <div class="mb-3">
                <label class="form-label">End Time</label>

                <input type="time"
                       name="end_time"
                       class="form-control @error('end_time') is-invalid @enderror"
                       value="{{ old('end_time') }}"
                       required>

                @error('end_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Capacity -->
            <div class="mb-3">
                <label class="form-label">Maximum Capacity</label>

                <input type="number"
                       name="capacity"
                       class="form-control @error('capacity') is-invalid @enderror"
                       value="{{ old('capacity', 1) }}"
                       min="1"
                       required>

                @error('capacity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-2">

                <button type="submit" class="btn btn-primary">
                    Save Appointment Slot
                </button>

                <a href="{{ route('admin.appointment-slots.index') }}"
                   class="btn btn-secondary">
                    Cancel
                </a>

            </div>

        </form>

    </div>
</div>

</div>

</body>
</html>
 