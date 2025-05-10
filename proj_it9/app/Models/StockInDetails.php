<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInDetails extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'stock_in_details';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'id',
        'product_id',
        'cost_price',
        'quantity',
    ];

    /**
     * Define a relationship with the Product model.
     */
    public function product()
    {
        return $this->belongsTo(Pos::class, 'product_id', 'id');
    }
}
