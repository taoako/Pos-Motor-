<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'purchase_date',
        'total_amount',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function transactionLogs()
    {
        return $this->hasMany(TransactionLog::class);
    }
    public function stockInDetails()
    {
        return $this->hasMany(StockInDetail::class);
    }
}
