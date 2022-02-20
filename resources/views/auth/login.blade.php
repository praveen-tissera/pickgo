@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<form action="{{ route('login') }}" method="post" class="form-signin text-center">
    <!-- cross site request forgery -->
    @csrf
    <h1 class="mb-3 font-weight-normal">{{ __('login.login') }}</h1>

    <!-- email -->
    <div class="form-group">
        <label for="email" class="sr-only">{{ __('login.email') }}</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('login.enter_email') }}"  autofocus>

        {{-- display the erors --}}
        @error('email')
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @enderror
    </div>

    <!-- password -->
    <div class="form-group">
        <label for="password" class="sr-only">{{ __('login.password') }}</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('login.enter_password') }}" value="123456789">

        {{-- display the erors --}}
        @error('password')
            <div class="alert alert-danger">
                <p>{{ $message }}</p>
            </div>
        @enderror
    </div>

    <!-- remember me -->
    {{-- <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> {{ __('login.remember_me') }}
        </label>
    </div> --}}

    <!-- submit -->
    <button class="btn btn-lg btn-primary btn-block" type="submit">{{ __('login.login') }}</button>
    <a href="{{ route('register') }}">{{ __('login.dt_have_account') }} {{ __('login.register') }}</a>
    <p class="mt-5 mb-3 text-muted">&copy; 2021</p>
</form>
@endsection
