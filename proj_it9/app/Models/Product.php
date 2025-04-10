<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'category_id',
        'supplier_id',
        'sku',
        'barcode',
        'unit',
        'cost_price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

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
