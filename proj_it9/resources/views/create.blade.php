<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Stock In Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin-top: 50px;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.5rem;
            text-align: center;
            padding: 15px 0;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .form-label {
            font-weight: bold;
        }

        .form-select,
        .form-control {
            height: 40px;
            border-radius: 5px;
        }

        .alert {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Create Stock In Detail</h4>
            </div>
            <div class="card-body">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Form Start -->
                <form action="{{ route('stock-in-details.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="stock_in_transaction_id" class="form-label">Stock In Transaction</label>
                        <select class="form-select" name="stock_in_transaction_id" required>
                            <option value="">Select Transaction</option>
                            @foreach ($transactions as $transaction)
                                <option value="{{ $transaction->id }}" 
                                    {{ old('stock_in_transaction_id') == $transaction->id ? 'selected' : '' }}>
                                    {{ $transaction->id }} - {{ $transaction->purchase_date }}
                                </option>
                            @endforeach
                        </select>
                        @error('stock_in_transaction_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product</label>
                        <select class="form-select" name="product_id" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" min="1" value="{{ old('quantity') }}" required>
                        @error('quantity')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cost_price" class="form-label">Cost Price</label>
                        <input type="number" class="form-control" name="cost_price" step="0.01" value="{{ old('cost_price') }}" required>
                        @error('cost_price')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="total_cost" class="form-label">Total Cost</label>
                        <input type="number" class="form-control" name="total_cost" step="0.01" value="{{ old('total_cost') }}" required>
                        @error('total_cost')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
