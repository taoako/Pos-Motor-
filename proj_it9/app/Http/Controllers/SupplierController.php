<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Show the form for creating a new supplier.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('supplier.create'); // Return the Blade view for adding a supplier
    }

    /**
     * Store a newly created supplier in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:suppliers,email|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
        ]);

        // Create a new supplier
        Supplier::create([
            'supplier_name' => $request->supplier_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Redirect back to the supplier creation form with a success message
        return redirect()->route('supplier.add')->with('success', 'Supplier added successfully!');
    }
}