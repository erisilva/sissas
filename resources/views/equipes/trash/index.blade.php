@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('equipes.index') }}">Lista de Equipes e Vagas</a></li>
      <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('equipes.trash') }}">Lixeira</a></li>
    </ol>
  </nav>
  <div class="btn-group py-1" role="group" aria-label="Opções">
    <a href="{{ route('equipes.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</a>
    <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modalFilter"><i class="fas fa-filter"></i> Filtrar</button>
    <a href="{{ route('equipes.trash') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-trash-alt"></i> Lixeira</a>
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
                <th scope="col">Excluído em</th>
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
                <td>{{ $equipe->deleted_at->format('d/m/Y') }}</td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{route('equipes.trash.show', array($equipe->id))}}" class="btn btn-primary btn-sm" role="button"><i class="fas fa-eye"></i></a>
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
          <form method="GET" action="{{ route('equipes.trash') }}">
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
                  <input class="form-check-input" type="radio" name="minima" id="inlineRadio1" value="" {{ (request()->input('minima') == '' ? 'checked' : '' ) }}>
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
            <a href="{{ route('equipes.trash') }}" class="btn btn-primary btn-sm" role="button">Limpar</a>
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
        window.open("{{ route('equipes.trash') }}" + "?perpage=" + perpage,"_self");
    });
}); 
</script>
@endsection