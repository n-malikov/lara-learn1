@extends('layouts.app')

{{-- laralearn переопределяем ту, что по умолчанию в layouts/app.blade.php --}}
@section('breadcrumb', '')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">Hello</div>

            <div class="card-body">

                <br>
                активировать созданного пользователя можно командой:
                <pre>php artisan user:verify EXAMPLE@EXAMPLE.COM</pre>

                <br>
                сделать его админом:
                <pre>php artisan user:role EXAMPLE@EXAMPLE.COM admin</pre>

                <br>
                сгенерировать несколько рандомных юзеров и регионов:
                <pre>php artisan db:seed</pre>

                <br>
                «laralearn» - введи в поиске по проекту, это комментарии

                <br><br><br>

                <div class="card card-default mb-3">
                    <div class="card-header">
                        All Categories
                    </div>
                    <div class="card-body pb-0" style="color: #aaa">
                        <div class="row">
                            @foreach (array_chunk($categories, 3) as $chunk)
                                <div class="col-md-3">
                                    <ul class="list-unstyled">
                                        @foreach ($chunk as $current)
                                            <li><a href="{{ route('adverts.index', [null, $current]) }}">{{ $current->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card card-default mb-3">
                    <div class="card-header">
                        All Regions
                    </div>
                    <div class="card-body pb-0" style="color: #aaa">
                        <div class="row">
                            @foreach (array_chunk($regions, 3) as $chunk)
                                <div class="col-md-3">
                                    <ul class="list-unstyled">
                                        @foreach ($chunk as $current)
                                            <li><a href="{{ route('adverts.index', [$current, null]) }}">{{ $current->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
