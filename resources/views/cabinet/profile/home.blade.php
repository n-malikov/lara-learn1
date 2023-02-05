@extends('layouts.app')

@section('content')
    @include('cabinet._nav', ['page' => 'profile'])

    <div class="mb-3">
        <a href="{{ route('cabinet.profile.edit') }}" class="btn btn-primary">Edit</a>
    </div>

    <table class="table table-bordered">
        <tbody>
        <tr>
            <th>First name</th><td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>Last name</th><td>{{ $user->last_name }}</td>
        </tr>
        <tr>
            <th>Email</th><td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>
                @if ($user->phone)
                    {{ $user->phone }}
                    @if (!$user->isPhoneVerified())
                        <i>(is not verified)</i><br>
                        <form method="POST" action="{{ route('cabinet.profile.phone') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Verify</button>
                        </form>
                    @endif
                @endif
            </td>
        </tr>
        @if ($user->phone)
            <tr>
                <th>Two Factor Auth</th><td>
                    <form method="POST" action="{{ route('cabinet.profile.phone.auth') }}">
                        @csrf
                        @if ($user->isPhoneAuthEnabled())
                            <button type="submit" class="btn btn-sm btn-success">On</button>
                        @else
                            <button type="submit" class="btn btn-sm btn-danger">Off</button>
                        @endif
                    </form>
                    не включай, если не подрубил SMS сервис в конфиге
                </td>
            </tr>
        @endif
        </tbody>
    </table>

@endsection
