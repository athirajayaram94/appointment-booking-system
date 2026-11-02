<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Book an Appointment | MediCare Hospital</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f1f5f9;
            font-family: Arial, sans-serif;
        }

        .main-card {
            border: none;
            border-radius: 15px;
        }

        .hospital-title {
            color: #0f766e;
            font-weight: bold;
        }

        .calendar-day {
            min-height: 75px;
            border: 1px solid #dee2e6;
            background: white;
            cursor: pointer;
            padding: 8px;
            text-align: center;
        }

        .calendar-day:hover {
            background: #e0f2fe;
        }

        .calendar-day.selected {
            background: #0d6efd;
            color: white;
        }

        .calendar-day.available {
            border-bottom: 4px solid #198754;
        }

        .calendar-day.unavailable {
            border-bottom: 4px solid #dc3545;
        }

        .calendar-day.disabled {
            background: #e9ecef;
            color: #adb5bd;
            cursor: not-allowed;
        }

        .slot-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 12px;
            background: white;
        }

        .slot-card.unavailable {
            background: #f1f1f1;
            opacity: 0.75;
        }

        .slot-card.available:hover {
            border-color: #198754;
        }

        .legend {
            font-size: 14px;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .weekday {
            text-align: center;
            font-weight: bold;
            padding: 10px 2px;
            background: #e2e8f0;
        }

        .slot-card label {
            cursor: pointer;
        }

        @media(max-width:576px) {
            .calendar-day {
                min-height: 55px;
                padding: 4px;
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

<div class="container py-4">

    <div class="card shadow main-card">

        <div class="card-body p-4">

            <h2 class="hospital-title">MediCare Hospital</h2>

            <h4 class="mt-3">Book Your Appointment</h4>

            <p class="text-muted">
                Select a date and choose your preferred appointment slot.
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($slots->isEmpty())

                <div class="alert alert-warning">
                    No appointment slots have been scheduled.
                    Please check again later.
                </div>

            @else

                <!-- Calendar Controls -->

                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">

                    <div>
                        <button class="btn btn-outline-primary" id="previousBtn">
                            Previous
                        </button>

                        <button class="btn btn-outline-primary" id="nextBtn">
                            Next
                        </button>

                        <button class="btn btn-outline-secondary" id="todayBtn">
                            Today
                        </button>
                    </div>

                    <div>
                        <button class="btn btn-primary" id="monthView">
                            Monthly
                        </button>

                        <button class="btn btn-outline-primary" id="weekView">
                            Weekly
                        </button>
                    </div>

                </div>

                <h5 class="text-center mb-3" id="calendarTitle"></h5>

                <!-- Calendar -->

                <div class="calendar-grid" id="calendar">

                </div>

                <!-- Legend -->

                <div class="d-flex flex-wrap gap-3 mt-3 legend">

                    <span>
                        <span class="text-success">●</span>
                        Available
                    </span>

                    <span>
                        <span class="text-danger">●</span>
                        Unavailable / Fully Booked
                    </span>

                    <span>
                        <span class="text-secondary">●</span>
                        No slots
                    </span>

                </div>

                <hr class="my-4">

                <!-- Selected Date -->

                <h5 id="selectedDateTitle">
                    Select an appointment date
                </h5>

                <div id="slotList" class="mt-3">

                    <p class="text-muted">
                        Select a date from the calendar to view appointment slots.
                    </p>

                </div>

                <!-- Booking Form -->

                <form action="{{ route('appointments.store') }}"
                      method="POST"
                      id="bookingForm"
                      class="mt-4">

                    @csrf

                    <input type="hidden"
                           name="slot_id"
                           id="slot_id"
                           value="{{ old('slot_id') }}">

                    <div class="mb-3">

                        <label class="form-label fw-bold">
                            Reason for Appointment
                        </label>

                        <textarea name="reason"
                                  class="form-control"
                                  rows="4"
                                  maxlength="1000"
                                  placeholder="Briefly describe your reason for the appointment"
                                  required>{{ old('reason') }}</textarea>

                    </div>

                    <button type="submit"
                            class="btn btn-success btn-lg"
                            id="confirmButton"
                            disabled>

                        Confirm Appointment

                    </button>

                </form>

            @endif

            <div class="mt-4">

                <a href="{{ route('dashboard') }}"
                   class="btn btn-secondary">

                    Back to Dashboard

                </a>

            </div>

        </div>

    </div>

</div>

@if (!$slots->isEmpty())

@php
    $calendarSlots = $slots->map(function ($slot) {
        return [
            'id' => $slot->id,
            'doctor' => $slot->doctor_name,
            'date' => $slot->date->format('Y-m-d'),
            'start' => $slot->start_time,
            'end' => $slot->end_time,
            'capacity' => $slot->capacity,
            
            'bookings' => $slot->active_bookings_count,
            'active' => $slot->is_available
        ];
    })->values();
@endphp

<script>

    const slots = {{ \Illuminate\Support\Js::from($calendarSlots) }};



    let currentDate = new Date();
    let selectedDate = null;
    let currentView = 'month';

    const calendar = document.getElementById('calendar');

    const calendarTitle = document.getElementById('calendarTitle');

    const slotList = document.getElementById('slotList');

    const slotInput = document.getElementById('slot_id');

    const confirmButton = document.getElementById('confirmButton');

    const today = new Date();

    today.setHours(0, 0, 0, 0);

    function formatDate(date) {

        const year = date.getFullYear();

        const month = String(date.getMonth() + 1).padStart(2, '0');

        const day = String(date.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;
    }

    function isSlotAvailable(slot) {

        const slotDateTime = new Date(
            slot.date + 'T' + slot.start
        );

        return slot.active &&
               slot.bookings < slot.capacity &&
               slotDateTime > new Date();

    }

    function getSlotsForDate(date) {

        return slots.filter(slot => slot.date === date);

    }

    function renderCalendar() {

        calendar.innerHTML = '';

        const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        weekdays.forEach(day => {

            const heading = document.createElement('div');

            heading.className = 'weekday';

            heading.textContent = day;

            calendar.appendChild(heading);

        });

        let startDate;
        let totalDays;

        if (currentView === 'month') {

            const year = currentDate.getFullYear();

            const month = currentDate.getMonth();

            startDate = new Date(year, month, 1);

            const firstDay = startDate.getDay();

            totalDays = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {

                const empty = document.createElement('div');

                calendar.appendChild(empty);

            }

            calendarTitle.textContent = currentDate.toLocaleDateString(
                'en-US',
                {
                    month: 'long',
                    year: 'numeric'
                }
            );

        } else {

            startDate = new Date(currentDate);

            startDate.setDate(
                currentDate.getDate() - currentDate.getDay()
            );

            totalDays = 7;

            calendarTitle.textContent =
                'Week of ' + startDate.toLocaleDateString();

        }

        for (let i = 0; i < totalDays; i++) {

            const date = new Date(startDate);

            date.setDate(startDate.getDate() + i);

            const dateString = formatDate(date);

            const daySlots = getSlotsForDate(dateString);

            const available = daySlots.some(isSlotAvailable);

            const day = document.createElement('div');

            day.className = 'calendar-day';

            if (date < today) {

                day.classList.add('disabled');

            } else if (available) {

                day.classList.add('available');

            } else if (daySlots.length > 0) {

                day.classList.add('unavailable');

            }

            if (selectedDate === dateString) {

                day.classList.add('selected');

            }

            day.innerHTML = `
                <strong>${date.getDate()}</strong>
                <br>
                <small>
                    ${
                        available
                        ? 'Available'
                        : daySlots.length > 0
                            ? 'Unavailable'
                            : ''
                    }
                </small>
            `;

            if (date >= today) {

                day.addEventListener('click', function () {

                    selectedDate = dateString;

                    renderCalendar();

                    showSlots(dateString);

                });

            }

            calendar.appendChild(day);

        }

    }

    function showSlots(date) {

        const dateObject = new Date(date + 'T00:00:00');

        document.getElementById('selectedDateTitle').textContent =
            'Appointment Slots - ' +
            dateObject.toLocaleDateString('en-GB');

        slotList.innerHTML = '';

        slotInput.value = '';

        confirmButton.disabled = true;

        const daySlots = getSlotsForDate(date);

        if (daySlots.length === 0) {

            slotList.innerHTML = `
                <div class="alert alert-secondary">
                    No appointment slots are scheduled for this date.
                </div>
            `;

            return;

        }

        daySlots.forEach(slot => {

            const available = isSlotAvailable(slot);

            const card = document.createElement('div');

            card.className = 'slot-card ' +
                (available ? 'available' : 'unavailable');

            const status = available
                ? '<span class="badge bg-success">Available</span>'
                : '<span class="badge bg-danger">Unavailable</span>';

            card.innerHTML = `
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                    <div>

                        <strong>${slot.doctor || 'Doctor'}</strong>

                        <br>

                        <small>
                            ${slot.start} - ${slot.end}
                        </small>

                        <br>

                        ${status}

                    </div>

                    <div>
                        ${
                            available
                            ? `<input type="radio"
                                      name="selected_slot"
                                      value="${slot.id}"
                                      class="form-check-input slot-radio">`
                            : '<button class="btn btn-secondary btn-sm" disabled>Unavailable</button>'
                        }
                    </div>

                </div>
            `;

            slotList.appendChild(card);

        });

        document.querySelectorAll('.slot-radio').forEach(radio => {

            radio.addEventListener('change', function () {

                slotInput.value = this.value;

                confirmButton.disabled = false;

            });

        });

    }

    document.getElementById('previousBtn').addEventListener('click', function () {

        if (currentView === 'month') {

            currentDate.setMonth(currentDate.getMonth() - 1);

        } else {

            currentDate.setDate(currentDate.getDate() - 7);

        }

        renderCalendar();

    });

    document.getElementById('nextBtn').addEventListener('click', function () {

        if (currentView === 'month') {

            currentDate.setMonth(currentDate.getMonth() + 1);

        } else {

            currentDate.setDate(currentDate.getDate() + 7);

        }

        renderCalendar();

    });

    document.getElementById('todayBtn').addEventListener('click', function () {

        currentDate = new Date();

        renderCalendar();

    });

    document.getElementById('monthView').addEventListener('click', function () {

        currentView = 'month';

        this.className = 'btn btn-primary';

        document.getElementById('weekView').className =
            'btn btn-outline-primary';

        renderCalendar();

    });

    document.getElementById('weekView').addEventListener('click', function () {

        currentView = 'week';

        this.className = 'btn btn-primary';

        document.getElementById('monthView').className =
            'btn btn-outline-primary';

        renderCalendar();

    });

    renderCalendar();

</script>

@endif

</body>
</html>