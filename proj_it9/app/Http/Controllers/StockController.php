<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display the stock-in page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('stock-in'); // Ensure you create a `stock-in.blade.php` view file
    }
}
