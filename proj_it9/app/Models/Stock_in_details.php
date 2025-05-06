<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock_in_details extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stock_in_transaction_id',
        'product_id',
        'quantity',
        'cost_price',
        'total_cost',
    ];

    /**
     * Relationship with the StockInTransaction model.
     */
    public function stockInTransaction()
    {
        return $this->belongsTo(StockInTransaction::class);
    }

    /**
     * Relationship with the Product model.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}