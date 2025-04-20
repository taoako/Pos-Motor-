<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockInTransaction;
use App\Models\Stock_in_details;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display the stock-in page.
     */
    public function index()
    {
        return view('stock-in'); // Make sure stock-in.blade.php exists in resources/views
    }

    /**
     * Show the form for creating a new stock-in detail.
     */
    public function create()
    {
        return view('stock_in_details.create', [
            'transactions' => StockInTransaction::all(),
            'products' => Product::all(),
        ]);
    }

    /**
     * Store the stock-in detail.
     */
    public function store(Request $request)
    {
        $request->validate([
            'stock_in_transaction_id' => 'required|exists:stock_in_transactions,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'cost_price' => 'required|numeric|min:0',
            'total_cost' => 'required|numeric|min:0',
        ]);

        stock_in_details::create($request->all());

        return redirect()->route('stock-in-details.create')->with('success', 'Stock-in detail added successfully.');
    }
}
