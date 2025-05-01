@extends('layouts.app')

@section('content')
<div id="main-content">
    <h2 class="text-xl font-bold mb-4">Supplier Details</h2>
    <div class="mb-3"><strong>Name:</strong> {{ $supplier->supplier_name }}</div>
    <div class="mb-3"><strong>Contact Person:</strong> {{ $supplier->contact_person }}</div>
    <div class="mb-3"><strong>Contact Number:</strong> {{ $supplier->contact_number }}</div>
    <div class="mb-3"><strong>Address:</strong> {{ $supplier->address }}</div>
    <div class="mb-3"><strong>Email:</strong> {{ $supplier->email }}</div>
    <div class="mb-3"><strong>Status:</strong>
        @if($supplier->status)
        <span class="badge bg-success">Active</span>
        @else
        <span class="badge bg-secondary">Inactive</span>
        @endif
    </div>
    <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection