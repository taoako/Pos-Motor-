<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Stock-In Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Smooth fade-in animation for the form */
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Button hover animation */
        .btn-hover:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }

        /* Card shadow animation */
        .card {
            transition: box-shadow 0.3s ease-in-out, background-color 0.3s ease-in-out;
            background-color: #f8f9fa; /* Light gray */
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            background-color: #e9ecef; /* Slightly darker gray */
        }

        /* Background color */
        body {
            background-color: #6c757d; /* Gray */
            color: #343a40; /* Dark gray for text */
        }

        /* Form labels */
        .form-label {
            font-weight: bold;
            color: #495057; /* Medium gray */
        }

        /* Form inputs */
        .form-control {
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #495057; /* Darker gray */
            box-shadow: 0 0 5px rgba(73, 80, 87, 0.5);
        }
    </style>
</head>
<body>
    <div class="container mt-5 fade-in">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Create Stock-In Detail</h1>
                <!-- Back to Dashboard Button -->
                <a href="{{ route('dashboard') }}" class="btn btn-light btn-hover">Back to Dashboard</a>
            </div>
            <div class="card-body">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success fade-in">
                        {{ session('success') }}
                    </div>
                @elseif($errors->any())
                    <div class="alert alert-danger fade-in">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('stock-in-details.store') }}" method="POST" class="fade-in">
                    @csrf

                    <!-- Supplier Dropdown -->
                    <div class="mb-3">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select class="form-select" name="supplier_id" required>
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Product Dropdown -->
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product</label>
                        <select class="form-select" name="product_id" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Quantity -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" min="1" required>
                    </div>

                    <!-- Cost Price -->
                    <div class="mb-3">
                        <label for="cost_price" class="form-label">Cost Price</label>
                        <input type="number" class="form-control" name="cost_price" id="cost_price" step="0.01" required>
                    </div>

                    <!-- Total Cost -->
                    <div class="mb-3">
                        <label for="total_cost" class="form-label">Total Cost</label>
                        <input type="number" class="form-control" name="total_cost" id="total_cost" step="0.01" readonly>
                    </div>

                    <!-- Interest -->
                    <div class="mb-3">
                        <label for="interest" class="form-label">Interest</label>
                        <input type="number" class="form-control" name="interest" id="interest" step="0.01" readonly>
                    </div>

                    <!-- Final Price -->
                    <div class="mb-3">
                        <label for="final_price" class="form-label">Final Price</label>
                        <input type="number" class="form-control" name="final_price" id="final_price" step="0.01" readonly>
                    </div>

                    <button type="submit" class="btn btn-success btn-hover">Save</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-hover">Back</a>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript to Calculate Total Cost, Interest, and Final Price -->
    <script>
        document.getElementById('quantity').addEventListener('input', calculateTotals);
        document.getElementById('cost_price').addEventListener('input', calculateTotals);

        function calculateTotals() {
            const quantity = parseFloat(document.getElementById('quantity').value) || 0;
            const costPrice = parseFloat(document.getElementById('cost_price').value) || 0;
            const totalCost = quantity * costPrice;

            // Calculate interest based on total cost
            let interestRate = 0.05; // Default interest rate is 5%
            if (totalCost > 10000) {
                interestRate = 0.10; // 10% interest for total cost > 10,000
            } else if (totalCost > 5000) {
                interestRate = 0.12; // 12% interest for total cost > 5,000
            }
            const interest = totalCost * interestRate;

            // Calculate final price (total cost + interest)
            const finalPrice = totalCost + interest;

            // Update the fields
            document.getElementById('total_cost').value = totalCost.toFixed(2);
            document.getElementById('interest').value = interest.toFixed(2);
            document.getElementById('final_price').value = finalPrice.toFixed(2);
        }
    </script>
</body>
</html>