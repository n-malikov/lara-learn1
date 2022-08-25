@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Аутентификация</div>

                <div class="card-body">

                    если хочешь, чтоб при смене пароля пользователя вышибало везде, то в <em>app/Http/Kernel.php</em> расскоментируй строчку:
                    <pre>\Illuminate\Session\Middleware\AuthenticateSession::class</pre>

                    <hr><hr><hr>

                    правим <em>app/Http/Controllers/Auth/RegisterController.php</em><br><br>

                    для письма создаем вьюшку и класс (в app/Mail)
                    <pre>php artisan make:mail VerifyMail --markdown=emails.auth.register.confirm</pre>
                    *markdown - это форматирование в стиле README.md<br><br>

                    правим <em>app/Http/Controllers/Auth/LoginController.php</em><br><br>

                    добавялем недостающие поля
                    <pre>php artisan make:migration add_user_verification --table=users</pre>
                    после заполнения применяем
                    <pre>php artisan migrate</pre><br>

                    в <em>routes/web.php</em> добавляем
                    <pre>Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('register.verify');</pre><br>

                    генерим request'ы
                    <pre>php artisan make:request Auth\\RegisterRequest</pre>
                    <pre>php artisan make:request Auth\\LoginRequest</pre>
                    заполняем и в функциях register и login подменяем стандартный Request на наши

                </div>
            </div>
        </div>
    </div>
@endsection
