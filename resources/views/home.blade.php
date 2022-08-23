@extends('layouts.app')

{{-- laralearn переопределяем ту, что по умолчанию в layouts/app.blade.php --}}
@section('breadcrumb', '')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
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

                без пакетов для разработчика
                <pre>composer install --no-dev</pre>

                <h4>Node</h4>
                @include('components.pre.node')

                <h4>IDE Helper</h4>
                добавляем Laravel IDE Helper
                <pre>composer require --dev barryvdh/laravel-ide-helper</pre>

                скопируем файл настроек из vendor в config нашего проекта
                <pre>php artisan vendor:publish</pre>
                и далее выбираем нужный модуль из списка
                <pre>php artisan vendor:publish --provider="Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider" --tag=config</pre>
                в конце не забываем сгенерировать по новой:
                <pre>php artisan ide-helper:generate</pre>

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
                <pre>docker-compose exec node yarn remove vue</pre>
                удалить из файла <em>resources/js/app.js</em> все что к нему относится<br>
                удалить <em>resources/js/components/ExampleComponent.vue</em>

                <h4>Breadcrumbs</h4>
                <pre>composer require davejamesmiller/laravel-breadcrumbs</pre>
                создаем файл <em>routes/breadcrumbs.php</em><br>
                там где нужно вывести вставляем: <code>&#123;!! Breadcrumbs::render() !!}</code>

            </div>
        </div>
    </div>
</div>
@endsection
