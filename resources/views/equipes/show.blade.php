@extends('layouts.app')

@section('title', 'Equipes e Vagas')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('equipes.index') }}">
          Equipes e Vagas
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<div class="container">
  <form>
  <div class="row g-3">


    <div class="col-md-8">
        <label for="descricao" class="form-label">Descrição</label>
        <input type="text" class="form-control" name="descricao" id="descricao" value="{{ $equipe->decricao }}" readonly> 
    </div>
    <div class="col-md-4">
        <label for="numero" class="form-label">Número</label>
        <input type="text" class="form-control" name="numero" id="numero" value="{{ $equipe->numero }}" readonly>   
    </div>

    <div class="col-md-3">
      <label for="cnes" class="form-label">CNES</label>
      <input type="text" class="form-control" name="cnes" id="cnes" value="{{ $equipe->cnes }}" readonly>   
    </div>
    <div class="col-md-3">
      <label for="ine" class="form-label">INE</label>
      <input type="text" class="form-control" name="ine" id="ine" value="{{ $equipe->ine }}" readonly>   
    </div>
    <div class="col-md-3">
      <label for="minima" class="form-label">Mínima</label>
      <input type="text" class="form-control" name="minima" id="minima" value="{{ $equipe->minima }}" readonly>   
    </div>
    <div class="col-md-3">
      <label for="tipo" class="form-label">Tipo</label>
      <input type="text" class="form-control" name="tipo" id="tipo" value="{{ $equipe->equipeTipo->nome }}" readonly>   
    </div>

    <div class="col-md-8">
      <label for="unidade" class="form-label">Unidade</label>
      <input type="text" class="form-control" name="unidade" id="unidade" value="{{ $equipe->unidade->nome }}" readonly> 
    </div>
    <div class="col-md-4">
        <label for="distrito" class="form-label">Distrito</label>
        <input type="text" class="form-control" name="distrito" id="distrito" value="{{ $equipe->unidade->distrito->nome }}" readonly>   
    </div>


    <div class="col-md-4">
      <label for="total_de_vagas" class="form-label">Total de Vagas</label>
      <input type="text" class="form-control" name="total_de_vagas" id="total_de_vagas" value="{{ $equipe->total_vagas }}" readonly>   
    </div>
    <div class="col-md-4">
      <label for="total_de_vagas_preenchidas" class="form-label">Total de Vagas Prenchidas</label>
      <input type="text" class="form-control" name="total_de_vagas_preenchidas" id="total_de_vagas_preenchidas" value="{{ $equipe->vagas_preenchidas }}" readonly>   
    </div>
    <div class="col-md-4">
      <label for="total_de_vagas_livres" class="form-label">Total de Vagas Livres</label>
      <input type="text" class="form-control" name="numero" id="total_de_vagas_livres" value="{{ $equipe->vagas_disponiveis }}" readonly>   
    </div>



  </div>  
  </form>  
</div>


@can('equipe.delete')
<x-btn-trash />
@endcan

<x-btn-back route="equipes.index" />

@can('equipe.delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('equipes.destroy', $equipe->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
