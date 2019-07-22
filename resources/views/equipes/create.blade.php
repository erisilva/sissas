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
      <li class="breadcrumb-item active" aria-current="page">Novo Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form method="POST" action="{{ route('equipes.store') }}">
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
        <label for="numero">Número</label>
        <input type="text" class="form-control{{ $errors->has('numero') ? ' is-invalid' : '' }}" name="numero" value="{{ old('numero') ?? '' }}">
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
        <input type="text" class="form-control{{ $errors->has('cnes') ? ' is-invalid' : '' }}" name="cnes" value="{{ old('cnes') ?? '' }}">
        @if ($errors->has('cnes'))
        <div class="invalid-feedback">
        {{ $errors->first('cnes') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="ine">INE</label>
        <input type="text" class="form-control{{ $errors->has('ine') ? ' is-invalid' : '' }}" name="ine" value="{{ old('ine') ?? '' }}">
        @if ($errors->has('ine'))
        <div class="invalid-feedback">
        {{ $errors->first('ine') }}
        </div>
        @endif  
      </div>
      <div class="form-group col-md-4">
        <p>Mínima</p>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="minima" id="inlineRadio1" value="s" checked="true">
          <label class="form-check-label" for="inlineRadio1">Sim</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="minima" id="inlineRadio2" value="n">
          <label class="form-check-label" for="inlineRadio2">Não</label>
        </div>         
      </div>
    </div>


    <div class="form-group">
      <label for="unidade_descricao">Unidade</label>
      <input type="text" class="form-control typeahead {{ $errors->has('unidade_id') ? ' is-invalid' : '' }}" name="unidade_descricao" id="unidade_descricao" value="{{ old('unidade_descricao') ?? '' }}" autocomplete="off">       
      <input type="hidden" id="unidade_id" name="unidade_id" value="{{ old('unidade_id') ?? '' }}">
      @if ($errors->has('unidade_id'))
        <div class="invalid-feedback">
        {{ $errors->first('unidade_id') }}
        </div>
      @endif
    </div>

    <button type="submit" class="btn btn-primary"><i class="fas fa-plus-square"></i> Incluir Equipe</button>
  </form>
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
            'Não encontrado',
          '</div>'
        ].join('\n'),
        suggestion: function(data) {
            return '<div>' + data.text + '</div>';
          }
      }    
      }).on("typeahead:selected", function(obj, datum, name) {
          console.log(datum);
          $(this).data("seletectedId", datum.value);
          $('#unidade_id').val(datum.value);
          console.log(datum.value);
      }).on('typeahead:autocompleted', function (e, datum) {
          console.log(datum);
          $(this).data("seletectedId", datum.value);
          $('#unidade_id').val(datum.value);
          console.log(datum.value);
  });

});
</script>
@endsection  
