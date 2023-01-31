<?php

namespace App\Services\Sms;

class ArraySender implements SmsSender
{
    // laralearn этот класс нужен как заглушка, чисто под Unit тесты
    // так же не забываем дописать в /phpunit.xml <server name="SMS_DRIVER" value="array"/>

    private $messages = [];

    public function send($number, $text): void
    {
        $this->messages[] = [
            'to' => '+' . trim($number, '+'),
            'text' => $text
        ];
    }

    public function getMessages(): array
    {
        return $this->messages;
    }
}
