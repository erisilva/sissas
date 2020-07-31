@extends('layouts.app')

@section('css-header')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('historicos.index') }}">Histórico dos Profissionais</a></li>
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
                <th scope="col">Data</th>
                <th scope="col">Hora</th>
                <th scope="col">Descrição</th>
                <th scope="col">Profissional</th>
                <th scope="col">Matrícula</th>
                <th scope="col">Operador</th>
                <th scope="col">Observações</th>
                <th scope="col">Equipe</th>
                <th scope="col">Unidade</th>
                <th scope="col">Distrito</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historicos as $historico)
            <tr>
                <td><strong>{{$historico->created_at->format('d/m/Y')}}</strong></td>
                <td><strong>{{$historico->created_at->format('H:i')}}</strong></td>
                <td>{{$historico->historicoTipo->descricao}}</td>
                <td>{{$historico->profissional->nome}}</td>
                <td>{{$historico->profissional->matricula}}</td>
                <td>{{$historico->user->name}}</td>
                <td>{{$historico->observacao}}</td>
                <td>{{$historico->equipe->descricao ?? '-'}}</td>
                <td>{{$historico->unidade->descricao ?? $historico->equipe->unidade->descricao ?? '-'}}</td>
                <td>{{$historico->unidade->distrito->nome ?? $historico->equipe->unidade->distrito->nome ?? '-'}}</td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  <p class="text-center">Página {{ $historicos->currentPage() }} de {{ $historicos->lastPage() }}. Total de registros: {{ $historicos->total() }}.</p>
  <div class="container-fluid">
      {{ $historicos->links() }}
  </div>
  <!-- Janela de filtragem da consulta -->
  <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="JanelaFiltro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fas fa-filter"></i> Filtro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Filtragem dos dados -->
          <form method="GET" action="{{ route('historicos.index') }}">
            <div class="form-row">
              <div class="form-group col-6">
                <label for="profissional">Profissional</label>
                <input type="text" class="form-control" id="profissional" name="profissional" value="{{request()->input('profissional')}}">
                
              </div>
              <div class="form-group col-3">
                <label for="dtainicio">Data inicial</label>
                <input type="text" class="form-control" id="dtainicio" name="dtainicio" value="{{request()->input('dtainicio')}}" autocomplete="off">
              </div>
              <div class="form-group col-3">
                <label for="dtafinal">Data final</label>
                <input type="text" class="form-control" id="dtafinal" name="dtafinal" value="{{request()->input('dtafinal')}}" autocomplete="off">
              </div>  
            </div>
            <div class="container bg-primary text-white">
              <p class="text-center">Tipos de Histórico</p>
            </div>

            <div class="form-row bg-info text-white">
              <div class="form-group col-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="select-all" id="select-all">
                    <label class="form-check-label" for="hist_filtro">Selecionar Todos</label>
                </div>
              </div> 
            </div>
            <div class="form-row">
              @foreach($historicotipos as $historicotipo)
                @php
                  $checked = "";
                  if(request('hist_filtro') != null){
                    foreach (request('hist_filtro') as $key => $id) {
                      if((int)request('hist_filtro.'.$key) == $historicotipo->id){
                        $checked = "checked";
                      }
                    }    
                  }
                @endphp
              <div class="form-group col-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="hist_filtro[]" value="{{$historicotipo->id}}" {{$checked}}>
                    <label class="form-check-label" for="hist_filtro">{{$historicotipo->descricao}}</label>
                </div>
              </div>
              @endforeach
            </div>

            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Pesquisar</button>
            <a href="{{ route('historicos.index') }}" class="btn btn-primary btn-sm" role="button">Limpar</a>
          </form>
          <br>
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
    window.open("{{ route('historicos.index') }}" + "?perpage=" + perpage,"_self");
  });

  $('#btnExportarCSV').on('click', function(){
    var filtro_profissional = $('input[name="profissional"]').val();
    var filtro_operador = $('input[name="operador"]').val();
    var filtro_historico_tipo_id = $('select[name="historico_tipo_id"]').val();
    if (typeof filtro_historico_tipo_id === "undefined") {
    filtro_historico_tipo_id = "";
    }     
    var filtro_dtainicio = $('input[name="dtainicio"]').val();
    var filtro_dtafinal = $('input[name="dtafinal"]').val();
    window.open("{{ route('historicos.export.csv') }}" + "?profissional=" + filtro_profissional + "&operador=" + filtro_operador + "&historico_tipo_id=" + filtro_historico_tipo_id + "&dtainicio=" + filtro_dtainicio + "&dtafinal=" + filtro_dtafinal, "_self");
  });

  $('#btnExportarPDF').on('click', function(){
    var filtro_profissional = $('input[name="profissional"]').val();
    var filtro_operador = $('input[name="operador"]').val();
    var filtro_historico_tipo_id = $('select[name="historico_tipo_id"]').val();
    if (typeof filtro_historico_tipo_id === "undefined") {
    filtro_historico_tipo_id = "";
    }     
    var filtro_dtainicio = $('input[name="dtainicio"]').val();
    var filtro_dtafinal = $('input[name="dtafinal"]').val();
    window.open("{{ route('historicos.export.pdf') }}" + "?profissional=" + filtro_profissional + "&operador=" + filtro_operador + "&historico_tipo_id=" + filtro_historico_tipo_id + "&dtainicio=" + filtro_dtainicio + "&dtafinal=" + filtro_dtafinal, "_self");
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

  $('#select-all').click(function(event) {   
    if(this.checked) {
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;                       
        });
    }
  });
}); 
</script>
@endsection