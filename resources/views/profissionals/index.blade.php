@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('profissionals.index') }}">Lista de Profissionais</a></li>
    </ol>
  </nav>
  @if(Session::has('deleted_profissional'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('deleted_profissional') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('create_profissional'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('create_profissional') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('restore_profissional'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('restore_profissional') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <div class="btn-group py-1" role="group" aria-label="Opções">
    <a href="{{ route('profissionals.create') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-plus-square"></i> Novo Registro</a>
    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalFilter"><i class="fas fa-filter"></i> Filtrar</button>
    <div class="btn-group" role="group">
      <button id="btnGroupDropOptions" type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-print"></i> Relatórios
      </button>
      <div class="dropdown-menu" aria-labelledby="btnGroupDropOptions">
        <a class="dropdown-item" href="#" id="btnExportarCSV"><i class="fas fa-file-download"></i> Exportar Planilha</a>
        <a class="dropdown-item" href="#" id="btnExportarPDF"><i class="fas fa-file-download"></i> Exportar PDF</a>
        <a class="dropdown-item" href="#" id="btnExportarPDFsimples"><i class="fas fa-file-download"></i> Exportar PDF (Simplificado)</a>
      </div>
    </div>
    <a href="{{ route('profissionals.trash') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-trash-alt"></i> Lixeira</a>
  </div>
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Matrícula</th>
                <th scope="col">Nome</th>
                <th scope="col">Cargo</th>
                <th scope="col">Vínculo</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($profissionals as $profissional)
            <tr>
                <td>{{$profissional->matricula}}</td>
                <td>{{$profissional->nome}}</td>
                <td>{{$profissional->cargo->nome}}</td>
                <td>{{$profissional->vinculo->descricao}}</td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{route('profissionals.edit', $profissional->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-edit"></i></a>
                    <a href="{{route('profissionals.show', $profissional->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('profissionals.export.pdf.individual', $profissional->id) }}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-print"></i></a>
                  </div>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  <p class="text-center">Página {{ $profissionals->currentPage() }} de {{ $profissionals->lastPage() }}. Total de registros: {{ $profissionals->total() }}.</p>
  <div class="container-fluid">
      {{ $profissionals->links() }}
  </div>
  <!-- Janela de filtragem da consulta -->
  <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="JanelaFiltro" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fas fa-filter"></i> Filtro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Filtragem dos dados -->
          <form method="GET" action="{{ route('profissionals.index') }}">
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="matricula">Nº Matrícula</label>
                <input type="text" class="form-control" id="matricula" name="matricula" value="{{request()->input('matricula')}}">
              </div>
              <div class="form-group col-md-8">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{request()->input('nome')}}">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-8">
                <label for="cargo_id">Cargo</label>
                <select class="form-control" name="cargo_id" id="cargo_id">
                  <option value="">Mostrar todos</option>    
                  @foreach($cargos as $cargo)
                  <option value="{{$cargo->id}}" {{ ($cargo->id == request()->input('cargo_id')) ? ' selected' : '' }} >{{$cargo->nome . " CBO:" . $cargo->cbo}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="vinculo_id">Vínculo</label>
                <select class="form-control" name="vinculo_id" id="vinculo_id">
                  <option value="">Mostrar todos</option>
                  @foreach($vinculos as $vinculo)
                  <option value="{{$vinculo->id}}" {{ ($vinculo->id == request()->input('vinculo_id')) ? ' selected' : '' }} >{{$vinculo->descricao}}</option>
                  @endforeach
                </select>
              </div> 
            </div> 
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Pesquisar</button>
            <a href="{{ route('profissionals.index') }}" class="btn btn-primary btn-sm" role="button">Limpar</a>
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
<script>
$(document).ready(function(){
    $('#perpage').on('change', function() {
        perpage = $(this).find(":selected").val(); 
        
        window.open("{{ route('profissionals.index') }}" + "?perpage=" + perpage,"_self");
    });

    $('#btnExportarCSV').on('click', function(){
      var filtro_matricula = $('input[name="matricula"]').val();
      var filtro_nome = $('input[name="nome"]').val();

      var filtro_cargo_id = $('select[name="cargo_id"]').val();
      if (typeof filtro_cargo_id === "undefined") {
          filtro_cargo_id = "";
      }

      var filtro_vinculo_id = $('select[name="vinculo_id"]').val();
      if (typeof filtro_vinculo_id === "undefined") {
          filtro_vinculo_id = "";
      }  

      window.open("{{ route('profissionals.export.csv') }}" + "?matricula=" + filtro_matricula + "&nome=" + filtro_nome + "&cargo_id=" + filtro_cargo_id + "&vinculo_id=" + filtro_vinculo_id,"_self");
    });

    $('#btnExportarPDF').on('click', function(){
      var filtro_matricula = $('input[name="matricula"]').val();
      var filtro_nome = $('input[name="nome"]').val();

      var filtro_cargo_id = $('select[name="cargo_id"]').val();
      if (typeof filtro_cargo_id === "undefined") {
          filtro_cargo_id = "";
      }

      var filtro_vinculo_id = $('select[name="vinculo_id"]').val();
      if (typeof filtro_vinculo_id === "undefined") {
          filtro_vinculo_id = "";
      }  

      window.open("{{ route('profissionals.export.pdf') }}" + "?matricula=" + filtro_matricula + "&nome=" + filtro_nome + "&cargo_id=" + filtro_cargo_id + "&vinculo_id=" + filtro_vinculo_id,"_self");
    });

    $('#btnExportarPDFsimples').on('click', function(){
      var filtro_matricula = $('input[name="matricula"]').val();
      var filtro_nome = $('input[name="nome"]').val();

      var filtro_cargo_id = $('select[name="cargo_id"]').val();
      if (typeof filtro_cargo_id === "undefined") {
          filtro_cargo_id = "";
      }

      var filtro_vinculo_id = $('select[name="vinculo_id"]').val();
      if (typeof filtro_vinculo_id === "undefined") {
          filtro_vinculo_id = "";
      }  

      window.open("{{ route('profissionals.export.pdf.simples') }}" + "?matricula=" + filtro_matricula + "&nome=" + filtro_nome + "&cargo_id=" + filtro_cargo_id + "&vinculo_id=" + filtro_vinculo_id,"_self");
    });
}); 
</script>
@endsection