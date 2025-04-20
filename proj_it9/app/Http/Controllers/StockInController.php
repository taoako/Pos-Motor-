<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\StockInTransaction;

class StockInController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        $stockIns = StockInTransaction::with('supplier')->latest()->take(10)->get();

        return view('stock_in.ajax', compact('suppliers', 'stockIns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $validated['status'] = 'pending'; // default status

        StockInTransaction::create($validated);

        return response()->json(['message' => 'Stock-In transaction added successfully.']);
    }
}
