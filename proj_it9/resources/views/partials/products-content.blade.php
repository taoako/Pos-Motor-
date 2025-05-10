<div class="p-6 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-xl">
    <h2 class="text-3xl font-extrabold text-white mb-6">Products Management</h2>

    <a href="{{ route('products.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl shadow-md mb-4 inline-block">
        + Add New Product
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-800 text-white rounded-xl shadow-md">
            <thead class="bg-gray-700 text-gray-200">
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
                <tr>
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
                    <td class="py-3 px-6">
                        <a href="{{ route('products.edit', $product) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-3">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>