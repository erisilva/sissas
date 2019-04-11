@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('cargos.index') }}">Lista de Cargos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form method="POST" action="{{ route('cargos.store') }}">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-7">
        <label for="nome">Nome</label>
        <input type="text" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" name="nome" value="{{ old('nome') ?? '' }}">
        @if ($errors->has('nome'))
        <div class="invalid-feedback">
        {{ $errors->first('nome') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-5">
        <label for="cbo">CBO</label>
        <input type="text" class="form-control{{ $errors->has('cbo') ? ' is-invalid' : '' }}" name="cbo" value="{{ old('cbo') ?? '' }}">
        @if ($errors->has('cbo'))
        <div class="invalid-feedback">
        {{ $errors->first('cbo') }}
        </div>
        @endif
      </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Incluir Cargo</button>
  </form>
  <div class="float-right">
    <a href="{{ route('cargos.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
  </div>
</div>
@endsection
