@extends('layouts.app')

@section('css-header')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('profissionals.index') }}">Lista de Profissionais</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form method="POST" action="{{ route('profissionals.store') }}">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="nome">Nome</label>
        <input type="text" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" name="nome" value="{{ old('nome') ?? '' }}">
        @if ($errors->has('nome'))
        <div class="invalid-feedback">
        {{ $errors->first('nome') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-2">
        <label for="matricula">Matrícula</label>
        <input type="text" class="form-control{{ $errors->has('matricula') ? ' is-invalid' : '' }}" name="matricula" value="{{ old('matricula') ?? '' }}">
        @if ($errors->has('matricula'))
        <div class="invalid-feedback">
        {{ $errors->first('matricula') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-2">
        <label for="cpf">CPF</label>
        <input type="text" class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" id="cpf" value="{{ old('cpf') ?? '' }}">
        @if ($errors->has('cpf'))
        <div class="invalid-feedback">
        {{ $errors->first('cpf') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-2">
        <label for="cns">CNS</label>
        <input type="text" class="form-control{{ $errors->has('cns') ? ' is-invalid' : '' }}" name="cns" value="{{ old('cns') ?? '' }}">
        @if ($errors->has('cns'))
        <div class="invalid-feedback">
        {{ $errors->first('cns') }}
        </div>
        @endif
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="email">E-mail</label>  
        <input type="text" class="form-control" name="email" id="email" value="{{ old('email') ?? '' }}">
      </div>
      <div class="form-group col-md-3">  
        <label for="tel">Tel</label>  
        <input type="text" class="form-control" name="tel" id="tel" value="{{ old('tel') ?? '' }}">
      </div> 
      <div class="form-group col-md-3">  
        <label for="cel">Cel</label>  
        <input type="text" class="form-control" name="cel" id="cel" value="{{ old('cel') ?? '' }}">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="cep">CEP</label>  
        <input type="text" class="form-control" name="cep" id="cep" value="{{ old('cep') ?? '' }}">
      </div>
      <div class="form-group col-md-5">  
        <label for="logradouro">Logradouro</label>  
        <input type="text" class="form-control" name="logradouro" id="logradouro" value="{{ old('logradouro') ?? '' }}">
      </div> 
      <div class="form-group col-md-2">  
        <label for="numero">Nº</label>  
        <input type="text" class="form-control" name="numero" id="numero" value="{{ old('numero') ?? '' }}">
      </div>
      <div class="form-group col-md-3">  
        <label for="complemento">Complemento</label>  
        <input type="text" class="form-control" name="complemento" id="complemento" value="{{ old('complemento') ?? '' }}">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="bairro">Bairro</label>  
        <input type="text" class="form-control" name="bairro" id="bairro" value="{{ old('bairro') ?? '' }}">
      </div>
      <div class="form-group col-md-6">  
        <label for="cidade">Cidade</label>  
        <input type="text" class="form-control" name="cidade" id="cidade" value="{{ old('cidade') ?? '' }}">
      </div> 
      <div class="form-group col-md-2">  
        <label for="uf">UF</label>  
        <input type="text" class="form-control" name="uf" id="uf" value="{{ old('uf') ?? '' }}">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-5">
        <label for="cargo_id">Cargo</label>
        <select class="form-control {{ $errors->has('cargo_id') ? ' is-invalid' : '' }}" name="cargo_id" id="cargo_id">
          <option value="" selected="true">Selecione ...</option>        
          @foreach($cargos as $cargo)
          <option value="{{$cargo->id}}">{{$cargo->nome . ' CBO:' . $cargo->cbo}}</option>
          @endforeach
        </select>
        @if ($errors->has('cargo_id'))
        <div class="invalid-feedback">
        {{ $errors->first('cargo_id') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-3">
        <label for="vinculo_id">Vínculo</label>
        <select class="form-control {{ $errors->has('vinculo_id') ? ' is-invalid' : '' }}" name="vinculo_id" id="vinculo_id">
          <option value="" selected="true">Selecione ...</option>        
          @foreach($vinculos as $vinculo)
          <option value="{{$vinculo->id}}">{{$vinculo->descricao}}</option>
          @endforeach
        </select>
        @if ($errors->has('vinculo_id'))
        <div class="invalid-feedback">
        {{ $errors->first('vinculo_id') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="vinculo_tipo_id">Tipo de Vínculo</label>
        <select class="form-control {{ $errors->has('vinculo_tipo_id') ? ' is-invalid' : '' }}" name="vinculo_tipo_id" id="vinculo_tipo_id">
          <option value="" selected="true">Selecione ...</option>        
          @foreach($vinculotipos as $vinculotipo)
          <option value="{{$vinculotipo->id}}">{{$vinculotipo->descricao}}</option>
          @endforeach
        </select>
        @if ($errors->has('vinculo_tipo_id'))
        <div class="invalid-feedback">
        {{ $errors->first('vinculo_tipo_id') }}
        </div>
        @endif
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="carga_horaria_id">Carga Horária</label>
        <select class="form-control {{ $errors->has('carga_horaria_id') ? ' is-invalid' : '' }}" name="carga_horaria_id" id="carga_horaria_id">
          <option value="" selected="true">Selecione ...</option>        
          @foreach($cargahorarias as $cargahoraria)
          <option value="{{$cargahoraria->id}}">{{$cargahoraria->descricao}}</option>
          @endforeach
        </select>
        @if ($errors->has('carga_horaria_id'))
        <div class="invalid-feedback">
        {{ $errors->first('carga_horaria_id') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-6">
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
      <div class="form-group col-md-3">  
        <label for="admissao">Admissão</label>  
        <input type="text" class="form-control{{ $errors->has('admissao') ? ' is-invalid' : '' }}" name="admissao" id="admissao" value="{{ old('admissao') ?? '' }}" autocomplete="off">
        @if ($errors->has('admissao'))
        <div class="invalid-feedback">
        {{ $errors->first('admissao') }}
        </div>
        @endif
      </div>    
    </div>
    <div class="form-group">
      <label for="observacao">Observações</label>
      <textarea class="form-control" name="observacao" rows="3">{{ old('observacao') ?? '' }}</textarea>      
    </div>

    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Incluir Profissional</button>
  </form>
  <div class="float-right">
    <a href="{{ route('profissionals.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
  </div>
</div>
@endsection

@section('script-footer')
<script src="{{ asset('js/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
<script>
  $(document).ready(function(){

        $('#admissao').datepicker({
          format: "dd/mm/yyyy",
          todayBtn: "linked",
          clearBtn: true,
          language: "pt-BR",
          autoclose: true,
          todayHighlight: true
      });

      $("#cel").inputmask({"mask": "(99) 99999-9999"});
      $("#tel").inputmask({"mask": "(99) 9999-9999"});
      $("#cep").inputmask({"mask": "99.999-999"});
      $("#cpf").inputmask({"mask": "999.999.999-99"});

      function limpa_formulario_cep() {
          $("#logradouro").val("");
          $("#bairro").val("");
          $("#cidade").val("");
          $("#uf").val("");
      }

      $("#cep").blur(function () {
          var cep = $(this).val().replace(/\D/g, '');
          if (cep != "") {
              var validacep = /^[0-9]{8}$/;
              if(validacep.test(cep)) {
                  $("#logradouro").val("...");
                  $("#bairro").val("...");
                  $("#cidade").val("...");
                  $("#uf").val("...");
                  $.ajax({
                      dataType: "json",
                      url: "https://erisilva.net/cep/?value=" + cep + "&field=cep&method=json",
                      type: "GET",
                      success: function(json) {
                          if (json['erro']) {
                              limpa_formulario_cep();
                              console.log('cep inválido');
                          } else {
                              $("#bairro").val(json[0]['bairro']);
                              $("#cidade").val(json[0]['cidade']);
                              $("#uf").val(json[0]['uf'].toUpperCase());
                              var tipo = json[0]['tipo'];
                              var logradouro = json[0]['logradouro'];
                              $("#logradouro").val(tipo + ' ' + logradouro);
                          }
                      }
                  });
              } else {
                  limpa_formulario_cep();
              }
          } else {
              limpa_formulario_cep();
          }
      });
  });
</script>

@endsection
