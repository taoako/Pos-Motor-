<div class="p-6 bg-gray-800 rounded-2xl shadow-lg">
    <h2 class="text-3xl font-bold text-white mb-6">📦 Inventory - Car & Motor Parts</h2>
    <div class="grid grid-cols-2 gap-6">
        <!-- Stock Levels Section -->
        <div class="overflow-x-auto">
            <h3 class="text-2xl font-semibold text-white mb-4">Stock Levels</h3>
            <table class="min-w-full bg-gray-700 text-white rounded-xl">
                <thead>
                    <tr class="bg-gray-600">
                        <th class="py-2 px-4 text-left">Image</th>
                        <th class="py-2 px-4 text-left">Name</th>
                        <th class="py-2 px-4 text-left">Brand</th>
                        <th class="py-2 px-4 text-left">Stock</th>
                        <th class="py-2 px-4 text-left">Selling Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-600">
                        <td class="py-2 px-4">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->product_name }}" class="w-16 h-16 object-cover rounded">
                        </td>
                        <td class="py-2 px-4">{{ $product->product_name }}</td>
                        <td class="py-2 px-4">{{ $product->brand }}</td>
                        <td class="py-2 px-4">{{ $product->stock }}</td>
                        <td class="py-2 px-4">₱{{ $product->selling_price }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="pagination-links" class="mt-4">
                {{ $products->withPath(route('inventory.content'))->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Stock-Out Management Section  -->
        <div>
            <h3 class="text-2xl font-semibold text-white mb-4">Stock-Out Management</h3>
            <table class="min-w-full bg-gray-700 text-white rounded-xl">
                <thead>
                    <tr class="bg-gray-600">
                        <th class="py-2 px-4 text-left">Reason</th>
                        <th class="py-2 px-4 text-left">Quantity</th>
                        <th class="py-2 px-4 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockOutLogs as $log)
                    <tr class="hover:bg-gray-600">
                        <td class="py-2 px-4">{{ $log->transaction_type }}</td>
                        <td class="py-2 px-4">{{ $log->quantity }}</td>
                        <td class="py-2 px-4">{{ $log->logged_at->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $stockOutLogs->links() }}
            </div>
        </div>
    </div>
</div>