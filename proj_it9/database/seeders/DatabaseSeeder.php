<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the employee that user will link to
        $employee = Employee::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'position' => 'Administrator',
            // Add any other required fields here
        ]);

        // 2. Create the admin user and link to that employee
        User::create([
            'employee_id' => $employee->id,
            'username' => 'ADMIN',
            'password' => 'PASSWORD123', // Auto-hashed
            'role' => 'free',
            'is_active' => true,
        ]);
    }
}
