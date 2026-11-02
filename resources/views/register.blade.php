<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MediCare Hospital | Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #e8f5e9);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 15px;
        }

        .register-container {
            width: 100%;
            max-width: 480px;
        }

        .register-card {
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .hospital-icon {
            width: 65px;
            height: 65px;
            background: #e0f2f1;
            color: #00897b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin: 0 auto 15px;
        }

        .hospital-name {
            color: #00897b;
            font-weight: bold;
        }

        .form-control {
            padding: 11px;
            border-radius: 8px;
        }

        .register-button {
            width: 100%;
            padding: 12px;
            background: #00897b;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
        }

        .register-button:hover {
            background: #00695c;
        }

        .login-link {
            color: #00897b;
            font-weight: bold;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        .footer-text {
            color: #777;
            font-size: 13px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<div class="register-container">

    <div class="register-card">

        <div class="hospital-icon">✚</div>

        <h2 class="text-center hospital-name">MediCare Hospital</h2>

        <p class="text-center text-muted mb-4">
            Hospital Appointment Booking System
        </p>

        <h4 class="text-center mb-4">Create Your Account</h4>

     <form action="{{ route('register.submit') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control"
               value="{{ old('name') }}" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control"
               value="{{ old('email') }}" required>
    </div>

    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password"
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation"
               class="form-control" required>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <button type="submit" class="btn btn-primary w-100">
        Register
    </button>
</form>

        <p class="text-center mt-4 mb-0">
            Already have an account?
            <a href="{{ route('login') }}" class="login-link">
                Login Here
            </a>
        </p>

        <p class="footer-text">
            &copy; {{ date('Y') }} MediCare Hospital.
            All rights reserved.
        </p>

    </div>

</div>

</body>
</html>