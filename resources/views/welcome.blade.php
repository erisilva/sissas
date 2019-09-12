@extends('layouts.app')

@section('content')
@if (!Auth::guest())
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
@else
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Senha</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection