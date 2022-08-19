@extends('layouts.app')

{{-- laralearn переопределяем ту, что по умолчанию в layouts/app.blade.php --}}
@section('breadcrumb', '')

@section('content')
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

                <h2><code>laralearn</code> - введи в поиске по проекту, это комментарии из уроков</h2>

                <ul>
                    <li><a href="/docker">Docker</a></li>
                </ul>

                <p>
                    без пакетов для разработчика<br>
                    <code>composer install --no-dev</code>
                </p>

                <h4>Node</h4>
                <p>
                    <code>nvm install 16.14.2</code><br>
                    <code>nvm use 16.14.2</code><br>
                    <code>yarn</code><br>
                    <code>npm install</code><br>
                    <code>npm run dev</code> или <code>npm run prod</code> - все варианты в /package.json
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

                <h4>Webpack</h4>
                <p>
                    <code>/webpack.mix.js</code> - упрощенный конфиг для сборщика модулей webpack<br>
                    поменять путь, куда webpack будет складывать свои файлы можно в этом же файле
                </p>
                <p>
                    Борьба с кэшем браузеров:<br>
                    в /webpack.mix.js добавить <code>.version()</code>, теперь все файлы будут генериться с get параметром<br>
                    в фалах темы сменить все <code>asset('build/js/app.js')</code> на <code>mix('js/app.js', 'build')</code> (второй параметр это папка где лежит)
                </p>

                <h4>удалить Vue</h4>
                <p>
                    <code>docker-compose exec node yarn remove vue</code><br>
                    удалить из файла <em>resources/js/app.js</em> все что к нему относится<br>
                    удалить <em>resources/js/components/ExampleComponent.vue</em>
                </p>

                <h4>Breadcrumbs</h4>
                <p>
                    <code>composer require davejamesmiller/laravel-breadcrumbs</code><br>
                    создаем файл <em>routes/breadcrumbs.php</em><br>
                    там где нужно вывести вставляем: <code>&#123;!! Breadcrumbs::render() !!}</code>
                </p>

            </div>
        </div>
    </div>
</div>
@endsection
