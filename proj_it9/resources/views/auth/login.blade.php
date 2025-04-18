<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #77696b;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background: #8a8a8a;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            width: 450px;
            height: auto;
        }

        .form-control {
            font-size: 18px;
            margin-bottom: 20px;
            border-radius: 10px;
            border: 3px solid #333;
        }

        .btn-start {
            background: #2d7074;
            color: #fff;
            padding: 13px 35px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
        }

        h2 {
            font-size: 40px;
        }

        p {
            font-size: 12px;
        }

        .password-container {
            position: relative;
            margin-bottom: 20px;
        }

        .toggle-password {
            position: absolute;
            top: 67%;
            right: 15px;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        .form-label {
            text-align: left;
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>MOTOR & <br>VEHICLE PARTS</h2>
        <p>POINT OF SALE SYSTEM</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required autofocus>
            </div>
            <div class="password-container">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                <button type="button" class="toggle-password" onclick="togglePassword()">Show</button>
            </div>
            @if ($errors->any())
            <p style="color: red;">{{ $errors->first() }}</p>
            @endif
            <button type="submit" class="btn btn-start mt-3">LOGIN</button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleButton = document.querySelector('.toggle-password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.textContent = 'Hide';
            } else {
                passwordField.type = 'password';
                toggleButton.textContent = 'Show';
            }
        }
    </script>
</body>

</html>