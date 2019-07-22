@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('equipes.index') }}">Lista de Equipes e Vagas</a></li>
    </ol>
  </nav>
  {{-- avisa se um usuario foi excluido --}}
  @if(Session::has('deleted_equipe'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('deleted_equipe') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  {{-- avisa quando um usuário foi modificado --}}
  @if(Session::has('create_equipe'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('create_equipe') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <div class="btn-group py-1" role="group" aria-label="Opções">
    <a href="{{ route('equipes.create') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-plus-square"></i> Novo Registro</a>
    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalFilter"><i class="fas fa-filter"></i> Filtrar</button>
    <div class="btn-group" role="group">
      <button id="btnGroupDropOptions" type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Opções
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
                <th scope="col">Unidade</th>
                <th scope="col">Distrito</th>
                <th scope="col">Nº</th>
                <th scope="col">CNES</th>
                <th scope="col">INE</th>
                <th scope="col">Mínima</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipes as $equipe)
            <tr>
                <td>{{ $equipe->descricao }}</td>
                <td>{{ $equipe->unidade->descricao }}</td>
                <td>{{ $equipe->unidade->distrito->nome }}</td>
                <td>{{ $equipe->numero }}</td>
                <td>{{ $equipe->cnes }}</td>
                <td>{{ $equipe->ine }}</td>
                <td>{{ ($equipe->minima == 's') ? 'Sim' : 'Não' }}</td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{route('equipes.edit', $equipe->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-edit"></i></a>
                    <a href="{{route('equipes.show', $equipe->id)}}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('equipes.export.pdf.individual', $equipe->id) }}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-print"></i></a>
                  </div>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  <p class="text-center">Página {{ $equipes->currentPage() }} de {{ $equipes->lastPage() }}. Total de registros: {{ $equipes->total() }}.</p>
  <div class="container-fluid">
      {{ $equipes->links() }}
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


          <form method="GET" action="{{ route('equipes.index') }}">

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="descricao">Descrição</label>
                <input type="text" class="form-control" id="descricao" name="descricao" value="{{request()->input('descricao')}}">
              </div>
              <div class="form-group col-md-3">
                <label for="numero">Nº</label>
                <input type="text" class="form-control" id="numero" name="numero" value="{{request()->input('numero')}}">
              </div>
              <div class="form-group col-md-3">
                <label for="cnes">CNES</label>
                <input type="text" class="form-control" id="cnes" name="cnes" value="{{request()->input('cnes')}}">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="unidade">Unidade</label>
                <input type="text" class="form-control" id="unidade" name="unidade" value="{{request()->input('unidade')}}">
              </div>
              <div class="form-group col-md-4">
                <label for="distrito_id">Distritos</label>
                <select class="form-control" name="distrito_id" id="distrito_id">
                  <option value="">Mostrar todos</option>
                  @foreach($distritos as $distrito)
                  <option value="{{$distrito->id}}" {{ ($distrito->id == request()->input('distrito_id')) ? ' selected' : '' }} >{{$distrito->nome}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-md-4">
                <p>Mínima</p>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="minima" id="inlineRadio1" value="t" {{ (request()->input('minima') == 't' ? 'checked' : '' ) }}>
                  <label class="form-check-label" for="inlineRadio1">Todos</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="minima" id="inlineRadio1" value="s" {{ (request()->input('minima') == 's' ? 'checked' : '' ) }}>
                  <label class="form-check-label" for="inlineRadio1">Sim</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="minima" id="inlineRadio2" value="n" {{ (request()->input('minima') == 'n' ? 'checked' : '' ) }}>
                  <label class="form-check-label" for="inlineRadio2">Não</label>
                </div>                
              </div>
            </div>


            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Pesquisar</button>
            <a href="{{ route('equipes.index') }}" class="btn btn-primary btn-sm" role="button">Limpar</a>
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
        window.open("{{ route('equipes.index') }}" + "?perpage=" + perpage,"_self");
    });

    $('#btnExportarCSV').on('click', function(){
        window.open("{{ route('equipes.export.csv') }}","_self");
    });

    $('#btnExportarPDF').on('click', function(){
        window.open("{{ route('equipes.export.pdf') }}","_self");
    });
}); 
</script>
@endsection