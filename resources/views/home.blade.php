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
                «laralearn» - введи в поиске по проекту, это комментарии

            </div>
        </div>
    </div>
</div>
@endsection
