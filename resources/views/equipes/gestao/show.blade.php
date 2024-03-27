@extends('layouts.app')

@section('css-header')
<style>
  .twitter-typeahead, .tt-hint, .tt-input, .tt-menu { width: 100%; }
  .tt-query, .tt-hint { outline: none;}
  .tt-query { box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);}
  .tt-hint {color: #999;}
  .tt-menu { 
      width: 100%;
      margin-top: 12px;
      padding: 8px 0;
      background-color: #fff;
      border: 1px solid #ccc;
      border: 1px solid rgba(0, 0, 0, 0.2);
      border-radius: 8px;
      box-shadow: 0 5px 10px rgba(0,0,0,.2);
  }
  .tt-suggestion { padding: 3px 20px; }
  .tt-suggestion.tt-is-under-cursor { color: #fff; }
  .tt-suggestion p { margin: 0;}
</style>
@endsection

@section('title', 'Equipes')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('equipegestao.index') }}">
          <x-icon icon='people' /> Equipes
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<div class="container">

  <x-flash-message status='success'  message='message' />

  @error('cargo_id')
  <div class="alert alert-danger" role="alert">
    {{ $message }}
  </div>
  @enderror 

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
  </div>  
  </form>  
</div>


<br>

@if (count($equipeprofissionais))
<div class="container-fluid py-2">
  <p class="text-center bg-primary text-white">
    <strong>Cargos e Vagas</strong>
  </p>  
</div>

<div class="container-fluid">
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">CBO</th>
                <th scope="col">Cargo</th>                
                <th scope="col">Profissional</th>
                <th scope="col">Matrícula</th>
                <th scope="col">CPF</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipeprofissionais as $equipeprofissional)
            <tr>
              <td>
                {{ $equipeprofissional->cargo->cbo }}
              </td>
              <td>
                {{ $equipeprofissional->cargo->nome }}
              </td>
              
              <td>
                @if(isset($equipeprofissional->profissional->id))
                  <span>
                    <a class="btn btn-sm btn-success" role="button" data-bs-toggle="modal" data-bs-target="#ProfissionalModal" data-profissional-id="{{ $equipeprofissional->profissional->id }}">
                      <x-icon icon='people' />
                    </a> 
                        {{ $equipeprofissional->profissional->nome }}
                  </span>
                @else
                <span class="badge text-bg-info">Vaga Livre</span>
                @endif
              </td>

              <td>
                @if(isset($equipeprofissional->profissional->matricula))
                  {{ $equipeprofissional->profissional->matricula }}
                @else
                  <span class="badge text-bg-info">Vaga Livre</span>
                @endif
              </td>

              <td>
                @if(isset($equipeprofissional->profissional->cpf))
                  {{ $equipeprofissional->profissional->cpf }}
                @else
                  <span class="badge text-bg-info">Vaga Livre</span>
                @endif
              </td>


              <td>
                @if(isset($equipeprofissional->profissional_id))
                <button type="button" class="btn btn-warning btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modallimparvaga" 
                            data-cargo-nome="{{ $equipeprofissional->cargo->nome}}" 
                            data-profissional-nome="{{ isset($equipeprofissional->profissional_id) ?  $equipeprofissional->profissional->nome : 'Sem Vínculo' }}" 
                            data-equipeprofissional-id="{{ $equipeprofissional->id}}" 
                            data-equipe-id="{{ $equipe->id}}">
                            <x-icon icon='x-circle' /> Remover
                </button>

                @else

                <button type="button" class="btn btn-primary btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalvincularprofissional" 
                            data-equipeprofissional-id="{{ $equipeprofissional->id}}" 
                            data-cargo-id="{{ $equipeprofissional->cargo->id}}" 
                            data-cargo-nome="{{ $equipeprofissional->cargo->nome}}" 
                            data-equipe-id="{{ $equipe->id}}">
                            <x-icon icon='plus-circle' /> Atribuir
                </button>
                <button type="button" class="btn btn-secondary btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalregistrarprofissional" 
                            data-equipeprofissional-id="{{ $equipeprofissional->id}}" 
                            data-cargo-id="{{ $equipeprofissional->cargo->id}}"
                            data-cargo-nome="{{ $equipeprofissional->cargo->nome}}"
                            data-equipe-id="{{ $equipe->id}}">
                            <x-icon icon='file-earmark' /> Registrar
                </button>

                @endif
              </td>



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


