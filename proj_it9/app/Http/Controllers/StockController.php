<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function create()
    {
        // Fetch all suppliers and products
        $suppliers = Supplier::all();
        $products = Product::all();

        // Pass the suppliers and products to the view
        return view('stock-in.create', compact('suppliers', 'products'));
    }

    public function store(Request $request)
    {
        // Handle form submission and store stock-in details logic here
        // Validate and store the data
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'cost_price' => 'required|numeric|min:0',
        ]);

        // Store the new stock-in detail
        // You would need to add your logic to save the stock-in details, e.g., in a StockIn model

        return redirect()->route('stock-in-details.create')->with('success', 'Stock-in details saved successfully.');
    }
}
