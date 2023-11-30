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

@section('title', 'Equipes e Vagas')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('equipes.index') }}">Equipes e Vagas</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
      {{ __('New') }}
      </li>
    </ol>
  </nav>
</div>

<div class="container">
  <form method="POST" action="{{ route('equipes.store') }}">
    @csrf

    <div class="row g-3">
      <div class="col-md-8">
          <label for="descricao" class="form-label">Descrição <strong  class="text-danger">(*)</strong></label>
          <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" value="{{ old('descricao') ?? '' }}">
          @error('descricao')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror      
      </div>
      <div class="col-md-4">
          <label for="numero" class="form-label">Número <strong  class="text-danger">(*)</strong></label>
          <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero') ?? '' }}">
          @error('numero')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror       
      </div>


      <div class="col-md-3">
        <label for="cnes" class="form-label">CNES <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('cnes') is-invalid @enderror" name="cnes" id="cnes" value="{{ old('cnes') ?? '' }}">
        @error('cnes')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror       
      </div>
      <div class="col-md-3">
        <label for="ine" class="form-label">INE <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('ine') is-invalid @enderror" name="ine" id="ine" value="{{ old('ine') ?? '' }}">
        @error('ine')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror       
      </div>
      <div class="col-md-3">
        <p>Mínima <strong  class="text-danger">(*)</strong></p>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="minima" id="minima_s" value="s" checked="true">
          <label class="form-check-label" for="minima_s">Sim</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="minima" id="minima_n" value="n">
          <label class="form-check-label" for="minima_n">Não</label>
        </div>      
     </div>
     <div class="col-md-3">        
      <label for="equipe_tipo_id" class="form-label">Tipo <strong  class="text-danger">(*)</strong></label>
      <select class="form-select" id="equipe_tipo_id" name="equipe_tipo_id">
        <option value="" selected>Clique ...</option> 
        @foreach($equipetipos as $equipetipo)
        <option value="{{ $equipetipo->id }}" @selected(old('equipe_tipo_id') == $equipetipo->id)>
          {{$equipetipo->nome}}
        </option>
        @endforeach
      </select>
      @if ($errors->has('equipe_tipo_id'))
        <div class="text-danger">
          {{ $errors->first('equipe_tipo_id') }}
        </div>
      @endif
    </div>

     <div class="col-md-8">
        <label for="unidade_descricao" class="form-label">Unidade <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('unidade_descricao') is-invalid @enderror" name="unidade_descricao" id="unidade_descricao" value="{{ old('unidade_descricao') ?? '' }}" autocomplete="off">
        @error('unidade_id')
          <div class="text-danger">
            {{ $message }}
          </div>
        @enderror    
      </div>
      <div class="col-md-4">
          <label for="distrito_descricao" class="form-label">Distrito</label>
          <input type="text" class="form-control @error('distrito_descricao') is-invalid @enderror" name="distrito_descricao" id="distrito_descricao" value="{{ old('distrito_descricao') ?? '' }}" readonly>
          @error('distrito_descricao')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror       
      </div>

      <input type="hidden" id="unidade_id" name="unidade_id" value="{{ old('unidade_id') ?? '' }}">







      <div class="col-12">
        <button type="submit" class="btn btn-primary"><x-icon icon='plus-circle' /> {{ __('Save') }}</button>  
      </div>
    </div>     
  </form>
</div>

<x-btn-back route="equipes.index" />
@endsection


@section('script-footer')
<script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script>

var unidades = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
          url: "{{route('unidades.autocomplete')}}?query=%QUERY",
          wildcard: '%QUERY'
      }
      
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
      limit: 10,

      source: unidades.ttAdapter(),
      templates: {
        empty: [
          '<div class="empty-message">',
            '<p class="text-center font-weight-bold text-warning">Não foi encontrado nenhuma unidade com o texto digitado.</p>',
          '</div>'
        ].join('\n'),
        suggestion: function(data) {
            return '<div class="text-bg-primary py-1">' + data.text + '<strong> - Distrito: ' + data.distrito + '</strong>' + '</div>';
          }
      }    
      }).on("typeahead:selected", function(obj, datum, name) {
          console.log(datum);
          $(this).data("seletectedId", datum.value);
          $('#unidade_id').val(datum.value);
          $('#distrito_descricao').val(datum.distrito);
          console.log(datum.value);
          console.log(datum.distrito);
      }).on('typeahead:autocompleted', function (e, datum) {
          console.log(datum);
          $(this).data("seletectedId", datum.value);
          $('#unidade_id').val(datum.value);
          $('#distrito_descricao').val(datum.distrito);
          console.log(datum.value);
          console.log(datum.distrito);
  });
</script>

@endsection
