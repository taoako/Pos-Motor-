<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100 text-gray-900" x-data="posApp()">
    <div class="flex min-h-screen">
        <!-- Left Section: Products -->
        <div class="w-2/3 bg-white p-6 overflow-y-auto">
            <h1 class="text-2xl font-bold mb-4">Choose Products</h1>
            <div class="grid grid-cols-3 gap-4">
                @foreach ($products as $product)
                    <div class="border rounded-lg p-4 text-center shadow hover:shadow-lg transition">
                        <img src="{{ $product->image_url }}" alt="{{ $product->product_name }}" class="h-24 mx-auto mb-2">
                        <h2 class="font-bold">{{ $product->product_name }}</h2>
                        <p class="text-sm text-gray-600">Brand: {{ $product->brand }}</p>
                        <p class="text-sm text-gray-600">Category: {{ $product->category->category_name }}</p>
                        <p class="text-sm text-gray-600">Barcode: {{ $product->barcode }}</p>
                        <p class="text-lg font-bold">Price: PHP {{ $product->selling_price }}</p>
                        <p class="text-sm text-gray-600">Stock: {{ $product->stock }}</p>
                        <button class="mt-2 bg-blue-500 text-white px-4 py-2 rounded" @click="addToOrder({
                                    id: {{ $product->id }},
                                    name: '{{ $product->product_name }}',
                                    price: {{ $product->selling_price }},
                                    quantity: 1
                                })">
                            Add to Order
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Section: Orders -->
        <div class="w-1/3 bg-gray-800 text-white p-6 flex flex-col justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-4">Orders</h1>
                <div id="order-list" class="space-y-4 max-h-[60vh] overflow-y-auto">
                    <template x-for="(item, index) in orders" :key="item . id">
                        <div class="flex justify-between items-center bg-gray-700 p-2 rounded">
                            <div class="flex items-center">
                                <button class="text-lg text-gray-300 mr-2"
                                    @click="updateQuantity(index, 'decrease')">-</button>
                                <p class="font-semibold" x-text="item.name"></p>
                                <span class="ml-2">x</span>
                                <p class="text-sm text-gray-300" x-text="item.quantity"></p>
                                <button class="text-lg text-gray-300 ml-2"
                                    @click="updateQuantity(index, 'increase')">+</button>
                            </div>
                            <p class="text-sm text-gray-300" x-text="'PHP ' + (item.price * item.quantity).toFixed(2)">
                            </p>
                            <button class="text-red-400 hover:text-red-200" @click="removeOrder(index)">×</button>
                        </div>
                    </template>
                </div>
            </div>

            <div class="mt-4 border-t border-gray-600 pt-4 space-y-2">
                <div class="flex justify-between">
                    <span>Subtotal:</span>
                    <span x-text="'PHP ' + subtotal.toFixed(2)"></span>
                </div>
                <div class="flex justify-between">
                    <span>Discount:</span>
                    <span x-text="'PHP ' + discount.toFixed(2)"></span>
                </div>
                <div class="flex justify-between font-bold text-lg">
                    <span>Total:</span>
                    <span x-text="'PHP ' + total.toFixed(2)"></span>
                </div>
                <button class="mt-4 w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                    Continue to Payment
                </button>
            </div>
        </div>
    </div>

    <script>
        function posApp() {
            return {
                orders: [],
                get subtotal() {
                    return this.orders.reduce((sum, item) => sum + item.price * item.quantity, 0);
                },
                get discount() {
                    return 0; // You can customize this logic
                },
                get total() {
                    return this.subtotal - this.discount;
                },
                addToOrder(product) {
                    const existingItem = this.orders.find(item => item.id === product.id);
                    if (existingItem) {
                        // If product already in the order, increase quantity
                        existingItem.quantity += 1;
                    } else {
                        this.orders.push(product);
                    }
                },
                updateQuantity(index, action) {
                    if (action === 'increase') {
                        this.orders[index].quantity += 1;
                    } else if (action === 'decrease' && this.orders[index].quantity > 1) {
                        this.orders[index].quantity -= 1;
                    }

                    // Remove the item if quantity is 0
                    if (this.orders[index].quantity === 0) {
                        this.removeOrder(index);
                    }
                },
                removeOrder(index) {
                    this.orders.splice(index, 1);
                }
            };
        }
    </script>
</body>

</html>