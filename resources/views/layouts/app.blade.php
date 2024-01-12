<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="robots" content="noindex, nofollow">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    
    @if (Auth::guest())
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('css/' . Auth::user()->theme->filename) }}">
    @endif

    <!-- Custom css -->
    @yield('css-header')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="bi bi-heart-pulse"></i> {{ config('app.name', 'Laravel') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        
                        

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                               Profissionais
                            </a>
                            <ul class="dropdown-menu">
                                @can('profissional.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('profissionals.index') }}">
                                        <x-icon icon='people' /> Profissionais
                                    </a>
                                </li>
                                @endcan   
                                @can('ferias.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('ferias.index') }}">
                                        <x-icon icon='airplane' /> Férias dos Profissionais
                                    </a>
                                </li>
                                @endcan
                                @can('licenca.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('licencas.index') }}">
                                        <x-icon icon='file-medical' /> Licenças dos Profissionais
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                               Equipes
                            </a>
                            <ul class="dropdown-menu">
                                @can('equipe.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('equipegestao.index') }}">
                                        <x-icon icon='person-gear' /> Gestão de Equipes e Vagas
                                    </a>
                                </li>
                                @endcan   
                                @can('equipe.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('equipeview.index') }}">
                                        <x-icon icon='compass' /> Mapa
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                               {{ __('Config') }} 
                            </a>
                            <ul class="dropdown-menu">
                                @can('user-index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('users.index') }}">
                                        <x-icon icon='people' /> {{ __('Users') }}
                                    </a>
                                </li>
                                @endcan
                                @can('log-index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('logs.index') }}">
                                        <x-icon icon='list' /> {{ __('Logs') }}
                                    </a>
                                </li>
                                @endcan
                                @can('distrito.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('distritos.index') }}">
                                        <x-icon icon='house-door-fill' /> Distritos
                                    </a>
                                </li>
                                @endcan
                                @can('unidade.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('unidades.index') }}">
                                        <x-icon icon='house-heart' /> Unidades
                                    </a>
                                </li>
                                @endcan
                                @can('equipe.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('equipes.index') }}">
                                        <x-icon icon='people-fill' /> Equipes e Vagas
                                    </a>
                                </li>
                                @endcan
                                @can('cargo.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('cargos.index') }}">
                                        <x-icon icon='table' /> Cargos
                                    </a>
                                </li>
                                @endcan
                                @can('cargahoraria.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('cargahorarias.index') }}">
                                        <x-icon icon='table' /> Carga Horária
                                    </a>
                                </li>
                                @endcan
                                @can('vinculo.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('vinculos.index') }}">
                                        <x-icon icon='table' /> Vínculos
                                    </a>
                                </li>
                                @endcan
                                @can('licencatipo.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('licencatipos.index') }}">
                                        <x-icon icon='table' /> Tipos de Licença
                                    </a>
                                </li>
                                @endcan
                                @can('feriastipo.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('feriastipos.index') }}">
                                        <x-icon icon='table' /> Tipos de Férias
                                    </a>
                                </li>
                                @endcan
                                @can('capacitacaotipo.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('capacitacaotipos.index') }}">
                                        <x-icon icon='table' /> Tipos de Capacitação
                                    </a>
                                </li>
                                @endcan
                                @can('vinculotipo.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('vinculotipos.index') }}">
                                        <x-icon icon='table' /> Tipos de Vínculo
                                    </a>
                                </li>
                                @endcan
                                @can('equipetipo.index')
                                <li>
                                    <a class="dropdown-item" href="{{ route('equipetipos.index') }}">
                                        <x-icon icon='table' /> Tipos de Equipe
                                    </a>
                                </li>
                                @endcan
                                <li>
                                    <a class="dropdown-item" href="#">
                                        Another action
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('about') }}">
                                        <x-icon icon='info-square' /> {{ __('About') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        Something else here
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    @endauth
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile') }}">
                                            <x-icon icon='person-fill' /> {{ __('Profile') }}
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            <x-icon icon='box-arrow-right' /> {{ __('Logout') }}
                                        </a>
                                    </li> 

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    @yield('script-footer')    
</body>
</html>
