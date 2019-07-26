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
<br>
<div class="container bg-primary text-white">
  <p class="text-center">Profissionais</p>
</div>
<div class="container">
  <form method="POST" action="{{ route('unidadeprofissionais.store') }}">
    @csrf
    <input type="hidden" id="unidade_id" name="unidade_id" value="{{ $unidade->id }}">
    <div class="form-group">
      <label for="profissional_nome">Profissional</label>
      <input type="text" class="form-control typeahead {{ $errors->has('unidade_id') ? ' is-invalid' : '' }}" name="profissional_nome" id="profissional_nome" value="{{ old('profissional_nome') ?? '' }}" autocomplete="off">       
      <input type="hidden" id="profissional_id" name="profissional_id" value="{{ old('profissional_id') ?? '' }}">
      @if ($errors->has('profissional_id'))
        <div class="invalid-feedback">
        {{ $errors->first('profissional_id') }}
        </div>
      @endif
    </div>  
    <div class="form-row">
      <div class="form-group col-md-9">
        <label for="cargo_descricao">Cargo</label>
        <input type="text" class="form-control" name="cargo_descricao" id="cargo_descricao" value="" readonly tabIndex="-1" placeholder="">
      </div>
      <div class="form-group col-md-3">
        <label for="matricula_profissional">Matrícula</label>
        <input type="text" class="form-control" name="matricula_profissional" id="matricula_profissional" value="" readonly tabIndex="-1" placeholder="">
      </div>
    </div>    
    <div class="form-group">
      <label for="descricao">Observações</label>
      <textarea class="form-control" name="descricao" rows="3">{{ old('descricao') ?? '' }}</textarea> 
    </div>
    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Incluir Profissional nesta Unidade</button>
  </form>
</div>
<div class="container">
  @if(Session::has('create_unidadeprofissional'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('create_unidadeprofissional') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('delete_unidadeprofissional'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('delete_unidadeprofissional') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Profissional</th>
                <th scope="col">Cargo</th>
                <th scope="col">Matrícula</th>
                <th scope="col">Observações</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($unidadeprofissionais as $unidadeprofissional)
            <tr>
                <td>{{ $unidadeprofissional->profissional->nome }}</td>
                <td>{{ $unidadeprofissional->profissional->cargo->nome }}</td>
                <td>{{ $unidadeprofissional->profissional->matricula }}</td>
                <td>{{ $unidadeprofissional->descricao }}</td>
                <td>
                  <form method="post" action="{{route('unidadeprofissionais.destroy', $unidadeprofissional->id)}}">
                    @csrf
                    @method('DELETE')  
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                  </form>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div> 
</div>
<br>
<div class="container">
  <div class="float-right">
    <a href="{{ route('unidades.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
  </div>
</div>
@endsection
@section('script-footer')
<script src="{{ asset('js/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
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

      var profissionais = new Bloodhound({
          datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          remote: {
              url: "{{route('profissionals.autocomplete')}}?query=%QUERY",
              wildcard: '%QUERY'
          },
          limit: 10
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

          source: profissionais.ttAdapter(),
          templates: {
            empty: [
              '<div class="empty-message">',
                '<p class="text-center font-weight-bold text-warning">Não foi encontrado nenhum profissional com o texto digitado.</p>',
              '</div>'
            ].join('\n'),
            suggestion: function(data) {
                return '<div><div>' + data.text + ' - <strong>Matrícula:</strong> ' + data.matricula + '</div>' + '<div><i>' + data.cargo + '</i></div></div>';
              }
          }    
          }).on("typeahead:selected", function(obj, datum, name) {
              $(this).data("seletectedId", datum.value);
              $('#profissional_id').val(datum.value);
              $('#matricula_profissional').val(datum.matricula);
              $('#cargo_descricao').val(datum.cargo);
          }).on('typeahead:autocompleted', function (e, datum) {
              $(this).data("seletectedId", datum.value);
              $('#profissional_id').val(datum.value);
              $('#matricula_profissional').val(datum.matricula);
              $('#cargo_descricao').val(datum.cargo);
      });


  });
</script>

@endsection