@extends('layouts.app')
@section('css-header')
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
@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('equipegestao.index') }}">Gestão de Equipes</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir Vagas</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="dia">Data</label>
        <input type="text" class="form-control" name="dia" value="{{ $equipe->created_at->format('d/m/Y') }}" readonly>
      </div>
      <div class="form-group col-md-2">
        <label for="hora">Hora</label>
        <input type="text" class="form-control" name="hora" value="{{ $equipe->created_at->format('H:i') }}" readonly>
      </div>
      <div class="form-group col-md-5">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" name="descricao" value="{{ $equipe->descricao }}" readonly>
      </div>
      <div class="form-group col-md-3">
        <label for="numero">Nº</label>
        <input type="text" class="form-control" name="numero" value="{{ $equipe->numero }}" readonly>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="cnes">CNES</label>
        <input type="text" class="form-control" name="cnes" value="{{ $equipe->cnes }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="ine">INE</label>
        <input type="text" class="form-control" name="ine" value="{{ $equipe->ine }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="minima">Mínima</label>
        <input type="text" class="form-control" name="minima" value="{{ ($equipe->minima == 's') ? 'Sim' : 'Não' }}" readonly>
      </div>     
    </div>
    <div class="form-row">
      <div class="form-group col-md-8">
        <label for="unidade">Unidade</label>
          <input type="text" class="form-control" name="unidade" value="{{ $equipe->unidade->descricao }}" readonly>     
      </div>
      <div class="form-group col-md-4">
        <label for="distrito">Distrito</label>
          <input type="text" class="form-control" name="distrito" value="{{ $equipe->unidade->distrito->nome }}" readonly>     
      </div>
    </div>
  </form>
  <br>
  <div class="container bg-primary text-white">
    <p class="text-center">Vinculação de Profissionais a Equipe</p>
  </div>
  @if ($errors->has('profissional_id'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ $errors->first('profissional_id') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if ($errors->has('equipe_id'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ $errors->first('equipe_id') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if ($errors->has('cargo_id'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ $errors->first('cargo_id') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if ($errors->has('equipeprofissional_id'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ $errors->first('equipeprofissional_id') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('equipe_vincula'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('equipe_vincula') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('equipe_limpar'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('equipe_limpar') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <div class="container">
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Cargo</th>
                <th scope="col">CBO</th>
                <th scope="col">Profissional</th>
                <th scope="col">Matrícula</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipeprofissionais as $equipeprofissional)
            <tr>
                <td>{{ $equipeprofissional->cargo->nome }}</td>
                <td>{{ $equipeprofissional->cargo->cbo }}</td>
                <td>{{ isset($equipeprofissional->profissional_id) ?  $equipeprofissional->profissional->nome : 'Não vinculado' }}</td>
                <td>{{ isset($equipeprofissional->profissional_id) ?  $equipeprofissional->profissional->matricula : '-' }}</td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalvincularprofissional" data-equipeprofissional-id="{{ $equipeprofissional->id}}" data-cargo-id="{{ $equipeprofissional->cargo->id}}" data-cargo-nome="{{ $equipeprofissional->cargo->nome}}" data-equipe-id="{{ $equipe->id}}"><i class="fas fa-plus"></i></button>
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modallimparvaga" data-cargo-nome="{{ $equipeprofissional->cargo->nome}}" data-profissional-nome="{{ isset($equipeprofissional->profissional_id) ?  $equipeprofissional->profissional->nome : 'Sem Vínculo' }}" data-equipeprofissional-id="{{ $equipeprofissional->id}}" data-equipe-id="{{ $equipe->id}}"><i class="fas fa-minus"></i></button>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal fade" id="modalvincularprofissional" tabindex="-1" role="dialog" aria-labelledby="JanelaProfissional" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fas fa-plus"></i> Vincular Profissional a Vaga</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('equipegestao.preenchervaga') }}">
            @csrf
            <div class="form-group">
              <label for="cargo_nome">Vaga</label>
              <input type="text" class="form-control" name="cargo_nome" id="cargo_nome" readonly>
            </div>
            <input type="hidden" id="equipe_id" name="equipe_id" value="">
            <input type="hidden" id="cargo_id" name="cargo_id" value="">            
            <input type="hidden" id="equipeprofissional_id" name="equipeprofissional_id" value="">
            <div class="form-group">
              <label for="profissional_nome">Profissional</label>
              <input type="text" class="form-control typeahead" name="profissional_nome" id="profissional_nome" value="{{ old('profissional_nome') ?? '' }}" autocomplete="off">       
              <input type="hidden" id="profissional_id" name="profissional_id" value="{{ old('profissional_id') ?? '' }}">
              <input type="hidden" id="cargo_profissional_id" name="cargo_profissional_id" value="{{ old('cargo_profissional_id') ?? '' }}">
            </div>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Vincular Profissional</button>
          </form>
        </div>     
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Fechar</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="modallimparvaga" tabindex="-1" role="dialog" aria-labelledby="JanelaProfissional" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"><i class="fas fa-minus"></i> Desvincular Profissional da Vaga</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('equipegestao.limparvaga') }}">
            @csrf
            <div class="form-group">
              <label for="cargo_nome_limpar">Cargo da Vaga</label>
              <input type="text" class="form-control" name="cargo_nome_limpar" id="cargo_nome_limpar" readonly>
            </div>
            <div class="form-group">
              <label for="profissional_nome_limpar">Profissional Vinculado</label>
              <input type="text" class="form-control" name="profissional_nome_limpar" id="profissional_nome_limpar" readonly>
            </div>
            <div class="form-group">
              <label for="motivo_limpar">Motivo</label>
              <input type="text" class="form-control" name="motivo_limpar" id="motivo_limpar">
            </div>
            <input type="hidden" id="equipeprofissional_id_limpar" name="equipeprofissional_id_limpar" value="">
            <input type="hidden" id="equipe_id_limpar" name="equipe_id_limpar" value="">            
            <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-minus"></i> Desvincular Profissional dessa Vaga</button>          
          </form>
        </div>     
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-window-close"></i> Fechar</button>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <a href="{{ route('equipegestao.index') }}" class="btn btn-primary" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
  </div>
</div>
@endsection

@section('script-footer')
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script>
$(document).ready(function(){

      $('#modalvincularprofissional').on('show.bs.modal', function(e) {
          var equipeprofissionalid = $(e.relatedTarget).data('equipeprofissional-id');
          var cargonome = $(e.relatedTarget).data('cargo-nome');
          var cargoid = $(e.relatedTarget).data('cargo-id');
          var equipeid = $(e.relatedTarget).data('equipe-id');

          $(e.currentTarget).find('input[name="equipeprofissional_id"]').val(equipeprofissionalid);
          $(e.currentTarget).find('input[name="cargo_nome"]').val(cargonome);
          $(e.currentTarget).find('input[name="cargo_id"]').val(cargoid);
          $(e.currentTarget).find('input[name="equipe_id"]').val(equipeid);
      });

      $('#modallimparvaga').on('show.bs.modal', function(e) {
          var equipeprofissionalid = $(e.relatedTarget).data('equipeprofissional-id');
          var cargonome = $(e.relatedTarget).data('cargo-nome');
          var profissionalnome = $(e.relatedTarget).data('profissional-nome');
          var equipeid = $(e.relatedTarget).data('equipe-id');

          $(e.currentTarget).find('input[name="equipeprofissional_id_limpar"]').val(equipeprofissionalid);
          $(e.currentTarget).find('input[name="cargo_nome_limpar"]').val(cargonome);
          $(e.currentTarget).find('input[name="profissional_nome_limpar"]').val(profissionalnome);
          $(e.currentTarget).find('input[name="equipe_id_limpar"]').val(equipeid);          
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

          source: profissionais.ttAdapter(),
          templates: {
            empty: [
              '<div class="empty-message">',
                '<p class="text-center font-weight-bold text-warning">Não foi encontrado nenhum profissional com o texto digitado.</p>',
              '</div>'
            ].join('\n'),
            suggestion: function(data) {
                return '<div><div class="bg-dark text-white rounded"> ' + data.text + ' - <strong>Matrícula:</strong> ' + data.matricula + '</div>' + '<div class="mx-1">Cargo: <i>' + data.cargo + '</i></div></div>';
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
