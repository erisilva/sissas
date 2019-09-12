@extends('layouts.app')

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
                <a class="nav-link" href="{{ route('equipegestao.index') }}"><i class="fas fa-users fa-10x text-primary"></i></a>
                <h2 class="py-2">Equipes</h2>
            </div>
        </div>

        <div class="col">
            <div class="text-center">
                <a class="nav-link" href="{{ route('profissionals.index') }}"><i class="fas fa-user-md fa-10x fa-10x text-primary"></i></a>
                <h2 class="py-2">Profissionais</h2>
            </div>
        </div>

        <div class="col">
            <div class="text-center">
                <a class="nav-link" href="{{ route('unidades.index') }}"><i class="fas fa-clinic-medical fa-10x text-primary"></i></a>
                <h2 class="py-2">Unidades</h2>
            </div>    
        </div>

        <div class="col">
            <div class="text-center">
                <a class="nav-link" href="{{ route('historicos.index') }}"><i class="fas fa-file-medical fa-10x text-primary"></i></a>
                <h2 class="py-2">Histórico</h2>
            </div>
        </div>
    </div>
</div>    
@endsection
