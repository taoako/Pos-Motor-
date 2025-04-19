<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Stock-In Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1D2B64, #F8C4D8); /* Purple-blue gradient background */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            color: #ffffff;
        }

        .container {
            max-width: 900px;
            padding: 50px;
        }

        .card {
            background-color: #2C3E50; /* Deep blue-gray */
            color: #ecf0f1; /* Off white */
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-15px); /* More pronounced lift */
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4); /* Enhanced shadow */
        }

        .card-header {
            background-color: #8E44AD; /* Purple color */
            color: #fff;
            text-align: center;
            padding: 25px;
            border-radius: 20px 20px 0 0;
        }

        .card-header h1 {
            margin: 0;
            font-size: 2.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            animation: fadeIn 0.6s ease-out;
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
            border-radius: 12px;
            border: 1px solid #d1d3e2;
            background-color: #34495E; /* Dark gray with blue undertones */
            color: #ecf0f1;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .form-select:focus, .form-control:focus {
            border-color: #8E44AD;
            box-shadow: 0 0 0 0.2rem rgba(142, 68, 173, 0.25); /* Purple glow on focus */
            background-color: #5D6D7E; /* Lighter dark gray */
            transform: scale(1.05); /* Subtle scale effect */
        }

        .form-control {
            padding: 15px;
            font-size: 1.1rem;
        }

        button {
            background-color: #8E44AD; /* Purple */
            border-color: #8E44AD;
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
            background-color: #9B59B6; /* Lighter purple */
            border-color: #9B59B6;
            transform: scale(1.1); /* Button grow effect */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25); /* Enhanced shadow */
        }

        button:active {
            transform: scale(1); /* Restore size on click */
        }

        .alert-success {
            background-color: #27AE60; /* Green success */
            color: white;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
            animation: fadeIn 1s ease-out;
        }

        .alert-danger {
            background-color: #E74C3C; /* Red error */
            color: white;
            padding: 15px;
            border-radius: 12px;
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
