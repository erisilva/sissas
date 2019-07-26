@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('equipes.index') }}">Lista de Equipes e Vagas</a></li>
      <li class="breadcrumb-item"><a href="{{ route('equipes.trash') }}">Lixeira</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir e Restaurar Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="dia">Data</label>
        <input type="text" class="form-control" name="dia" value="{{ $equipe->created_at->format('d/m/Y') }}" readonly>
      </div>
      <div class="form-group col-md-2">
        <label for="hora">Hora</label>
        <input type="text" class="form-control" name="hora" value="{{ $equipe->created_at->format('H:i') }}" readonly>
      </div>
      <div class="form-group col-md-5">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" name="descricao" value="{{ $equipe->descricao }}" readonly>
      </div>
      <div class="form-group col-md-3">
        <label for="numero">Nº</label>
        <input type="text" class="form-control" name="numero" value="{{ $equipe->numero }}" readonly>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="cnes">CNES</label>
        <input type="text" class="form-control" name="cnes" value="{{ $equipe->cnes }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="ine">INE</label>
        <input type="text" class="form-control" name="ine" value="{{ $equipe->ine }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="minima">Mínima</label>
        <input type="text" class="form-control" name="minima" value="{{ ($equipe->minima == 's') ? 'Sim' : 'Não' }}" readonly>
      </div>     
    </div>
    <div class="form-row">
      <div class="form-group col-md-8">
        <label for="unidade">Unidade</label>
          <input type="text" class="form-control" name="unidade" value="{{ $equipe->unidade->descricao }}" readonly>     
      </div>
      <div class="form-group col-md-4">
        <label for="distrito">Distrito</label>
          <input type="text" class="form-control" name="distrito" value="{{ $equipe->unidade->distrito->nome }}" readonly>     
      </div>
    </div>
  </form>
  <br>
  <div class="container">
    <form method="post" action="{{route('equipes.trash.restore', array($equipe->id))}}">
      @csrf
      <a href="{{ route('equipes.trash') }}" class="btn btn-primary" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
      <button type="submit" class="btn btn-success"><i class="fas fa-trash-restore"></i> Restaurar</button>
    </form>
  </div>
</div>

@endsection
