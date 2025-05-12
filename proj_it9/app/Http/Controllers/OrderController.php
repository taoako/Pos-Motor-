<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Transaction_Detail;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id', // Optional customer
            'customer' => 'nullable|array', // New customer details
            'customer.first_name' => 'required_with:customer|string|max:255',
            'customer.last_name' => 'required_with:customer|string|max:255',
            'customer.email' => 'nullable|email',
            'customer.phone' => 'nullable|string|max:15',
            'orders' => 'required|array',
            'orders.*.product_id' => 'required|exists:products,id',
            'orders.*.quantity' => 'required|integer|min:1',
            'orders.*.selling_price' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,credit_card',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Handle customer creation or retrieval
            $customer = null;
            if (!empty($validated['customer'])) {
                $customer = Customer::create([
                    'first_name' => $validated['customer']['first_name'],
                    'last_name' => $validated['customer']['last_name'],
                    'email' => $validated['customer']['email'] ?? null,
                    'phone' => $validated['customer']['phone'] ?? null,
                ]);
            } elseif (!empty($validated['customer_id'])) {
                $customer = Customer::find($validated['customer_id']);
            }

            // Create the transaction
            $transaction = Transaction::create([
                'customer_id' => $customer ? $customer->id : null,
                'user_id' => Auth::id(), // Logged-in user
                'transaction_date' => now(),
                'total_amount' => $validated['total_amount'],
                'payment_method' => $validated['payment_method'],
            ]);

            // Save transaction details
            foreach ($validated['orders'] as $order) {
                Transaction_Detail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $order['product_id'],
                    'quantity' => $order['quantity'],
                    'selling_price' => $order['selling_price'],
                ]);
            }

            // Commit the transaction
            DB::commit();

            return response()->json(['message' => 'Order recorded successfully!'], 200);
        } catch (\Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();

            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function checkout(Request $request)
    {
        // Validate and process the checkout
        $transaction = Transaction::create([
            'customer_id' => $request->customer_id,
            'user_id' => auth()->id(),
            'transaction_date' => $request->transaction_date,
            'total_amount' => $request->total_amount,
            'payment_method' => $request->payment_method,
            'amount_received' => $request->amount_received,
            'change' => $request->amount_received - $request->total_amount,
        ]);

        // Save transaction details (if applicable)
        foreach ($request->orders as $order) {
            $transaction->transactionDetails()->create($order);
        }

        // Set session data
        session()->flash('checkout_complete', true);
        session()->flash('transaction', $transaction);

        return redirect()->route('pos.index');
    }
}
