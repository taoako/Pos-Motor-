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
            background-color: #0d1117;
            color: #e6edf3;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h3,
        h5,
        label {
            color: #f0f6fc;
        }

        .product-card {
            background-color: #161b22;
            border: 1px solid #30363d;
            padding: 15px;
            border-radius: 12px;
            transition: all 0.3s ease-in-out;
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 255, 204, 0.1);
        }

        .product-card img {
            max-height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .barcode {
            background-color: #ffffff;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 8px;
            display: inline-block;
            margin-top: 10px;
        }

        .cart-card {
            background-color: #23272f;
            border: 1px solid #30363d;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .cart-item {
            border-bottom: 1px solid #30363d;
            padding: 12px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-control {
            background-color: #21262d;
            color: #c9d1d9;
            border: 1px solid #444c56;
            border-radius: 8px;
        }

        .form-control:focus {
            border-color: #58a6ff;
            box-shadow: 0 0 0 0.25rem rgba(56, 139, 253, 0.25);
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-success {
            background-color: #238636;
        }

        .btn-success:hover {
            background-color: #2ea043;
        }

        .btn-danger {
            background-color: #da3633;
        }

        .btn-danger:hover {
            background-color: #f85149;
        }

        .btn-primary {
            background-color: #1f6feb;
        }

        .btn-primary:hover {
            background-color: #388bfd;
        }

        .modal-content {
            background-color: #161b22;
            color: #e6edf3;
        }

        .receipt {
            background-color: #0d1117;
            padding: 20px;
            border: 1px solid #30363d;
            border-radius: 12px;
        }

        select.form-control {
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="white" height="16" width="16" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
            padding-right: 2.5rem;
        }
    </style>
</head>

<body>
    <header class="py-4 mb-4 shadow-sm" style="background-color: #161b22; border-bottom: 1px solid #30363d;">
        <div class="container d-flex align-items-center justify-content-center">
            <i class="fas fa-car-side fa-2x text-info me-3"></i>
            <h1 class="m-0" style="color: #58a6ff; font-weight: bold;">Motor and Car Parts POS</h1>
        </div>
    </header>
    <div class="container py-4">
        <div class="row">
            <!-- Products -->
            <div class="col-md-8">
                <div class="card shadow-lg" style="background-color: #161b22;">
                    <div class="card-body">
                        <h3 class="mb-3">Products</h3>
                        <div class="row g-3">
                            @foreach ($products as $product)
                                <div class="col-md-4">
                                    <div class="product-card text-center">
                                        <!-- Product Image -->
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="img-fluid">

                                        <h5>{{ $product->product_name }}</h5>
                                        <p>₱{{ number_format($product->selling_price, 2) }}</p>
                                        <p>Stock: {{ $product->stock }}</p>

                                        <!-- Barcode Image -->
                                        @if (Storage::disk('public')->exists('barcodes/' . $product->barcode . '.png'))
                                            <div class="barcode">
                                                <img src="{{ asset('storage/barcodes/' . $product->barcode . '.png') }}" alt="Barcode" class="img-fluid">
                                            </div>
                                        @else
                                            <p class="text-muted">No Barcode Available</p>
                                        @endif

                                        <form action="{{ route('pos.addToCart') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="number" name="quantity" min="1" value="1" class="form-control mb-2">
                                            <button type="submit" class="btn btn-success btn-sm w-100">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart -->
            <div class="col-md-4 position-sticky" style="top: 1rem;">
                <div class="card shadow-lg" style="background-color: #23272f;">
                    <div class="card-body">
                        <h3 class="mb-3">Cart</h3>
                        <div class="cart-items">
                            @php $totalAmount = 0; @endphp
                            @foreach ($cart as $item)
                                @php $totalAmount += $item['price'] * $item['quantity']; @endphp
                                <div class="cart-item">
                                    <p>{{ $item['product_name'] }} - ₱{{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}</p>
                                    <form action="{{ route('pos.removeFromCart') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <p class="mt-3"><strong>Total:</strong> ₱{{ number_format($totalAmount, 2) }}</p>

                        <form action="{{ route('pos.checkout') }}" method="POST">
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
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
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
                                <input type="date" name="transaction_date" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>Amount Received</label>
                                <input type="number" name="amount_received" id="amountReceived" class="form-control" required>
                            </div>

                            <p><strong>Change:</strong> ₱<span id="changeAmount">0.00</span></p>

                            <button type="submit" class="btn btn-success w-100">Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <!-- Receipt Modal -->
    @if (session('checkout_complete'))
        @php $transaction = session('transaction'); @endphp
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
                                {{ $transaction->customer->last_name }}
                            </p>
                            <ul>
                                @foreach ($transaction->transactionDetails as $detail)
                                    <li>{{ $detail->product->product_name }} - ${{ $detail->selling_price }} ×
                                        {{ $detail->quantity }}
                                    </li>
                                @endforeach
                            </ul>
                            <p><strong>Total:</strong> ${{ $transaction->total_amount }}</p>
                            <p><strong>Received:</strong> ${{ $transaction->amount_received }}</p>
                            <p><strong>Change:</strong> ${{ $transaction->change }}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('receipt.download', $transaction->id) }}" class="btn btn-primary">Download
                            PDF</a>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('checkout_complete'))
                const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
                receiptModal.show();
            @endif
        });

        const amountReceivedInput = document.getElementById('amountReceived');
        const changeAmountSpan = document.getElementById('changeAmount');
        const totalAmount = {{ $totalAmount }};

        amountReceivedInput.addEventListener('input', function () {
            const received = parseFloat(this.value) || 0;
            const change = received - totalAmount;
            changeAmountSpan.textContent = change >= 0 ? change.toFixed(2) : '0.00';
        });
    </script>

    <!-- Log Out Button -->
    <form action="{{ route('logout') }}" method="POST" class="position-fixed bottom-0 end-0 m-4">
        @csrf
        <button type="submit" class="btn btn-danger btn-sm">Log Out</button>
    </form>
</body>

</html>