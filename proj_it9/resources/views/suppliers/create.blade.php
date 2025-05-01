@extends('layouts.app')

@section('content')
<div id="main-content">
    <h2 class="text-xl font-bold mb-4">Add Supplier</h2>
    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name</label>
            <input name="supplier_name" class="form-control" required value="{{ old('supplier_name') }}">
        </div>
        <div class="mb-3">
            <label>Contact Person</label>
            <input name="contact_person" class="form-control" value="{{ old('contact_person') }}">
        </div>
        <div class="mb-3">
            <label>Contact Number</label>
            <input name="contact_number" class="form-control" value="{{ old('contact_number') }}">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <input name="address" class="form-control" value="{{ old('address') }}">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input name="email" type="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="status" class="form-check-input" id="status" checked>
            <label class="form-check-label" for="status">Active</label>
        </div>
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection