<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        /* Product card hover animation */
        .product-card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        /* Button hover animation */
        .btn-hover {
            transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .btn-hover:hover {
            transform: scale(1.05);
        }

        /* Order summary styles */
        .order-summary {
            background-color: #1a202c; /* Dark gray */
            color: #e2e8f0; /* Light gray text */
            border-radius: 8px;
            padding: 20px;
        }

        .order-summary h1 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .order-summary .totals {
            margin-top: 20px;
            border-top: 1px solid #2d3748;
            padding-top: 10px;
        }

        .order-summary .totals div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .order-summary .totals .total {
            font-size: 1.2rem;
            font-weight: bold;
        }

        /* Receipt modal styles */
        .receipt-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .receipt-content {
            background: #ffffff;
            color: #000000;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
        }
    </style>
</head>

<body class="bg-gray-900 text-gray-100" x-data="posApp()">
    <div class="min-h-screen p-6">
        <!-- Header Section -->
        <div class="text-center mb-6">
            <h1 class="text-4xl font-bold text-gray-100">Point of Sale</h1>
            <p class="text-gray-400">Select products and manage your orders efficiently</p>
        </div>

        <!-- Category Buttons -->
        <div class="flex justify-center space-x-4 mb-6">
            <button class="bg-indigo-600 text-white py-2 px-6 rounded btn-hover shadow-md"
                @click="filterCategory('car')">Car Parts</button>
            <button class="bg-teal-600 text-white py-2 px-6 rounded btn-hover shadow-md"
                @click="filterCategory('motor')">Motor Parts</button>
            <button class="bg-gray-600 text-white py-2 px-6 rounded btn-hover shadow-md"
                @click="showAllProducts()">All Products</button>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <!-- Products Section -->
            <div class="col-span-2 bg-gray-800 p-6 rounded shadow">
                <h2 class="text-2xl font-bold mb-4 text-center text-gray-100">Available Products</h2>
                <div class="grid grid-cols-3 gap-4">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <div class="border rounded-lg p-4 text-center shadow product-card bg-gray-700">
                            <img :src="product.image_url" :alt="product.name" class="h-24 mx-auto mb-2">
                            <h2 class="font-bold text-lg text-gray-100" x-text="product.name"></h2>
                            <p class="text-sm text-gray-400" x-text="'Brand: ' + product.brand"></p>
                            <p class="text-sm text-gray-400" x-text="'Category: ' + product.category"></p>
                            <p class="text-lg font-bold text-indigo-400" x-text="'PHP ' + product.price"></p>
                            <p class="text-sm text-gray-400" x-text="'Stock: ' + product.stock"></p>
                            <button class="mt-2 bg-indigo-600 text-white px-4 py-2 rounded btn-hover"
                                @click="addToOrder(product)">
                                Add to Order
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Orders Section -->
            <div class="order-summary">
    <h1>Order Summary</h1>
    <div id="order-list" class="space-y-4 max-h-[60vh] overflow-y-auto">
        <template x-for="(item, index) in orders" :key="item.id">
            <div class="flex justify-between items-center bg-gray-700 p-2 rounded">
                <div class="flex items-center">
                    <button class="text-lg text-gray-300 mr-2 btn-hover"
                        @click="updateQuantity(index, 'decrease')">-</button>
                    <p class="font-semibold text-gray-200" x-text="item.name"></p>
                    <span class="ml-2 text-gray-400">x</span>
                    <p class="text-sm text-gray-300" x-text="item.quantity"></p>
                    <button class="text-lg text-gray-300 ml-2 btn-hover"
                        @click="updateQuantity(index, 'increase')">+</button>
                </div>
                <p class="text-sm text-gray-300" x-text="'PHP ' + (item.price * item.quantity).toFixed(2)"></p>
                <button class="text-red-400 hover:text-red-200 btn-hover"
                    @click="removeOrder(index)">×</button>
            </div>
        </template>
    </div>

    <div class="totals">
        <div>
            <span>Subtotal:</span>
            <span x-text="'PHP ' + subtotal.toFixed(2)"></span>
        </div>
        <div>
            <span>Discount:</span>
            <span x-text="'PHP ' + discount.toFixed(2)"></span>
        </div>
        <div>
            <span>Total:</span>
            <span x-text="'PHP ' + total.toFixed(2)"></span>
        </div>
        <div class="mt-4">
            <label for="customerName" class="block text-sm text-gray-400">Customer Name:</label>
            <input type="text" id="customerName" class="w-full p-2 rounded bg-gray-800 text-gray-100"
                placeholder="Enter customer name" x-model="customerName">
        </div>
        <div class="mt-4">
            <label for="payment" class="block text-sm text-gray-400">Payment Method:</label>
            <select id="payment" class="w-full p-2 rounded bg-gray-800 text-gray-100" x-model="paymentMethod">
                <option value="cash">Cash</option>
                <option value="digital">Digital Payment</option>
            </select>
        </div>
        <div class="mt-4" x-show="paymentMethod === 'cash'">
            <label for="cash" class="block text-sm text-gray-400">Cash Payment:</label>
            <input type="number" id="cash" class="w-full p-2 rounded bg-gray-800 text-gray-100"
                placeholder="Enter cash amount" x-model.number="cashPayment">
        </div>
        <div class="mt-2" x-show="paymentMethod === 'cash'">
            <span>Change:</span>
            <span x-text="'PHP ' + change.toFixed(2)"></span>
        </div>
    </div>
    <button class="mt-4 w-full bg-indigo-600 text-white py-2 rounded btn-hover"
        @click="processPayment()">
        Complete Payment
    </button>
    <button class="mt-4 w-full bg-green-600 text-white py-2 rounded btn-hover"
        @click="newTransaction()">
        New Transaction
    </button>
</div>
    <!-- Receipt Modal -->
    <div class="receipt-modal" x-show="showReceipt" @click.away="showReceipt = false">
    <div class="receipt-content" id="receipt" style="text-align: center;">
        <h2 class="text-2xl font-bold mb-4">Receipt</h2>
        <p><strong>Customer:</strong> <span x-text="customerName"></span></p>
        <p><strong>Payment Method:</strong> <span x-text="paymentMethod"></span></p>
        <p><strong>Total Paid:</strong> PHP <span x-text="paymentMethod === 'cash' ? cashPayment.toFixed(2) : total.toFixed(2)"></span></p>
        <p><strong>Change:</strong> PHP <span x-text="change.toFixed(2)"></span></p>
        <button class="mt-4 bg-blue-600 text-white py-2 px-4 rounded btn-hover" @click="printReceipt()">
            Print Receipt
        </button>
        <button class="mt-4 bg-red-600 text-white py-2 px-4 rounded btn-hover" @click="showReceipt = false">
            Close
        </button>
    </div>
</div>

    <script>
        function posApp() {
            return {
                orders: [],
                products: [
                    { id: 1, name: 'Car Tire', brand: 'Brand A', category: 'car', price: 1000, stock: 10, image_url: 'https://via.placeholder.com/150' },
                    { id: 2, name: 'Motor Oil', brand: 'Brand B', category: 'motor', price: 500, stock: 20, image_url: 'https://via.placeholder.com/150' },
                    { id: 3, name: 'Car Battery', brand: 'Brand C', category: 'car', price: 3000, stock: 5, image_url: 'https://via.placeholder.com/150' },
                    { id: 4, name: 'Motor Helmet', brand: 'Brand D', category: 'motor', price: 1500, stock: 15, image_url: 'https://via.placeholder.com/150' },
                ],
                filteredProducts: [],
                paymentMethod: 'cash',
                cashPayment: 0,
                customerName: '',
                showReceipt: false,
                get subtotal() {
                    return this.orders.reduce((sum, item) => sum + item.price * item.quantity, 0);
                },
                get discount() {
                    return this.subtotal > 5000 ? this.subtotal * 0.1 : 0; // 10% discount if subtotal > 5000
                },
                get total() {
                    return this.subtotal - this.discount;
                },
                get change() {
                    return this.cashPayment - this.total > 0 ? this.cashPayment - this.total : 0;
                },
                addToOrder(product) {
                    const existingItem = this.orders.find(item => item.id === product.id);
                    if (existingItem) {
                        existingItem.quantity += 1;
                    } else {
                        this.orders.push({ ...product, quantity: 1 });
                    }
                },
                updateQuantity(index, action) {
                    if (action === 'increase') {
                        this.orders[index].quantity += 1;
                    } else if (action === 'decrease' && this.orders[index].quantity > 1) {
                        this.orders[index].quantity -= 1;
                    }
                },
                removeOrder(index) {
                    this.orders.splice(index, 1);
                },
                filterCategory(category) {
                    this.filteredProducts = this.products.filter(product => product.category === category);
                },
                showAllProducts() {
                    this.filteredProducts = this.products; // Reset to show all products
                },
                processPayment() {
                    if (this.orders.length === 0) {
                        alert("Your order list is empty!");
                        return;
                    }

                    if (this.paymentMethod === 'cash') {
                        if (this.cashPayment < this.total) {
                            alert("Insufficient cash payment!");
                            return;
                        }
                    }

                    // Debugging: Log the values to ensure they are correct
                    console.log("Total:", this.total);
                    console.log("Cash Payment:", this.cashPayment);
                    console.log("Change:", this.change);

                    // Simulate saving to the database
                    console.log("Order Details:", this.orders);
                    console.log("Payment Method:", this.paymentMethod);
                    alert("Payment successful! Thank you for your purchase.");

                    // Automatically show the receipt after payment
                    this.showReceipt = true;
                },
                printReceipt() {
                    const receiptContent = document.getElementById('receipt').innerHTML;
                    const originalContent = document.body.innerHTML;

                    // Replace the body content with the receipt content
                    document.body.innerHTML = receiptContent;

                    // Trigger the print dialog
                    window.print();

                    // Restore the original content
                    document.body.innerHTML = originalContent;

                    // Reinitialize Alpine.js after restoring the content
                    window.location.reload();
                },
                newTransaction() {
                    this.orders = [];
                    this.cashPayment = 0;
                    this.customerName = '';
                    this.paymentMethod = 'cash';
                    this.showReceipt = false;
                },
                init() {
                    this.filteredProducts = this.products; // Initialize with all products
                }
            };
        }
    </script>
</body>

</html>