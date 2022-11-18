@extends('layouts.app')

{{-- laralearn переопределяем ту, что по умолчанию в layouts/app.blade.php --}}
@section('breadcrumb', '')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">Hello</div>

            <div class="card-body">

                <h2><code>laralearn</code> - введи в поиске по проекту, это комментарии из уроков</h2>

                <br><br>
                активировать созданного пользователя можно командой:
                <pre>php artisan user:verify EXAMPLE@EXAMPLE.COM</pre>

            </div>
        </div>
    </div>
</div>
@endsection
