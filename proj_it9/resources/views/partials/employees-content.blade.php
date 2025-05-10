<div class="p-6 bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-xl">
    <h2 class="text-3xl font-extrabold text-white mb-6">Employees Management</h2>



    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-800 text-white rounded-xl shadow-md">
            <thead class="bg-gray-700 text-gray-200">
                <tr>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Username</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td class="py-3 px-6">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                    <td class="py-3 px-6">{{ $employee->email }}</td>
                    <td class="py-3 px-6">{{ $employee->user->username ?? 'No Username' }}</td>
                    <td class="py-3 px-6">
                        <a href="{{ route('employees.edit', $employee->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">Edit</a>
                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-3">No employees found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="pagination-links" class="mt-4">
        {{ $employees->withPath(route('employees.content'))->links('pagination::tailwind') }}
    </div>

</div>