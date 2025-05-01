<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_name',
        'contact_person',
        'contact_number',
        'address',

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the stock in transactions for the supplier.
     */
    public function stockInTransactions()
    {
        return $this->hasMany(StockInTransaction::class);
    }

    /**
     * Get the products associated with the supplier.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope a query to only include active suppliers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Check if the supplier is active.
     */
    public function isActive()
    {
        return $this->status;
    }
}
