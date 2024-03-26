@extends('layouts.app')

@section('css-header')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('title', 'Histórico')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('historico.index') }}">
            Histórico
        </a>
      </li>
    </ol>
  </nav>

  <x-flash-message status='success'  message='message' />

  <x-btn-group label='MenuPrincipal' class="py-1">
     
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon icon='funnel'/> {{ __('Filters') }}</button>

    @can('permission-export')
    <x-dropdown-menu title='Reports' icon='printer'>

      <li>
        <a class="dropdown-item" href="{{ route('historico.export.xls', ['data_inicio' => request()->input('data_inicio'), 'data_fim' => request()->input('data_fim'), 'historico_tipo_id' => request()->input('historico_tipo_id'), 'nome' => request()->input('nome'), 'matricula' => request()->input('matricula'), 'cpf' => request()->input('cpf'), 'user_name' => request()->input('user_name'), 'equipe_descricao' => request()->input('equipe_descricao'), 'ine' => request()->input('ine'), 'unidade' => request()->input('unidade'), 'distrito_id' => request()->input('distrito_id')]) }}"><x-icon icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' XLS' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('historico.export.csv', ['data_inicio' => request()->input('data_inicio'), 'data_fim' => request()->input('data_fim'), 'historico_tipo_id' => request()->input('historico_tipo_id'), 'nome' => request()->input('nome'), 'matricula' => request()->input('matricula'), 'cpf' => request()->input('cpf'), 'user_name' => request()->input('user_name'), 'equipe_descricao' => request()->input('equipe_descricao'), 'ine' => request()->input('ine'), 'unidade' => request()->input('unidade'), 'distrito_id' => request()->input('distrito_id')]) }}"><x-icon icon='file-earmark-spreadsheet-fill'/> {{ __('Export') . ' CSV' }}</a>
      </li>
    
    </x-dropdown-menu>
    @endcan

  </x-btn-group>
  
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Data</th>
                <th scope="col">Hora</th>
                <th scope="col">Descrição</th>
                <th scope="col">Profissional</th>
                <th scope="col">Matrícula</th>
                <th scope="col">CPF</th>
                <th scope="col">Operador</th>
                <th scope="col">Equipe</th>
                <th scope="col">INE</th>
                <th scope="col">Unidade</th>
                <th scope="col">Distrito</th>
                <th scope="col">Observações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historicos as $historico)
            <tr>
                <td>
                    <strong>{{ $historico->created_at->format('d/m/Y') }}</strong>
                </td>
                <td>
                    <strong>{{ $historico->created_at->format('H:i') }}</strong>
                </td>
                <td>
                    {{ $historico->historicoTipo->descricao }}
                </td>
                <td>
                    {{ $historico->profissional->nome }}
                </td>
                <td>
                    {{ $historico->profissional->matricula }}
                </td>
                <td>
                    {{ $historico->profissional->cpf }}
                </td>
                <td>
                    {{ $historico->user->name }}
                </td>
                <td>
                    {{$historico->equipe->descricao ?? '-'}}
                </td>
                <td>
                    {{ $historico->equipe->ine ?? '-' }}
                </td>
                <td>
                    {{ $historico->equipe->unidade->nome ?? '-' }}
                </td>
                <td>
                    {{ $historico->equipe->unidade->distrito->nome ?? '-' }}
                </td>
                <td>
                    {{ $historico->observacao }}
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  
  <x-pagination :query="$historicos" />

</div>

<x-modal-filter class="modal-xl" :perpages="$perpages" icon='funnel' title='Filters'>

  <form method="GET" action="{{ route('historico.index') }}">
    
    <div class="row g-3">

      <div class="col-md-3">
        <label for="data_inicio" class="form-label">Data inicial</label>
        <input type="text" class="form-control" id="data_inicio" name="data_inicio" value="{{ session()->get('historico_data_inicio') }}" autocomplete="off">
      </div>

      <div class="col-md-3">
        <label for="data_fim" class="form-label">Data final</label>
        <input type="text" class="form-control" id="data_fim" name="data_fim" value="{{ session()->get('historico_data_fim') }}" autocomplete="off">
      </div>

      <div class="col-md-6">
        <label for="historico_tipo_id" class="form-label">Tipo de Histórico</label>
        <select class="form-select" id="historico_tipo_id" name="historico_tipo_id">
            <option value="" selected="true">Clique ...</option> 
            @foreach($historicoTipos as $historicoTipo)
            <option value="{{ $historicoTipo->id }}" @selected(session()->get('historico_historico_tipo_id') == $historicoTipo->id) >
              {{ $historicoTipo->descricao }}
            </option>
            @endforeach
        </select>
      </div>

      <div class="col-md-6">
        <label for="nome" class="form-label">Nome do Profissional</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{ session()->get('historico_nome') }}">
      </div>

      <div class="col-md-3">
        <label for="matricula" class="form-label">Matrícula</label>
        <input type="text" class="form-control" id="matricula" name="matricula" value="{{ session()->get('historico_matricula') }}">
      </div>

      <div class="col-md-3">
        <label for="cpf" class="form-label">CPF</label>
        <input type="text" class="form-control" id="cpf" name="cpf" value="{{ session()->get('historico_cpf') }}">
      </div>

      <div class="col-md-5">
        <label for="user_name" class="form-label">Nome do Operador</label>
        <input type="text" class="form-control" id="user_name" name="user_name" value="{{ session()->get('historico_user_name') }}">
      </div>

      <div class="col-md-5">
        <label for="equipe_descricao" class="form-label">Descrição da Equipe</label>
        <input type="text" class="form-control" id="equipe_descricao" name="equipe_descricao" value="{{ session()->get('historico_equipe_descricao') }}">
      </div>

      <div class="col-md-2">
        <label for="ine" class="form-label">INE</label>
        <input type="text" class="form-control" id="ine" name="ine" value="{{ session()->get('historico_ine') }}">
      </div>

      <div class="col-md-6">
        <label for="unidade" class="form-label">Unidade</label>
        <input type="text" class="form-control" id="unidade" name="unidade" value="{{ session()->get('historico_unidade') }}">
      </div>

      <div class="col-md-6">
        <label for="distrito_id" class="form-label">Distrito</label>
        <select class="form-select" id="distrito_id" name="distrito_id">
            <option value="" selected="true">Clique ...</option> 
            @foreach($distritos as $distrito)
            <option value="{{ $distrito->id }}" @selected(session()->get('historico_distrito_id') == $distrito->id) >
              {{ $distrito->nome }}
            </option>
            @endforeach
        </select>
      </div>

      {{-- 'data_inicio' => '', 'data_fim' => '', 'historico_tipo_id' => '', 'nome' => '', 'matricula' => '','cpf' => '', 'user_name' => '', 'equipe_descricao' => '', 'ine' => '', 'unidade' => '', 'distrito_id' => '' --}}
      <div class="col-12">
        <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search'/> {{ __('Search') }}</button>
        <a href="{{ route('historico.index', ['data_inicio' => '', 'data_fim' => '', 'historico_tipo_id' => '', 'nome' => '', 'matricula' => '','cpf' => '', 'user_name' => '', 'equipe_descricao' => '', 'ine' => '', 'unidade' => '', 'distrito_id' => '']) }}" class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars'/> {{ __('Reset') }}</a>
      </div>      

    </div>
  </form>

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