<br>

<div class="container py-2">
  <p class="text-center bg-primary text-white">
    <strong>Sumário</strong>
  </p>  
</div>

<div class="container py-3">
  <form>
  <div class="row g-3">
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


<x-btn-back route="equipegestao.index" />


{{-- Modal Vincular Profissional --}}
<div class="modal fade" id="modalvincularprofissional" tabindex="-1" aria-labelledby="JanelaVincularVaga" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ModalLabelVincularVaga"><x-icon icon='plus-circle' /> Atribuir Profissional</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form method="POST" action="{{ route('equipegestao.preenchervaga') }}">
          @csrf
          
          <div class="mb-3">
            <label for="cargo_nome" class="form-label">Vaga</label>
            <input type="text" class="form-control" name="cargo_nome" id="cargo_nome" readonly>
          </div>
        

          <input type="hidden" id="equipe_id" name="equipe_id" value="">
          <input type="hidden" id="cargo_id" name="cargo_id" value="">            
          <input type="hidden" id="equipeprofissional_id" name="equipeprofissional_id" value="">

          <div class="mb-3">
            <label for="profissional_nome" class="form-label">Profissional</label>
            <input type="text" class="form-control typeahead" name="profissional_nome" id="profissional_nome" value="{{ old('profissional_nome') ?? '' }}" autocomplete="off">       
            <input type="hidden" id="profissional_id" name="profissional_id" value="{{ old('profissional_id') ?? '' }}">
            <input type="hidden" id="cargo_profissional_id" name="cargo_profissional_id" value="{{ old('cargo_profissional_id') ?? '' }}">
          </div>

          <button type="submit" class="btn btn-primary"><x-icon icon='plus-circle' /> Atribuir Profissional</button>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><x-icon icon='x' /> Fechar</button>
      </div>
    </div>
  </div>
</div>




{{-- Modal Limpar Vaga--}}
<div class="modal fade" id="modallimparvaga" tabindex="-1" aria-labelledby="JanelaVincularVaga" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ModalLabelLimparVaga"><x-icon icon='x-circle' /> Remover Profissional</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('equipegestao.limparvaga') }}">
          @csrf
          <div class="mb-3">
            <label for="cargo_nome_limpar" class="form-label">Cargo da Vaga</label>
            <input type="text" class="form-control" name="cargo_nome_limpar" id="cargo_nome_limpar" readonly>
          </div>
          <div class="form-group">
            <label for="profissional_nome_limpar">Profissional Vinculado</label>
            <input type="text" class="form-control" name="profissional_nome_limpar" id="profissional_nome_limpar" readonly>
          </div>
          <div class="mb-3">
            <label for="motivo_limpar" class="form-label">Motivo</label>
            <input type="text" class="form-control" name="motivo_limpar" id="motivo_limpar">
          </div>
          <input type="hidden" id="equipeprofissional_id_limpar" name="equipeprofissional_id_limpar" value="">
          <input type="hidden" id="equipe_id_limpar" name="equipe_id_limpar" value="">            
          <button type="submit" class="btn btn-warning"><x-icon icon='x-circle' /> Remover Profissional</button>          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><x-icon icon='x' /> Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Profissional Modal -->
