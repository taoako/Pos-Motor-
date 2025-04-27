<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{


    public function update(Request $request)
    {
        $user     = Auth::user(); // Ensure $user is an instance of a model like App\Models\User
        if (!$user instanceof \App\Models\User) {
            abort(500, 'Authenticated user is not a valid User model.');
        }
        $employee = $user->employee;    // now an Employee model, not a Collection

        // … your validation …

        // mass‐assign (or stick with filling attributes one by one)
        $employee->first_name = $request->first_name;
        // … etc …
        $employee->save();              // ← now works

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return back()->with('success', 'Profile updated successfully!');
    }
}
