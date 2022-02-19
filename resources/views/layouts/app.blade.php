<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    @yield('css')

</head>
<body>
    <!-- navbar -->
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="{{ route('home') }}">Pick & Go</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    @if(Auth::check())
                        {{-- home --}}
                        <li class="nav-item {{ Route::currentRouteName() === 'home' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('home') }}">{{ __('layout.home') }}</a>
                        </li>

                        {{-- test if the user is admin --}}
                        @if(\App\User::role() === "admin")
                            {{-- users --}}
                            <li class="nav-item {{ Route::currentRouteName() === 'users' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('users') }}">{{ __('layout.users') }}</a>
                            </li>

                            {{-- deliverers --}}
                            <li class="nav-item {{ Route::currentRouteName() === 'deliverers' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('deliverers') }}">{{ __('layout.deliverers') }}</a>
                            </li>

                            {{-- packages --}}
                            <li class="nav-item {{ Route::currentRouteName() === 'all-packages' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('all-packages') }}">{{ __('layout.all-packages') }}</a>
                            </li>

                            {{-- all packages --}}
                            <li class="nav-item {{ Route::currentRouteName() === 'packages' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('packages') }}">{{ __('layout.packages') }}</a>
                            </li>

                            {{-- current deliveries --}}
                            <li class="nav-item {{ Route::currentRouteName() === 'current-deliveries' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('current-deliveries') }}">{{ __('layout.current-deliveries') }}</a>
                            </li>
                        @endif

                        {{-- test if the user is deliverer --}}
                        @if(\App\User::role() === "deliverer")
                            {{-- @if(!\App\Delivery::hasDelivery()) --}}
                                {{-- packages map --}}
                                <li class="nav-item {{ Route::currentRouteName() === 'packages-map' ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('packages-map') }}">{{ __('layout.packages-map') }}</a>
                                </li>
                            {{-- @endif --}}

                            @if(\App\Delivery::hasDelivery(Auth::id()))
                                {{-- delivery package info --}}
                                <li class="nav-item {{ Route::currentRouteName() === 'package-info' ? 'active' : '' }}">
                                    <span class="has-delivery pull-right"></span>
                                    <a class="nav-link" href="{{ route('package-info') }}">{{ __('layout.package-info') }}</a>
                                </li>
                            @endif
                        @endif
                    @endif
                </ul>

                {{-- test if the role of the user --}}
                @if(Auth::check())
                    <!-- dropdown -->
                    <div class="dropdown">
                        <a class="text-light dropdown-toggle btn btn-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->firstname .' '. Auth::user()->lastname }}
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <p class="dropdown-item disabled font-weight-bold">{{ ucfirst(Auth::user()->role) }}</p>
                            <div class="dropdown-divider"></div>
                            {{-- logout form + a tag --}}
                            <form action="{{ route('logout') }}" method="post" id="form-logout" class="d-none">@csrf</form>
                            <a class="dropdown-item" href="{{ route('logout') }}" 
                                onclick="event.preventDefault();document.getElementById('form-logout').submit();">
                                {{ __('auth.logout') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </nav>
    </header>

    <div class="content">
        @yield('content')
    </div>

    @yield('js')
</body>
</html>
