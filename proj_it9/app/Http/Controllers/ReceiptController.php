<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function download($id)
    {
        // ✅ This loads the transaction model with its related customer and products
        $transaction = Transaction::with(['customer', 'transactionDetails.product'])->findOrFail($id);

        // ✅ This passes the model object directly to the view
        $pdf = Pdf::loadView('pos.receipt', compact('transaction'));

        return $pdf->download('receipt_' . $transaction->id . '.pdf');
    }
}

