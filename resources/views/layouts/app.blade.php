<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Custom Scripts -->
    @yield('script-header')

    <!-- Icones -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Custom css, necessary for typehead -->
    @yield('css-header')    
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-heartbeat"></i> {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @if (!Auth::guest())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('equipegestao.index') }}">Equipes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profissionals.index') }}">Profissionais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('unidades.index') }}">Unidades</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarConfig" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Configurações
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarConfig">
                          <a class="dropdown-item" href="{{ route('users.index') }}"><i class="fas fa-users-cog"></i> Operadores do Sistema</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="{{ route('distritos.index') }}"><i class="fas fa-map-marked-alt"></i> Distritos</a>
                          <a class="dropdown-item" href="{{ route('unidades.index') }}"><i class="fas fa-hospital"></i> Unidades</a>
                          <a class="dropdown-item" href="{{ route('equipes.index') }}"><i class="fas fa-users"></i> Equipes e Vagas</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="{{ route('cargos.index') }}"><i class="fas fa-table"></i> Cargos</a>
                          <a class="dropdown-item" href="{{ route('cargahorarias.index') }}"><i class="fas fa-table"></i> Cargas Horárias</a>
                          <a class="dropdown-item" href="{{ route('vinculos.index') }}"><i class="fas fa-table"></i> Vínculos</a>
                          <a class="dropdown-item" href="{{ route('vinculotipos.index') }}"><i class="fas fa-table"></i> Tipos de Vínculo</a>
                          <a class="dropdown-item" href="{{ route('licencatipos.index') }}"><i class="fas fa-table"></i> Tipos de Licença</a>
                          <a class="dropdown-item" href="{{ route('feriastipos.index') }}"><i class="fas fa-table"></i> Tipos de Férias</a>
                          <a class="dropdown-item" href="{{ route('capacitacaotipos.index') }}"><i class="fas fa-table"></i> Tipos de Capacitações</a>
                          <a class="dropdown-item" href="{{ route('orgaoemissores.index') }}"><i class="fas fa-table"></i> Orgão Emissor</a>
                        </div>
                    </li>
                    @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Sair do Sistema
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                                <a class="dropdown-item" href="{{ route('users.password') }}"><i class="fas fa-key"></i> Trocar Senha</a>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-2">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    @yield('script-footer')
</body>
</html>
