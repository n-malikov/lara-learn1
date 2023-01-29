@extends('layouts.app')

@section('content')
    @include('cabinet._nav', ['page' => 'profile'])

    <form method="POST" action="{{ route('cabinet.profile.phone.verify') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="token" class="col-form-label">SMS Code</label>
            <input id="token" class="form-control{{ $errors->has('token') ? ' is-invalid' : '' }}" name="token" value="{{ old('token') }}" required>
            @if ($errors->has('token'))
                <span class="invalid-feedback"><strong>{{ $errors->first('token') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Verify</button>
        </div>
    </form>

    <pre>код можно посмотреть в таблице user -> verify_token</pre>
@endsection
