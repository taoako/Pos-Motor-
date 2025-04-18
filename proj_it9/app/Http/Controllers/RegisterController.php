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
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:employees,email',
            'phone'      => 'required|string|max:20',
            'address'    => 'required|string|max:255',
            'position'   => 'required|string',
            'username'   => 'required|string|unique:users,username',
            'password'   => 'required|string|min:6',
        ]);

        // Save employee
        $employee = Employee::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'address'    => $validated['address'],
            'position'   => $validated['position'],
        ]);

        // Save user with hashed password
        User::create([
            'employee_id' => $employee->id,
            'username'    => $validated['username'],
            'password'    => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', 'User registered successfully!');
    }
}
