@extends('layouts.app') {{-- Or whatever your main layout is --}}

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-900 shadow-xl rounded-2xl p-6">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-6">Product Management</h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Add New Product Button --}}
        <div class="mb-6">
            <a href="{{ route('products.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-xl shadow">
                + Add New Product
            </a>
        </div>

        {{-- Include Product Table Partial --}}
        @include('partial.product-content', ['products' => $products])
    </div>
</div>
@endsection
