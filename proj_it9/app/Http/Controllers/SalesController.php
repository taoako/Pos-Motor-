<?php

namespace App\Http\Controllers;

use App\Models\Sale; // Assuming you have a Sale model to handle sales data
use Illuminate\Http\Request;

class SalesController extends Controller
{
    // Show sales page with data
    public function index()
    {
        $sales = Sale::all(); // Fetch all sales records from the database
        return view('sales.index', compact('sales'));
    }
}
