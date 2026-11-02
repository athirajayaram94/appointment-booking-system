<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MediCare Hospital | Login</title>

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
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .hospital-icon {
            width: 75px;
            height: 75px;
            background: #e0f2f1;
            color: #00897b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            margin: 0 auto 15px;
        }

        .hospital-name {
            color: #00897b;
            font-weight: bold;
        }

        .form-control {
            padding: 12px;
            border-radius: 8px;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background: #00897b;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
        }

        .login-button:hover {
            background: #00695c;
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

<div class="login-container">

    <div class="login-card">

        <div class="hospital-icon">✚</div>

        <h2 class="text-center hospital-name">MediCare Hospital</h2>

        <p class="text-center text-muted mb-4">
            Hospital Appointment Booking System
        </p>

        <h4 class="text-center mb-4">Welcome Back!</h4>

          <form action="{{ route('login.submit') }}" method="POST">
    @csrf
    
    @if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>

                <input type="email"
                       id="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter your email"
                       required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>

                <input type="password"
                       id="password"
                       name="password"
                       class="form-control"
                       placeholder="Enter your password"
                       required>
            </div>

            <div class="d-flex justify-content-between mb-4">
                <div>
                    <input type="checkbox" id="remember">
                    <label for="remember">Remember me</label>
                </div>

                <a href="#" class="text-decoration-none">
                    Forgot Password?
                </a>
            </div>

            <button type="submit" class="login-button">
                Login
            </button>
            <p class="text-center mt-4 mb-0">
    Don't have an account?
    <a href="{{ route('register') }}" class="text-decoration-none"
       style="color: #00897b; font-weight: bold;">
        Register Here
    </a>
</p>

        </form>

        <p class="footer-text">
            &copy; {{ date('Y') }} MediCare Hospital.
            All rights reserved.
        </p>

    </div>

</div>

</body>
</html>
