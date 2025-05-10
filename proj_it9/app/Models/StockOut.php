<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'reason',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
