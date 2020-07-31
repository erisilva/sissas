@extends('layouts.app')

@section('css-header')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('profissionals.index') }}">Lista de Profissionais</a></li>
      <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('licencas.index') }}">Licenças</a></li>
    </ol>
  </nav>
  <div class="btn-group py-1" role="group" aria-label="Opções">
    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalFilter"><i class="fas fa-filter"></i> Filtrar</button>
    <div class="btn-group" role="group">
      <button id="btnGroupDropOptions" type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-print"></i> Relatórios
      </button>
      <div class="dropdown-menu" aria-labelledby="btnGroupDropOptions">
        <a class="dropdown-item" href="#" id="btnExportarCSV"><i class="fas fa-file-download"></i> Exportar Planilha</a>
        <a class="dropdown-item" href="#" id="btnExportarPDF"><i class="fas fa-file-download"></i> Exportar PDF</a>
      </div>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Profissional</th>
                <th scope="col">Matrícula</th>
                <th scope="col">Cargo</th>
                <th scope="col">Tipo Licença</th>
                <th scope="col">Inicio</th>
                <th scope="col">Fim</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($licencas as $licenca)
            <tr>
                <td>{{$licenca->profissional->nome}}</td>
                <td>{{$licenca->profissional->matricula}}</td>
                <td>{{$licenca->profissional->cargo->nome}}</td>
                <td>{{$licenca->licencaTipo->descricao}}</td>
                <td>{{ isset($licenca->inicio) ?  $licenca->inicio->format('d/m/Y') : '-' }}</td>
                <td>{{ isset($licenca->fim) ?  $licenca->fim->format('d/m/Y') : '-' }}</td>
                <td></td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  <p class="text-center">Página {{ $licencas->currentPage() }} de {{ $licencas->lastPage() }}. Total de registros: {{ $licencas->total() }}.</p>
  <div class="container-fluid">
      {{ $licencas->links() }}
  </div>
  <!-- Janela de filtragem da consulta -->
  <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="JanelaFiltro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fas fa-filter"></i> Filtro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Filtragem dos dados -->
          <form method="GET" action="{{ route('licencas.index') }}">
            <div class="form-group">
              <label for="profissional">Profissional</label>
                <input type="text" class="form-control" id="profissional" name="profissional" value="{{request()->input('profissional')}}">
            </div>
            <div class="form-row">
              <div class="form-group col-6">
                <label for="dtainicio">Data inicial</label>
                <input type="text" class="form-control" id="dtainicio" name="dtainicio" value="{{request()->input('dtainicio')}}" autocomplete="off">
              </div>
              <div class="form-group col-6">
                <label for="dtafinal">Data final</label>
                <input type="text" class="form-control" id="dtafinal" name="dtafinal" value="{{request()->input('dtafinal')}}" autocomplete="off">
              </div>  
            </div>
            <div class="form-group">
              <label for="licencatipo_id">Tipos de Licença</label>
              <select class="form-control" name="licencatipo_id" id="licencatipo_id">
                <option value="">Mostrar todos</option>
                @foreach($licencatipos as $licencatipo)
                <option value="{{$licencatipo->id}}" {{ ($licencatipo->id == request()->input('licencatipo_id')) ? ' selected' : '' }} >{{$licencatipo->descricao}}</option>
                @endforeach
              </select>
            </div>   
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Pesquisar</button>
            <a href="{{ route('licencas.index') }}" class="btn btn-primary btn-sm" role="button">Limpar</a>
          </form>
          <!-- Seleção de número de resultados por página -->
          <div class="form-group">
            <select class="form-control" name="perpage" id="perpage">
              @foreach($perpages as $perpage)
              <option value="{{$perpage->valor}}"  {{($perpage->valor == session('perPage')) ? 'selected' : ''}}>{{$perpage->nome}}</option>
              @endforeach
            </select>
          </div>
        </div>     
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Fechar</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script-footer')
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
<script>
$(document).ready(function(){
    $('#perpage').on('change', function() {
        perpage = $(this).find(":selected").val(); 
        
        window.open("{{ route('licencas.index') }}" + "?perpage=" + perpage,"_self");
    });

    $('#btnExportarCSV').on('click', function(){
        window.open("{{ route('licencas.export.csv') }}","_self");
    });

    $('#btnExportarPDF').on('click', function(){
        window.open("{{ route('licencas.export.pdf') }}","_self");
    });

  $('#dtainicio').datepicker({
    format: "dd/mm/yyyy",
    todayBtn: "linked",
    clearBtn: true,
    language: "pt-BR",
    autoclose: true,
    todayHighlight: true
  });

  $('#dtafinal').datepicker({
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