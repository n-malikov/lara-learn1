<?php

namespace App\Console\Commands\User;

use App\User;
use Illuminate\Console\Command;

class RoleCommand extends Command
{
    // php artisan make:command User/RoleCommand
    // php artisan user:role example@mail.com admin

    protected $signature = 'user:role {email} {role}'; // в фигурных скобках параметры

    protected $description = 'Set role for user';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        if (!$user = User::where('email', $email)->first()) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        try {
            $user->changeRole($role);
        } catch (\DomainException $e) {
            $this->error( $e->getMessage() );
            return false;
        }

        $this->info('Role is successfully changed');
        return true;
    }
}
