<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|max:255|unique:employees,email',
            'phone'      => 'required|string|max:15',
            'address'    => 'required|string|max:255',
            'position'   => 'required|string',
            'username'   => 'required|string|unique:users,username',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                // Log the incoming payload
                Log::info('Register store payload:', $validated);

                // Create the Employee
                $employee = Employee::create([
                    'first_name' => $validated['first_name'],
                    'last_name'  => $validated['last_name'],
                    'email'      => $validated['email'],
                    'phone'      => $validated['phone'],
                    'address'    => $validated['address'],
                    'position'   => $validated['position'],
                ]);

                // — COMMENTED OUT DD so user creation can proceed — 
                // dd($employee->toArray());

                // Create the User and associate it with the Employee
                $user = User::create([
                    'employee_id' => $employee->id,
                    'username'    => $validated['username'],
                    'password'    => Hash::make($validated['password']),
                ]);

                // Log the created User
                Log::info('User created:', $user->toArray());

                // Update the Employee’s user_id
                $employee->user_id = $user->id;
                $employee->save();
            });

            return redirect()
                ->route('dashboard')
                ->with('success', 'User registered successfully!');
        } catch (\Exception $e) {
            Log::error('Error registering user: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors(['error' => 'Failed to register user. Please try again later.']);
        }
    }
}
