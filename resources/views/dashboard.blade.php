<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MediCare Hospital | Dashboard</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
          rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7faff;
            color: #243247;
        }

        .topbar {
            background: #ffffff;
            padding: 18px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .hospital-name {
            font-size: 27px;
            font-weight: bold;
            color: #087f8c;
            text-decoration: none;
        }

        .hospital-name i {
            margin-right: 8px;
        }

        .book-btn {
            display: inline-block;
            background: #087f8c;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .book-btn:hover {
            background: #056570;
            color: white;
            transform: translateY(-2px);
        }

        .book-appointment-btn {
            display: inline-block;
            background-color: #0f766e;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            margin: 8px 5px;
            transition: 0.3s;
        }

        .book-appointment-btn:hover {
            background-color: #115e59;
            color: white;
        }

        .hero {
            text-align: center;
            padding: 65px 20px 45px;
        }

        .hero h1 {
            font-size: 42px;
            font-weight: bold;
            color: #173b57;
        }

        .hero h1 span {
            color: #087f8c;
        }

        .hero p {
            color: #68788b;
            font-size: 17px;
            margin-top: 15px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 35px;
        }

        .section-title h2 {
            font-size: 32px;
            font-weight: bold;
            color: #173b57;
        }

        .section-title p {
            color: #758398;
            margin-top: 10px;
        }

        .speciality-section {
            padding: 30px 7% 65px;
        }

        .speciality-card {
            background: white;
            border-radius: 16px;
            padding: 28px 15px;
            text-align: center;
            height: 100%;
            border: 1px solid #edf1f5;
            transition: 0.3s;
        }

        .speciality-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .speciality-icon {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: #e5f6f6;
            color: #087f8c;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 29px;
        }

        .speciality-card h5 {
            font-size: 17px;
            font-weight: bold;
        }

        .doctors-section {
            padding: 60px 7%;
            background: #edf7fa;
        }

        .doctor-card {
            background: white;
            border-radius: 18px;
            overflow: hidden;
            height: 100%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            transition: 0.3s;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.09);
        }

        .doctor-image {
            width: 100%;
            height: 230px;
            object-fit: cover;
            background: #e4edf2;
        }

        .doctor-details {
            padding: 22px;
            text-align: center;
        }

        .doctor-details h5 {
            font-weight: bold;
            color: #173b57;
        }

        .doctor-speciality {
            color: #087f8c;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .experience {
            color: #788697;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .dashboard-card {
            background: white;
            border-radius: 15px;
            border: none;
            height: 100%;
            transition: 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08) !important;
        }

        .dashboard-icon {
            font-size: 38px;
            margin-bottom: 12px;
        }

        .dashboard-number {
            font-size: 32px;
            font-weight: bold;
            color: #173b57;
        }

        .dashboard-heading {
            color: #173b57;
            font-weight: bold;
        }

        .footer {
            background: #173b57;
            color: white;
            text-align: center;
            padding: 25px 15px;
        }

        .footer p {
            margin: 0;
        }

        @media (max-width: 576px) {
            .topbar {
                padding: 15px 4%;
            }

            .hospital-name {
                font-size: 20px;
            }

            .book-btn {
                padding: 10px 14px;
                font-size: 13px;
            }

            .hero h1 {
                font-size: 31px;
            }

            .section-title h2 {
                font-size: 27px;
            }
        }
        .btnprimary {
    background-color: #0F766E;
    border-color: #0F766E;
    color: white;
}

.btnsuccess {
    background-color: #166534;
    border-color: #166534;
    color: white;
}

.btnwarning {
    background-color: #7DD3FC;
    border-color: #7DD3FC;
    color: #173B57;
}
/* Patient Dashboard Heading */
.patient-heading {
    font-size: 28px !important;
}

/* Patient Welcome Message */
.patient-dashboard .text-secondary {
    font-size: 14px;
}

/* Patient Dashboard Buttons */
.patient-btn {
    font-size: 14px;
    padding: 9px 16px;
    margin: 5px;
}
        
    </style>
</head>

<body>

    <!-- SUCCESS MESSAGE -->
    @if (session('success'))
        <div class="alert alert-success text-center mb-0">
            {{ session('success') }}
        </div>
    @endif

    <!-- ERROR MESSAGE -->
    @if (session('error'))
        <div class="alert alert-danger text-center mb-0">
            {{ session('error') }}
        </div>
    @endif

    <!-- TOPBAR -->
    <nav class="topbar">

        <a href="/" class="hospital-name">
            <i class="bi bi-hospital"></i>MediCare Hospital
        </a>

        <div class="d-flex align-items-center gap-3 flex-wrap">

            <a href="{{ route('appointments.create') }}" class="book-btn">
                <i class="bi bi-calendar-check me-1"></i>
                Book an Appointment
            </a>

            <form action="{{ route('logout') }}" method="POST">
    @csrf

    <button type="submit" class="btn btn-danger">
        Logout
    </button>
