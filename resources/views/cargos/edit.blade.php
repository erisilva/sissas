@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('cargos.index') }}">Lista de Cargos</a></li>
      <li class="breadcrumb-item active" aria-current="page">Alterar Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  {{-- avisa se uma permissão foi alterada --}}
  @if(Session::has('edited_cargo'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('edited_cargo') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <form method="POST" action="{{ route('cargos.update', $cargo->id) }}">
    @csrf
    @method('PUT')
    <div class="form-row">
      <div class="form-group col-md-5">
        <label for="nome">Nome</label>
        <input type="text" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" name="nome" value="{{ old('nome') ?? $cargo->nome }}">
        @if ($errors->has('nome'))
        <div class="invalid-feedback">
        {{ $errors->first('nome') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-7">
        <label for="cbo">CBO</label>
        <input type="text" class="form-control{{ $errors->has('cbo') ? ' is-invalid' : '' }}" name="cbo" value="{{ old('cbo') ?? $cargo->cbo }}">
        @if ($errors->has('cbo'))
        <div class="invalid-feedback">
        {{ $errors->first('cbo') }}
        </div>
        @endif
      </div>
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Alterar Dados do Cargo</button>
  </form>
</div>
<div class="container">
  <div class="float-right">
    <a href="{{ route('cargos.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
  </div>
</div>
@endsection
