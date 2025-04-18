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
}
