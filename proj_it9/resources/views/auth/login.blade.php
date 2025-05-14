
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #c3d4ef;
            /* Match the dashboard background color */
            color: #e6edf3;
            /* Match the dashboard text color */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            background-color: #e1ebf8;
            /* Match the dashboard card background color */
            border: 1px solid #30363d;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background-color: #1f6feb;
            border-color: #1f6feb;
        }

        .btn-primary:hover {
            background-color: #388bfd;
            border-color: #388bfd;
        }

        .form-control {
            background-color: #d5e5fd;
            color: #c9d1d9;
            border: 1px solid #444c56;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: #58a6ff;
            box-shadow: 0 0 0 0.25rem rgba(56, 139, 253, 0.25);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Login Image -->
        <div class="login-image">
            <img src="https://img.freepik.com/premium-photo/front-view-generic-brandless-modern-sport-car-dark-background_110488-536.jpg"
                alt="Login Image">
        </div>

        <!-- Login Form -->
        <div class="login-form">
            <h2>Welcome back</h2>
            <p>Please login to your account</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <label for="username">User Name</label>
                <input type="text" id="username" name="username" required autofocus>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                @if ($errors->any())
                    <p class="error">{{ $errors->first() }}</p>
                @endif

                <div class="form-footer">
                    <a href="#" class="forgot">Forgot?</a>
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>