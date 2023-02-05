<?php

namespace App\Services\Sms;

interface SmsSender
{
    // laralearn какой именно класс использовать тут мы указываем в /app/Providers/AppServiceProvider.php

    public function send($number, $text) : void;
}

