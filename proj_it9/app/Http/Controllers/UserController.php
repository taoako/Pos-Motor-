<?PHP

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;

class UserController extends Controller
{
    // This method will create a free account for testing purposes
    public function createFreeAccount()
    {
        // Check if there's at least one employee in the database
        $employee = Employee::first();

        if (!$employee) {
            // If no employee exists, create a dummy employee
            $employee = Employee::create([
                'name' => 'Test Employee',  // Modify this to suit your needs
            ]);
        }

        // Create a new free account user and link it to the employee
        $user = User::createFreeAccount([
            'employee_id' => $employee->id,  // Link the user to the employee
            'username'    => 'freeuser123',   // Username for the user
            'password'    => 'password123',   // Password (it will be hashed automatically)
        ]);

        // Return a response or redirect
        return response()->json($user);  // For testing purposes, you can return the user data
    }
}
