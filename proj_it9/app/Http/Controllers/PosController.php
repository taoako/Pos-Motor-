<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pos;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;

class PosController extends Controller
{
    /**
     * Display the POS page with products and stock details.
     */
    public function index()
    {
        $products = Product::select('id', 'product_name', 'selling_price', 'stock', 'barcode', 'image', 'category_id')->get();
        $categories = Category::select('id', 'category_name')->get();
        $customers  = Customer::all();

        return view('pos.pos', compact('products', 'categories', 'customers'));
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
