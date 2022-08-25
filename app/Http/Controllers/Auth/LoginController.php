<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    // use AuthenticatesUsers;

    // laralearn защита от перебора пароля, ниже берем несколько методов из
    // vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php
    use ThrottlesLogins;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(LoginRequest $request) {
        // laralearn выше заменили стандартный Request на нами созданный LoginRequest

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $authenticate = Auth::attempt(
            $request->only(['email', 'password']),
            $request->filled('remember')
        );

        if ($authenticate) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            $user = Auth::user();
            if ($user->status != User::STATUS_ACTIVE ) {
                Auth::logout();
                return back()->with('error', 'You need to confirm your account. Please check your email. 777');
            }
            return redirect()->intended(route('cabinet'));
        }

        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages(['email' => [trans('auth.failed')]]);
    }

    /**
     * laralearn переопределяем заглушку vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if ( $user->status != User::STATUS_ACTIVE ) {
            $this->guard()->logout();
            return back()->with('error', 'You need to confirm your account. Please check your email.');
        }

        return redirect()->intended( $this->redirectPath() );
    }

    public function logout(Request $request) {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('login');
    }

    protected function guard() {
        return Auth::guard();
    }

    /**
     * @return string
     */
    protected function username(): string
    {
        return 'name';
    }
}
