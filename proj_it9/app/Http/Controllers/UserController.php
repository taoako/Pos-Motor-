<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
        ]);

        User::create([
            'employee_id' => $request->employee_id,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('register')->with('success', 'User successfully registered!');
    }
}
