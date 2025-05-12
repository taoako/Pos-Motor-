<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10px;
        }

        .receipt {
            max-width: 300px;
            margin: 20px 0 20px 10px;
            /* Align to left with a small left margin */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            page-break-inside: avoid;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .receipt-header h1 {
            font-size: 14px;
            margin: 0;
        }

        .receipt-header p {
            margin: 0;
            font-size: 10px;
            color: #555;
        }

        .receipt-body {
            margin-bottom: 10px;
        }

        .receipt-body table {
            width: 100%;
            border-collapse: collapse;
        }

        .receipt-body table th,
        .receipt-body table td {
            text-align: left;
            padding: 3px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }

        .receipt-footer {
            text-align: center;
            font-size: 10px;
            color: #555;
        }

        @media print {
            .receipt {
                width: auto;
                max-width: none;
                margin: 10mm 0 10mm 5mm;
                /* Align to left side */
                padding: 10mm;
                font-size: 9px;
                page-break-inside: avoid;
            }

            @page {
                size: A4 portrait;
                margin: 10mm;
            }

        }
    </style>

</head>

<body>
    <div class="receipt">
        <div class="receipt-header">
            <h1>Motor and Car Parts POS</h1>
            <p>123 Main Street, City, Country</p>
            <p>Phone: (123) 456-7890</p>
        </div>
        <div class="receipt-body">
            <p><strong>Customer:</strong> {{ $transaction->customer->first_name }}
                {{ $transaction->customer->last_name }}
            </p>
            <p><strong>Date:</strong> {{ $transaction->transaction_date }}</p>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->transactionDetails as $detail)
                        <tr>
                            <td>{{ $detail->product->product_name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>${{ number_format($detail->selling_price, 2) }}</td>
                            <td>${{ number_format($detail->quantity * $detail->selling_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p><strong>Total Amount:</strong> ${{ number_format($transaction->total_amount, 2) }}</p>
            <p><strong>Amount Received:</strong> ${{ number_format($transaction->amount_received, 2) }}</p>
            <p><strong>Change:</strong> ${{ number_format($transaction->change, 2) }}</p>
        </div>
        <div class="receipt-footer">
            <p>Thank you for your purchase!</p>
        </div>
    </div>
</body>

</html>