<div class="modal fade modal-xl" id="ProfissionalModal" tabindex="-1" aria-labelledby="Profissional" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"><x-icon icon='people' /> Profissional</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control" name="modal_nome" id="modal_nome" value="" readonly disabled>
            </div>
            <div class="col-md-2">
              <label for="matricula" class="form-label">Matricula</label>
              <input type="text" class="form-control" name="modal_matricula" id="modal_matricula" value="" readonly disabled>
            </div>
            <div class="col-md-2">
              <label for="cpf" class="form-label">CPF</label>
              <input type="text" class="form-control" name="modal_cpf" id="modal_cpf" value="" readonly disabled>
            </div>
            <div class="col-md-2">
              <label for="cns" class="form-label">CNS</label>
              <input type="text" class="form-control" name="modal_cns" id="modal_cns" value="" readonly disabled>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">E-mail</label>
              <input type="text" class="form-control" name="modal_email" id="modal_email" value="" readonly disabled>
            </div>
            <div class="col-md-3">
              <label for="tel" class="form-label">TEL</label>
              <input type="text" class="form-control" name="modal_tel" id="modal_tel" value="" readonly disabled>
            </div>
            <div class="col-md-3">
              <label for="cel" class="form-label">CEL</label>
              <input type="text" class="form-control" name="modal_cel" id="modal_cel" value="" readonly disabled>
            </div>
            <div class="col-md-2">
              <label for="cep" class="form-label">CEP</label>
              <input type="text" class="form-control" name="modal_cep" id="modal_cep" value="" readonly disabled>
            </div>
            <div class="col-md-5">
              <label for="logradouro" class="form-label">Logradouro</label>
              <input type="text" class="form-control" name="modal_logradouro" id="modal_logradouro" value="" readonly disabled>
            </div>
            <div class="col-md-2">
              <label for="numero" class="form-label">Nº</label>
              <input type="text" class="form-control" name="modal_numero" id="modal_numero" value="" readonly disabled>
            </div>
            <div class="col-md-3">
              <label for="complemento" class="form-label">Complemento</label>
              <input type="text" class="form-control" name="modal_complemento" id="modal_complemento" value="" readonly disabled>
            </div>
            <div class="col-md-5">
              <label for="bairro" class="form-label">Bairro</label>
              <input type="text" class="form-control" name="modal_bairro" id="modal_bairro" value="" readonly disabled>
            </div>
            <div class="col-md-5">
              <label for="cidade" class="form-label">Cidade</label>
              <input type="text" class="form-control" name="modal_cidade" id="modal_cidade" value="" readonly disabled>
            </div>
            <div class="col-md-2">
              <label for="uf" class="form-label">UF</label>
              <input type="text" class="form-control" name="modal_uf" id="modal_uf" value="" readonly disabled>
            </div>
            <div class="col-md-5">
              <label for="cargo" class="form-label">Cargo</label>
              <input type="text" class="form-control" name="modal_cargo" id="modal_cargo" value="" readonly disabled>
            </div>
            <div class="col-md-3">
              <label for="vinculo" class="form-label">Vinculo</label>
              <input type="text" class="form-control" name="modal_vinculo" id="modal_vinculo" value="" readonly disabled>
            </div>
            <div class="col-md-4">
              <label for="vinculotipo" class="form-label">Tipo de Vínculo</label>
              <input type="text" class="form-control" name="modal_vinculotipo" id="modal_vinculotipo" value="" readonly disabled>
            </div>
            <div class="col-md-3">
              <label for="cargahoraria" class="form-label">Carga Horária</label>
              <input type="text" class="form-control" name="modal_cargahoraria" id="modal_cargahoraria" value="" readonly disabled>
            </div>
            <div class="col-md-6">
              <label for="flexibilizacao" class="form-label">Flexibilização</label>
              <input type="text" class="form-control" name="modal_flexibilizacao" id="modal_flexibilizacao" value="" readonly disabled>
            </div>
            <div class="col-md-3">
              <label for="admissao" class="form-label">Admissão</label>
              <input type="text" class="form-control" name="modal_admissao" id="modal_admissao" value="" readonly disabled>
            </div>
            <div class="col-md-4">
              <label for="registroClasse" class="form-label">Registro de Classe</label>
              <input type="text" class="form-control" name="modal_registroClasse" id="modal_registroClasse" value="" readonly disabled>
            </div>
            <div class="col-md-4">
              <label for="orgao_emissor" class="form-label">Orgão Emissor</label>
              <input type="text" class="form-control" name="modal_orgao_emissor" id="modal_orgao_emissor" value="" readonly disabled>
            </div>
            <div class="col-md-4">
              <label for="ufOrgaoEmissor" class="form-label">UF/SSP</label>
              <input type="text" class="form-control" name="modal_ufOrgaoEmissor" id="modal_ufOrgaoEmissor" value="" readonly disabled>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <x-icon icon='x' /> Fechar
        </button>
      </div>
    </div>
  </div>
