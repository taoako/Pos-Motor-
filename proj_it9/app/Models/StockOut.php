<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $table = 'stock_outs'; // Specify the table name

    protected $fillable = [
        'product_id',
        'transaction_type', // Type of transaction (e.g., stock_out, sale)
        'quantity',
        'reason', // Reason for stock-out (e.g., damaged, returned)
        'sale_id', // Link to a sale for returned items
        'logged_at', // Date of the stock-out
    ];

    protected $casts = [
        'logged_at' => 'datetime', // Cast logged_at as a Carbon date object
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
