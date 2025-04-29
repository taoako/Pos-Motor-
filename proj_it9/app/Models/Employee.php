<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'position',
        'user_id', // Ensure this is fillable
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
