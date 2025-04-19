<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1e;
            color: #e4e4e7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .container {
            padding: 50px 0;
            animation: fadeIn 0.7s ease-in-out;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .card {
            background-color: #2c2c2e;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
            color: #fff;
            overflow: hidden;
            animation: slideUp 0.8s ease;
        }

        @keyframes slideUp {
            0% { transform: translateY(20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        .card-header {
            background-color: #343a40;
            color: #ffca28;
            font-size: 1.8rem;
            font-weight: bold;
            text-align: center;
            padding: 20px;
            letter-spacing: 1px;
        }

        table {
            color: #fff;
            margin-top: 20px;
            animation: fadeIn 1s ease-in-out;
        }

        .table th {
            color: #ffca28;
            font-weight: bold;
            font-size: 1rem;
        }

        .table tbody tr {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .table tbody tr:hover {
            background-color: #3a3a3d;
            transform: scale(1.01);
        }

        .btn-back {
            background-color: #ffca28;
            color: #1c1c1e;
            font-weight: bold;
            padding: 10px 25px;
            border-radius: 30px;
            transition: all 0.3s ease-in-out;
        }

        .btn-back:hover {
            background-color: #e1a900;
            transform: scale(1.08);
            box-shadow: 0 0 15px rgba(255, 202, 40, 0.4);
        }

        .text-center.mt-4 {
            animation: fadeIn 1.3s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                Inventory
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Cost Price</th>
                            <th>Total Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category ?? 'N/A' }}</td>
                                <td>{{ $product->quantity }}</td>
                                <td>₱{{ number_format($product->cost_price, 2) }}</td>
                                <td>₱{{ number_format($product->cost_price * $product->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-center mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-back">← Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
