<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock_In_Details extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_in_transaction_id',
        'product_id',
        'quantity',
        'cost_price',
        'total_cost',
    ];

    public function stockInTransaction()
    {
        return $this->belongsTo(StockInTransaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
