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
    }
}
