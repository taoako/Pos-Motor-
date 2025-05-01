<div class="p-6 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300">
    <h2 class="text-3xl font-extrabold text-white mb-6 flex items-center gap-2 animate__animated animate__fadeIn">
        <span>📦</span><span>Suppliers Management</span>
    </h2>

    <!-- Add New Supplier Button -->
    <a href="{{ route('suppliers.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl shadow-md mb-4 inline-block transform hover:scale-110 transition-transform duration-300 hover:shadow-lg">
        + Add New Supplier
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-800 text-white rounded-xl shadow-md transition-all duration-300">
            <thead class="bg-gray-700 text-gray-200">
                <tr>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Contact Person</th>
                    <th class="py-3 px-6 text-left">Contact Number</th>
                    <th class="py-3 px-6 text-left">Address</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr class="hover:bg-gray-700 transition-colors duration-300">
                    <td class="py-3 px-6">{{ $supplier->supplier_name }}</td>
                    <td class="py-3 px-6">{{ $supplier->contact_person }}</td>
                    <td class="py-3 px-6">{{ $supplier->contact_number }}</td>
                    <td class="py-3 px-6">{{ $supplier->address }}</td>
                    <td class="py-3 px-6">{{ $supplier->email }}</td>
                    <td class="py-3 px-6">
                        @if($supplier->status)
                        <span class="badge bg-green-500 text-white px-2 py-1 rounded">Active</span>
                        @else
                        <span class="badge bg-gray-500 text-white px-2 py-1 rounded">Inactive</span>
                        @endif
                    </td>
                    <td class="py-3 px-6">
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow-md inline-block">Edit</a>
                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow-md inline-block" onclick="return confirm('Are you sure you want to delete this supplier?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-3 px-6">No suppliers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $suppliers->links() }}
    </div>
</div>

<!-- Tailwind CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
<!-- Animate.css CDN for animation -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />