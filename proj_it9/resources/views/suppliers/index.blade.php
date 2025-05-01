<div class="container">
    <h2 class="text-xl font-bold mb-4">Suppliers</h2>
    <table class="table table-bordered table-striped w-full text-sm">
        <thead class="bg-gray-700 text-white">
            <tr>
                <th>Name</th>
                <th>Contact Person</th>
                <th>Contact Number</th>
                <th>Address</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($suppliers as $supplier)
            <tr>
                <td>{{ $supplier->supplier_name }}</td>
                <td>{{ $supplier->contact_person }}</td>
                <td>{{ $supplier->contact_number }}</td>
                <td>{{ $supplier->address }}</td>
                <td>{{ $supplier->email }}</td>
                <td>
                    @if($supplier->status)
                    <span class="badge bg-success">Active</span>
                    @else
                    <span class="badge bg-secondary">Inactive</span>
                    @endif
                </td>
                <td>
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
                <td colspan="7" class="text-center">No suppliers found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $suppliers->links() }}
    </div>
</div>