</div>


{{-- Registrar um novo profissional em uma vaga da equipe --}}
<div class="modal fade modal-xl" id="modalregistrarprofissional" tabindex="-1" aria-labelledby="Profissional" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="registrarProfissionalLabel"><x-icon icon='people' /> Profissional</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">







        <form method="POST" action="{{ route('equipegestao.registrarvaga') }}">
          @csrf
          <div class="row g-3">

            <div class="col-md-6">
              <label for="nome" class="form-label">{{ __('Name') }} <strong  class="text-danger">(*)</strong></label>
              <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') ?? '' }}">
              @error('nome')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
            
            <div class="col-md-2">
              <label for="matricula" class="form-label">Matrícula <strong  class="text-danger">(*)</strong></label>
              <input type="text" class="form-control @error('matricula') is-invalid @enderror" name="matricula" value="{{ old('matricula') ?? '' }}">
              @error('matricula')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror   
            </div>
      
            <div class="col-md-2">        
              <label for="cpf" class="form-label">CPF <strong  class="text-danger">(*)</strong></label>
              <input type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" id="cpf" value="{{ old('cpf') ?? '' }}">
              @error('cpf')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror   
            </div>
      
            <div class="col-md-2">        
              <label for="cns" class="form-label">CNS</label>
              <input type="text" class="form-control @error('cns') is-invalid @enderror" name="cns" id="cns" value="{{ old('cns') ?? '' }}">
              @error('cns')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror   
            </div>
      
            <div class="col-md-6">
              <label for="email" class="form-label">E-mail</label>
              <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? '' }}">
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
      
            <div class="col-md-3">
              <label for="tel" class="form-label">TEL</label>
              <input type="text" class="form-control @error('tel') is-invalid @enderror" name="tel" id="tel" value="{{ old('tel') ?? '' }}">
              @error('tel')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
      
            <div class="col-md-3">
              <label for="cel" class="form-label">CEL</label>
              <input type="text" class="form-control @error('cel') is-invalid @enderror" name="cel" id="cel" value="{{ old('cel') ?? '' }}">
              @error('cel')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
      
            <div class="col-md-2">
              <label for="cep" class="form-label">CEP</label>
              <input type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" id="cep" value="{{ old('cep') ?? '' }}">
              @error('cep')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
      
            <div class="col-md-5">
              <label for="logradouro" class="form-label">Logradouro</label>
              <input type="text" class="form-control @error('logradouro') is-invalid @enderror" name="logradouro" id="logradouro" value="{{ old('logradouro') ?? '' }}">
              @error('logradouro')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
      
            <div class="col-md-2">
              <label for="numero" class="form-label">Nº</label>
              <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero') ?? '' }}">
              @error('numero')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
      
            <div class="col-md-3">
              <label for="complemento" class="form-label">Complemento</label>
              <input type="text" class="form-control @error('complemento') is-invalid @enderror" name="complemento" value="{{ old('complemento') ?? '' }}">
              @error('complemento')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
      
            <div class="col-md-5">
              <label for="bairro" class="form-label">Bairro</label>
              <input type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" id="bairro" value="{{ old('bairro') ?? '' }}">
              @error('bairro')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
      
            <div class="col-md-5">
              <label for="cidade" class="form-label">Cidade</label>
              <input type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" id="cidade" value="{{ old('cidade') ?? '' }}">
              @error('cidade')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
      
            <div class="col-md-2">
              <label for="uf" class="form-label">UF</label>
              <input type="text" class="form-control @error('uf') is-invalid @enderror" name="uf" id="uf" value="{{ old('uf') ?? '' }}">
              @error('uf')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
      


            
            {{--  Cargo --}}
            <div class="col-md-5">        
              <label for="cargo" class="form-label">Cargo <strong  class="text-danger">(*)</strong></label>
              <div class="input-group mb-3">
                <input type="text" class="form-control" name="cargo" id="cargo" value="" readonly aria-label="Cargo do Profissional" aria-describedby="basic-addon2">
              <span class="input-group-text text-bg-danger" id="basic-addon2"><x-icon icon='exclamation-diamond-fill' /></span>
              </div>              
            </div>
      
            {{--  Vinculo --}}
            <div class="col-md-3">        
              <label for="vinculo_id" class="form-label">Vínculo <strong  class="text-danger">(*)</strong></label>
              <select class="form-select" id="vinculo_id" name="vinculo_id">
                <option value="" selected>Clique ...</option> 
                @foreach($vinculos as $vinculo)
                <option value="{{ $vinculo->id }}" @selected(old('vinculo_id') == $vinculo->id)>
                  {{$vinculo->nome}}
                </option>
                @endforeach
              </select>
              @if ($errors->has('vinculo_id'))
              <div class="text-danger">
              {{ $errors->first('vinculo_id') }}
              </div>
              @endif
            </div>
      
            {{-- VinculoTipo --}}
            <div class="col-md-4">        
              <label for="vinculo_tipo_id" class="form-label">Tipo de Vínculo <strong  class="text-danger">(*)</strong></label>
              <select class="form-select" id="vinculo_tipo_id" name="vinculo_tipo_id">
                <option value="" selected>Clique ...</option> 
                @foreach($vinculotipos as $vinculotipo)
                <option value="{{ $vinculotipo->id }}" @selected(old('vinculo_tipo_id') == $vinculotipo->id)>
                  {{$vinculotipo->nome}}
                </option>
                @endforeach
              </select>
              @if ($errors->has('vinculo_tipo_id'))
              <div class="text-danger">
              {{ $errors->first('vinculo_tipo_id') }}
              </div>
              @endif
            </div>
      
            {{--  CargaHoraria --}}
            <div class="col-md-3">        
              <label for="carga_horaria_id" class="form-label">Carga Horária <strong  class="text-danger">(*)</strong></label>
              <select class="form-select" id="carga_horaria_id" name="carga_horaria_id">
                <option value="" selected>Clique ...</option> 
                @foreach($cargahorarias as $cargahoraria)
                <option value="{{ $cargahoraria->id }}" @selected(old('carga_horaria_id') == $cargahoraria->id)>
                  {{$cargahoraria->nome}}
                </option>
                @endforeach
              </select>
              @if ($errors->has('carga_horaria_id'))
              <div class="text-danger">
              {{ $errors->first('carga_horaria_id') }}
              </div>
              @endif
            </div>
        
            <div class="col-md-6">
              <p>Flexibilização</p>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="flexibilizacao" id="inlineRadio1" value="Nenhum" checked="true">
                <label class="form-check-label" for="inlineRadio1">Nenhum</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="flexibilizacao" id="inlineRadio2" value="Extensão">
                <label class="form-check-label" for="inlineRadio2">Extensão</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="flexibilizacao" id="inlineRadio3" value="Redução">
                <label class="form-check-label" for="inlineRadio3">Redução</label>
              </div>
            </div>
      
            <div class="col-md-3">
              <label for="admissao" class="form-label">Admissão  <strong  class="text-danger">(*)</strong></label>
              <input type="text" class="form-control @error('admissao') is-invalid @enderror" name="admissao" id="admissao" value="{{ old('admissao') ?? '' }}">
              @error('admissao')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
      
            <div class="col-md-4">
              <label for="registroClasse" class="form-label">Registro de Classe</label>
              <input type="text" class="form-control @error('registroClasse') is-invalid @enderror" name="registroClasse" value="{{ old('registroClasse') ?? '' }}">
              @error('registroClasse')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
      
            {{-- OrgaoEmissor --}}
            <div class="col-md-4">        
              <label for="orgao_emissor_id" class="form-label">Orgão Emissor <strong  class="text-danger">(*)</strong></label>
              <select class="form-select" id="orgao_emissor_id" name="orgao_emissor_id">
                <option value="" selected>Clique ...</option> 
                @foreach($orgaoemissors as $orgaoemissor)
                <option value="{{ $orgaoemissor->id }}" @selected(old('orgao_emissor_id') == $orgaoemissor->id)>
                  {{$orgaoemissor->nome}}
                </option>
                @endforeach
              </select>
              @if ($errors->has('orgao_emissor_id'))
              <div class="text-danger">
              {{ $errors->first('orgao_emissor_id') }}
              </div>
              @endif
            </div>
      
            <div class="col-md-4">
              <label for="ufOrgaoEmissor" class="form-label">UF/SSP</label>
              <input type="text" class="form-control @error('ufOrgaoEmissor') is-invalid @enderror" name="ufOrgaoEmissor" value="{{ old('ufOrgaoEmissor') ?? '' }}"  maxlength="2" style="text-transform:uppercase">
              @error('ufOrgaoEmissor')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror      
            </div>
      
            <div class="col-12">
              <label for="observacao">Observações</label>
              <textarea class="form-control" name="observacao" rows="3">{{ old('observacao') ?? '' }}</textarea>    
            </div>
    


            <div class="col-12">
              <button type="submit" class="btn btn-warning"><x-icon icon='file-earmark' /> Registrar Profissional</button>    
            </div>

            <input type="hidden" id="equipeprofissional_id_registrar" name="equipeprofissional_id_registrar" value="">
            <input type="hidden" id="equipe_id_registrar" name="equipe_id_registrar" value="">
            <input type="hidden" id="cargo_id_registrar" name="cargo_id_registrar" value="">
          </div>  
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <x-icon icon='x' /> Fechar
        </button>
      </div>
    </div>
  </div>
