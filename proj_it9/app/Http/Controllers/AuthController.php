<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the username and password fields
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // Check if the authenticated user is an admin
            $user = Auth::user();
            if ($user->employee && $user->employee->position === 'Admin') {
                // Redirect to the dashboard if the user is an admin
                return redirect()->route('dashboard');
            }

            // Log out the user if they are not an admin
            Auth::logout();
            return back()->withErrors(['username' => 'Access denied. Only Admins can log in.']);
        }

        // Authentication failed, redirect back with an error
        return back()->withErrors(['username' => 'Invalid username or password']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
