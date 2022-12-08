<?php

namespace App\Console\Commands\User;

use App\UseCases\Auth\RegisterService;
use App\User;
use Illuminate\Console\Command;

class VerifyCommand extends Command
{
    // php artisan make:command User/VerifyCommand
    // php artisan user:verify example@mail.com
    protected $signature = 'user:verify {email}'; // в фигурных скобках параметр

    protected $description = 'Подтверждение регистрации пользователя';

    private RegisterService $service;

    public function __construct(RegisterService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle() : bool
    {
        $email = $this->argument('email');

        if ( !$user = User::where('email', $email)->first() ) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        try {
            $this->service->verify($user->id);
            //или напрямую:
            //$user->verify();
        } catch (\DomainException $e) {
            $this->error($e->getMessage());
            return false;
        }

        $this->info('User is successfully verified');
        return true;
    }
}
