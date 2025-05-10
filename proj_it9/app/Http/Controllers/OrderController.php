<?php
// filepath: c:\xampp\htdocs\NEW\Pos-Motor-\proj_it9\app\Http\Controllers\OrderController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'orders' => 'required|array',
            'subtotal' => 'required|numeric',
            'discount' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        // Save the order to the database
        $order = new Order();
        $order->details = json_encode($validated['orders']);
        $order->subtotal = $validated['subtotal'];
        $order->discount = $validated['discount'];
        $order->total = $validated['total'];
        $order->save();

        return response()->json(['message' => 'Order recorded successfully!'], 200);
    }
}