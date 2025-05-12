<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['transactiondetail_id', 'product_id', 'quantity', 'price', 'total', 'date'];



    public function transactionDetail()
    {
        return $this->belongsTo(TransactionDetail::class, 'transactiondetail_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
