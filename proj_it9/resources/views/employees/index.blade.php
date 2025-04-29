@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Manage Employees</h1>
    <table class="table-auto w-full text-left">
        <thead>
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Username</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr>
                <td class="border px-4 py-2">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                <td class="border px-4 py-2">{{ $employee->email }}</td>
                <td class="border px-4 py-2">
                    {{ $employee->user->username ?? 'No Username' }}
                </td>
                <td class="border px-4 py-2">
                    <a href="{{ route('employees.edit', $employee->id) }}" class="text-blue-500 hover:underline">Edit</a>
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection