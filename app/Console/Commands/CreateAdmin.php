<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new admin';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        do {
            $details = $this->askForUserDetails($details ?? null);
        } while (!$this->confirm("Create admin?", true));

        $user = User::create([
            'name' => $details['name'],
            'email' => $details['email'],
            'password' => Hash::make($details['password']),
            'is_admin' => true
        ]);

        $this->info("Created new user #{$user->id}");
    }

    /**
     * @param null $defaults
     * @return array
     */
    protected function askForUserDetails($defaults = null)
    {
        $name = $this->ask('Name for admin:', $defaults['name'] ?? null);
        $email = $this->askUniqueEmail('Email address for admin: ', $defaults['email'] ?? null);
        $password = $this->ask('Password for admin: (will be visible)', $defaults['password'] ?? null);

        return compact('name',  'email', 'password');
    }

    /**
     * @param      $message
     * @param null $default
     * @return string
     */
    protected function askUniqueEmail($message, $default = null)
    {
        do {
            $email = $this->ask($message, $default);
        } while (!$this->checkEmailIsValid($email) || !$this->checkEmailIsUnique($email));

        return $email;
    }

    /**
     * @param $email
     * @return bool
     */
    protected function checkEmailIsValid($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Sorry, "' . $email . '" is not a valid email address!');
            return false;
        }

        return true;
    }

    /**
     * @param $email
     * @return bool
     */
    public function checkEmailIsUnique($email)
    {
        if (User::whereEmail($email)->exists()) {
            $this->error('Sorry, "' . $email . '" is already in use!');
            return false;
        }

        return true;
    }
}
