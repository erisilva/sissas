@extends('layouts.app')

@section('css-header')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title', 'Férias - '  . __('Edit'))

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
        <a href="{{ route('ferias.index') }}">
          Férias
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

    <form method="POST" action="{{ route('ferias.update', $ferias->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-3">

      <input type="hidden" id="profissional_id" name="profissional_id" value="{{ $ferias->profissional_id }}">

      <div class="col-md-6">
        <label for="profissional_nome" class="form-label">Profissional</label>
        <input type="text" class="form-control" name="profissional_nome" value="{{ $ferias->profissional->nome }}" readonly disabled>
      </div>
      <div class="col-md-4">
        <label for="cargo_descricao" class="form-label">Cargo</label>
        <input type="text" class="form-control" name="cargo_descricao" value="{{ $ferias->profissional->cargo->nome }}" readonly disabled>
      </div>
      <div class="col-md-2">
        <label for="matricula_profissional" class="form-label">Matrícula</label>
        <input type="text" class="form-control" name="matricula_profissional" value="{{ $ferias->profissional->matricula }}" readonly disabled>
      </div>


      
      <div class="col-md-6">        
        <label for="feriastipo_id" class="form-label">Distrito <strong  class="text-danger">(*)</strong></label>
        <select class="form-select" id="feriastipo_id" name="feriastipo_id">
          <option value="{{ $ferias->feriastipo->id }}" selected="true">
            &rarr; {{ $ferias->feriastipo->nome }}
          </option> 
          @foreach($feriastipos as $feriastipo)
          <option value="{{ $feriastipo->id }}" @selected(old('feriastipo') == $feriastipo->id)>
            {{$feriastipo->nome}}
          </option>
          @endforeach
        </select>
        @if ($errors->has('feriastipo_id'))
        <div class="text-danger">
        {{ $errors->first('feriastipo_id') }}
        </div>
        @endif
      </div>

      <div class="col-md-3">
        <label for="inicio" class="form-label">Data Inicial</label>
        <input type="text" class="form-control @error('inicio') is-invalid @enderror" name="inicio" id="inicio" value="{{ old('inicio') ?? $ferias->inicio->format('d/m/Y') }}">
        @error('inicio')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-md-3">
        <label for="fim" class="form-label">Data Final</label>
        <input type="text" class="form-control @error('fim') is-invalid @enderror" name="fim" id="fim" value="{{ old('fim') ?? $ferias->fim->format('d/m/Y') }}">
        @error('fim')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror      
      </div>

      <div class="col-12">
        <label for="justificativa" class="form-label">Justificativa</label>
        <input type="text" class="form-control" name="justificativa" value="{{ old('justificativa') ?? $ferias->justificativa }}">  
      </div>


      <div class="col-12">
        <button type="submit" class="btn btn-primary">
          <x-icon icon='pencil-square' />{{ __('Edit') }}
        </button> 
      </div>

    </div>  
   </form>
</div>

<x-btn-back route="ferias.index" />
@endsection

@section('script-footer')
<script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
<script src="{{ asset('js/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
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
 
  });
</script>

@endsection
