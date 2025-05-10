<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_Log extends Model
{
    use HasFactory;


    protected $table = 'transaction_logs';

    protected $fillable = [
        'product_id',
        'transaction_id',
        'stock_in_transaction_id',
        'transaction_type',
        'quantity',
        'logged_at',
    ];

    protected $dates = ['logged_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function stockInTransaction()
    {
        return $this->belongsTo(StockInTransaction::class);
    }
}
