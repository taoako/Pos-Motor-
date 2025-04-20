<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Make sure this model exists and is imported

class InventoryController extends Controller
{
    /**
     * Display the inventory page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = Product::all(); // Fetch all products from the database
        return view('inventory.index', compact('products')); // Make sure the view is at resources/views/inventory/index.blade.php
    }
}
