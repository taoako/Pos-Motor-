<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function store(Request $request)
    {
        $employee = Employee::create($request->all());

        // Pass employee ID to session for user registration
        return redirect()->route('register')->with('employee_id', $employee->id);
    }

    // List all employees
    public function index()
    {
        $employees = Employee::with('user')->get(); // Assuming Employee has a relationship with User
        return view('employees.index', compact('employees'));
    }

    // Show the edit form for an employee
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $user = $employee->user; // Assuming Employee has a `hasOne` relationship with User
        return view('employees.edit', compact('employee', 'user'));
    }

    // Update employee and user details
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $user = $employee->user;

        // Validate input
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees,email,' . $employee->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        // Update employee details
        $employee->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);

        // Update user details
        $user->update([
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    // Delete an employee and their associated user
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $user = $employee->user;

        // Delete the user first
        if ($user) {
            $user->delete();
        }

        // Delete the employee
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}
