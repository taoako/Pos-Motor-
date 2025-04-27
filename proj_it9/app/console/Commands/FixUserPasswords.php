<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FixUserPasswords extends Command
{
    protected $signature = 'users:fix-passwords';
    protected $description = 'Detects and fixes user passwords that are not properly hashed.';

    public function handle()
    {
        $users = User::all();
        $fixedCount = 0;

        foreach ($users as $user) {
            $password = $user->password;

            if (!$this->isBcryptHash($password)) {
                $newPassword = Str::random(10); // generate a random password
                $user->password = Hash::make($newPassword);
                $user->save();

                $this->info("Fixed password for user ID {$user->id} ({$user->email}). New Password: {$newPassword}");

                $fixedCount++;
            }
        }

        $this->info("Done! {$fixedCount} user(s) had their passwords fixed.");
    }

    private function isBcryptHash($hash)
    {
        return (strlen($hash) === 60) && (substr($hash, 0, 4) === '$2y$');
    }
}
