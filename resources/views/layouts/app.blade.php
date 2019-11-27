@php($admin = !is_null(Auth::user()) && Auth::user()->admin)
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MTLSZ JVB</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@section('header_scripts')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
@show
</head>
<body>
    <div id="app">
        @auth
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <!-- <a class="navbar-brand" href="{{ route('login') }}">
                    MTLSZ JVB
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> -->

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('calendar') }}">{{ __('Tournament calendar') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('calendar',Auth::user()->id) }}">{{ __('My applications') }}</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @if( $admin )
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminNavbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Admin
                                </a>
                                <div class="dropdown-menu" aria-labelledby="adminNavbarDropdown">
                                    <a class="nav-link" href="{{ route('users') }}">{{ __('Users') }}</a>
                                    <a class="nav-link" href="{{ route('venues') }}">{{ __('Venues') }}</a>
                                    <a class="nav-link" href="{{ route('tournaments') }}">{{ __('Tournaments') }}</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#">|</a>
                            </li>
                        @endif
                        <!-- Authentication Links -->
                        @auth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @endif

        <main class="py-4">
            <div class="container">
                @if(session('error'))
                    <div class="row justify-content-center">
                        <div class="col col-auto alert alert-danger" role="alert">
                            {{ __(session('error')) }}
                        </div>
                    </div>
                @endif
                @if(session('message'))
                    <div class="row justify-content-center">
                        <div class="col col-auto alert alert-success" role="alert">
                            {{ __(session('message')) }}
                        </div>
                    </div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
