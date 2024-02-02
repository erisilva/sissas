@extends('layouts.app')

@section('title', 'Unidades - '  . __('Edit'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('unidades.index') }}">
          <x-icon icon='hospital' /> Unidades
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

    <form method="POST" action="{{ route('unidades.update', $unidade->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-3">

      <div class="col-md-8">
        <label for="nome" class="form-label">{{ __('Name') }} <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') ?? $unidade->nome }}">
        @error('nome')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>
      
      <div class="col-md-4">        
        <label for="distrito_id" class="form-label">Distrito <strong  class="text-danger">(*)</strong></label>
        <select class="form-select" id="distrito_id" name="distrito_id">
          <option value="{{ $unidade->distrito_id }}" selected="true">
            &rarr; {{ $unidade->distrito->nome }}
          </option> 
          @foreach($distritos as $distrito)
          <option value="{{ $distrito->id }}" @selected(old('distrito_id') == $distrito->id)>
            {{$distrito->nome}}
          </option>
          @endforeach
        </select>
        @if ($errors->has('distrito_id'))
        <div class="text-danger">
        {{ $errors->first('distrito_id') }}
        </div>
        @endif
      </div>

      <div class="col-md-6">
        <label for="email" class="form-label">E-mail</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $unidade->email }}">
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-3">
        <label for="tel" class="form-label">TEL</label>
        <input type="text" class="form-control @error('tel') is-invalid @enderror" name="tel" id="tel" value="{{ old('tel') ?? $unidade->tel }}">
        @error('tel')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-3">
        <label for="cel" class="form-label">CEL</label>
        <input type="text" class="form-control @error('cel') is-invalid @enderror" name="cel" id="cel" value="{{ old('cel') ?? $unidade->cel }}">
        @error('cel')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-2">
        <label for="cep" class="form-label">CEP</label>
        <input type="text" class="form-control @error('cep') is-invalid @enderror" name="cep" id="cep" value="{{ old('cep') ?? $unidade->cep }}">
        @error('cep')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-5">
        <label for="logradouro" class="form-label">Logradouro</label>
        <input type="text" class="form-control @error('logradouro') is-invalid @enderror" name="logradouro" id="logradouro" value="{{ old('logradouro') ?? $unidade->logradouro }}">
        @error('logradouro')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-2">
        <label for="numero" class="form-label">Nº</label>
        <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero') ?? $unidade->numero }}">
        @error('numero')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-3">
        <label for="complemento" class="form-label">Complemento</label>
        <input type="text" class="form-control @error('complemento') is-invalid @enderror" name="complemento" value="{{ old('complemento') ?? $unidade->complemento }}">
        @error('complemento')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-4">
        <label for="bairro" class="form-label">Bairro</label>
        <input type="text" class="form-control @error('bairro') is-invalid @enderror" name="bairro" id="bairro" value="{{ old('bairro') ?? $unidade->bairro }}">
        @error('bairro')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-4">
        <label for="cidade" class="form-label">Cidade</label>
        <input type="text" class="form-control @error('cidade') is-invalid @enderror" name="cidade" id="cidade" value="{{ old('cidade') ?? $unidade->cidade }}">
        @error('cidade')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-2">
        <label for="uf" class="form-label">UF</label>
        <input type="text" class="form-control @error('uf') is-invalid @enderror" name="uf" id="uf" value="{{ old('uf') ?? $unidade->uf }}">
        @error('uf')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-2">
        <label for="porte" class="form-label">Porte <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('porte') is-invalid @enderror" name="porte" value="{{ old('porte') ?? $unidade->porte }}">
        @error('porte')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary">
          <x-icon icon='pencil-square' />{{ __('Edit') }}
        </button> 
      </div>

    </div>  
   </form>
</div>

<div class="container py-3">
  @if($equipes->count() > 0)

  <div class="container py-2">
    <p class="text-center bg-primary text-white">
      <strong>Equipes</strong>
    </p>  
  </div>

  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Número</th>
                <th>Tipo</th>
                <th>CNES</th>
                <th>INE</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipes as $equipe)
            <tr>
                <td class="text-nowrap">
                  {{$equipe->descricao}}
                </td>
                <td class="text-nowrap">
                  {{$equipe->numero}}
                </td>
                <td class="text-nowrap">
                  {{$equipe->equipeTipo->nome}}
                </td>
                <td>
                  {{$equipe->cnes}}
                </td>
                <td>
                  {{$equipe->ine}}
                </td>
                <td>
                  @can('gestao.equipe.show')
                  <x-btn-group label='Opções'>
                    <a href="{{route('equipegestao.show', $equipe->id)}}" target="blank_" class="btn btn-info btn-sm" role="button"><x-icon icon='eye'/></a>
                  </x-btn-group>
                  @endcan
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>

  @else
  <div class="alert alert-info" role="alert">
    Essa Unidade não possui Equipes cadastradas.
  </div>

  @endif
</div>


<div class="container py-4">
  <div class="float-sm-end">
    <a href="{{ route('unidades.create') }}" class="btn btn-primary btn-lg" role="button">
      <x-icon icon='file-earmark' />
      {{ __('New') }}
   </a>
    <a href="{{ route('unidades.index') }}" class="btn btn-secondary btn-lg" role="button">
       <x-icon icon='arrow-left-square' />
       {{ __('Back') }}
    </a>
  </div>      
</div>

@endsection

@section('script-footer')
<script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
<script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>

<script>
  $(document).ready(function(){

      $("#cel").inputmask({"mask": "(99) 99999-9999"});
      $("#tel").inputmask({"mask": "(99) 9999-9999"});
      $("#cep").inputmask({"mask": "99.999-999"});


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
