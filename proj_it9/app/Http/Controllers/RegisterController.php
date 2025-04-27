<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:employees,email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'position' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create the Employee
        $employee = Employee::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'position' => $validated['position'],
        ]);

        // Create the User and associate it with the Employee
        $user = User::create([
            'employee_id' => $employee->id, // Associate the employee
            'username' => $validated['username'],
            'password' => $validated['password'], // Automatically hashed by the mutator
        ]);

        // Update the employee's user_id
        $employee->user_id = $user->id;
        $employee->save();

        return redirect()->back()->with('success', 'User registered successfully!');
    }
}
