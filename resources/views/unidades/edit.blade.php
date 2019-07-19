@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('unidades.index') }}">Lista de Unidades</a></li>
      <li class="breadcrumb-item active" aria-current="page">Alterar Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  {{-- avisa se uma permissão foi alterada --}}
  @if(Session::has('edited_unidade'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('edited_unidade') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <form method="POST" action="{{ route('unidades.update', $unidade->id) }}">
    @csrf
    @method('PUT')

    <div class="form-row">
      <div class="form-group col-md-8">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" name="descricao" value="{{ $unidade->descricao }}">
      </div>
      <div class="form-group col-md-4">
        <label for="distrito_id">Distrito</label>
        <select class="form-control" name="distrito_id" id="distrito_id">
          <option value="{{ $unidade->distrito->id }}" selected="true"> &rarr; {{ $unidade->distrito->nome }}</option>  
          @foreach($distritos as $distrito)
          <option value="{{$distrito->id}}">{{$distrito->nome}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="email">E-mail</label>  
        <input type="text" class="form-control" name="email" id="email" value="{{ $unidade->email }}">
      </div>
      <div class="form-group col-md-3">  
        <label for="tel">Tel</label>  
        <input type="text" class="form-control" name="tel" id="tel" value="{{ $unidade->tel }}">
      </div> 
      <div class="form-group col-md-3">  
        <label for="cel">Cel</label>  
        <input type="text" class="form-control" name="cel" id="cel" value="{{ $unidade->cel }}">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="cep">CEP</label>  
        <input type="text" class="form-control" name="cep" id="cep" value="{{ $unidade->cep }}">
      </div>
      <div class="form-group col-md-5">  
        <label for="logradouro">Logradouro</label>  
        <input type="text" class="form-control" name="logradouro" id="logradouro" value="{{ $unidade->logradouro }}">
      </div> 
      <div class="form-group col-md-2">  
        <label for="numero">Nº</label>  
        <input type="text" class="form-control" name="numero" id="numero" value="{{ $unidade->numero }}">
      </div>
      <div class="form-group col-md-3">  
        <label for="complemento">Complemento</label>  
        <input type="text" class="form-control" name="complemento" id="complemento" value="{{ $unidade->complemento }}">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="bairro">Bairro</label>  
        <input type="text" class="form-control" name="bairro" id="bairro" value="{{ $unidade->bairro }}">
      </div>
      <div class="form-group col-md-4">  
        <label for="cidade">Cidade</label>  
        <input type="text" class="form-control" name="cidade" id="cidade" value="{{ $unidade->cidade }}">
      </div> 
      <div class="form-group col-md-2">  
        <label for="uf">UF</label>  
        <input type="text" class="form-control" name="uf" id="uf" value="{{ $unidade->uf }}">
      </div>
      <div class="form-group col-md-2">  
        <label for="porte">Porte</label>  
        <input type="text" class="form-control" name="porte" id="porte" value="{{ $unidade->porte }}">
      </div>      
    </div>

    <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Alterar Dados da Unidade</button>
  </form>
</div>
<div class="container">
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