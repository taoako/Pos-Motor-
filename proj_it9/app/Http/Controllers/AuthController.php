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
            // Get the authenticated user
            $user = Auth::user();

            // Check if the user is linked to an employee
            if ($user->employee) {
                $position = $user->employee->position;

                // Redirect based on the employee's position
                switch ($position) {
                    case 'Admin':
                        return redirect()->route('dashboard'); // Admins go to the dashboard
                    case 'Inventory Staff':
                        return redirect()->route('dashboard'); // Inventory Staff go to the dashboard
                    case 'Cashier':
                        return redirect('/pos'); // Cashiers go directly to the POS
                    default:
                        Auth::logout();
                        return back()->withErrors(['username' => 'Access denied. Unauthorized position.']);
                }
            }

            // If no employee is linked, log out the user
            Auth::logout();
            return back()->withErrors(['username' => 'Access denied. No employee record found.']);
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
