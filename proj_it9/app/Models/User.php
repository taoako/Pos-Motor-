<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'username',
        'password',
    ];

    protected $hidden = ['password'];

    public function setPasswordAttribute($value)
    {
        // Only hash if it's not already hashed
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
