@extends('layouts.app')

@section('css-header')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title', 'Férias' )

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('profissionals.index') }}">Profissionais</a></li>
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('ferias.index') }}">Férias</a>
      </li>
    </ol>
  </nav>

  <x-flash-message status='success'  message='message' />

  <x-btn-group label='MenuPrincipal' class="py-1">

    <a class="btn btn-primary" href="{{ route('ferias.create') }}" role="button"><x-icon icon='file-earmark'/> {{ __('New') }}</a>  
     
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon icon='funnel'/> {{ __('Filters') }}</button>

    <x-dropdown-menu title='Reports' icon='printer'>

      {{-- Não precisa passar pra rota as variáveis do request, pois a filtragem será feita pelas variáveis da session --}}
      <li>
        <a class="dropdown-item" href="{{route('ferias.export.xls')}}"><x-icon icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' XLS' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('ferias.export.csv')}}"><x-icon icon='file-earmark-spreadsheet-fill'/> {{ __('Export') . ' CSV' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('ferias.export.pdf')}}"><x-icon icon='file-pdf-fill' /> {{ __('Export') . ' PDF' }}</a>
      </li>
    
    </x-dropdown-menu>  

  </x-btn-group>
  
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
              <th scope="col">Profissional</th>
              <th scope="col">Matrícula</th>
              <th scope="col">Cargo</th>
              <th scope="col">Tipo</th>
              <th scope="col">Inicio</th>
              <th scope="col">Fim</th>
              <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($ferias as $ferias_index)
            <tr>
              <td>
                {{$ferias_index->profissional->nome}}
              </td>
              <td>
                {{$ferias_index->profissional->matricula}}
              </td>
              <td>
                {{$ferias_index->profissional->cargo->nome}}
              </td>
              <td>
                {{$ferias_index->feriasTipo->nome}}
              </td>
              <td>
                {{ isset($ferias_index->inicio) ?  $ferias_index->inicio->format('d/m/Y') : '-' }}
              </td>
              <td>
                {{ isset($ferias_index->fim) ?  $ferias_index->fim->format('d/m/y') : '-' }}
              </td> 
              <td>
                <x-btn-group label='Opções'>

                  <a href="{{route('ferias.edit', $ferias_index->id)}}" class="btn btn-primary btn-sm" role="button"><x-icon icon='pencil-square'/></a>

                  <a href="{{route('ferias.show', $ferias_index)}}" class="btn btn-info btn-sm" role="button"><x-icon icon='eye'/></a>

                </x-btn-group>
              </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  
  <x-pagination :query="$ferias" />

</div>

<x-modal-filter :perpages="$perpages" icon='funnel' title='Filtros'>
  <div class="container">
    <form method="GET" action="{{ route('ferias.index') }}">
      <div class="row g-3">
        
        <div class="col-12">
          <label for="profissional" class="form-label">Profissional</label>
          <input type="text" class="form-control" id="profissional" name="profissional" value="{{ session()->get('ferias_profissional') }}">
        </div>


        <div class="col-md-6">
          <label for="data_inicio" class="form-label">Data inicial</label>
          <input type="text" class="form-control" id="data_inicio" name="data_inicio" value="{{ session()->get('ferias_data_inicio') }}" autocomplete="off">
        </div>

        <div class="col-md-6">
          <label for="data_fim" class="form-label">Data final</label>
          <input type="text" class="form-control" id="data_fim" name="data_fim" value="{{ session()->get('ferias_data_fim') }}" autocomplete="off">
        </div>

        <div class="col-12">
          <div class="alert alert-success" role="alert">
            Para filtrar por data é obrigatório prrencher a data inicial e a data final.
          </div>
        </div>  

        <div class="col-md-12">
          <label for="ferias_tipo_id" class="form-label">Tipo</label>
          <select class="form-select" id="ferias_tipo_id" name="ferias_tipo_id">
            <option value="">Selecione...</option>
            @foreach($feriastipos as $feriastipo)
            <option value="{{ $feriastipo->id }}" @selected(session()->get('ferias_ferias_tipo_id') == $feriastipo->id) >{{ $feriastipo->nome }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search'/> {{ __('Search') }}</button>
      
          {{-- Reset the Filter --}}
          <a href="{{ route('ferias.index', ['profissional' => '', 'data_inicio' => '', 'data_fim' => '', 'ferias_tipo_id' => '']) }}" class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars'/> {{ __('Reset') }}</a>
        </div>
      
      </div>  
    </form>
  </div>  

</x-modal-filter>  

@endsection

@section('script-footer')
<script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
<script>
$(document).ready(function(){
    $('#perpage').on('change', function() {
        perpage = $(this).find(":selected").val(); 
        
        window.open("{{ route('ferias.index') }}" + "?perpage=" + perpage,"_self");
    });

    $('#btnExportarCSV').on('click', function(){
        window.open("{{ route('ferias.export.csv') }}","_self");
    });

    $('#btnExportarPDF').on('click', function(){
        window.open("{{ route('ferias.export.pdf') }}","_self");
    });

  $('#data_fim').datepicker({
    format: "dd/mm/yyyy",
    todayBtn: "linked",
    clearBtn: true,
    language: "pt-BR",
    autoclose: true,
    todayHighlight: true
  });

  $('#data_inicio').datepicker({
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