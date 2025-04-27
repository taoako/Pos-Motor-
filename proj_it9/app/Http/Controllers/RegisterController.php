<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
<<<<<<< HEAD
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
=======
        return view('auth.register');
    }

    /**
     * Handle the registration process.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the input
        $validatedData = Validator::make($request->all(), [
            'employee_id' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:6|confirmed', // Ensure password confirmation field exists
        ])->validate();

        // Create the user and hash the password
        $user = User::create([
            'employee_id' => $request->employee_id,
            'username' => $request->username,
            'password' => $request->password,  // Password will be hashed automatically by the model
        ]);

        // You can optionally log the user in after registration
        Auth::login($user);

        // Redirect to a desired page after successful registration
        return redirect()->route('dashboard'); // or wherever you want to redirect
>>>>>>> d4f05414767b75983a03c5294ac03e60f22a1544
    }
}
