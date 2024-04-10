@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
<div class="container">
    <div class="row">
        <div class="text-center">
            <h1 class="text-primary">Bem Vindo!</h1>
        </div>    
    </div>
</div>

<div class="container">
    <div class="row py-5">
        <div class="col">
            <div class="text-center">
                <a class="nav-link" href="{{ route('profissionals.index') }}">
                    <i class="bi bi-file-person fs-1 text-primary"></i>
                </a>
                <h2 class="py-2">Profissionais</h2>
            </div>
        </div>

        <div class="col">
            <div class="text-center">
                <a class="nav-link" href="{{ route('equipegestao.index') }}">
                    <i class="bi bi-people fs-1 text-primary"></i>
                </a>
                <h2 class="py-2">Equipes</h2>
            </div>
        </div>

        <div class="col">
            <div class="text-center">
                <a class="nav-link" href="{{ route('unidades.index') }}">
                    <i class="bi bi-hospital fs-1 text-primary"></i>
                </a>
                <h2 class="py-2">Unidades</h2>
            </div>    
        </div>

        <div class="col">
            <div class="text-center">
                <a class="nav-link" href="{{ route('equipeview.index') }}">
                    <i class="bi bi-compass fs-1 text-primary"></i>
                </a>
                <h2 class="py-2">Mapa</h2>
            </div>    
        </div>

        <div class="col">
            <div class="text-center">
                <a class="nav-link" href="{{ route('historico.index') }}">
                    <i class="bi bi-journal-arrow-down fs-1 text-primary"></i>
                </a>
                <h2 class="py-2">Histórico</h2>
            </div>
        </div>
    </div>
</div>  
@endsection
