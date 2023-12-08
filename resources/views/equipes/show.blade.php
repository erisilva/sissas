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
        <input type="text" class="form-control" name="descricao" id="descricao" value="{{ $equipe->descricao }}" readonly> 
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

<br>

@if (count($equipeprofissionais))
<div class="container py-2">
  <p class="text-center bg-primary text-white">
    <strong>Cargos e Vagas</strong>
  </p>  
</div>

  <div class="container">
    <div class="table-responsive">
      <table class="table table-striped">
          <thead>
              <tr>
                  <th scope="col">Cargo</th>
                  <th scope="col">CBO</th>
                  <th scope="col">Profissional</th>
                  <th scope="col">Matrícula</th>
              </tr>
          </thead>
          <tbody>
              @foreach($equipeprofissionais as $equipeprofissional)
              <tr>
                <td>{{ $equipeprofissional->cargo->nome }}</td>
                <td>{{ $equipeprofissional->cargo->cbo }}</td>
                <td>
                  @if(isset($equipeprofissional->profissional->id))
                    <span><a class="btn btn-sm btn-success" href="{{ route('profissionals.edit', $equipeprofissional->profissional->id) }}" role="button" btn-sm><x-icon icon='people' /></a> {{ $equipeprofissional->profissional->nome }}</span>
                  @else
                    <span class="fw-light">Vaga Livre</span>
                  @endif
                </td>
                <td>{{ isset($equipeprofissional->profissional->matricula) ?  $equipeprofissional->profissional->matricula : '-' }}</td>
              </tr>    
              @endforeach                                             
          </tbody>
      </table>
    </div>  
  </div>

@else
<div class="alert alert-info" role="alert">
  Essa Unidade não Possui Vagas Preenchidas!
</div>
@endif


<div class="container">




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
