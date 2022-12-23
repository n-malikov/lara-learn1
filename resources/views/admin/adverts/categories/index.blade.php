@extends('layouts.app')

@section('content')
    @include('admin._nav', ['page' => 'categories'])

    <p><a href="{{ route('admin.adverts.categories.create') }}" class="btn btn-success">Add Category</a></p>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Slug</th>
        </tr>
        </thead>
        <tbody>

        @foreach($categories AS $category)
            <tr>
                <td>
                    {!! $category->depth ? str_repeat('&mdash;', $category->depth) : '' !!}
                    {{-- @for ($i = 0; $i < $category->depth; $i++) &mdash; @endfor--}}
                    <a href="{{ route('admin.adverts.categories.show', $category) }}">{{ $category->name }}</a>
                </td>
                <td>{{ $category->slug }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>


@endsection
