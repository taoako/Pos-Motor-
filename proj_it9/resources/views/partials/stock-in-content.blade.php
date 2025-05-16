<!-- filepath: c:\laravel\pos motor and vechicle parts\it9_proj\proj_it9\resources\views\partials\stock-in-content.blade.php -->
<div class="p-6 bg-gradient-to-br from-white via-gray-100 to-white rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6 flex items-center gap-2 animate__animated animate__fadeIn">
        <span>🛠️</span><span>Stock In - Car & Motor Parts</span>
    </h2>

    <!-- Add New Stock Button -->
    <a href="{{ route('stock-in.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl shadow-md mb-4 inline-block transform hover:scale-110 transition-transform duration-300 hover:shadow-lg btn-glow">
        + Add New Stock
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-gray-800 rounded-xl shadow-md transition-all duration-300">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-3 px-6 text-left">Part Name</th>
                    <th class="py-3 px-6 text-left">Quantity</th>
                    <th class="py-3 px-6 text-left">Supplier</th>
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-left">Total Amount</th>
                    <th class="py-3 px-6 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stockInDetails as $detail)
                <tr class="hover:bg-blue-50 transition-colors duration-300">
                    <td class="py-3 px-6">{{ $detail->product->product_name }}</td>
                    <td class="py-3 px-6">{{ $detail->quantity }}</td>
                    <td class="py-3 px-6">{{ $detail->stockInTransaction->supplier->supplier_name ?? 'N/A' }}</td>
                    <td class="py-3 px-6">{{ $detail->stockInTransaction->purchase_date ?? 'N/A' }}</td>
                    <td class="py-3 px-6">₱{{ number_format($detail->stockInTransaction->total_amount, 2) }}</td>
                    <td class="py-3 px-6">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $detail->stockInTransaction->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($detail->stockInTransaction->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-3 px-6 text-center text-gray-400">No stock-in records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div id="pagination-links" class="mt-4">
        {{ $stockInDetails->withPath(route('stock-in.content'))->links('pagination::tailwind') }}
    </div>
</div>

<!-- Tailwind CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
<!-- Animate.css CDN for animation -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<style>
/* Glowing effect for button when active/clicked */
.btn-glow:active, .btn-glow.active, .btn-glow:focus {
    box-shadow: 0 0 12px 2px #22c55e, 0 0 0 4px #bbf7d0;
    border: 1.5px solid #22c55e !important;
    background-color: #bbf7d0 !important;
    color: #166534 !important;
    outline: none;
    transition: box-shadow 0.3s, border 0.3s, background 0.3s;
}
</style>