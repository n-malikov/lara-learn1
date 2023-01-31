<?php

namespace App\Providers;

use App\Services\Sms\ArraySender;
use App\Services\Sms\SmsRu;
use App\Services\Sms\SmsSender;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    // laralearn не забываем указывать созданные провайдеры в /config/app.php

    public function register() : void
    {
        // singleton - защищает от многократного вызова за один раз
        $this->app->singleton(SmsSender::class, function (Application $app) {

            $config = $app->make('config')->get('sms');

            switch ($config['driver']) {
                case 'sms.ru':
                    $params = $config['drivers']['sms.ru'];
                    if (!empty($params['url'])) {
                        return new SmsRu($params['app_id'], $params['url']);
                    }
                    return new SmsRu($params['app_id']);
                case 'array': // для Unit тестов, не забываем дописать в /phpunit.xml <server name="SMS_DRIVER" value="array"/>
                    return new ArraySender();
                default:
                    throw new \InvalidArgumentException('Undefined SMS driver ' . $config['driver']);
            }
        });
    }
}
