{{-- filepath: c:\xampp\htdocs\NEW\Pos-Motor-\proj_it9\resources\views\supplier\create.blade.php --}}
@extends('layouts.app') <!-- Ensure this layout file exists -->

@section('title', 'Add Supplier')

@section('content')
<div class="container">
    <h1>Add Supplier</h1>

    {{-- Display validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Supplier creation form --}}
    <form method="POST" action="{{ route('supplier.store') }}">
        @csrf
        <div class="mb-3">
            <label for="supplier_name">Supplier Name</label>
            <input type="text" name="supplier_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="mb-3">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="mb-3">
            <label for="address">Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Supplier</button>
    </form>
</div>
@endsection
