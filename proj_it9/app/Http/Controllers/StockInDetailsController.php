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
            'purchase_date' => 'required|date',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.cost_price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Create a new StockInTransaction record
            $stockInTransaction = StockInTransaction::create([
                'supplier_id' => $validated['supplier_id'],
                'purchase_date' => $validated['purchase_date'],
                'total_amount' => 0, // Will calculate later
                'status' => 'completed',
            ]);

            $totalAmount = 0;
            $markupPercentage = 20; // 20% markup

            // Loop through each product and create Stock_in_details records
            foreach ($validated['products'] as $productData) {
                $totalCost = $productData['quantity'] * $productData['cost_price'];
                $totalAmount += $totalCost;

                Stock_in_details::create([
                    'stock_in_transaction_id' => $stockInTransaction->id,
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                    'cost_price' => $productData['cost_price'],
                    'total_cost' => $totalCost,
                ]);

                // Update the Product table (stock and selling price)
                $product = Product::findOrFail($productData['product_id']);
                $product->increment('stock', $productData['quantity']);

                // Calculate the selling price based on the cost price and markup
                $sellingPrice = $productData['cost_price'] + ($productData['cost_price'] * $markupPercentage / 100);
                $product->update(['selling_price' => $sellingPrice]);
            }

            // Update the total amount in the StockInTransaction record
            $stockInTransaction->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Stock-In successfully created!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}
