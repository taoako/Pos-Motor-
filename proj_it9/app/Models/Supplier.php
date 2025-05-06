<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_name',
        'contact_person',
        'contact_number',
        'address',
        'email',
        'status',
    ];

    public function stockInTransactions()
    {
        return $this->hasMany(StockInTransaction::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function isActive()
    {
        return $this->status;
    }
}