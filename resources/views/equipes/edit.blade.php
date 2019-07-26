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
      <li class="breadcrumb-item"><a href="{{ route('equipes.index') }}">Lista de Equipes e Vagas</a></li>
      <li class="breadcrumb-item active" aria-current="page">Alterar Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  @if(Session::has('edited_equipe'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('edited_equipe') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('create_equipe'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('create_equipe') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <form method="POST" action="{{ route('equipes.update', $equipe->id) }}">
    @csrf
    @method('PUT')

    <div class="form-row">
      <div class="form-group col-md-8">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control{{ $errors->has('descricao') ? ' is-invalid' : '' }}" name="descricao" value="{{ old('descricao') ?? $equipe->descricao }}">
        @if ($errors->has('descricao'))
        <div class="invalid-feedback">
        {{ $errors->first('descricao') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="numero">Número</label>
        <input type="text" class="form-control{{ $errors->has('numero') ? ' is-invalid' : '' }}" name="numero" value="{{ old('numero') ?? $equipe->numero }}">
        @if ($errors->has('numero'))
        <div class="invalid-feedback">
        {{ $errors->first('numero') }}
        </div>
        @endif
      </div>
    </div>



    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="cnes">CNES</label>
        <input type="text" class="form-control{{ $errors->has('cnes') ? ' is-invalid' : '' }}" name="cnes" value="{{ old('cnes') ?? $equipe->cnes }}">
        @if ($errors->has('cnes'))
        <div class="invalid-feedback">
        {{ $errors->first('cnes') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="ine">INE</label>
        <input type="text" class="form-control{{ $errors->has('ine') ? ' is-invalid' : '' }}" name="ine" value="{{ old('ine') ?? $equipe->ine }}">
        @if ($errors->has('ine'))
        <div class="invalid-feedback">
        {{ $errors->first('ine') }}
        </div>
        @endif  
      </div>
      <div class="form-group col-md-4">
        <p>Mínima</p>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="minima" id="inlineRadio1" value="S" {{ ($equipe->minima == 's' ? 'checked' : '') }} >
          <label class="form-check-label" for="inlineRadio1">Sim</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="minima" id="inlineRadio2" value="N" {{ ($equipe->minima == 'n' ? 'checked' : '') }}>
          <label class="form-check-label" for="inlineRadio2">Não</label>
        </div>         
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-md-8">
        <label for="unidade_descricao">Unidade</label>
        <input type="text" class="form-control typeahead {{ $errors->has('unidade_id') ? ' is-invalid' : '' }}" name="unidade_descricao" id="unidade_descricao" value="{{ old('unidade_descricao') ?? $equipe->unidade->descricao }}" autocomplete="off">       
        <input type="hidden" id="unidade_id" name="unidade_id" value="{{ old('unidade_id') ?? $equipe->unidade_id }}">
        @if ($errors->has('unidade_id'))
          <div class="invalid-feedback">
          {{ $errors->first('unidade_id') }}
          </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="distrito_descricao">Distrito</label>
        <input type="text" class="form-control" name="distrito_descricao" id="distrito_descricao" value="{{ old('distrito_descricao') ?? $equipe->unidade->distrito->nome }}" readonly>
      </div>
    </div>




    <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Alterar Dados da Equipe</button>
  </form>
</div>
<div class="container">
  <div class="float-right">
    <a href="{{ route('equipes.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
  </div>
</div>
@endsection

@section('script-footer')
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script>
$(document).ready(function(){

  var unidades = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
          url: "{{route('unidades.autocomplete')}}?query=%QUERY",
          wildcard: '%QUERY'
      },
      limit: 10
  });
  unidades.initialize();

  $("#unidade_descricao").typeahead({
      hint: true,
      highlight: true,
      minLength: 1
  },
  {
      name: "unidades",
      displayKey: "text",
      source: unidades.ttAdapter(),
      templates: {
        empty: [
          '<div class="empty-message">',
            '<p class="text-center font-weight-bold text-warning">Não foi encontrado nenhuma unidade com o texto digitado.</p>',
          '</div>'
        ].join('\n'),
        suggestion: function(data) {
            return '<div>' + data.text + '<strong> - Distrito: ' + data.distrito + '</strong>' + '</div>';
          }
      }    
      }).on("typeahead:selected", function(obj, datum, name) {
          $(this).data("seletectedId", datum.value);
          $('#unidade_id').val(datum.value);
          $('#distrito_descricao').val(datum.distrito);
      }).on('typeahead:autocompleted', function (e, datum) {
          $(this).data("seletectedId", datum.value);
          $('#unidade_id').val(datum.value);
          $('#distrito_descricao').val(datum.distrito);
  });

});
</script>
@endsection 