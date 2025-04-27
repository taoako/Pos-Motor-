<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class FreeUserSeeder extends Seeder
{
    public function run()
    {
        // Create an employee if one doesn't exist
        $employee = Employee::first() ?: Employee::create([
            'name' => 'Test Employee', // You can modify this
        ]);

        // Check if username already exists
        $username = 'freeuser123';  // You can change this
        if (User::where('username', $username)->exists()) {
            echo "Username {$username} already exists. Skipping user creation.\n";
        } else {
            // Create the free account user
            User::create([
                'employee_id' => $employee->id,
                'username' => $username,
                'password' => Hash::make('password123'), // Hashed password
                'role' => 'free',
                'is_active' => true,
            ]);
        }
    }
}
