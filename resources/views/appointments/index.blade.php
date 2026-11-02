<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Appointments | MediCare Hospital</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 25px;
            color: #334155;
        }

        .container {
            max-width: 1400px;
            margin: 20px auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px #00000012;
            overflow-x: auto;
        }

        h1, h2 {
            color: #0f766e;
        }

        h2 {
            margin-top: 35px;
        }

        .subtitle {
            color: #64748b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            min-width: 900px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #e2e8f0;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #0f766e;
            color: white;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .button {
            display: inline-block;
            padding: 9px 13px;
            border: none;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            margin: 3px;
            font-size: 13px;
            white-space: nowrap;
        }

        .approve {
            background: #16a34a;
        }

        .reject {
            background: #dc2626;
        }

        .delete {
            background: #475569;
        }

        .cancel {
            background: #ea580c;
        }

        .back {
            background: #64748b;
        }

        .search-button {
            background: #0f766e;
        }

        .clear-button {
            background: #64748b;
        }

        .button:hover {
            opacity: 0.85;
            color: white;
        }

        .status {
            font-weight: bold;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 15px;
            font-size: 12px;
            white-space: nowrap;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .approved {
            background: #dcfce7;
            color: #166534;
        }

        .rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .cancelled {
            background: #e2e8f0;
            color: #334155;
        }

        .completed {
            background: #dbeafe;
            color: #1e40af;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .reason-input {
            width: 150px;
            padding: 8px;
            margin: 3px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #64748b;
        }

        .info {
            background: #f0fdfa;
            border-left: 4px solid #0f766e;
            padding: 12px;
            margin: 15px 0;
        }

        form.action-form {
            display: inline-block;
            margin: 2px;
        }

        /* Search and filter section */
        .filter-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
        }

        .filter-box h3 {
            margin-top: 0;
            color: #0f766e;
        }

        .filter-form {
            display: block;
            margin: 0;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(150px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .filter-field label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
            font-size: 14px;
        }

        .filter-field input,
        .filter-field select {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: white;
            font-size: 14px;
        }

        .filter-actions {
            margin-top: 18px;
        }

        .pagination {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .pagination nav {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .pagination nav div:first-child {
            margin-bottom: 10px;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 8px 12px;
            margin: 2px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            text-decoration: none;
            color: #0f766e;
        }

        .pagination [aria-current="page"] span {
            background: #0f766e;
            color: white;
            border-color: #0f766e;
        }

        .summary-box {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 20px 0;
        }

        .summary-item {
            background: #f0fdfa;
            border: 1px solid #ccfbf1;
            padding: 12px 18px;
            border-radius: 8px;
        }

        @media (max-width: 900px) {
            .filter-grid {
                grid-template-columns: repeat(2, minmax(140px, 1fr));
            }
        }

        @media (max-width: 550px) {
            body {
                padding: 8px;
            }

            .container {
                padding: 15px;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="container">

    @php
        $isAdmin = strtolower(trim(auth()->user()->role ?? '')) === 'admin';
    @endphp

    <h1>Appointment Management</h1>

    <p class="subtitle">MediCare Hospital — Appointment Portal</p>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="error">
            <strong>Please correct the following:</strong>

            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif


    {{-- ================================================== --}}
    {{-- ADMIN APPOINTMENT MANAGEMENT                       --}}
    {{-- ================================================== --}}

    @if ($isAdmin)

        <div class="info">
            You are logged in as an administrator.
            You can search and manage all customer appointments.
        </div>

        <h2>All Appointments</h2>


        {{-- SEARCH AND FILTER FORM --}}

        <div class="filter-box">

            <h3>Search and Filter Appointments</h3>

            <form
                action="{{ route('appointments.index') }}"
                method="GET"
                class="filter-form"
            >

                <div class="filter-grid">

                    {{-- Customer Search --}}
                    <div class="filter-field">
                        <label for="customer">Customer Name or Email</label>

                        <input
                            type="text"
                            name="customer"
                            id="customer"
                            placeholder="Enter customer name or email"
                            value="{{ request('customer') }}"
                        >
                    </div>


                    {{-- Starting Date --}}
                    <div class="filter-field">
                        <label for="start_date">From Date</label>

                        <input
                            type="date"
                            name="start_date"
                            id="start_date"
                            value="{{ request('start_date') }}"
                        >
                    </div>


                    {{-- Ending Date --}}
                    <div class="filter-field">
                        <label for="end_date">To Date</label>

                        <input
                            type="date"
                            name="end_date"
                            id="end_date"
                            value="{{ request('end_date') }}"
                        >
                    </div>


                    {{-- Status Filter --}}
                    <div class="filter-field">
                        <label for="status">Appointment Status</label>

                        <select name="status" id="status">

                            <option value="">All Statuses</option>

                            <option value="Pending"
                                {{ request('status') === 'Pending' ? 'selected' : '' }}>
                                Pending
                            </option>

                            <option value="Approved"
                                {{ request('status') === 'Approved' ? 'selected' : '' }}>
                                Approved
                            </option>

                            <option value="Rejected"
                                {{ request('status') === 'Rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>

                            <option value="Cancelled"
                                {{ request('status') === 'Cancelled' ? 'selected' : '' }}>
                                Cancelled
                            </option>

                            <option value="Completed"
                                {{ request('status') === 'Completed' ? 'selected' : '' }}>
                                Completed
                            </option>

                        </select>
                    </div>

                </div>


                <div class="filter-actions">

                    <button type="submit" class="button search-button">
                        Search Appointments
                    </button>

                    <a
                        href="{{ route('appointments.index') }}"
                        class="button clear-button"
                    >
                        Clear Filters
                    </a>

                </div>

            </form>

        </div>


        {{-- SEARCH RESULTS SUMMARY --}}

        <div class="summary-box">

            <div class="summary-item">
                <strong>Appointments found:</strong>
                {{ $appointments->total() }}
            </div>

            <div class="summary-item">
                <strong>Current page:</strong>
                {{ $appointments->currentPage() }}
                of
                {{ max(1, $appointments->lastPage()) }}
            </div>

        </div>


        {{-- ADMIN APPOINTMENTS TABLE --}}

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Doctor Name</th>
                    <th>Appointment Date</th>
                    <th>Time</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Rejection Reason</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($appointments as $appointment)

                    <tr>

                        <td>{{ $appointment->id }}</td>

                        <td>
                            {{ $appointment->customer->name ?? 'Name not found' }}
                        </td>

                        <td>
                            {{ $appointment->customer->email ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $appointment->slot->doctor_name ?? 'Not assigned' }}
                        </td>

                        <td>
                            @if ($appointment->slot && $appointment->slot->date)
                                {{ \Carbon\Carbon::parse($appointment->slot->date)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </td>

                        <td>
                            @if ($appointment->slot)
                                {{ $appointment->slot->start_time }}
                                -
                                {{ $appointment->slot->end_time }}
                            @else
                                N/A
                            @endif
                        </td>

                        <td>
                            {{ $appointment->reason ?? 'N/A' }}
                        </td>

                        <td class="status">

                            @php
                                $statusClass = strtolower($appointment->status ?? 'pending');
                            @endphp

                            <span class="status-badge {{ $statusClass }}">
                                {{ $appointment->status ?? 'Pending' }}
                            </span>

                        </td>

                        <td>
                            {{ $appointment->rejection_reason ?? 'N/A' }}
                        </td>

                        <td>

                            {{-- Approve and Reject only for pending appointments --}}

                            @if (strtolower($appointment->status ?? '') === 'pending')

                                <form
                                    action="{{ route('appointments.approve', $appointment->id) }}"
                                    method="POST"
                                    class="action-form"
                                    onsubmit="return confirm('Approve this appointment?');"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="button approve">
                                        Approve
                                    </button>
                                </form>


                                <form
                                    action="{{ route('appointments.reject', $appointment->id) }}"
                                    method="POST"
                                    class="action-form"
                                    onsubmit="return confirm('Reject this appointment?');"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <input
                                        type="text"
                                        name="rejection_reason"
                                        class="reason-input"
                                        placeholder="Rejection reason"
                                        maxlength="1000"
                                        required
                                    >

                                    <button type="submit" class="button reject">
                                        Reject
                                    </button>
                                </form>

                            @endif


                            {{-- Complete approved appointments --}}

                            @if (strtolower($appointment->status ?? '') === 'approved')

                                <form
                                    action="{{ route('appointments.complete', $appointment->id) }}"
                                    method="POST"
                                    class="action-form"
                                    onsubmit="return confirm('Mark this appointment as completed?');"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="button approve">
                                        Complete
                                    </button>
                                </form>

                            @endif


                            {{-- Delete appointment --}}

                            <form
                                action="{{ route('appointments.destroy', $appointment->id) }}"
                                method="POST"
                                class="action-form"
                                onsubmit="return confirm('Are you sure you want to delete this appointment?');"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="button delete">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="10" class="empty">
                            No appointments found for the selected search criteria.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>


        {{-- PAGINATION --}}

        @if ($appointments->hasPages())

            <div class="pagination">
                {{ $appointments->links() }}
            </div>

        @endif


    {{-- ================================================== --}}
    {{-- CUSTOMER APPOINTMENT MANAGEMENT                    --}}
    {{-- ================================================== --}}

    @else

        <div class="info">
            Welcome, {{ auth()->user()->name }}!
            You can view and manage only your own appointments.
        </div>


        {{-- UPCOMING APPOINTMENTS --}}

        <h2>My Upcoming Appointments</h2>

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Doctor Name</th>
                    <th>Appointment Date</th>
                    <th>Time</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($upcomingAppointments as $appointment)

                    <tr>

                        <td>{{ $appointment->id }}</td>

                        <td>
                            {{ $appointment->slot->doctor_name ?? 'Not assigned' }}
                        </td>

                        <td>
                            @if ($appointment->slot && $appointment->slot->date)
                                {{ \Carbon\Carbon::parse($appointment->slot->date)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </td>

                        <td>
                            @if ($appointment->slot)
                                {{ $appointment->slot->start_time }}
                                -
                                {{ $appointment->slot->end_time }}
                            @else
                                N/A
                            @endif
                        </td>

                        <td>
                            {{ $appointment->reason ?? 'N/A' }}
                        </td>

                        <td class="status">

                            @php
                                $statusClass = strtolower($appointment->status ?? 'pending');
                            @endphp

                            <span class="status-badge {{ $statusClass }}">
                                {{ $appointment->status ?? 'Pending' }}
                            </span>

                        </td>

                        <td>

                            @if (in_array($appointment->status, ['Pending', 'Approved']))

                                <form
                                    action="{{ route('appointments.cancel', $appointment->id) }}"
                                    method="POST"
                                    class="action-form"
                                    onsubmit="return confirm('Are you sure you want to cancel this appointment?');"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit" class="button cancel">
                                        Cancel Appointment
                                    </button>
                                </form>

                            @else

                                No actions available.

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="empty">
                            You have no upcoming appointments.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>


        {{-- APPOINTMENT HISTORY --}}

        <h2>My Appointment History</h2>

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Doctor Name</th>
                    <th>Appointment Date</th>
                    <th>Time</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Rejection Reason</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($appointmentHistory as $appointment)

                    <tr>

                        <td>{{ $appointment->id }}</td>

                        <td>
                            {{ $appointment->slot->doctor_name ?? 'Not assigned' }}
                        </td>

                        <td>
                            @if ($appointment->slot && $appointment->slot->date)
                                {{ \Carbon\Carbon::parse($appointment->slot->date)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </td>

                        <td>
                            @if ($appointment->slot)
                                {{ $appointment->slot->start_time }}
                                -
                                {{ $appointment->slot->end_time }}
                            @else
                                N/A
                            @endif
                        </td>

                        <td>
                            {{ $appointment->reason ?? 'N/A' }}
                        </td>

                        <td class="status">

                            @php
                                $statusClass = strtolower($appointment->status ?? 'pending');
                            @endphp

                            <span class="status-badge {{ $statusClass }}">
                                {{ $appointment->status ?? 'Pending' }}
                            </span>

                        </td>

                        <td>
                            {{ $appointment->rejection_reason ?? 'N/A' }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="empty">
                            You have no previous appointments.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    @endif


    <br><br>

    <a href="{{ route('dashboard') }}" class="button back">
        Back to Dashboard
    </a>

</div>

</body>
</html>
