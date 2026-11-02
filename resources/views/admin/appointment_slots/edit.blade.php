<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Appointment Slot</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0 fw-bold">Edit Appointment Slot</h4>
        </div>

        <div class="card-body">

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.appointment-slots.update', $slot->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                {{-- Doctor Name --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Doctor Name</label>

                    <input type="text"
                           name="doctor_name"
                           class="form-control"
                           value="{{ old('doctor_name', $slot->doctor_name) }}"
                           required>
                </div>

                {{-- Appointment Date --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Appointment Date</label>

                    <input type="date"
                           name="date"
                           class="form-control"
                           value="{{ old('date', \Carbon\Carbon::parse($slot->date)->format('Y-m-d')) }}"
                           required>
                </div>

                {{-- Start Time --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Start Time</label>

                    <input type="time"
                           name="start_time"
                           class="form-control"
                           value="{{ old('start_time', substr($slot->start_time, 0, 5)) }}"
                           required>
                </div>

                {{-- End Time --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">End Time</label>

                    <input type="time"
                           name="end_time"
                           class="form-control"
                           value="{{ old('end_time', substr($slot->end_time, 0, 5)) }}"
                           required>
                </div>

                {{-- Capacity --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Capacity</label>

                    <input type="number"
                           name="capacity"
                           class="form-control"
                           min="1"
                           value="{{ old('capacity', $slot->capacity) }}"
                           required>
                </div>

                {{-- Availability Status --}}
                <div class="mb-4">
                    <label class="form-label fw-bold">Status</label>

                    <select name="is_available" class="form-select" required>
                        <option value="1"
                            {{ old('is_available', $slot->is_available) == 1 ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0"
                            {{ old('is_available', $slot->is_available) == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-success fw-bold px-4">
                        Update Slot
                    </button>

                    <a href="{{ route('admin.appointment-slots.index') }}"
                       class="btn btn-secondary fw-bold px-4">
                        Cancel
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>