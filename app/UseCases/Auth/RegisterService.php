<?php

namespace App\UseCases\Auth;


use App\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\VerifyMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;


class RegisterService
{
    private $mailer;
    private $dispatcher;

    public function __construct(Mailer $mailer, Dispatcher $dispatcher)
    {
        $this->mailer = $mailer;
        $this->dispatcher = $dispatcher;
    }


    public function register(RegisterRequest $request): void
    {
        // laralearn выше заменили стандартный Request на нами созданный RegisterRequest

        $user = User::register(
            $request['name'],
            $request['email'],
            $request['password']
        );

        // $this->mailer->to( $user->email )->send( new VerifyMail($user) );
        // или:
        // Mail::to($user->email)->send(new VerifyMail($user));
        // laralearn способом ниже мы не сразу отправляем письмо, а ставим в очередь, смотри в .env QUEUE_CONNECTION
        // Mail::to($user->email)->queue(new VerifyMail($user));

        $this->dispatcher->dispatch( new Registered($user) );
        // или:
        // event( new Registered($user) );

    }

    public function verify($id): void
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $user->verify();
    }
}
