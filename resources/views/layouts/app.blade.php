<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="/css/estilo1.css">
    
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <header>
            <nav class="navbar">
                <div class="navbar-left">
                    <img src="/media/photos/11.png" alt="Logo de la empresa">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('Hydra-Motor', 'Hydra-Motor') }}
                    </a>
                </div>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-right">
                    @if(Auth::check() && Auth::user()->is_admin)
                    <li><a href="{{route('users.index')}}">Usuarios</a></li>
                    <li><a href="{{route('employees.index')}}">Empleados</a></li>
                    @endif
                    @if(Auth::check() && Auth::user()->is_employee)
                    <li><a href="{{route('customers.index')}}">Clientes</a></li>
                    <li><a href="{{route('sales.index')}}">Ventas</a></li>
                    @endif
                    <li><a href="{{route('concessionaires.index')}}">Concessionarios</a></li>
                    <li><a href="{{route('vehicles.index')}}">Vehiculos</a></li>
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        @endif

                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </nav>
        </header>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
