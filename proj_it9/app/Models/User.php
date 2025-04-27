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
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Automatically hash the password when it's set.
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            // Hash only if it's not already hashed
            if (!preg_match('/^\$2y\$/', $value)) {
                $value = Hash::make($value);
            }
            $this->attributes['password'] = $value;
        }
    }

    /**
     * Create a new free user account with default role and status.
     */
    public static function createFreeAccount($data)
    {
        $data['role'] = 'free';       // Default role
        $data['is_active'] = true;    // Default account status

        return self::create($data);
    }

    /**
     * Relationship to employee (belongs to).
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * Relationship to transactions (has many).
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
