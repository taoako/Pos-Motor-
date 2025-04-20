<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock-In Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1>Stock-In Details</h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Transaction ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Cost Price</th>
                    <th>Total Cost</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stockInDetails as $detail)
                    <tr>
                        <td>{{ $detail->id }}</td>
                        <td>{{ $detail->stock_in_transaction_id }}</td>
                        <td>{{ $detail->product->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ $detail->cost_price }}</td>
                        <td>{{ $detail->total_cost }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Button to navigate back to the Dashboard -->
        <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>

        <a href="{{ route('stock-in-details.create') }}" class="btn btn-primary mt-3">Add New Stock-In Detail</a>
    </div>
</body>
</html>
