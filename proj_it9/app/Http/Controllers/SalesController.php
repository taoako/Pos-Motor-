<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display the sales page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('sales'); // Ensure you create a `sales.blade.php` view file
    }
}
