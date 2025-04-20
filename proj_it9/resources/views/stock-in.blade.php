<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1e; /* Dark background */
            color: #e4e4e7; /* Light gray text for contrast */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .card {
            background: #2c2c2e; /* Dark card background */
            border-radius: 12px; /* Rounded corners */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px); /* Card lift effect on hover */
        }

        .card-header {
            background-color: #343a40; /* Dark header */
            color: #ffca28; /* Golden header text */
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 20px 15px;
            text-align: center;
        }

        h1 {
            font-size: 2rem;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #ffca28; /* Gold button */
            border-color: #ffca28;
            color: #1c1c1e;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #e1a900; /* Darker gold on hover */
            border-color: #e1a900;
        }

        .btn-outline-secondary {
            border-color: #6c757d;
            color: #e4e4e7;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #1c1c1e;
        }

        .container {
            max-width: 900px;
            padding: 40px;
        }

        .card-body {
            padding: 30px;
        }

        .row h5 {
            color: #ffca28; /* Golden headings */
            font-weight: 600;
        }

        .text-center p {
            font-size: 1.5rem; /* Increased font size */
            margin-bottom: 30px;
            color: #f1f1f1; /* Light text color for better contrast */
            line-height: 1.5; /* Line spacing for readability */
        }

        .text-center a {
            padding: 12px 25px;
            font-size: 1.1rem;
            border-radius: 30px;
            transition: background-color 0.3s ease;
            color: #1c1c1e; /* Set text color for links */
        }

        .text-center a:hover {
            background-color: #e1a900;
            text-decoration: none;
        }

        .text-muted {
            color: #a1a1a6 !important;
        }

        /* Adjusting link color for better contrast */
        .text-muted a {
            color: #ffca28; /* Golden link color */
        }

        .text-muted a:hover {
            color: #e1a900; /* Darker gold on hover */
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <!-- Card for the Stock In page -->
        <div class="card shadow-lg rounded">
            <div class="card-header">
                <h1 class="mb-0">Stock In</h1>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <p>Welcome to the Stock In page. Manage your stock and keep track of your inventory in a few clicks.</p>
                    <a href="{{ route('stock-in-details.create') }}" class="btn btn-primary btn-lg">Add New Stock</a>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h5>Current Stock</h5>
                        <p class="text-muted">Monitor your existing stock and make informed decisions.</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Stock History</h5>
                        <p class="text-muted">Review past stock transactions and track movements with ease.</p>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('inventory') }}" class="btn btn-outline-secondary">Go to Inventory</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
