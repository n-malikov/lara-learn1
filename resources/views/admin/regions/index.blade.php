@extends('layouts.app')

@section('content')
    @include('admin._nav', ['page' => 'regions'])

    <p><a href="{{ route('admin.regions.create') }}" class="btn btn-success">Add Region</a></p>

    @include('admin.regions._list', ['regions' => $regions])
@endsection
