<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Stock-In Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/BILAT.css') }}"> <!-- Link to the new CSS file -->
</head>
<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Create Stock-In Detail</h1>
            </div>
            <div class="card-body">

                <!-- Back Button -->
                <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">← Back</a>

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