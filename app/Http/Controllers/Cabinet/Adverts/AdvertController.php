<?php

namespace App\Http\Controllers\Cabinet\Adverts;

use App\Entity\Adverts\Advert\Advert;
use App\Http\Middleware\FilledProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertController extends Controller
{
    // php artisan make:controller Cabinet\\Adverts\\AdvertController --resource

    public function __construct()
    {
        $this->middleware(FilledProfile::class);
    }

    public function index()
    {
        // не забудь добавить scope метод для forUser (scopeForUser)
        //$adverts = Advert::forUser(Auth::id())->orderByDesc('id')->paginate(20);
        $adverts = Advert::forUser(Auth::user())->orderByDesc('id')->paginate(20);

        return view('cabinet.adverts.index', compact('adverts'));
    }
}
