<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Stock-In Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #1f4037, #99f2c8); /* Gradient background */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .container {
            max-width: 900px;
            padding: 40px;
        }

        .card {
            background-color: #222222;
            color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px); /* Slight lift effect */
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3); /* Enhanced shadow effect */
        }

        .card-header {
            background-color: #4e73df;
            color: #fff;
            text-align: center;
            padding: 25px;
            border-radius: 15px 15px 0 0;
        }

        .card-header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            animation: fadeIn 0.6s ease-out; /* Card header fade-in animation */
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .form-label {
            font-weight: bold;
            color: #f7f7f7;
        }

        .form-select, .form-control {
            border-radius: 10px;
            border: 1px solid #d1d3e2;
            background-color: #444;
            color: #fff;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .form-select:focus, .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            background-color: #555;
            transform: scale(1.05); /* Scale effect on focus */
        }

        .form-control {
            padding: 15px;
            font-size: 1rem;
        }

        button {
            background-color: #4e73df;
            border-color: #4e73df;
            padding: 15px 25px;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            display: inline-block;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        button:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
            transform: scale(1.1); /* Button grow effect */
        }

        button:active {
            transform: scale(1); /* Restore to normal size when clicked */
        }

        .alert-success {
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            animation: fadeIn 1s ease-out;
        }

        .alert-danger {
            background-color: #dc3545;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            animation: fadeIn 1s ease-out;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .card {
                padding: 20px;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Create Stock-In Detail</h1>
            </div>
            <div class="card-body">

                <!-- Success or Error Message -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('stock-in-details.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="stock_in_transaction_id" class="form-label">Stock In Transaction</label>
                        <select class="form-select" name="stock_in_transaction_id" required>
                            <option value="">Select Transaction</option>
                            @foreach ($transactions as $transaction)
                                <option value="{{ $transaction->id }}">{{ $transaction->id }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product</label>
                        <select class="form-select" name="product_id" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label for="cost_price" class="form-label">Cost Price</label>
                        <input type="number" class="form-control" name="cost_price" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label for="total_cost" class="form-label">Total Cost</label>
                        <input type="number" class="form-control" name="total_cost" step="0.01" required>
                    </div>

                    <button type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
