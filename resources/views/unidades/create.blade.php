@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('unidades.index') }}">Lista de Unidades</a></li>
      <li class="breadcrumb-item active" aria-current="page">Novo Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form method="POST" action="{{ route('unidades.store') }}">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-8">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control{{ $errors->has('descricao') ? ' is-invalid' : '' }}" name="descricao" value="{{ old('descricao') ?? '' }}">
        @if ($errors->has('descricao'))
        <div class="invalid-feedback">
        {{ $errors->first('descricao') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="distrito_id">Distrito</label>
        <select class="form-control {{ $errors->has('distrito_id') ? ' is-invalid' : '' }}" name="distrito_id" id="distrito_id">
          <option value="" selected="true">Selecione ...</option>        
          @foreach($distritos as $distrito)
          <option value="{{$distrito->id}}">{{$distrito->nome}}</option>
          @endforeach
        </select>
        @if ($errors->has('distrito_id'))
        <div class="invalid-feedback">
        {{ $errors->first('distrito_id') }}
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
      <div class="form-group col-md-4">  
        <label for="cidade">Cidade</label>  
        <input type="text" class="form-control" name="cidade" id="cidade" value="{{ old('cidade') ?? '' }}">
      </div> 
      <div class="form-group col-md-2">  
        <label for="uf">UF</label>  
        <input type="text" class="form-control" name="uf" id="uf" value="{{ old('uf') ?? '' }}">
      </div>
      <div class="form-group col-md-2">  
        <label for="porte">Porte</label>  
        <input type="text" class="form-control  {{ $errors->has('porte') ? ' is-invalid' : '' }}" name="porte" id="porte" value="{{ old('porte') ?? '' }}">
        @if ($errors->has('porte'))
        <div class="invalid-feedback">
        {{ $errors->first('porte') }}
        </div>
        @endif
      </div>      
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Incluir Unidade</button>
  </form>
  <div class="float-right">
    <a href="{{ route('unidades.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
  </div>
</div>
@endsection

@section('script-footer')
<script src="{{ asset('js/jquery.inputmask.bundle.min.js') }}"></script>
<script>
  $(document).ready(function(){

      $("#cel").inputmask({"mask": "(99) 99999-9999"});
      $("#tel").inputmask({"mask": "(99) 9999-9999"});
      $("#cep").inputmask({"mask": "99.999-999"});

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
