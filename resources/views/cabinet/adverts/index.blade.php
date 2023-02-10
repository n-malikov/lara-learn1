@extends('layouts.app')

@section('content')
    @include('cabinet._nav', ['page' => 'adverts'])

    <a href="{{ route('cabinet.adverts.create') }}">Create</a>

    <br><br>

    adverts

    <div
        class="region-selector"
        data-selected="{{ json_encode((array)old('regions')) }}"
        data-source="{{ route('ajax.regions') }}"
    ></div>

@endsection
