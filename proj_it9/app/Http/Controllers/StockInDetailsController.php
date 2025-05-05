<?php

namespace App\Http\Controllers;

use App\Models\Stock_in_details;
use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Http\Request;

class StockInDetailsController extends Controller
{
    /**
     * Show the form for creating a new stock-in detail.
     */
    public function create()
    {
        // Fetch all suppliers
        $suppliers = Supplier::all();

        // Fetch all products
        $products = Product::all();

        // Pass to the view
        return view('stock_in_details.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created stock-in detail in the database.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'cost_price' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
        ]);

        // Save the validated data to the database
        Stock_in_details::create([
            'supplier_id' => $validated['supplier_id'],
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'cost_price' => $validated['cost_price'],
            'total_cost' => $validated['total_cost'],
        ]);

        // Redirect with success message
        return redirect()->route('stock-in-details.index')->with('success', 'Stock-In Detail created successfully!');
    }

    /**
     * Display a listing of the stock-in details.
     */
    public function index()
    {
        // Fetch all stock-in details with related product and supplier data
        $stockInDetails = Stock_in_details::with('product', 'stockInTransaction')->get();

        // Pass the data to the view
        return view('stock_in_details.index', compact('stockInDetails'));
    }
}