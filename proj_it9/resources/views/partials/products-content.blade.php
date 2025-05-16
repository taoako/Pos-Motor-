<!-- filepath: c:\laravel\pos motor and vechicle parts\it9_proj\proj_it9\resources\views\partials\products-content.blade.php -->
<div class="p-6 bg-gradient-to-br from-white via-gray-100 to-white rounded-2xl shadow-xl">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Products Management</h2>

    <a href="{{ route('products.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl shadow-md mb-4 inline-block transform hover:scale-110 transition-transform duration-300 hover:shadow-lg btn-glow">
        + Add New Product
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-gray-800 rounded-xl shadow-md">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Brand</th>
                    <th class="py-3 px-6 text-left">Category</th>
                    <th class="py-3 px-6 text-left">Barcode</th>
                    <th class="py-3 px-6 text-left">Image</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr class="hover:bg-blue-50 transition-colors duration-300">
                    <td class="py-3 px-6">{{ $product->product_name }}</td>
                    <td class="py-3 px-6">{{ $product->brand }}</td>
                    <td class="py-3 px-6">{{ $product->category->category_name }}</td>
                    <td class="py-3 px-6">
                        <img src="{{ asset('storage/barcodes/' . $product->barcode . '.png') }}" alt="Barcode" class="w-32 h-8">
                    </td>
                    <td class="py-3 px-6">
                        @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="w-16 h-16 rounded">
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="py-3 px-6 flex gap-2">
                        <a href="{{ route('products.edit', $product) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded shadow transition btn-glow">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow transition btn-glow" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-3 text-gray-400">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="pagination-links" class="mt-4">
        {{ $products->withPath(route('products.content'))->links('pagination::tailwind') }}
    </div>
</div>

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