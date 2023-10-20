@extends('layouts.app')

@section('title', 'Licenças - ' . __('Show'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('profissionals.index') }}">
          Profissionais
        </a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('licencas.index') }}">
          Licenças
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<div class="container py-3">
  <form>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="profissional_nome" class="form-label">Profissional</label>
        <input type="text" class="form-control" name="profissional_nome" value="{{ $licenca->profissional->nome }}" readonly disabled>
      </div>
      <div class="col-md-4">
        <label for="cargo_descricao" class="form-label">Cargo</label>
        <input type="text" class="form-control" name="cargo_descricao" value="{{ $licenca->profissional->cargo->nome }}" readonly disabled>
      </div>
      <div class="col-md-2">
        <label for="matricula_profissional" class="form-label">Matrícula</label>
        <input type="text" class="form-control" name="matricula_profissional" value="{{ $licenca->profissional->matricula }}" readonly disabled>
      </div>
      <div class="col-md-6">
        <label for="licencatipo" class="form-label">Tipo de Férias</label>
        <input type="text" class="form-control" name="licencatipo" value="{{ $licenca->licencatipo->nome }}" readonly disabled>
      </div>
      <div class="col-md-3">
        <label for="inicio" class="form-label">Data Inicial</label>
        <input type="text" class="form-control" name="inicio" value="{{ $licenca->inicio->format('d/m/Y') }}" readonly disabled>
      </div>
      <div class="col-md-3">
        <label for="fim" class="form-label">Data Final</label>
        <input type="text" class="form-control" name="fim" value="{{ $licenca->fim->format('d/m/Y') }}" readonly disabled>
      </div>
      <div class="col-12">
        <label for="observacao" class="form-label">Observações</label>
        <input type="text" class="form-control" name="observacao" value="{{ $licenca->observacao }}" readonly disabled>
      </div>
    </div>
  </form>
</div>

@can('licenca.delete')
<div class="container py-2">
  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalLixeira">
    <x-icon icon='trash' /> {{ __('Delete this record?') }}
  </button>
</div>
@endcan


<x-btn-back route="licencas.index" />

@can('licenca.delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('licencas.destroy', $licenca->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
