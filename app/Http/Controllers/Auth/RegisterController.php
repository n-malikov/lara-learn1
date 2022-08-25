<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\User;
use App\Mail\VerifyMail;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/cabinet';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function verify ($token)
    {
        // laralearn этот метод для подтверждения ссылок типа http://lara-learn.test/verify/6RHwtDdsEc99UV3u
        if ( !$user = User::where('verify_token', $token)->first() ) {
            return redirect()->route('login')
                ->with('error', 'Sorry your link cannot be identified.');
        }

        if ( $user->status !== User::STATUS_WAIT ) {
            return redirect()->route('login')
                ->with('error', 'Your email is already verified.');
        }

        $user->status = User::STATUS_ACTIVE;
        $user->verify_token = null;
        $user->save();

        return redirect()->route('login')
            ->with('success', 'Your e-mail is verified. You can now login.');
    }

    protected function register(RegisterRequest $request)
    {
        // laralearn выше заменили стандартный Request на нами созданный RegisterRequest
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            // laralearn добавим еще и свои поля
            'verify_token' => Str::random(),
            'status' => User::STATUS_WAIT,
        ]);

        // Mail::to($user->email)->send(new VerifyMail($user));
        // laralearn способом ниже мы не сразу отправляем письмо, а ставим в очередь, смотри в .env QUEUE_CONNECTION
        // Mail::to($user->email)->queue(new VerifyMail($user));

        event( new Registered($user) );

        return redirect()->route('login')
            ->with('success', 'Check your email and click on the link to verify.');
    }

    /**
     * laralearn по адресу:
     * vendor/laravel/framework/src/Illuminate/Foundation/Auth/RegistersUsers.php
     * лежит заглушка, тут ее переопределяем
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();

        return redirect()->route('login')
            ->with('success', 'Check your email and click on the link to verify.');
    }
}
