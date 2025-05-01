<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function content()
    {
        $suppliers = Supplier::latest()->paginate(10); // Fetch suppliers with pagination
        return view('partials.suppliers-content', compact('suppliers'));
    }

    public function index()
    {
        $suppliers = Supplier::latest()->paginate(10);
        return view('partials.suppliers-content', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255', // Add email validation
        ]);

        Supplier::create($validated);

        return redirect()->route('dashboard')->with('success', 'Supplier created successfully.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255', // Add email validation
        ]);

        $supplier->update($validated);

        return redirect()->route('dashboard')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('dashboard')->with('success', 'Supplier deleted successfully.');
    }
}