</form>
        </div>

    </nav>


    <!-- ================================================== -->
    <!-- ADMIN DASHBOARD                                   -->
    <!-- ================================================== -->

    @if (strtolower(trim(auth()->user()->role ?? '')) === 'admin')

        <section class="container py-5">

            <div class="text-center mb-5">
                <h1 class="fw-bold" style="color:#173b57;">
                    Admin Dashboard
                </h1>

                <p class="text-secondary">
                    Appointment Management Overview
                </p>
            </div>

            <!-- ADMIN ACTION BUTTONS -->
            <div class="d-flex justify-content-center flex-wrap gap-3 mt-4 mb-4">

                <a href="{{ route('appointments.index') }}"
                   class="btn btnprimary btn-lg">
                    <i class="bi bi-list-ul me-1"></i>
                    Manage All Appointments
                </a>

                <a href="{{ route('admin.appointment-slots.index') }}"
                   class="btn btnsuccess btn-lg">
                    <i class="bi bi-calendar2-week me-1"></i>
                    Manage Appointment Slots
                </a>

                <a href="{{ route('admin.appointment-slots.create') }}"
                   class="btn btnwarning btn-lg">
                    <i class="bi bi-plus-circle me-1"></i>
                    Create Appointment Slot
                </a>

            </div>

            <div class="row g-4">

                <!-- Total Appointments -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card dashboard-card shadow-sm p-4 text-center">
                        <i class="bi bi-calendar-check dashboard-icon text-primary"></i>

                        <h6>Total Appointments</h6>

                        <div class="dashboard-number">
                            {{ $totalAppointments ?? 0 }}
                        </div>
                    </div>
                </div>

                <!-- Pending Appointments -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card dashboard-card shadow-sm p-4 text-center">
                        <i class="bi bi-hourglass-split dashboard-icon text-warning"></i>

                        <h6>Pending Appointments</h6>

                        <div class="dashboard-number">
                            {{ $pendingAppointments ?? 0 }}
                        </div>
                    </div>
                </div>

                <!-- Approved Appointments -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card dashboard-card shadow-sm p-4 text-center">
                        <i class="bi bi-check-circle dashboard-icon text-success"></i>

                        <h6>Approved Appointments</h6>

                        <div class="dashboard-number">
                            {{ $approvedAppointments ?? 0 }}
                        </div>
                    </div>
                </div>

                <!-- Rejected Appointments -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card dashboard-card shadow-sm p-4 text-center">
                        <i class="bi bi-x-circle dashboard-icon text-danger"></i>

                        <h6>Rejected Appointments</h6>

                        <div class="dashboard-number">
                            {{ $rejectedAppointments ?? 0 }}
                        </div>
                    </div>
                </div>

                <!-- Cancelled Appointments -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card dashboard-card shadow-sm p-4 text-center">
                        <i class="bi bi-calendar-x dashboard-icon text-secondary"></i>

                        <h6>Cancelled Appointments</h6>

                        <div class="dashboard-number">
                            {{ $cancelledAppointments ?? 0 }}
                        </div>
                    </div>
                </div>

                <!-- Today's Appointments -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="card dashboard-card shadow-sm p-4 text-center">
                        <i class="bi bi-calendar-day dashboard-icon"
                           style="color:#087f8c;"></i>

                        <h6>Today's Appointments</h6>

                        <div class="dashboard-number">
                            {{ $todaysAppointments ?? 0 }}
                        </div>
                    </div>
                </div>

            </div>

           
        </section>

    @else

        <!-- ================================================== -->
        <!-- CUSTOMER DASHBOARD                                -->
        <!-- ================================================== -->

        <section class="container py-5">

            <div class="text-center mb-5">

                <h1 class="fw-bold" style="color:#173b57;">
                    My Appointment Dashboard</h1>
        
                <p class="text-secondary">
                    Welcome, {{ auth()->user()->name }}!
                    Manage your appointments and booking requests.
                </p>

                <a href="{{ route('appointments.create') }}"
   class="book-appointment-btn patient-btn">
    <i class="bi bi-calendar-plus me-1"></i>
    Book New Appointment
</a>

<a href="{{ route('appointments.index') }}"
   class="book-appointment-btn patient-btn">
    <i class="bi bi-list-ul me-1"></i>
    View My Appointments
