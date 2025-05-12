<div class="p-6 bg-gray-900 rounded-2xl shadow-2xl">
    <h2 class="text-3xl font-extrabold text-white mb-6 tracking-wide">
        💰 Sales Dashboard
    </h2>

    <!-- Top Section: Selling & Recent Orders Side by Side -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Top-Selling Products (limit to 4) -->
        <div class="bg-gray-800 p-4 rounded-2xl shadow-inner">
            <h3 class="text-xl font-bold text-white mb-4">🔥 Top-Selling Products</h3>
            <div class="space-y-3">
                @foreach($topSellingProducts->take(4) as $product)
                    <div class="bg-gray-700 rounded-lg overflow-hidden transform hover:scale-105 transition-transform duration-200 shadow flex items-center p-2">
                        <img src="{{ asset('storage/' . $product->product->image) }}" alt="{{ $product->product->product_name }}" class="w-10 h-10 object-cover rounded mr-3">
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-white truncate">{{ $product->product->product_name }}</h4>
                            <p class="text-green-400 text-xs mt-1">{{ $product->total_quantity }} sold</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Orders (modern dark scrollbar) -->
        <div class="bg-gray-800 p-4 rounded-2xl shadow-inner">
            <h3 class="text-xl font-bold text-white mb-4">🛒 Recent Orders</h3>
            <div class="overflow-y-auto max-h-64 rounded scroll-area" style="scrollbar-width: thin; scrollbar-color: #4B5563 #1F2937;">
                <style>
                    .scroll-area::-webkit-scrollbar { width: 6px; }
                    .scroll-area::-webkit-scrollbar-track { background: #1F2937; }
                    .scroll-area::-webkit-scrollbar-thumb { background-color: #4B5563; border-radius: 3px; }
                </style>
                <table class="w-full text-white table-auto text-xs">
                    <thead>
                        <tr class="bg-gray-700 text-left rounded-t-lg">
                            <th class="px-3 py-1">Customer</th>
                            <th class="px-3 py-1">Product</th>
                            <th class="px-3 py-1">Qty</th>
                            <th class="px-3 py-1">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-gray-700">
                                <td class="px-3 py-1 truncate">{{ $order->transactionDetail->transaction->customer->first_name }} {{ $order->transactionDetail->transaction->customer->last_name }}</td>
                                <td class="px-3 py-1 truncate">{{ $order->product->product_name }}</td>
                                <td class="px-3 py-1">{{ $order->quantity }}</td>
                                <td class="px-3 py-1">₱{{ number_format($order->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Sales Chart (centered & larger) -->
    <div class="bg-gray-800 p-4 rounded-2xl shadow-inner mx-auto w-full md:w-3/4">
        <h3 class="text-xl font-bold text-white mb-3 text-center">📊 Sales Chart</h3>
        <div class="flex justify-center items-center mb-4 space-x-3 text-sm">
            <label for="chartType" class="text-white">View:</label>
            <select
                id="chartType"
                class="bg-gray-700 text-white rounded px-3 py-1 focus:outline-none focus:ring-2 focus:ring-green-500"
                data-daily='@json($dailySales)'
                data-weekly='@json($weeklySales)'
                data-monthly='@json($monthlySales)'
            >
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>
        <div class="h-96 flex justify-center">
            <canvas id="salesChart" class="w-full h-full"></canvas>
        </div>
    </div>
</div>
