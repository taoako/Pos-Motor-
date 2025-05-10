<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'supplier')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function content()
    {
        $products = Product::with('category', 'supplier')->latest()->paginate(10);
        return view('partials.products-content', compact('products'));
    }

    public function create()
    {
        // Fetch categories and suppliers for the dropdowns
        $categories = Category::all();
        $suppliers = Supplier::all();

        // Pass the data to the view
        return view('products.create', compact('categories', 'suppliers'));
    }


    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255', // Validate brand
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'sku' => 'nullable|string|max:255',
            'unit' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate a unique barcode
        $validated['barcode'] = rand(100000000000, 999999999999); // Generate a 12-digit barcode

        // Generate a barcode image
        $generator = new BarcodeGeneratorPNG();
        $barcodeImage = $generator->getBarcode($validated['barcode'], $generator::TYPE_CODE_128);
        $barcodePath = 'barcodes/' . $validated['barcode'] . '.png';
        Storage::disk('public')->put($barcodePath, $barcodeImage);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['stock'] = 0;

        // Create the product
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
            'brand' => 'required|string|max:255',



            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
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
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Product deleted successfully.');
    }
}
