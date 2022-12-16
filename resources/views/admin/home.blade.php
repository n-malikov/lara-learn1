@extends('layouts.app')

@section('content')
    @include('admin._nav', ['page' => ''])

    <div class="card">
        <div class="card-header">Admin</div>

        <div class="card-body">
            You are logged in!
        </div>
    </div>
@endsection
