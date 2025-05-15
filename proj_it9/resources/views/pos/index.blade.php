<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f6fa;
            color: #222;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h3,
        h5,
        label {
            color: #222;
        }

        .product-card {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            padding: 15px;
            border-radius: 12px;
            transition: all 0.3s ease-in-out;
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(25, 118, 210, 0.08);
        }

        .product-card img {
            max-height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
            background: #f5f6fa;
        }

        .barcode {
            background-color: #f8f9fa;
            padding: 5px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            display: inline-block;
            margin-top: 10px;
        }

        .cart-card {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        .cart-item {
            border-bottom: 1px solid #e0e0e0;
            padding: 12px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-control {
            background-color: #f9f9f9;
            color: #222;
            border: 1px solid #bbb;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: #1976d2;
            box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.15);
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-success {
            background-color: #1976d2;
            color: #fff;
            border: none;
        }

        .btn-success:hover {
            background-color: #1565c0;
            color: #fff;
        }

        .btn-danger {
            background-color: #d32f2f;
            color: #fff;
            border: none;
        }

        .btn-danger:hover {
            background-color: #b71c1c;
            color: #fff;
        }

        .btn-primary {
            background-color: #388bfd;
            color: #fff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #1976d2;
            color: #fff;
        }

        .modal-content {
            background-color: #fff;
            color: #222;
        }

        .receipt {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            color: #222;
        }

        select.form-control {
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="black" height="16" width="16" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
            padding-right: 2.5rem;
            color: #222;
        }

        .text-muted {
            color: #888 !important;
        }

        .scroll-products {
            max-height: 70vh;
            overflow-y: auto;
        }

        .navbar-light {
            background-color: #fff !important;
            border-bottom: 1px solid #e0e0e0;
        }

        .navbar-light .navbar-brand,
        .navbar-light .nav-link {
            color: #1976d2 !important;
            font-weight: 600;
        }

        .navbar-light .nav-link.active {
            color: #fff !important;
            background: #1976d2 !important;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <!-- Navbar for admin quick switch -->
    <nav class="navbar navbar-expand-lg navbar-light mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">POS System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Auth::user()->employee->position === 'Admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('inventory.content') }}">Inventory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.content') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('suppliers.content') }}">Suppliers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('employees.content') }}">Employees</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm ms-2">Log Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container py-4">
        <div class="row">
            <!-- Products -->
            <div class="col-md-8">
                <div class="card shadow-lg" style="background-color: #fff;">
                    <div class="card-body scroll-products" style="max-height:70vh;overflow-y:auto;">
                        <h3 class="mb-3">Products</h3>
                        <!-- Category Filter -->
                        <form method="GET" class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <select name="category" id="categoryFilter" class="form-control"
                                        onchange="this.form.submit()">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="row g-3">
                            @foreach ($products as $product)
                                @if (!request('category') || $product->category_id == request('category'))
                                    <div class="col-md-4">
                                        <div class="product-card text-center">
                                            <!-- Product Image -->
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->product_name }}" class="img-fluid">

                                            <h5>{{ $product->product_name }}</h5>
                                            <p>₱{{ number_format($product->selling_price, 2) }}</p>
                                            <p>Stock: {{ $product->stock }}</p>

                                            <!-- Barcode Image -->
                                            @if (Storage::disk('public')->exists('barcodes/' . $product->barcode . '.png'))
                                                <div class="barcode">
                                                    <img src="{{ asset('storage/barcodes/' . $product->barcode . '.png') }}"
                                                        alt="Barcode" class="img-fluid">
                                                </div>
                                            @else
                                                <p class="text-muted">No Barcode Available</p>
                                            @endif

                                            <form action="{{ route('pos.addToCart') }}" method="POST"
                                                class="d-flex align-items-center justify-content-center gap-2">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="number" name="quantity" min="1" value="1" class="form-control mb-2"
                                                    style="width: 70px;">
                                                <button type="submit" class="btn btn-success btn-sm">Add</button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart -->
            <div class="col-md-4 position-sticky" style="top: 1rem;">
                <div class="card shadow-lg" style="background-color: #fff;">
                    <div class="card-body">
                        <h3 class="mb-3">Cart</h3>
                        <div class="cart-items">
                            @php $totalAmount = 0; @endphp
                            @foreach ($cart as $item)
                                @php $totalAmount += $item['price'] * $item['quantity']; @endphp
                                <div class="cart-item">
                                    <p>{{ $item['product_name'] }} - ₱{{ number_format($item['price'], 2) }} ×
                                        {{ $item['quantity'] }}
                                    </p>
                                    <form action="{{ route('pos.removeFromCart') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <p class="mt-3"><strong>Total:</strong> ₱{{ number_format($totalAmount, 2) }}</p>

                        <form action="{{ route('pos.checkout') }}" method="POST" id="checkoutForm">
                            @csrf
                            <div class="mb-3">
                                <label>Customer</label>
                                <div class="d-flex">
                                    <select name="customer_id" class="form-control me-2" required>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">
                                                {{ $customer->first_name }} {{ $customer->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" id="showAddCustomerModal">
                                        Add
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label>Payment Method</label>
                                <select name="payment_method" class="form-control" required>
                                    <option value="Cash">Cash</option>
                                    <option value="Card">Card</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Transaction Date</label>
                                <input type="date" name="transaction_date" id="transactionDate" class="form-control"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label>Amount Received</label>
                                <input type="number" name="amount_received" id="amountReceived" class="form-control"
                                    required min="0" step="any">
                                <div id="amountError" class="text-danger small mt-1" style="display:none;">Amount
                                    received is insufficient.</div>
                            </div>

                            <p><strong>Change:</strong> ₱<span id="changeAmount">0.00</span></p>

                            <button type="submit" class="btn btn-success w-100" id="checkoutBtn">Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCustomerModalLabel">Add Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<!-- Receipt Modal -->
@if (session('checkout_complete'))
    @php
        $transaction = session('transaction');
        // Ensure user relation is loaded and get full name
        $cashierName = '';
        if ($transaction->user) {
            if (isset($transaction->user->employee)) {
                $cashierName = trim(($transaction->user->employee->first_name ?? '') . ' ' . ($transaction->user->employee->last_name ?? ''));
            }
            if (!$cashierName) {
                $cashierName = trim(($transaction->user->first_name ?? '') . ' ' . ($transaction->user->last_name ?? ''));
            }
            if (!$cashierName && isset($transaction->user->name)) {
                $cashierName = $transaction->user->name;
            }
        }
    @endphp
    <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="receiptModalLabel">Receipt</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="receipt">
                        <h4>Receipt</h4>
                        <p><strong>Customer:</strong> {{ $transaction->customer->first_name }}
                            {{ $transaction->customer->last_name }}</p>
                        <p><strong>Cashier:</strong> {{ $cashierName ?: 'N/A' }}</p>
                        <ul>
                            @foreach ($transaction->transactionDetails as $detail)
                                <li>{{ $detail->product->product_name }} - ₱{{ number_format($detail->selling_price, 2) }} ×
                                    {{ $detail->quantity }}</li>
                            @endforeach
                        </ul>
                        <p><strong>Total:</strong> ₱{{ number_format($transaction->total_amount, 2) }}</p>
                        <p><strong>Received:</strong> ₱{{ number_format($transaction->amount_received, 2) }}</p>
                        <p><strong>Change:</strong> ₱{{ number_format($transaction->change, 2) }}</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('receipt.download', $transaction->id) }}" class="btn btn-primary">Download PDF</a>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set today's date for transaction_date
        const transactionDateInput = document.getElementById('transactionDate');
        if (transactionDateInput) {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            transactionDateInput.value = `${yyyy}-${mm}-${dd}`;
        }

        // Show Add Customer Modal
        const showAddCustomerModalBtn = document.getElementById('showAddCustomerModal');
        if (showAddCustomerModalBtn) {
            showAddCustomerModalBtn.addEventListener('click', function () {
                const modal = new bootstrap.Modal(document.getElementById('addCustomerModal'));
                modal.show();
            });
        }

        @if (session('checkout_complete'))
            const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
            receiptModal.show();
        @endif

        // Prevent checkout if amount received is less than total
        const checkoutForm = document.getElementById('checkoutForm');
        const amountReceivedInput = document.getElementById('amountReceived');
        const changeAmountSpan = document.getElementById('changeAmount');
        const amountError = document.getElementById('amountError');
        const totalAmount = {{ $totalAmount }};

        function validateAmount() {
            const received = parseFloat(amountReceivedInput.value) || 0;
            const change = received - totalAmount;
            changeAmountSpan.textContent = change >= 0 ? change.toFixed(2) : '0.00';
            if (received < totalAmount) {
                amountError.style.display = 'block';
                return false;
            } else {
                amountError.style.display = 'none';
                return true;
            }
        }

        amountReceivedInput.addEventListener('input', validateAmount);

        checkoutForm.addEventListener('submit', function (e) {
            if (!validateAmount()) {
                e.preventDefault();
                amountReceivedInput.focus();
            }
        });
    });
</script>

</html>