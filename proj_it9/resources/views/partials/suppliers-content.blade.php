<!-- filepath: c:\laravel\pos motor and vechicle parts\it9_proj\proj_it9\resources\views\partials\suppliers-content.blade.php -->
<div class="p-6 bg-gradient-to-br from-white via-gray-100 to-white rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6 flex items-center gap-2 animate__animated animate__fadeIn">
        <span>📦</span><span>Suppliers Management</span>
    </h2>

    <!-- Add New Supplier Button -->
    <a href="{{ route('suppliers.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl shadow-md mb-4 inline-block transform hover:scale-105 transition-transform duration-300 hover:shadow-lg btn-glow">
        + Add New Supplier
    </a>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white text-gray-800 rounded-xl shadow-md transition-all duration-300">
            <thead class="bg-gray-100 text-gray-700">
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
                <tr class="hover:bg-blue-50 transition-colors duration-300">
                    <td class="py-3 px-6">{{ $supplier->supplier_name }}</td>
                    <td class="py-3 px-6">{{ $supplier->contact_person }}</td>
                    <td class="py-3 px-6">{{ $supplier->contact_number }}</td>
                    <td class="py-3 px-6">{{ $supplier->address }}</td>
                    <td class="py-3 px-6">{{ $supplier->email }}</td>
                    <td class="py-3 px-6">
                        @if($supplier->status)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Active</span>
                        @else
                        <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">Inactive</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 flex gap-2">
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300 btn-glow">
                            Edit
                        </a>
                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300 btn-glow" onclick="return confirm('Are you sure you want to delete this supplier?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-3 px-6 text-gray-400">No suppliers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="pagination-links" class="mt-4">
        {{ $suppliers->withPath(route('suppliers.content'))->links('pagination::tailwind') }}
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