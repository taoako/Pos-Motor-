<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My App</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/supplier.css') }}">
    <style>
        /* General body styling */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(to right,rgb(36, 33, 33),rgb(150, 142, 142)); /* Gradient background */
            color: #ffffff; /* White text for contrast */
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Navbar styling */
        .navbar {
            background-color: #b30000; /* Dark red background */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
            padding: 15px 20px;
        }

        a.navbar-brand {
            font-weight: bold;
            font-size: 1.8rem;
            color: #ffffff; /* White text for the brand */
            transition: color 0.3s ease;
        }

        a.navbar-brand:hover {
            color: #ffcccc; /* Light pink hover effect */
        }

        /* Main container styling */
        .container {
            flex: 1;
            margin: 50px auto; /* Center the container horizontally */
            background-color: #ffffff; /* White background for content */
            color: #333333; /* Dark gray text */
            border-radius: 16px; /* Rounded corners */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); /* Stronger shadow for depth */
            padding: 40px;
            max-width: 900px; /* Limit the width of the container */
            animation: fadeIn 1s ease-in-out; /* Fade-in animation for the container */
        }

        /* Back button styling */
        .btn-back {
            background-color:rgb(36, 29, 29); /* Light red background */
            color: #ffffff; /* White text */
            font-weight: bold;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            display: inline-block;
            margin-bottom: 20px; /* Add spacing below the button */
        }

        .btn-back:hover {
            background-color:rgb(32, 27, 27); /* Darker red on hover */
            transform: translateY(-2px); /* Slight lift effect */
        }

        /* Footer styling */
        footer {
            background-color:rgb(32, 31, 31); /* Dark red background */
            color: #ffffff; /* White text */
            text-align: center;
            padding: 20px 0;
            border-top: 3px solid #ffcccc; /* Light pink border for contrast */
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
            font-size: 0.9rem;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 20px auto;
            }

            a.navbar-brand {
                font-size: 1.5rem; /* Smaller brand size for mobile */
            }

            footer {
                font-size: 0.8rem; /* Smaller footer text for mobile */
            }
        }
    </style>
</head>
<body>
    

    <!-- Main Content -->
    <div class="container">
        <!-- Back to Dashboard Button -->
        <a href="{{ route('dashboard') }}" class="btn-back">← Back to Dashboard</a>

        @yield('content')
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>