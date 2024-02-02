@extends('layouts.app')

@section('css-header')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
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

@section('title', 'Licenças - ' . __('New'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('profissionals.index') }}">
          <x-icon icon='file-person' /> Profissionais
        </a>
      </li>
      <li class="breadcrumb-item">
        <a href="{{ route('licencas.index') }}">
          Licenças
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
      {{ __('New') }}
      </li>
    </ol>
  </nav>
</div>

<div class="container">
  <form method="POST" action="{{ route('licencas.store') }}">
    @csrf
    <div class="row g-3">
      <div class="col-md-6">
        <label for="profissional_nome" class="form-label">Profissional <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('profissional_id') is-invalid @enderror" name="profissional_nome" id="profissional_nome" value="{{ old('profissional_nome') ?? '' }}"  autocomplete="off">
        @error('profissional_id')
          <div class="text-danger"><small>{{ $message }}</small></div>
        @enderror      
      </div>
      <div class="col-md-4">
        <label for="cargo_descricao" class="form-label">Cargo <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control" name="cargo_descricao" id="cargo_descricao" value="{{ old('cargo_descricao') ?? '' }}" readonly tabIndex="-1" placeholder="">
      </div>
      <div class="col-md-2">
        <label for="matricula_profissional" class="form-label">Matrícula <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control" name="matricula_profissional" id="matricula_profissional" value="{{ old('matricula_profissional') ?? '' }}" readonly tabIndex="-1" placeholder="">
      </div>      
      <input type="hidden" id="profissional_id" name="profissional_id" value="{{ old('profissional_id') ?? '' }}">
      <input type="hidden" id="cargo_profissional_id" name="cargo_profissional_id" value="{{ old('cargo_profissional_id') ?? '' }}">      
      <div class="col-md-6">        
        <label for="licenca_tipo_id" class="form-label">Tipo de Licença <strong  class="text-danger">(*)</strong></label>
        <select class="form-select" id="licenca_tipo_id" name="licenca_tipo_id">
          <option value="" selected>Clique ...</option> 
          @foreach($licencatipos as $licencatipo)
          <option value="{{ $licencatipo->id }}" @selected(old('licenca_tipo_id') == $licencatipo->id)>
            {{$licencatipo->nome}}
          </option>
          @endforeach
        </select>
        @error('licenca_tipo_id')
          <div class="text-danger"><small>{{ $message }}</small></div>
        @enderror
      </div>
      <div class="col-md-3">
        <label for="inicio" class="form-label">Data inicial <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control  @error('inicio') is-invalid @enderror" id="inicio" name="inicio" value="{{ session()->get('inicio') }}" autocomplete="off">
        @error('inicio')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror   
      </div>
      <div class="col-md-3">
        <label for="fim" class="form-label">Data final <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control  @error('fim') is-invalid @enderror" id="fim" name="fim" value="{{ session()->get('fim') }}" autocomplete="off">
        @error('fim')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror   
      </div>
      <div class="col-12">
        <label for="observacao" class="form-label">Observações</label>
        <input type="text" class="form-control" name="observacao" value="{{ old('observacao') ?? '' }}">     
      </div>
      <div class="col12">
        <button type="submit" class="btn btn-primary"><x-icon icon='plus-circle' /> {{ __('Save') }}</button>  
      </div>
    </div>     
  </form>
</div>

<x-btn-back route="licencas.index" />
@endsection

@section('script-footer')
<script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script>
  $(document).ready(function(){
    $('#fim').datepicker({
    format: "dd/mm/yyyy",
    todayBtn: "linked",
    clearBtn: true,
    language: "pt-BR",
    autoclose: true,
    todayHighlight: true
    });

    $('#inicio').datepicker({
      format: "dd/mm/yyyy",
      todayBtn: "linked",
      clearBtn: true,
      language: "pt-BR",
      autoclose: true,
      todayHighlight: true
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

  });
</script>

@endsection
