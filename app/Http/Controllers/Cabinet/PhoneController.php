<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Services\Sms\SmsSender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class PhoneController extends Controller
{
    private $sms;

    public function __construct(SmsSender $sms)
    {
        $this->sms = $sms;
    }

    // под POST запрос
    public function request(Request $request)
    {
        $user = Auth::user();

        try {
            $token = $user->requestPhoneVerification(Carbon::now());
            $this->sms->send($user->phone, 'Phone verification token: ' . $token);
        } catch (\DomainException $e) {
            $request->session()->flash('error', $e->getMessage());
        }

        return redirect()->route('cabinet.profile.phone');
    }

    // под GET запрос
    public function form()
    {
        $user = Auth::user();

        return view('cabinet.profile.phone', compact('user'));
    }

    public function verify(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|string|max:255',
        ]);

        $user = Auth::user();

        try {
            $user->verifyPhone($request['token'], Carbon::now());
        } catch (\DomainException $e) {
            return redirect()->route('cabinet.profile.phone')->with('error', $e->getMessage());
        }

        return redirect()->route('cabinet.profile.home');
    }

    public function auth()
    {
        $user = Auth::user();
        if ($user->isPhoneAuthEnabled()) {
            $user->disablePhoneAuth();
        } else {
            $user->enablePhoneAuth();
        }
        return redirect()->route('cabinet.profile.home');
    }

}
