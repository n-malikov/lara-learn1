@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Hello</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>
                        без пакетов для разработчика<br>
                        <code>composer install --no-dev</code>
                    </p>

                    <h4>IDE Helper</h4>
                    <p>
                        добавляем Laravel IDE Helper<br>
                        <code>composer require --dev barryvdh/laravel-ide-helper</code>
                    </p>
                    <p>
                        скопируем файл настроек из vendor в config нашего проекта<br>
                        <code>php artisan vendor:publish</code><br>
                        и далее выбираем нужный модуль из списка<br>
                        <code>php artisan vendor:publish --provider="Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider" --tag=config</code><br>
                        в конце не забываем сгенерировать по новой:<br>
                        <code>php artisan ide-helper:generate</code>
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
