@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('unidades.index') }}">Lista de Unidades</a></li>
    </ol>
  </nav>
  {{-- avisa se um usuario foi excluido --}}
  @if(Session::has('deleted_unidade'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('deleted_unidade') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  {{-- avisa quando um usuário foi modificado --}}
  @if(Session::has('create_unidade'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('create_unidade') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <div class="btn-group py-1" role="group" aria-label="Opções">
    <a href="{{ route('unidades.create') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-plus-square"></i> Novo Registro</a>
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
                <th scope="col">Descrição</th>
                <th scope="col">Distrito</th>
                <th scope="col">Tel</th>
                <th scope="col">E-mail</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($unidades as $unidade)
            <tr>
                <td>{{$unidade->descricao}}</td>
                <td>{{$unidade->distrito->nome}}</td>
                <td>{{$unidade->tel}}</td>
                <td>{{$unidade->email}}</td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{route('unidades.edit', $unidade->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-edit"></i></a>
                    <a href="{{route('unidades.show', $unidade->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-eye"></i></a>
                  </div>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  <p class="text-center">Página {{ $unidades->currentPage() }} de {{ $unidades->lastPage() }}. Total de registros: {{ $unidades->total() }}.</p>
  <div class="container-fluid">
      {{ $unidades->links() }}
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
          <form method="GET" action="{{ route('unidades.index') }}">
            <div class="form-group">
              <label for="descricao">Descrição</label>
              <input type="text" class="form-control" id="descricao" name="descricao" value="{{request()->input('descricao')}}">
            </div>
            <div class="form-group">
                <label for="distrito_id">Distrito</label>
                <select class="form-control" name="distrito_id" id="distrito_id">
                  <option value="">Mostrar todos</option>    
                  @foreach($distritos as $distrito)
                  <option value="{{$distrito->id}}" {{ ($distrito->id == request()->input('distrito_id')) ? ' selected' : '' }} >{{$distrito->nome}}</option>
                  @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Pesquisar</button>
            <a href="{{ route('unidades.index') }}" class="btn btn-primary btn-sm" role="button">Limpar</a>
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
        window.open("{{ route('unidades.index') }}" + "?perpage=" + perpage,"_self");
    });

    $('#btnExportarCSV').on('click', function(){
        var filtro_descricao = $('input[name="descricao"]').val();

        var filtro_distrito_id = $('select[name="distrito_id"]').val();
        if (typeof filtro_distrito_id === "undefined") {
          filtro_distrito_id = "";
        }

        window.open("{{ route('unidades.export.csv') }}" + "?descricao=" + filtro_descricao + "&distrito_id=" + filtro_distrito_id,"_self");
    });

    $('#btnExportarPDF').on('click', function(){
        var filtro_descricao = $('input[name="descricao"]').val();

        var filtro_distrito_id = $('select[name="distrito_id"]').val();
        if (typeof filtro_distrito_id === "undefined") {
          filtro_distrito_id = "";
        }

        window.open("{{ route('unidades.export.pdf') }}" + "?descricao=" + filtro_descricao + "&distrito_id=" + filtro_distrito_id,"_self");

    });
}); 
</script>
@endsection