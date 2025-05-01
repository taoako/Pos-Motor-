@extends('layouts.app')

@section('content')
<div class="p-6 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300">
    <h2 class="text-3xl font-extrabold text-white mb-6 flex items-center gap-2 animate__animated animate__fadeIn">
        <span>📋</span><span>Supplier Management</span>
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
                    <td class="py-3 px-6">{{ $supplier->email }}</td>
                    <td class="py-3 px-6">
                        @if($supplier->status)
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="py-3 px-6">
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this supplier?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No suppliers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $suppliers->links() }}
    </div>
</div>
@endsection