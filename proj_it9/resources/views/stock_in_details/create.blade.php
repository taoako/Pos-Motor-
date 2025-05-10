<!-- filepath: c:\laravel\pos motor and vechicle parts\it9_proj\proj_it9\resources\views\stock_in_details\create.blade.php -->
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
            background-color: #f8f9fa;
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            background-color: #e9ecef;
        }

        /* Background color */
        body {
            background-color: #6c757d;
            color: #343a40;
        }

        /* Form labels */
        .form-label {
            font-weight: bold;
            color: #495057;
        }

        /* Form inputs */
        .form-control {
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #495057;
            box-shadow: 0 0 5px rgba(73, 80, 87, 0.5);
        }
    </style>
</head>

<body>
    <div class="container mt-5 fade-in">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Create Stock-In Transaction</h1>
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

                <form action="{{ route('stock-in.store') }}" method="POST">
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

                    <!-- Purchase Date -->
                    <div class="mb-3">
                        <label for="purchase_date" class="form-label">Purchase Date</label>
                        <input type="date" class="form-control" name="purchase_date" required>
                    </div>

                    <!-- Products Section -->
                    <div id="products-section">
                        <div class="product-item mb-3 border rounded p-3">
                            <h5>Product 1</h5>
                            <div class="mb-3">
                                <label for="product_id" class="form-label">Product</label>
                                <select class="form-select" name="products[0][product_id]" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="products[0][quantity]" min="1" required>
                            </div>
                            <div class="mb-3">
                                <label for="cost_price" class="form-label">Cost Price</label>
                                <input type="number" class="form-control" name="products[0][cost_price]" step="0.01" required>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-product" class="btn btn-primary mb-3">+ Add Another Product</button>

                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let productIndex = 1;

            document.getElementById('add-product').addEventListener('click', function() {
                const productsSection = document.getElementById('products-section');

                const newProduct = document.createElement('div');
                newProduct.classList.add('product-item', 'mb-3', 'border', 'rounded', 'p-3');
                newProduct.innerHTML = `
                    <h5>Product ${productIndex + 1}</h5>
                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product</label>
                        <select class="form-select" name="products[${productIndex}][product_id]" required>
                            <option value="">Select Product</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="products[${productIndex}][quantity]" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="cost_price" class="form-label">Cost Price</label>
                        <input type="number" class="form-control" name="products[${productIndex}][cost_price]" step="0.01" required>
                    </div>
                `;

                productsSection.appendChild(newProduct);
                productIndex++;
            });
        });
    </script>
</body>

</html>