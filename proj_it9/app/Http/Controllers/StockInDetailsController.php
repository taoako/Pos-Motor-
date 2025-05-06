<?php

namespace App\Http\Controllers;

use App\Models\Stock_in_details;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\StockInTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInDetailsController extends Controller
{

    public function content()
    {
        // Fetch stock-in details with related product and supplier data
        $stockInDetails = Stock_in_details::with('product', 'stockInTransaction.supplier')->latest()->paginate(10);

        // Pass the data to the view
        return view('partials.stock-in-content', compact('stockInDetails'));
    }

    public function index()
    {
        // Fetch stock-in details with related product and supplier data
        $stockInDetails = Stock_in_details::with('product', 'stockInTransaction.supplier')->latest()->paginate(10);

        // Pass the data to the view
        return view('stock_in_details.index', compact('stockInDetails'));
    }
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
            'purchase_date' => 'required|date', // Use purchase_date instead of transaction_date
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'cost_price' => 'required|numeric|min:0',
        ]);

        // Define the markup percentage (e.g., 20%)
        $markupPercentage = 0.20;

        // Compute the selling price
        $sellingPrice = $validated['cost_price'] * (1 + $markupPercentage);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create a new StockInTransaction record
            $stockInTransaction = StockInTransaction::create([
                'supplier_id' => $validated['supplier_id'],
                'purchase_date' => $validated['purchase_date'], // Use purchase_date
                'total_amount' => $validated['quantity'] * $validated['cost_price'], // Calculate total amount
                'status' => 'completed', // Default status
            ]);

            // Create a new Stock_in_details record
            Stock_in_details::create([
                'stock_in_transaction_id' => $stockInTransaction->id,
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'cost_price' => $validated['cost_price'],
                'total_cost' => $validated['quantity'] * $validated['cost_price'], // Calculate total cost
            ]);

            // Update the Product table (stock and selling price)
            $product = Product::findOrFail($validated['product_id']);
            $product->increment('stock', $validated['quantity']); // Increment stock
            $product->update(['selling_price' => $sellingPrice]); // Update selling price

            // Commit the transaction
            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Stock-In successfully created!');
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'An error occurred while creating the stock-in: ' . $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the stock-in details.
     */
}
