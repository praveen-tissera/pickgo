@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('js')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{ asset('js/register.js') }}"></script>
@endsection

@section('content')
<form action="{{ route('register') }}" method="post" class="form-register text-center mx-auto">
    @csrf
    <h1 class="mb-3 font-weight-normal">{{ __('register.register') }}</h1>

    <div class="row">
        <!-- firstname -->
        <div class="form-group col-md-5 mx-auto">
            {{-- <label for="firstname">{{ __('register.firstname') }}</label> --}}
            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="{{ __('register.firstname') }}">

            {{-- display the erors --}}
            @error('firstname')
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @enderror
        </div>

        <!-- lastname -->
        <div class="form-group col-md-5 mx-auto">
            {{-- <label for="lastname">{{ __('register.lastname') }}</label> --}}
            <input type="text" name="lastname" id="lastname" class="form-control" value="kfjskdjf" placeholder="{{ __('register.lastname') }}">

            {{-- display the erors --}}
            @error('lastname')
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <!-- email -->
        <div class="form-group col-md-5 mx-auto">
            {{-- <label for="email">{{ __('register.email') }}</label> --}}
            <input type="test" name="email" id="email" class="form-control" value="omar@email.com" placeholder="{{ __('register.email') }}">
            
            {{-- display the erors --}}
            @error('email')
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @enderror
        </div>

        <!-- phone -->
        <div class="form-group col-md-5 mx-auto">
            {{-- <label for="phone">{{ __('register.phone') }}</label> --}}
            <input type="text" name="phone" id="phone" class="form-control" value="0987654321" placeholder="{{ __('register.phone') }}">

            {{-- display the erors --}}
            @error('phone')
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <!-- password -->
        <div class="form-group col-md-5 mx-auto">
            {{-- <label for="password">{{ __('register.password') }}</label> --}}
            <input type="password" name="password" id="password" class="form-control" value="123456789" placeholder="{{ __('register.password') }}">

            {{-- display the erors --}}
            @error('password')
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @enderror
        </div>
            
        <!-- password confirmation -->
        <div class="form-group col-md-5 mx-auto">
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" value="123456789" placeholder="{{ __('register.password_confirmation') }}">

            {{-- display the erors --}}
            @error('password_confirmation')
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <!-- adresse -->
        <div class="form-group col-md-5 mx-auto">
            {{-- <label for="adresse">{{ __('register.adresse') }}</label> --}}
            <input type="text" name="adresse" id="adresse" class="form-control" value="hdjahsf sdaj" placeholder="{{ __('register.adresse') }}">

            {{-- display the erors --}}
            @error('adresse')
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @enderror
        </div>

        <!-- cin -->
        <div class="form-group col-md-5 mx-auto">
            {{-- <label for="cin">{{ __('register.cin') }}</label> --}}
            <input type="text" name="cin" id="cin" class="form-control" value="hdjahsf sdaj" placeholder="{{ __('register.cin') }}">

            {{-- display the erors --}}
            @error('cin')
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <!-- cin -->
        <div class="form-group col-md-5 mx-auto">
            <input type="text" name="cin" id="cin" class="form-control" value="z123456" placeholder="Enter CIN">

            {{-- display the erors --}}
            @error('cin')
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-5 mx-auto">
            <div class="g-recaptcha mx-auto mb-4" data-sitekey="{{ config('admin.captcha-key') }}"></div>

            {{-- display the erors --}}
            @error('g-recaptcha-response')
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @enderror
        </div>
    </div>

    <!-- submit -->
    <div class="row">
        <input type="submit" value="{{ __('register.crt_account') }}" class="btn btn-primary mx-auto mb-3">
    </div>
    <a class="mx-auto" href="{{ route('login') }}">{{ __('register.al_have_account') }} {{ __('register.login') }}</a>
</form>
@endsection
