@extends('layouts.app')

@section('title', 'Mapa - ' . __('Show'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item" aria-current="page">
        <a href="{{ route('equipeview.index') }}">
          <x-icon icon='compass' /> Mapa
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<div class="container py-2">

  <div class="container py-2">
    <p class="text-center bg-primary text-white">
      <strong>Profissional</strong>
    </p>
  </div>

  <div class="container py-2">


    <form>
      <div class="row g-3">
        <div class="col-md-6">
          <label for="nome" class="form-label">Nome</label>
          <input type="text" class="form-control" name="nome" value="{{ $equipeView->nome }}" readonly disabled>
        </div>
        <div class="col-md-2">
          <label for="matricula" class="form-label">Matricula</label>
          <input type="text" class="form-control" name="matricula" value="{{ $equipeView->matricula }}" readonly disabled>
        </div>
        <div class="col-md-2">
          <label for="cpf" class="form-label">CPF</label>
          <input type="text" class="form-control" name="cpf" value="{{ $equipeView->cpf }}" readonly disabled>
        </div>
        <div class="col-md-2">
          <label for="cns" class="form-label">CNS</label>
          <input type="text" class="form-control" name="cns" value="{{ $equipeView->cns }}" readonly disabled>
        </div>
        <div class="col-md-6">
          <label for="email" class="form-label">E-mail</label>
          <input type="text" class="form-control" name="email" value="{{ $equipeView->email }}" readonly disabled>
        </div>
        <div class="col-md-3">
          <label for="tel" class="form-label">TEL</label>
          <input type="text" class="form-control" name="tel" value="{{ $equipeView->tel }}" readonly disabled>
        </div>
        <div class="col-md-3">
          <label for="cel" class="form-label">CEL</label>
          <input type="text" class="form-control" name="cel" value="{{ $equipeView->cel }}" readonly disabled>
        </div>
        <div class="col-md-2">
          <label for="cep" class="form-label">CEP</label>
          <input type="text" class="form-control" name="cep" value="{{ $equipeView->cep }}" readonly disabled>
        </div>
        <div class="col-md-5">
          <label for="logradouro" class="form-label">Logradouro</label>
          <input type="text" class="form-control" name="logradouro" value="{{ $equipeView->logradouro }}" readonly disabled>
        </div>
        <div class="col-md-2">
          <label for="numero" class="form-label">Nº</label>
          <input type="text" class="form-control" name="numero" value="{{ $equipeView->numero }}" readonly disabled>
        </div>
        <div class="col-md-3">
          <label for="complemento" class="form-label">Complemento</label>
          <input type="text" class="form-control" name="complemento" value="{{ $equipeView->complemento }}" readonly disabled>
        </div>
        <div class="col-md-5">
          <label for="bairro" class="form-label">Bairro</label>
          <input type="text" class="form-control" name="bairro" value="{{ $equipeView->bairro }}" readonly disabled>
        </div>
        <div class="col-md-5">
          <label for="cidade" class="form-label">Cidade</label>
          <input type="text" class="form-control" name="cidade" value="{{ $equipeView->cidade }}" readonly disabled>
        </div>
        <div class="col-md-2">
          <label for="uf" class="form-label">UF</label>
          <input type="text" class="form-control" name="uf" value="{{ $equipeView->uf }}" readonly disabled>
        </div>
        <div class="col-md-5">
          <label for="cargo" class="form-label">Cargo</label>
          <input type="text" class="form-control" name="cargo" value="{{ $equipeView->cargo_profissional ?? '' }}" readonly disabled>
        </div>
        <div class="col-md-3">
          <label for="vinculo" class="form-label">Vinculo</label>
          <input type="text" class="form-control" name="vinculo" value="{{ $equipeView->vinculo ?? '' }}" readonly disabled>
        </div>
        <div class="col-md-4">
          <label for="vinculotipo" class="form-label">Tipo de Vínculo</label>
          <input type="text" class="form-control" name="vinculotipo" value="{{ $equipeView->tipo_de_vinculo ?? '' }}" readonly disabled>
        </div>
        <div class="col-md-3">
          <label for="cargahoraria" class="form-label">Carga Horária</label>
          <input type="text" class="form-control" name="cargahoraria" value="{{ $equipeView->carga_horaria ?? '' }}" readonly disabled>
        </div>
        <div class="col-md-6">
          <label for="flexibilizacao" class="form-label">Flexibilização</label>
          <input type="text" class="form-control" name="flexibilizacao" value="{{ $equipeView->flexibilizacao }}" readonly disabled>
        </div>
        <div class="col-md-3">
          <label for="admissao" class="form-label">Admissão</label>
          <input type="text" class="form-control" name="admissao" value="{{ date('d/m/Y', strtotime($equipeView->admissao))  ?? '' }}" readonly disabled>
        </div>
        <div class="col-md-4">
          <label for="registroClasse" class="form-label">Registro de Classe</label>
          <input type="text" class="form-control" name="registroClasse" value="{{ $equipeView->registroClasse }}" readonly disabled>
        </div>
        <div class="col-md-4">
          <label for="orgao_emissor" class="form-label">Orgão Emissor</label>
          <input type="text" class="form-control" name="orgao_emissor" value="{{ $equipeView->orgao_emissor ?? '' }}" readonly disabled>
        </div>
        <div class="col-md-4">
          <label for="ufOrgaoEmissor" class="form-label">UF/SSP</label>
          <input type="text" class="form-control" name="ufOrgaoEmissor" value="{{ $equipeView->ufOrgaoEmissor ?? '' }}" readonly disabled>
        </div>
      </div>
    </form>
  </div>
</div>


<div class="container py-2">

  <div class="container py-2">
    <p class="text-center bg-primary text-white">
      <strong>Equipe</strong>
    </p>
  </div>

  <div class="container py-2">

    <form>
      <div class="row g-3">   
        <div class="col-md-8">
            <label for="descricao" class="form-label">Descrição</label>
            <input type="text" class="form-control" name="descricao" id="descricao" value="{{ $equipeView->equipe }}" readonly> 
        </div>
        <div class="col-md-4">
            <label for="numero" class="form-label">Número</label>
            <input type="text" class="form-control" name="numero" id="numero" value="{{ $equipeView->equipe_numero }}" readonly>   
        </div>
    
        <div class="col-md-3">
          <label for="cnes" class="form-label">CNES</label>
          <input type="text" class="form-control" name="cnes" id="cnes" value="{{ $equipeView->cnes }}" readonly>   
        </div>
        <div class="col-md-3">
          <label for="ine" class="form-label">INE</label>
          <input type="text" class="form-control" name="ine" id="ine" value="{{ $equipeView->ine }}" readonly>   
        </div>
        <div class="col-md-3">
          <label for="minima" class="form-label">Mínima</label>
          <input type="text" class="form-control" name="minima" id="minima" value="{{ $equipeView->minima }}" readonly>   
        </div>
        <div class="col-md-3">
          <label for="tipo" class="form-label">Tipo</label>
          <input type="text" class="form-control" name="tipo" id="tipo" value="{{ $equipeView->equipe_tipo }}" readonly>   
        </div>
    
        <div class="col-md-8">
          <label for="unidade" class="form-label">Unidade</label>
          <input type="text" class="form-control" name="unidade" id="unidade" value="{{ $equipeView->unidade }}" readonly> 
        </div>
        <div class="col-md-4">
            <label for="distrito" class="form-label">Distrito</label>
            <input type="text" class="form-control" name="distrito" id="distrito" value="{{ $equipeView->distrito }}" readonly>   
        </div>
      </div>  
      </form> 

  </div>  
</div>

<x-btn-back route="equipeview.index" />

@endsection
