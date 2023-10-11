@extends('layouts.app')

@section('css-header')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title', 'Profissional - '  . __('Edit'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('profissionals.index') }}">
          Profissional
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Edit') }}
      </li>
    </ol>
  </nav>
</div>

<div class="container">
    <x-flash-message status='success'  message='message' />

    <form method="POST" action="{{ route('profissionals.update', $profissional->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-3">

      {{-- nome --}}
      <div class="col-md-6">
        <label for="nome" class="form-label">{{ __('Name') }} <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') ?? $profissional->nome }}">
        @error('nome')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      {{-- matricula --}}
      <div class="col-md-2">
        <label for="matricula" class="form-label">Matrícula</label>
        <input type="text" class="form-control @error('matricula') is-invalid @enderror" name="matricula" value="{{ old('matricula') ?? $profissional->matricula }}">
        @error('matricula')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- cpf --}}
      <div class="col-md-2">
        <label for="cpf" class="form-label">CPF</label>
        <input type="text" class="form-control @error('cpf') is-invalid @enderror" name="cpf" id="cpf" value="{{ old('cpf') ?? $profissional->cpf }}">
        @error('cpf')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- CNS --}}
      <div class="col-md-2">
        <label for="cns" class="form-label">CNS</label>
        <input type="text" class="form-control @error('cns') is-invalid @enderror" name="cns" value="{{ old('cns') ?? $profissional->cns }}">
        @error('cns')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Contatos --}}

      <div class="col-md-6">
        <label for="email" class="form-label">E-mail</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $profissional->email }}">
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-3">
        <label for="tel" class="form-label">TEL</label>
        <input type="text" class="form-control @error('tel') is-invalid @enderror" name="tel" id="tel" value="{{ old('tel') ?? $profissional->tel }}">
        @error('tel')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-3">
        <label for="cel" class="form-label">CEL</label>
        <input type="text" class="form-control @error('cel') is-invalid @enderror" name="cel" id="cel" value="{{ old('cel') ?? $profissional->cel }}">
        @error('cel')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      {{-- Endereço --}}

      <div class="col-md-2">
        <label for="cep" class="form-label">CEP</label>
        <input type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" id="cep" value="{{ old('cep') ?? $profissional->cep }}">
        @error('cep')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-5">
        <label for="logradouro" class="form-label">Logradouro</label>
        <input type="text" class="form-control @error('logradouro') is-invalid @enderror" name="logradouro" id="logradouro" value="{{ old('logradouro') ?? $profissional->logradouro }}">
        @error('logradouro')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-2">
        <label for="numero" class="form-label">Nº</label>
        <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero') ?? $profissional->numero }}">
        @error('numero')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-3">
        <label for="complemento" class="form-label">Complemento</label>
        <input type="text" class="form-control @error('complemento') is-invalid @enderror" name="complemento" value="{{ old('complemento') ?? $profissional->complemento }}">
        @error('complemento')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-5">
        <label for="bairro" class="form-label">Bairro</label>
        <input type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" id="bairro" value="{{ old('bairro') ?? $profissional->bairro }}">
        @error('bairro')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-5">
        <label for="cidade" class="form-label">Cidade</label>
        <input type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" id="cidade" value="{{ old('cidade') ?? $profissional->cidade }}">
        @error('cidade')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-2">
        <label for="uf" class="form-label">UF</label>
        <input type="text" class="form-control @error('uf') is-invalid @enderror" name="uf" id="uf" value="{{ old('uf') ?? $profissional->uf }}">
        @error('uf')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      {{-- Cargo --}}
      <div class="col-md-5">
        <label for="cargo_id" class="form-label">Cargo <strong  class="text-danger">(*)</strong></label>
        <select class="form-select" id="cargo_id" name="cargo_id">
          <option value="{{ $profissional->cargo_id }}" selected="true">
            &rarr; {{ $profissional->cargo->nome }}
          </option> 
          @foreach($cargos as $cargo)
          <option value="{{ $cargo->id }}" @selected(old('cargo_id') == $cargo->id)>
            {{$cargo->nome}}
          </option>
          @endforeach
        </select>
        @if ($errors->has('cargo_id'))
        <div class="text-danger">
        {{ $errors->first('cargo_id') }}
        </div>
        @endif
      </div>

      {{-- Vinculo --}}
      <div class="col-md-3">
        <label for="vinculo_id" class="form-label">Vínculo <strong  class="text-danger">(*)</strong></label>
        <select class="form-select" id="vinculo_id" name="vinculo_id">
          <option value="{{ $profissional->vinculo_id }}" selected="true">
            &rarr; {{ $profissional->vinculo->nome }}
          </option> 
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
          <option value="{{ $profissional->vinculo_tipo_id }}" selected="true">
            &rarr; {{ $profissional->vinculoTipo->nome }}
          </option> 
          @foreach($vinculotipos as $vinculoTipo)
          <option value="{{ $vinculoTipo->id }}" @selected(old('vinculo_tipo_id') == $vinculoTipo->id)>
            {{$vinculoTipo->nome}}
          </option>
          @endforeach
        </select>
        @if ($errors->has('vinculo_tipo_id'))
        <div class="text-danger">
        {{ $errors->first('vinculo_tipo_id') }}
        </div>
        @endif
      </div>

      {{-- CargaHoraria --}}
      <div class="col-md-3">
        <label for="carga_horaria_id" class="form-label">Carga Horária <strong  class="text-danger">(*)</strong></label>
        <select class="form-select" id="carga_horaria_id" name="carga_horaria_id">
          <option value="{{ $profissional->carga_horaria_id }}" selected="true">
            &rarr; {{ $profissional->cargaHoraria->nome }}
          </option> 
          @foreach($cargahorarias as $cargaHoraria)
          <option value="{{ $cargaHoraria->id }}" @selected(old('carga_horaria_id') == $cargaHoraria->id)>
            {{$cargaHoraria->nome}}
          </option>
          @endforeach
        </select>
        @if ($errors->has('carga_horaria_id'))
        <div class="text-danger">
        {{ $errors->first('carga_horaria_id') }}
        </div>
        @endif
      </div>

      {{-- Flexibilizacao --}}
      <div class="col-md-6">
        <p>Flexibilização</p>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="flexibilizacao" id="inlineRadio1" value="Nenhum" @checked($profissional->flexibilizacao == 'Nenhum')>
          <label class="form-check-label" for="inlineRadio1">Nenhum</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="flexibilizacao" id="inlineRadio2" value="Extensão" @checked($profissional->flexibilizacao == 'Extensão')>
          <label class="form-check-label" for="inlineRadio2">Extensão</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="flexibilizacao" id="inlineRadio3" value="Redução" @checked($profissional->flexibilizacao == 'Redução')>
          <label class="form-check-label" for="inlineRadio3">Redução</label>
        </div>
      </div>

      {{-- Admissao --}}
      <div class="col-md-3">
        <label for="admissao" class="form-label">Admissão <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('admissao') is-invalid @enderror" name="admissao" id="admissao" value="{{ old('admissao') ?? date('d/m/Y', strtotime($profissional->admissao)) }}">
        @error('admissao')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- registroClasse --}}
      <div class="col-md-4">
        <label for="registroClasse" class="form-label">Registro de Classe</label>
        <input type="text" class="form-control @error('registroClasse') is-invalid @enderror" name="registroClasse" value="{{ old('registroClasse') ?? $profissional->registroClasse }}">
        @error('registroClasse')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- OrgaoEmissor --}}
      <div class="col-md-4">
        <label for="orgao_emissor_id" class="form-label">Orgão Emissor <strong  class="text-danger">(*)</strong></label>
        <select class="form-select" id="orgao_emissor_id" name="orgao_emissor_id">
          <option value="{{ $profissional->orgao_emissor_id }}" selected="true">
            &rarr; {{ $profissional->orgaoEmissor->nome }}
          </option> 
          @foreach($orgaoemissors as $orgaoEmissor)
          <option value="{{ $orgaoEmissor->id }}" @selected(old('orgao_emissor_id') == $orgaoEmissor->id)>
            {{$orgaoEmissor->nome}}
          </option>
          @endforeach
        </select>
        @if ($errors->has('orgao_emissor_id'))
        <div class="text-danger">
        {{ $errors->first('orgao_emissor_id') }}
        </div>
        @endif
      </div>

      {{-- ufOrgaoEmissor --}}
      <div class="col-md-4">
        <label for="ufOrgaoEmissor" class="form-label">UF/SSP</label>
        <input type="text" class="form-control @error('ufOrgaoEmissor') is-invalid @enderror" name="ufOrgaoEmissor" value="{{ old('ufOrgaoEmissor') ?? $profissional->ufOrgaoEmissor }}">
        @error('ufOrgaoEmissor')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="col-12">
        <label for="observacao">Observações</label>
        <textarea class="form-control" name="observacao" rows="3">{{ old('observacao') ?? $profissional->observacao }}</textarea>    
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary">
          <x-icon icon='pencil-square' />{{ __('Edit') }}
        </button> 
      </div>

    </div>  
   </form>
</div>

<x-btn-back route="profissionals.index" />
@endsection

@section('script-footer')
<script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
<script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
<script>
  $(document).ready(function(){

      $("#cel").inputmask({"mask": "(99) 99999-9999"});
      $("#tel").inputmask({"mask": "(99) 9999-9999"});
      $("#cep").inputmask({"mask": "99.999-999"});
      $("#cpf").inputmask({"mask": "999.999.999-99"});
      $('#admissao').datepicker({
          format: "dd/mm/yyyy",
          todayBtn: "linked",
          clearBtn: true,
          language: "pt-BR",
          autoclose: true,
          todayHighlight: true
      });


      function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#logradouro").val("...");
                    $("#bairro").val("...");
                    $("#cidade").val("...");
                    $("#uf").val("...");

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#logradouro").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#uf").val(dados.uf);
                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });
  });
</script>

@endsection