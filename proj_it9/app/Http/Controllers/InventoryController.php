<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction_Log;

class InventoryController extends Controller
{
    /**
     * Display the inventory page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        $stockOutLogs = Transaction_Log::where('transaction_type', 'stock_out')->latest()->paginate(10);



        return view('partials.inventory-content', compact('products', 'stockOutLogs'));
    }
    /**
     * Render the partial inventory view.
     *
     * @return \Illuminate\View\View
     */
    public function content()
    {
        // Same logic as index for partial content
        $products = Product::latest()->paginate(10);
        $stockOutLogs = Transaction_Log::where('transaction_type', 'stock_out')->latest()->paginate(10);

        return view('partials.inventory-content', compact('products', 'stockOutLogs'));
    }
}
