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

    /**
     * Relationship with the Supplier model.
     * A StockInTransaction belongs to a Supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Relationship with the Stock_In_Details model.
     * A StockInTransaction can have many StockInDetails.
     */
    public function stockInDetails()
    {
        return $this->hasMany(Stock_In_Details::class);
    }
}
