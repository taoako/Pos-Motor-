<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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