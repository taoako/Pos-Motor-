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
            background-color: #1a1a2e; /* Dark Purple */
            color: #e0e0e0; /* Light Gray */
        }
        .container {
            margin-top: 30px;
        }
        .product-card {
            background-color: #16213e; /* Deep Blue */
            border: 1px solid #0f3460; /* Teal Border */
            padding: 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }
        .product-card h5, .product-card p {
            color: #e0e0e0; /* Light Gray */
        }
        .cart-item {
            border-bottom: 1px solid #0f3460; /* Teal */
            padding: 10px 0;
            animation: fadeIn 0.5s ease-in-out;
        }
        .cart-item p {
            color: #e0e0e0; /* Light Gray */
        }
        .btn-primary, .btn-success, .btn-danger {
            background-color: #0f3460; /* Teal */
            border: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover, .btn-success:hover, .btn-danger:hover {
            background-color: #3282b8; /* Lighter Teal */
            transform: translateY(-2px);
        }
        .modal-content {
            background-color: #16213e; /* Deep Blue */
            color: #e0e0e0; /* Light Gray */
            animation: slideIn 0.5s ease-out;
        }
        .form-control {
            background-color: #0f3460; /* Teal */
            color: #e0e0e0; /* Light Gray */
            border: 1px solid #3282b8; /* Lighter Teal */
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            background-color: #0f3460; /* Teal */
            color: #e0e0e0; /* Light Gray */
            border-color: #3282b8; /* Lighter Teal */
            box-shadow: 0 0 5px rgba(50, 130, 184, 0.5); /* Teal Glow */
        }
        .receipt-modal .modal-content {
            background-color: #16213e; /* Deep Blue */
            color: #e0e0e0; /* Light Gray */
        }
        .receipt-modal .modal-header, .receipt-modal .modal-footer {
            border: none;
        }
        .receipt-modal .modal-body {
            padding: 20px;
        }
        .receipt {
            background-color: #16213e; /* Deep Blue */
            border: 1px solid #0f3460; /* Teal */
            padding: 20px;
            border-radius: 8px;
        }
        .receipt h4, .receipt p, .receipt ul {
            color: #e0e0e0; /* Light Gray */
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <!-- Products -->
        <div class="col-md-8">
            <h3>Products</h3>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-3">
                        <div class="product-card text-center">
                            <h5>{{ $product->product_name }}</h5>
                            <p>Price: ${{ $product->selling_price }}</p>
                            <p>Stock: {{ $product->stock }}</p>
                            <form action="{{ route('pos.addToCart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="number" name="quantity" min="1" value="1" class="form-control mb-2">
                                <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Cart -->
        <div class="col-md-4">
            <h3>Cart</h3>
            <div class="cart-items">
                @php
                    $totalAmount = 0;
                @endphp
                @foreach($cart as $item)
                    @php
                        $totalAmount += $item['price'] * $item['quantity'];
                    @endphp
                    <div class="cart-item">
                        <p>{{ $item['product_name'] }} - ${{ $item['price'] }} x {{ $item['quantity'] }}</p>
                        <form action="{{ route('pos.removeFromCart') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </div>
                @endforeach
            </div>
            <p><strong>Total Amount:</strong> ${{ $totalAmount }}</p>
            <form action="{{ route('pos.checkout') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="customer_id" class="form-label">Customer</label>
                    <div class="d-flex">
                        <select name="customer_id" class="form-control me-2" required>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                            Add Customer
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-control" required>
                        <option value="Cash">Cash</option>
                        <option value="Card">Card</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="amount_received" class="form-label">Amount Received</label>
                    <input type="number" name="amount_received" id="amountReceived" class="form-control" required>
                </div>
                <p><strong>Change:</strong> $<span id="changeAmount">0.00</span></p>
                <button type="submit" class="btn btn-success btn-block">Checkout</button>
            </form>
        </div>
    </div>

    <!-- Modal for Adding a New Customer -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('customers.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Customer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    @if(session('checkout_complete'))
        @php
            $transaction = session('transaction');
        @endphp
        <div class="modal fade receipt-modal" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="receiptModalLabel">Receipt</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="receipt">
                            <h4>Receipt</h4>
                            <p><strong>Customer:</strong> {{ $transaction->customer->first_name }} {{ $transaction->customer->last_name }}</p>
                            <ul>
                                @foreach($transaction->transactionDetails as $detail)
                                    <li>{{ $detail->product->product_name }} - ${{ $detail->selling_price }} x {{ $detail->quantity }}</li>
                                @endforeach
                            </ul>
                            <p><strong>Total:</strong> ${{ $transaction->total_amount }}</p>
                            <p><strong>Amount Received:</strong> ${{ $transaction->amount_received }}</p>
                            <p><strong>Change:</strong> ${{ $transaction->change }}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Automatically show the receipt modal if the checkout is complete
    @if(session('checkout_complete'))
        const receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
        receiptModal.show();
    @endif

    // Calculate and display change dynamically
    const amountReceivedInput = document.getElementById('amountReceived');
    const changeAmountSpan = document.getElementById('changeAmount');
    const totalAmount = {{ $totalAmount }};

    amountReceivedInput.addEventListener('input', function () {
        const amountReceived = parseFloat(amountReceivedInput.value) || 0;
        const change = amountReceived - totalAmount;
        changeAmountSpan.textContent = change >= 0 ? change.toFixed(2) : '0.00';
    });
</script>
</body>
</html>