<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_name',
        'contact_person',
        'contact_number',
        'address',
    ];

    public function stockInTransactions()
    {
        return $this->hasMany(StockInTransaction::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
