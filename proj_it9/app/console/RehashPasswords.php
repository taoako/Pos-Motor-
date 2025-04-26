<?php



namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class RehashPasswords extends Command
{
    protected $signature = 'rehash:passwords';
    protected $description = 'Rehash passwords for all users';

    public function handle()
    {
        $users = User::all(); // Get all users

        foreach ($users as $user) {
            if (!Hash::check($user->password, $user->password)) {
                $user->password = Hash::make($user->password); // Rehash the password
                $user->save(); // Save the updated user
                $this->info("Password for user {$user->id} has been rehashed.");
            }
        }

        $this->info('Password rehashing completed!');
    }
}
