<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockOut;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Show the inventory dashboard.
     */
    public function index(Request $request)
    {
        // Paginate products for stock levels
        $products = Product::paginate(10);

        // Paginate stock-out logs
        $stockOutLogs = StockOut::with(['product', 'sale'])
            ->where('transaction_type', 'stock_out')
            ->latest('logged_at')
            ->paginate(10);

        return view('partials.inventory-content', compact('products', 'stockOutLogs'));
    }

    /**
     * Alias for AJAX-loaded content.
     */
    public function content(Request $request)
    {
        // exactly the same as index()
        $products = Product::paginate(10);
        $stockOutLogs = StockOut::with(['product', 'sale'])
            ->where('transaction_type', 'stock_out')
            ->latest('logged_at')
            ->paginate(10);

        return view('partials.inventory-content', compact('products', 'stockOutLogs'));
    }

    /**
     * Handle a stock-out submission.
     */

    public function stockOut(Request $request)
    {
        $validated = $request->validate([
            'reason'     => 'required|string|in:damaged,returned',
            'quantity'   => 'required|integer|min:1',
            // Only require product_id when damaged
            'product_id' => 'required_if:reason,damaged|nullable|exists:products,id',
            // Only require sale_id when returned
            'sale_id'    => 'required_if:reason,returned|nullable|exists:sales,id',
        ]);

        // If returned, use the sale to find product & enforce stock logic
        if ($validated['reason'] === 'returned') {
            $sale = Sale::findOrFail($validated['sale_id']);
            $product = $sale->product;   // assuming Sale belongsTo Product
        } else {
            $product = Product::findOrFail($validated['product_id']);
        }

        if ($product->stock < $validated['quantity']) {
            return back()->withErrors(['error' => 'Not enough stock available.'])->withInput();
        }

        DB::transaction(function () use ($validated, $product) {
            $product->decrement('stock', $validated['quantity']);

            StockOut::create([
                'product_id'       => $product->id,
                'transaction_type' => 'stock_out',
                'quantity'         => $validated['quantity'],
                'reason'           => $validated['reason'],
                // sale_id only for returned
                'sale_id'          => $validated['sale_id'] ?? null,
                'logged_at'        => now(),
            ]);

            if ($validated['reason'] === 'returned') {
                // zero out the original sale total
                $sale = Sale::findOrFail($validated['sale_id']);
                $sale->update(['total' => 0]);
            }
        });

        return redirect()->route('dashboard')->with('success', 'Stock-Out recorded.');
    }

    public function fetchSales(Request $request)
    {
        $q = $request->query('q', '');

        $sales = DB::table('sales')
            ->join('transaction_details', 'sales.transactiondetail_id', '=', 'transaction_details.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('customers', 'transactions.customer_id', '=', 'customers.id')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->when($q, function ($query) use ($q) {
                $query->where('products.product_name', 'like', "%{$q}%");
            })
            ->select(
                'sales.id',
                'products.product_name',
                'sales.quantity',
                'sales.date',
                DB::raw("CONCAT(customers.first_name, ' ', customers.last_name) as customer_name")
            )
            ->get();

        return response()->json($sales);
    }

    public function fetchProducts(Request $request)
    {
        $q = $request->query('q', '');
        $products = Product::where('stock', '>', 0)
            ->when($q, fn($qry) => $qry->where('product_name', 'like', "%{$q}%"))
            ->select('id', 'product_name', 'stock')
            ->get();
        return response()->json($products);
    }
}
