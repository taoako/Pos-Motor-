<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pos;

class PosController extends Controller
{
    /**
     * Display the POS page with products and stock details.
     */
    public function index()
    {
        $products = Pos::with(['category', 'stockInDetails'])
            ->select('id', 'product_name', 'brand', 'barcode', 'selling_price', 'category_id')
            ->get()
            ->map(function ($product) {
                $product->stock = $product->stockInDetails->sum('quantity');
                return $product;
            });

        return view('pos.pos', compact('products'));
    }

    /**
     * Handle adding a product to the order.
     */
    public function addToOrder(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Load product with latest stock-in details
        $product = Pos::with('latestStockIn')->find($validated['product_id']);

        if (!$product || !$product->latestStockIn) {
            return response()->json(['error' => 'Product or stock information not found'], 404);
        }

        $orderItem = [
            'product_id' => $product->id,
            'product_name' => $product->product_name,
            'cost_price' => $product->latestStockIn->cost_price,
            'quantity' => $validated['quantity'],
            'total_price' => $product->latestStockIn->cost_price * $validated['quantity'],
        ];

        // Store order item in session
        $order = session()->get('order', []);
        $order[] = $orderItem;
        session()->put('order', $order);

        return response()->json(['success' => 'Product added to order', 'orderItem' => $orderItem]);
    }
}
