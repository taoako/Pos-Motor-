<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Stock In Transaction</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .card-body {
            padding: 30px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card shadow-lg rounded">
            <div class="card-header text-center">
                <h3>Create Stock In Transaction</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('stock-in-transaction.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select id="supplier_id" name="supplier_id" class="form-select" required>
                            <option value="" disabled selected>Select Supplier</option>
                            <!-- Loop through suppliers in the back-end and populate options dynamically -->
                            <option value="1">Supplier 1</option>
                            <option value="2">Supplier 2</option>
                            <option value="3">Supplier 3</option>
                            <!-- Add more suppliers here -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="purchase_date" class="form-label">Purchase Date</label>
                        <input type="date" id="purchase_date" name="purchase_date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Total Amount</label>
                        <input type="number" id="total_amount" name="total_amount" class="form-control" required step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