</a>
            </div>

            <!-- CUSTOMER SUMMARY CARDS -->
            <div class="row g-4 mb-5">

                <!-- Upcoming Appointments -->
                <div class="col-12 col-md-6">

                    <div class="card dashboard-card shadow-sm p-4 text-center">

                        <i class="bi bi-calendar-check dashboard-icon text-success"></i>

                        <h5>Upcoming Appointments</h5>

                        <div class="dashboard-number">
                            {{ isset($upcomingAppointments) ? $upcomingAppointments->count() : 0 }}
                        </div>

                    </div>

                </div>

                <!-- Pending Requests -->
                <div class="col-12 col-md-6">

                    <div class="card dashboard-card shadow-sm p-4 text-center">

                        <i class="bi bi-hourglass-split dashboard-icon text-warning"></i>

                        <h5>Pending Requests</h5>

                        <div class="dashboard-number">
                            {{ $pendingRequests ?? 0 }}
                        </div>

                    </div>

                </div>

            </div>


            <!-- UPCOMING APPOINTMENTS TABLE -->
            <div class="card dashboard-card shadow-sm mb-5">

                <div class="card-header bg-white py-3">
                    <h4 class="dashboard-heading mb-0">
                        <i class="bi bi-calendar-event me-2"></i>
                        My Upcoming Appointments
                    </h4>
                </div>

                <div class="card-body">

                    @if(isset($upcomingAppointments) && $upcomingAppointments->count() > 0)

                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($upcomingAppointments as $appointment)

                                        <tr>

                                            <td>
                                                {{ $appointment->slot->date ?? 'N/A' }}
                                            </td>

                                            <td>
                                                {{ $appointment->slot->start_time ?? 'N/A' }}
                                            </td>

                                            <td>
                                                {{ $appointment->reason ?? 'N/A' }}
                                            </td>

                                            <td>
                                                @if($appointment->status === 'Approved')
                                                    <span class="badge bg-success">
                                                        Approved
                                                    </span>
                                                @elseif($appointment->status === 'Pending')
                                                    <span class="badge bg-warning text-dark">
                                                        Pending
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        {{ $appointment->status }}
                                                    </span>
                                                @endif
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="text-center py-4">
                            <i class="bi bi-calendar-x fs-1 text-secondary"></i>

                            <p class="text-secondary mt-2 mb-0">
                                You have no upcoming appointments.
                            </p>

                            <a href="{{ route('appointments.create') }}"
                               class="book-appointment-btn mt-3">
                                Book an Appointment
                            </a>
                        </div>

                    @endif

                </div>

            </div>


            <!-- APPOINTMENT HISTORY TABLE -->
            <div class="card dashboard-card shadow-sm mb-4">

                <div class="card-header bg-white py-3">
                    <h4 class="dashboard-heading mb-0">
                        <i class="bi bi-clock-history me-2"></i>
                        My Appointment History
                    </h4>
                </div>

                <div class="card-body">

                    @if(isset($appointmentHistory) && $appointmentHistory->count() > 0)

                        <div class="table-responsive">

                            <table class="table table-hover align-middle">

                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @foreach($appointmentHistory as $appointment)

                                        <tr>

                                            <td>
                                                {{ $appointment->slot->date ?? 'N/A' }}
                                            </td>

                                            <td>
                                                {{ $appointment->slot->start_time ?? 'N/A' }}
                                            </td>

                                            <td>
                                                {{ $appointment->reason ?? 'N/A' }}
                                            </td>

                                            <td>

                                                @if($appointment->status === 'Completed')
                                                    <span class="badge bg-success">
                                                        Completed
                                                    </span>
                                                @elseif($appointment->status === 'Rejected')
                                                    <span class="badge bg-danger">
                                                        Rejected
                                                    </span>
                                                @elseif($appointment->status === 'Cancelled')
                                                    <span class="badge bg-secondary">
                                                        Cancelled
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        {{ $appointment->status }}
                                                    </span>
                                                @endif

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="text-center py-4">
                            <i class="bi bi-clock-history fs-1 text-secondary"></i>

                            <p class="text-secondary mt-2 mb-0">
                                No previous appointments found.
                            </p>
                        </div>

                    @endif

                </div>

            </div>

        </section>

    @endif


    <!-- ================================================== -->
    <!-- WELCOME SECTION                                    -->
    <!-- ================================================== -->

    <section class="hero">

        <h1>Your Health, <span>Our Priority</span></h1>

        <p>
            Quality healthcare, experienced doctors, and compassionate care
            for you and your family.
        </p>

        <a href="#doctors" class="book-btn d-inline-block mt-3">
            Meet Our Doctors
            <i class="bi bi-arrow-right ms-1"></i>
        </a>

    </section>


    <!-- OUR SPECIALITIES -->
    <section class="speciality-section" id="specialities">

        <div class="section-title">

            <h2>Our Specialities</h2>

            <p>
                Comprehensive medical care for every stage of life.
            </p>

        </div>

        <div class="row g-4">

            <div class="col-6 col-md-4 col-lg-2">
                <div class="speciality-card">
                    <div class="speciality-icon">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h5>Cardiology</h5>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="speciality-card">
                    <div class="speciality-icon">
                        <i class="bi bi-activity"></i>
                    </div>
                    <h5>Neurology</h5>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="speciality-card">
                    <div class="speciality-icon">
                        <i class="bi bi-bandaid"></i>
                    </div>
                    <h5>Orthopedics</h5>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="speciality-card">
                    <div class="speciality-icon">
                        <i class="bi bi-person-hearts"></i>
                    </div>
                    <h5>Pediatrics</h5>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="speciality-card">
                    <div class="speciality-icon">
                        <i class="bi bi-clipboard2-pulse"></i>
                    </div>
                    <h5>General Medicine</h5>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-2">
                <div class="speciality-card">
                    <div class="speciality-icon">
                        <i class="bi bi-eye"></i>
                    </div>
                    <h5>Ophthalmology</h5>
                </div>
            </div>

        </div>

    </section>


    <!-- OUR DOCTORS -->
    <section class="doctors-section" id="doctors">

        <div class="section-title">

            <h2>Our Doctors</h2>

            <p>
                Meet our dedicated team of healthcare professionals.
            </p>

        </div>

        <div class="row g-4">

            <!-- Doctor 1 -->
            <div class="col-md-6 col-lg-3">

                <div class="doctor-card">

                    <img
                        src="https://placehold.co/400x300/e5f6f6/087f8c?text=Cardiologist"
                        alt="Cardiologist"
                        class="doctor-image">

                    <div class="doctor-details">

                        <h5>Dr. Arun Kumar</h5>

                        <p class="doctor-speciality">Cardiologist</p>

                        <p class="experience">
                            <i class="bi bi-briefcase me-1"></i>
                            12+ Years Experience
                        </p>

                        <a href="{{ route('appointments.create') }}"
                           class="book-btn d-block">
                            Book Appointment
                        </a>

                    </div>

                </div>

            </div>


            <!-- Doctor 2 -->
            <div class="col-md-6 col-lg-3">

                <div class="doctor-card">

                    <img
                        src="https://placehold.co/400x300/e5f6f6/087f8c?text=Neurologist"
                        alt="Neurologist"
                        class="doctor-image">

                    <div class="doctor-details">

                        <h5>Dr. Priya Nair</h5>

                        <p class="doctor-speciality">Neurologist</p>

                        <p class="experience">
                            <i class="bi bi-briefcase me-1"></i>
                            10+ Years Experience
                        </p>

                        <a href="{{ route('appointments.create') }}"
                           class="book-btn d-block">
                            Book Appointment
                        </a>

                    </div>

                </div>

            </div>


            <!-- Doctor 3 -->
            <div class="col-md-6 col-lg-3">

                <div class="doctor-card">

                    <img
                        src="https://placehold.co/400x300/e5f6f6/087f8c?text=Orthopedic"
                        alt="Orthopedic doctor"
                        class="doctor-image">

                    <div class="doctor-details">

                        <h5>Dr. Rahul Menon</h5>

                        <p class="doctor-speciality">
                            Orthopedic Specialist
                        </p>

                        <p class="experience">
                            <i class="bi bi-briefcase me-1"></i>
                            8+ Years Experience
                        </p>

                        <a href="{{ route('appointments.create') }}"
                           class="book-btn d-block">
                            Book Appointment
                        </a>

                    </div>

                </div>

            </div>


            <!-- Doctor 4 -->
            <div class="col-md-6 col-lg-3">

                <div class="doctor-card">

                    <img
                        src="https://placehold.co/400x300/e5f6f6/087f8c?text=Pediatrician"
                        alt="Pediatrician"
                        class="doctor-image">

                    <div class="doctor-details">

                        <h5>Dr. Anjali Thomas</h5>

                        <p class="doctor-speciality">Pediatrician</p>

                        <p class="experience">
                            <i class="bi bi-briefcase me-1"></i>
                            9+ Years Experience
                        </p>

                        <a href="{{ route('appointments.create') }}"
                           class="book-btn d-block">
                            Book Appointment
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- BOOKING SECTION -->
    <section class="py-5 text-center" id="book-appointment">

        <div class="container">

            <h2 class="fw-bold mb-3">
                Ready to Book Your Appointment?
            </h2>

            <p class="text-secondary mb-4">
                Take the first step towards better health.
            </p>

            <a href="{{ route('appointments.create') }}"
               class="book-appointment-btn">
                <i class="bi bi-calendar-plus me-1"></i>
                Book an Appointment
            </a>

        </div>

    </section>


    <!-- FOOTER -->
    <footer class="footer">

        <p>
            &copy; {{ date('Y') }} MediCare Hospital.
            All Rights Reserved.
        </p>

    </footer>

</body>
</html>

