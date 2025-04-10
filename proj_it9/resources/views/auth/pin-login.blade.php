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
            /* Increase padding */
            border-radius: 15px;
            text-align: center;
            width: 450px;
            /* Increase width */
            height: 350px;
            /* Increase height */
        }

        .pin-input {
            font-size: 20px;
            /* Make input text bigger */
            text-align: center;
            width: 45px;
            /* Make input boxes bigger */
            height: 45px;
            margin: 10px;
            border-radius: 10px;
            border: 3px solid #333;
        }

        .btn-start {
            background: #2d7074;
            color: #fff;
            padding: 13px 35px;
            /* Make button bigger */
            font-size: 18px;
            /* Increase font size */
            border: none;
            border-radius: 8px;
        }

        h2 {
            font-size: 40px;
            /* Increase title size */
        }

        p {
            font-size: 12px;
            /* Increase subtitle size */
        }
    </style>
</head>

<body>
    <div class="login-box">
        <h2>MOTOR & <br>VEHICLE PARTS</h2>
        <p>POINT OF SALE SYSTEM</p>
        <form method="POST" action="{{ route('login') }}" id="pin-form">
            @csrf
            <div>
                <input type="password" maxlength="1" class="pin-input" id="pin1" oninput="moveNext(1)" autofocus
                    required>
                <input type="password" maxlength="1" class="pin-input" id="pin2" oninput="moveNext(2)" required>
                <input type="password" maxlength="1" class="pin-input" id="pin3" oninput="moveNext(3)" required>
                <input type="password" maxlength="1" class="pin-input" id="pin4" oninput="moveNext(4)" required>
                <input type="hidden" name="pin" id="pin">
            </div>
            @if ($errors->any())
                <p style="color: red;">{{ $errors->first() }}</p>
            @endif
            <button type="submit" class="btn btn-start mt-3">START</button>
        </form>
    </div>

    <script>
        function moveNext(index) {
            let input = document.getElementById('pin' + index);
            if (input.value.length === 1 && index < 4) {
                document.getElementById('pin' + (index + 1)).focus();
            }

            let pinValue = '';
            for (let i = 1; i <= 4; i++) {
                pinValue += document.getElementById('pin' + i).value;
            }
            document.getElementById('pin').value = pinValue; 
        }
    </script>
</body>

</html>