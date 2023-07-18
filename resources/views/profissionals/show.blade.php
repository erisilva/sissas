@extends('layouts.app')

@section('title', 'Unidades - ' . __('Show'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('unidades.index') }}">
          Unidades
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
      <div class="col-md-8">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" name="nome" value="{{ $unidade->nome }}" readonly disabled>
      </div>
      <div class="col-md-4">
        <label for="distrito" class="form-label">Distrito</label>
        <input type="text" class="form-control" name="distrito" value="{{ $unidade->distrito->nome }}" readonly disabled>
      </div>
      <div class="col-md-6">
        <label for="email" class="form-label">E-mail</label>
        <input type="text" class="form-control" name="email" value="{{ $unidade->email }}" readonly disabled>
      </div>
      <div class="col-md-3">
        <label for="tel" class="form-label">TEL</label>
        <input type="text" class="form-control" name="tel" value="{{ $unidade->tel }}" readonly disabled>
      </div>
      <div class="col-md-3">
        <label for="cel" class="form-label">CEL</label>
        <input type="text" class="form-control" name="cel" value="{{ $unidade->cel }}" readonly disabled>
      </div>
      <div class="col-md-2">
        <label for="cep" class="form-label">CEP</label>
        <input type="text" class="form-control" name="cep" value="{{ $unidade->cep }}" readonly disabled>
      </div>
      <div class="col-md-5">
        <label for="logradouro" class="form-label">Logradouro</label>
        <input type="text" class="form-control" name="logradouro" value="{{ $unidade->logradouro }}" readonly disabled>
      </div>
      <div class="col-md-2">
        <label for="numero" class="form-label">Nº</label>
        <input type="text" class="form-control" name="numero" value="{{ $unidade->numero }}" readonly disabled>
      </div>
      <div class="col-md-3">
        <label for="complemento" class="form-label">Complemento</label>
        <input type="text" class="form-control" name="complemento" value="{{ $unidade->complemento }}" readonly disabled>
      </div>
      <div class="col-md-4">
        <label for="bairro" class="form-label">Bairro</label>
        <input type="text" class="form-control" name="bairro" value="{{ $unidade->bairro }}" readonly disabled>
      </div>
      <div class="col-md-4">
        <label for="cidade" class="form-label">Cidade</label>
        <input type="text" class="form-control" name="cidade" value="{{ $unidade->cidade }}" readonly disabled>
      </div>
      <div class="col-md-2">
        <label for="uf" class="form-label">UF</label>
        <input type="text" class="form-control" name="uf" value="{{ $unidade->uf }}" readonly disabled>
      </div>
      <div class="col-md-2">
        <label for="porte" class="form-label">Porte</label>
        <input type="text" class="form-control" name="porte" value="{{ $unidade->porte }}" readonly disabled>
      </div>
    </div>
  </form>
</div>

@can('unidade.delete')
<div class="container py-2">
  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalLixeira">
    <x-icon icon='trash' /> {{ __('Delete this record?') }}
  </button>
</div>
@endcan


<x-btn-back route="unidades.index" />

@can('unidade.delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('unidades.destroy', $unidade->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
