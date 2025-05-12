<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\StockOut;


class POSController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->get();
        $customers = Customer::all();
        $cart = session()->get('cart', []);

        return view('pos.index', compact('products', 'cart', 'customers'));
    }

    public function addToCart(Request $request)
    {
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

        session()->put('cart', $cart);
        return redirect()->route('pos.index')->with('success', 'Added to cart');
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->product_id]);
        session()->put('cart', $cart);

        return redirect()->route('pos.index')->with('success', 'Removed from cart');
    }


    public function checkout(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_method' => 'required|string',
            'amount_received' => 'required|numeric|min:0',
            'transaction_date' => 'nullable|date',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('pos.index')->with('error', 'Cart is empty');
        }

        DB::transaction(function () use ($request, $cart) {
            $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
            $transactionDate = $request->transaction_date ?? now();

            $transaction = Transaction::create([
                'customer_id' => $request->customer_id,
                'user_id' => auth()->id(),
                'transaction_date' => $transactionDate,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'amount_received' => $request->amount_received,
                'change' => $request->amount_received - $total,
            ]);

            foreach ($cart as $item) {
                $product = Product::findOrFail($item['product_id']);

                $transactionDetail = TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'selling_price' => $product->selling_price,
                ]);



                $sale = Sale::create([
                    'transactiondetail_id' => $transactionDetail->id, // Pass the correct ID

                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->selling_price,
                    'total' => $item['quantity'] * $product->selling_price,
                    'date' => $transactionDate,
                ]);

                $product->decrement('stock', $item['quantity']);

                // Log the sale transaction in StockOut
                StockOut::create([
                    'product_id' => $item['product_id'],
                    'transaction_type' => 'sale',
                    'quantity' => $item['quantity'],
                    'sale_id' => $sale->id, // Link the sale ID to the stock-out record

                    'logged_at' => now(),
                ]);
            }


            // Flash data to session for next request
            session()->flash('checkout_complete', true);
            session()->flash('transaction', $transaction);

            session()->put('transaction', $transaction);

        });

        session()->forget('cart');

        return redirect()->route('pos.index')->with('success', 'Transaction completed!');
    }
}