</div>


@endsection



@section('script-footer')
<script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>

$(document).ready(function(){

  $('#modalvincularprofissional').on('show.bs.modal', function(e) {
      var equipeprofissionalid = $(e.relatedTarget).data('equipeprofissional-id');
      var cargonome = $(e.relatedTarget).data('cargo-nome');
      var cargoid = $(e.relatedTarget).data('cargo-id');
      var equipeid = $(e.relatedTarget).data('equipe-id');

      $(e.currentTarget).find('input[name="equipeprofissional_id"]').val(equipeprofissionalid);
      $(e.currentTarget).find('input[name="cargo_nome"]').val(cargonome);
      $(e.currentTarget).find('input[name="cargo_id"]').val(cargoid);
      $(e.currentTarget).find('input[name="equipe_id"]').val(equipeid);
  });

  $('#modallimparvaga').on('show.bs.modal', function(e) {
      var equipeprofissionalid = $(e.relatedTarget).data('equipeprofissional-id');
      var cargonome = $(e.relatedTarget).data('cargo-nome');
      var profissionalnome = $(e.relatedTarget).data('profissional-nome');
      var equipeid = $(e.relatedTarget).data('equipe-id');

      $(e.currentTarget).find('input[name="equipeprofissional_id_limpar"]').val(equipeprofissionalid);
      $(e.currentTarget).find('input[name="cargo_nome_limpar"]').val(cargonome);
      $(e.currentTarget).find('input[name="profissional_nome_limpar"]').val(profissionalnome);
      $(e.currentTarget).find('input[name="equipe_id_limpar"]').val(equipeid);          
  });

  var profissionais = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
          url: "{{route('profissionals.autocomplete')}}?query=%QUERY",
          wildcard: '%QUERY'
      }
  });
  profissionais.initialize();

  $("#profissional_nome").typeahead({
      hint: true,
      highlight: true,
      minLength: 1
      
  },
  {
      name: "profissionais",
      displayKey: "text",
      limit: 10,
      source: profissionais.ttAdapter(),
      templates: {
        empty: [
          '<div class="empty-message">',
            '<p class="text-center font-weight-bold text-warning">Não foi encontrado nenhum profissional com o texto digitado.</p>',
          '</div>'
        ].join('\n'),
        suggestion: function(data) {
            return '<div><div class="text-bg-primary"> ' + data.text + ' - <strong>Matrícula:</strong> ' + data.matricula + '</div>' + '<div class="text-bg-light mx-1">Cargo: <i>' + data.cargo + '</i></div></div>';
          }
      }    
      }).on("typeahead:selected", function(obj, datum, name) {
          $(this).data("seletectedId", datum.value);
          $('#profissional_id').val(datum.value);
          $('#matricula_profissional').val(datum.matricula);
          $('#cargo_descricao').val(datum.cargo);
          $('#cargo_profissional_id').val(datum.cargo_id);
      }).on('typeahead:autocompleted', function (e, datum) {
          $(this).data("seletectedId", datum.value);
          $('#profissional_id').val(datum.value);
          $('#matricula_profissional').val(datum.matricula);
          $('#cargo_descricao').val(datum.cargo);
          $('#cargo_profissional_id').val(datum.cargo_id);
  });

  $('#ProfissionalModal').on('show.bs.modal', function(e) {
          var profissionalid = $(e.relatedTarget).data('profissional-id');

          $.ajax({
            dataType: "json",
            url: "{{url('/')}}" + "/profissionals/export/json/" + profissionalid,
            type: "GET",
            success: function(json) {
                    $("#modal_nome").val(json['nome']);
                    $("#modal_cpf").val(json['cpf']);
                    $("#modal_cns").val(json['cns']);
                    $("#modal_matricula").val(json['matricula']);
                    $("#modal_email").val(json['email']);
                    $("#modal_tel").val(json['tel']);
                    $("#modal_cel").val(json['cel']);
                    $("#modal_cep").val(json['cep']);
                    $("#modal_logradouro").val(json['logradouro']);
                    $("#modal_numero").val(json['numero']);
                    $("#modal_complemento").val(json['complemento']);
                    $("#modal_bairro").val(json['bairro']);
                    $("#modal_cidade").val(json['cidade']);
                    $("#modal_uf").val(json['uf']);
                    $("#modal_cargo").val(json['cargo']['nome']);
                    $("#modal_vinculo").val(json['vinculo']['nome']);
                    $("#modal_vinculotipo").val(json['vinculotipo']['nome']);
                    $("#modal_cargahoraria").val(json['cargahoraria']['nome']);
                    $("#modal_flexibilizacao").val(json['flexibilizacao']);
                    var admissaoDate = moment(json['admissao']).format('DD/MM/YYYY');
                    $("#modal_admissao").val(admissaoDate);
                    $("#modal_registroClasse").val(json['registroClasse']);
                    $("#modal_orgao_emissor").val(json['orgaoemissor']['nome']);
                    $("#modal_ufOrgaoEmissor").val(json['ufOrgaoEmissor']);

            }
        });
      }); 

}); 
</script>

@endsection
