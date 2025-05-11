<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;

use App\Models\Customer;

class POSController extends Controller
{


    public function index()
    {
        $products = Product::where('stock', '>', 0)->get();
        $customers = Customer::all(); // Fetch all customers
        $cart = session()->get('cart', []);



        return view('pos.index', compact('products', 'cart', 'customers'));
    }

    public function addToCart(Request $request)
    {
        // Find the product by ID and add it to the cart
        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                "product_id" => $product->id,
                "product_name" => $product->product_name,
                "price" => $product->selling_price,
                "quantity" => $request->quantity
            ];
        }

        // Store cart in session
        session()->put('cart', $cart);
        return redirect()->route('pos.index')->with('success', 'Added to cart');
    }

    public function removeFromCart(Request $request)
    {
        // Remove product from the cart in session
        $cart = session()->get('cart', []);
        unset($cart[$request->product_id]);
        session()->put('cart', $cart);
        return redirect()->route('pos.index')->with('success', 'Removed from cart');
    }

    public function checkout(Request $request)
    {
        // Validate the checkout request
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_method' => 'required|string',
            'amount_received' => 'required|numeric|min:0',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('pos.index')->with('error', 'Cart is empty');
        }

        // Start transaction to handle the sale process
        DB::transaction(function () use ($request, $cart) {
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            // Create a new transaction
            $transaction = Transaction::create([
                'customer_id' => $request->customer_id,
                'user_id' => auth()->id(),
                'transaction_date' => now(),
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'amount_received' => $request->amount_received,
                'change' => $request->amount_received - $total,
            ]);

            // Create transaction details and update product stock
            foreach ($cart as $item) {
                $product = Product::findOrFail($item['product_id']); // Ensure the product exists

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'selling_price' => $product->selling_price, // Use the selling_price from the Product model
                ]);

                // Decrease stock for the product
                $product->decrement('stock', $item['quantity']);
            }

            // Store the transaction in the session for displaying in the view
            session()->put('transaction', $transaction);
        });

        // Clear the cart after the transaction is done
        session()->forget('cart');

        // Redirect back to the POS index page with success message
        return redirect()->route('pos.index')->with('success', 'Transaction completed!');
    }
}
