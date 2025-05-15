<!-- filepath: c:\laravel\pos motor and vechicle parts\it9_proj\proj_it9\resources\views\partials\dashboard-content.blade.php -->
<div class="p-6 bg-gradient-to-br from-gray-950 via-gray-900 to-gray-950 rounded-2xl shadow-2xl animate__animated animate__fadeIn text-white">
    <h2 class="text-4xl font-extrabold text-cyan-400 mb-8 flex items-center gap-2">
        <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
    </h2>

    <!-- Sales Overview -->
    <div class="mb-8">
        <h3 class="text-2xl font-bold mb-4 text-cyan-300">Sales Overview</h3>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <x-dashboard-card title="Sales Today" :value="'₱' . number_format($totalSalesToday, 2)" color="cyan"/>
            <x-dashboard-card title="Sales This Week" :value="'₱' . number_format($totalSalesThisWeek, 2)" color="emerald"/>
            <x-dashboard-card title="Sales This Month" :value="'₱' . number_format($totalSalesThisMonth, 2)" color="indigo"/>
            <x-dashboard-card title="All Time Sales" :value="'₱' . number_format($totalSalesAllTime, 2)" color="yellow"/>
            <x-dashboard-card title="Gross Profit" :value="'₱' . number_format($grossProfit, 2)" color="pink"/>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <x-dashboard-card title="Transactions" :value="$totalTransactions" color="blue"/>
            <x-dashboard-card title="Items Sold" :value="$totalItemsSold" color="purple"/>
            <x-dashboard-card title="Avg Transaction" :value="'₱' . number_format($averageTransactionValue, 2)" color="green"/>
        </div>
    </div>

    <!-- Inventory Overview -->
    <div class="mb-8">
        <h3 class="text-2xl font-bold mb-4 text-emerald-300">Inventory Overview</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-dashboard-card title="Products" :value="$totalProducts" color="blue"/>
            <x-dashboard-card title="Total Stock" :value="$totalStock" color="purple"/>
            <x-dashboard-card title="Inventory Worth" :value="'₱' . number_format($inventoryWorth, 2)" color="green"/>
        </div>
        @if($lowStockProducts->count())
            <div class="mt-6">
                <h4 class="text-lg text-red-400 font-bold mb-2">⚠️ Low Stock Products</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($lowStockProducts as $product)
                        <div class="bg-gray-800 rounded-lg p-3 flex items-center justify-between">
                            <span class="font-semibold">{{ $product->product_name }}</span>
                            <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                {{ $product->stock }} left
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Supplier Overview -->
    <div class="mb-8">
        <h3 class="text-2xl font-bold mb-4 text-pink-300">Supplier Overview</h3>
        <div class="mb-2">Total Suppliers: <span class="font-bold">{{ $supplierCount }}</span></div>
        <div>
            <h4 class="font-semibold mb-2">Recent Stock-In Transactions</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-800 rounded-lg">
                    <thead>
                        <tr class="text-left text-gray-300">
                            <th class="px-4 py-2">Supplier</th>
                            <th class="px-4 py-2">Purchase Date</th>
                            <th class="px-4 py-2">Amount</th>
                        </tr>
                    </thead>
                   <tbody>
    @forelse($recentStockIns as $stockIn)
        <tr class="border-b border-gray-700 hover:bg-gray-700">
            <td class="px-4 py-2">
                {{ optional($stockIn->supplier)->supplier_name ?? 'No Supplier' }}
            </td>
            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($stockIn->purchase_date)->format('M d, Y') }}</td>
            <td class="px-4 py-2">₱{{ number_format($stockIn->total_amount, 2) }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="px-4 py-2 text-center text-gray-400">No recent stock-in transactions.</td>
        </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>