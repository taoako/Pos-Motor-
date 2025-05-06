<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function content()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('partials.products-content', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all(); // Fetch all suppliers
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id', // Validate supplier
            'sku' => 'nullable|string|max:255',
            'barcode' => 'required|numeric|digits:12', // Validate barcode as a 12-digit number
            'unit' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }



        Product::create($validated);

        return redirect()->route('dashboard')->with('success', 'Product created successfully.');
    }


    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'sku' => 'nullable|string|max:255',
            'barcode' => 'required|numeric|digits:12',
            'unit' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('dashboard')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete the image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.content')->with('success', 'Product deleted successfully.');
    }
}
