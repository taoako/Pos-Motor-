<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'id',
        'product_name',
        'brand',
        'barcode',
        'selling_price',
        'category_id',
    ];

    /**
     * Define a relationship with the StockInDetails model.
     */
    public function stockInDetails()
    {
        return $this->hasMany(StockInDetails::class, 'product_id', 'id');
    }

    /**
     * Define a relationship with the Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
