@extends('layouts.app')

@section('title', 'Profissionais - ' . __('Show'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('profissionals.index') }}">
          <x-icon icon='file-person' /> Profissionais
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
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" name="nome" value="{{ $profissional->nome }}" readonly disabled>
      </div>
      <div class="col-md-2">
        <label for="matricula" class="form-label">Matricula</label>
        <input type="text" class="form-control" name="matricula" value="{{ $profissional->matricula }}" readonly disabled>
      </div>
      <div class="col-md-2">
        <label for="cpf" class="form-label">CPF</label>
        <input type="text" class="form-control" name="cpf" value="{{ $profissional->cpf }}" readonly disabled>
      </div>
      <div class="col-md-2">
        <label for="cns" class="form-label">CNS</label>
        <input type="text" class="form-control" name="cns" value="{{ $profissional->cns }}" readonly disabled>
      </div>
      <div class="col-md-6">
        <label for="email" class="form-label">E-mail</label>
        <input type="text" class="form-control" name="email" value="{{ $profissional->email }}" readonly disabled>
      </div>
      <div class="col-md-3">
        <label for="tel" class="form-label">TEL</label>
        <input type="text" class="form-control" name="tel" value="{{ $profissional->tel }}" readonly disabled>
      </div>
      <div class="col-md-3">
        <label for="cel" class="form-label">CEL</label>
        <input type="text" class="form-control" name="cel" value="{{ $profissional->cel }}" readonly disabled>
      </div>
      <div class="col-md-2">
        <label for="cep" class="form-label">CEP</label>
        <input type="text" class="form-control" name="cep" value="{{ $profissional->cep }}" readonly disabled>
      </div>
      <div class="col-md-5">
        <label for="logradouro" class="form-label">Logradouro</label>
        <input type="text" class="form-control" name="logradouro" value="{{ $profissional->logradouro }}" readonly disabled>
      </div>
      <div class="col-md-2">
        <label for="numero" class="form-label">Nº</label>
        <input type="text" class="form-control" name="numero" value="{{ $profissional->numero }}" readonly disabled>
      </div>
      <div class="col-md-3">
        <label for="complemento" class="form-label">Complemento</label>
        <input type="text" class="form-control" name="complemento" value="{{ $profissional->complemento }}" readonly disabled>
      </div>
      <div class="col-md-5">
        <label for="bairro" class="form-label">Bairro</label>
        <input type="text" class="form-control" name="bairro" value="{{ $profissional->bairro }}" readonly disabled>
      </div>
      <div class="col-md-5">
        <label for="cidade" class="form-label">Cidade</label>
        <input type="text" class="form-control" name="cidade" value="{{ $profissional->cidade }}" readonly disabled>
      </div>
      <div class="col-md-2">
        <label for="uf" class="form-label">UF</label>
        <input type="text" class="form-control" name="uf" value="{{ $profissional->uf }}" readonly disabled>
      </div>
      <div class="col-md-5">
        <label for="cargo" class="form-label">Cargo</label>
        <input type="text" class="form-control" name="cargo" value="{{ $profissional->cargo->nome }}" readonly disabled>
      </div>
      <div class="col-md-3">
        <label for="vinculo" class="form-label">Vinculo</label>
        <input type="text" class="form-control" name="vinculo" value="{{ $profissional->vinculo->nome }}" readonly disabled>
      </div>
      <div class="col-md-4">
        <label for="vinculotipo" class="form-label">Tipo de Vínculo</label>
        <input type="text" class="form-control" name="vinculotipo" value="{{ $profissional->vinculoTipo->nome }}" readonly disabled>
      </div>
      <div class="col-md-3">
        <label for="cargahoraria" class="form-label">Carga Horária</label>
        <input type="text" class="form-control" name="cargahoraria" value="{{ $profissional->cargaHoraria->nome }}" readonly disabled>
      </div>
      <div class="col-md-6">
        <label for="flexibilizacao" class="form-label">Flexibilização</label>
        <input type="text" class="form-control" name="flexibilizacao" value="{{ $profissional->flexibilizacao }}" readonly disabled>
      </div>
      <div class="col-md-3">
        <label for="admissao" class="form-label">Admissão</label>
        <input type="text" class="form-control" name="admissao" value="{{ date('d/m/Y', strtotime($profissional->admissao)) }}" readonly disabled>
      </div>
      <div class="col-md-4">
        <label for="registroClasse" class="form-label">Registro de Classe</label>
        <input type="text" class="form-control" name="registroClasse" value="{{ $profissional->registroClasse }}" readonly disabled>
      </div>
      <div class="col-md-4">
        <label for="orgao_emissor" class="form-label">Orgão Emissor</label>
        <input type="text" class="form-control" name="orgao_emissor" value="{{ $profissional->orgaoEmissor->nome }}" readonly disabled>
      </div>
      <div class="col-md-4">
        <label for="ufOrgaoEmissor" class="form-label">UF/SSP</label>
        <input type="text" class="form-control" name="ufOrgaoEmissor" value="{{ $profissional->ufOrgaoEmissor }}" readonly disabled>
      </div>
      <div class="col-12">
        <label for="observacao">Observações</label>
        <textarea class="form-control" name="observacao" rows="3" readonly disabled>{{ $profissional->observacao }}</textarea>    
      </div>
    </div>
  </form>
</div>

@can('profissional.delete')
<div class="container py-2">
  <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalLixeira">
    <x-icon icon='trash' /> {{ __('Delete this record?') }}
  </button>
</div>
@endcan

<x-btn-back route="profissionals.index" />

@can('profissional.delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('profissionals.destroy', $profissional->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
