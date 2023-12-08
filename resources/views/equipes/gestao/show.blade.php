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

@section('title', 'Gestão de Equipes e Vagas')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('equipegestao.index') }}">
          Gestão de Equipes e Vagas
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<div class="container">
  <form>
  <div class="row g-3">


    <div class="col-md-8">
        <label for="descricao" class="form-label">Descrição</label>
        <input type="text" class="form-control" name="descricao" id="descricao" value="{{ $equipe->descricao }}" readonly> 
    </div>
    <div class="col-md-4">
        <label for="numero" class="form-label">Número</label>
        <input type="text" class="form-control" name="numero" id="numero" value="{{ $equipe->numero }}" readonly>   
    </div>

    <div class="col-md-3">
      <label for="cnes" class="form-label">CNES</label>
      <input type="text" class="form-control" name="cnes" id="cnes" value="{{ $equipe->cnes }}" readonly>   
    </div>
    <div class="col-md-3">
      <label for="ine" class="form-label">INE</label>
      <input type="text" class="form-control" name="ine" id="ine" value="{{ $equipe->ine }}" readonly>   
    </div>
    <div class="col-md-3">
      <label for="minima" class="form-label">Mínima</label>
      <input type="text" class="form-control" name="minima" id="minima" value="{{ $equipe->minima }}" readonly>   
    </div>
    <div class="col-md-3">
      <label for="tipo" class="form-label">Tipo</label>
      <input type="text" class="form-control" name="tipo" id="tipo" value="{{ $equipe->equipeTipo->nome }}" readonly>   
    </div>

    <div class="col-md-8">
      <label for="unidade" class="form-label">Unidade</label>
      <input type="text" class="form-control" name="unidade" id="unidade" value="{{ $equipe->unidade->nome }}" readonly> 
    </div>
    <div class="col-md-4">
        <label for="distrito" class="form-label">Distrito</label>
        <input type="text" class="form-control" name="distrito" id="distrito" value="{{ $equipe->unidade->distrito->nome }}" readonly>   
    </div>


    <div class="col-md-4">
      <label for="total_de_vagas" class="form-label">Total de Vagas</label>
      <input type="text" class="form-control" name="total_de_vagas" id="total_de_vagas" value="{{ $equipe->total_vagas }}" readonly>   
    </div>
    <div class="col-md-4">
      <label for="total_de_vagas_preenchidas" class="form-label">Total de Vagas Prenchidas</label>
      <input type="text" class="form-control" name="total_de_vagas_preenchidas" id="total_de_vagas_preenchidas" value="{{ $equipe->vagas_preenchidas }}" readonly>   
    </div>
    <div class="col-md-4">
      <label for="total_de_vagas_livres" class="form-label">Total de Vagas Livres</label>
      <input type="text" class="form-control" name="numero" id="total_de_vagas_livres" value="{{ $equipe->vagas_disponiveis }}" readonly>   
    </div>



  </div>  
  </form>  
</div>


<br>

@if (count($equipeprofissionais))
<div class="container-fluid py-2">
  <p class="text-center bg-primary text-white">
    <strong>Cargos e Vagas</strong>
  </p>  
</div>

<div class="container-fluid">
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
              <td>
                @if(isset($equipeprofissional->profissional->id))
                  <span><a class="btn btn-sm btn-success" href="{{ route('profissionals.edit', $equipeprofissional->profissional->id) }}" role="button" btn-sm><x-icon icon='people' /></a> {{ $equipeprofissional->profissional->nome }}</span>
                @else
                  <span class="fw-light">Vaga Livre</span>
                @endif
              </td>
              <td>{{ isset($equipeprofissional->profissional->matricula) ?  $equipeprofissional->profissional->matricula : '-' }}</td>
              <td>

              <td>
                @if(isset($equipeprofissional->profissional_id))
                <button type="button" class="btn btn-warning btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modallimparvaga" 
                            data-cargo-nome="{{ $equipeprofissional->cargo->nome}}" 
                            data-profissional-nome="{{ isset($equipeprofissional->profissional_id) ?  $equipeprofissional->profissional->nome : 'Sem Vínculo' }}" 
                            data-equipeprofissional-id="{{ $equipeprofissional->id}}" 
                            data-equipe-id="{{ $equipe->id}}">
                            <x-icon icon='x-circle' /> Remover
                </button>

                @else

                <button type="button" class="btn btn-primary btn-sm" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalvincularprofissional" 
                            data-equipeprofissional-id="{{ $equipeprofissional->id}}" 
                            data-cargo-id="{{ $equipeprofissional->cargo->id}}" 
                            data-cargo-nome="{{ $equipeprofissional->cargo->nome}}" 
                            data-equipe-id="{{ $equipe->id}}">
                            <x-icon icon='plus-circle' /> Atribuir
                </button>

                @endif
              </td>



            </tr>    
            @endforeach                                             
        </tbody>
    </table>
  </div>  
</div>

@else
<div class="alert alert-info" role="alert">
  Essa Unidade não Possui Vagas Preenchidas!
</div>
@endif


<x-btn-back route="equipegestao.index" />


{{-- Modal Vincular Profissional --}}
<div class="modal fade" id="modalvincularprofissional" tabindex="-1" aria-labelledby="JanelaVincularVaga" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ModalLabelVincularVaga"><x-icon icon='plus-circle' /> Atribuir Profissional</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form method="POST" action="{{ route('equipegestao.preenchervaga') }}">
          @csrf
          
          <div class="mb-3">
            <label for="cargo_nome" class="form-label">Vaga</label>
            <input type="text" class="form-control" name="cargo_nome" id="cargo_nome" readonly>
          </div>
        

          <input type="hidden" id="equipe_id" name="equipe_id" value="">
          <input type="hidden" id="cargo_id" name="cargo_id" value="">            
          <input type="hidden" id="equipeprofissional_id" name="equipeprofissional_id" value="">

          <div class="mb-3">
            <label for="profissional_nome" class="form-label">Profissional</label>
            <input type="text" class="form-control typeahead" name="profissional_nome" id="profissional_nome" value="{{ old('profissional_nome') ?? '' }}" autocomplete="off">       
            <input type="hidden" id="profissional_id" name="profissional_id" value="{{ old('profissional_id') ?? '' }}">
            <input type="hidden" id="cargo_profissional_id" name="cargo_profissional_id" value="{{ old('cargo_profissional_id') ?? '' }}">
          </div>

          <button type="submit" class="btn btn-primary"><x-icon icon='plus-circle' /> Atribuir Profissional</button>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><x-icon icon='x' /> Fechar</button>
      </div>
    </div>
  </div>
</div>




{{-- Modal Limpar Vaga--}}
<div class="modal fade" id="modallimparvaga" tabindex="-1" aria-labelledby="JanelaVincularVaga" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ModalLabelLimparVaga"><x-icon icon='x-circle' /> Remover Profissional</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('equipegestao.limparvaga') }}">
          @csrf
          <div class="mb-3">
            <label for="cargo_nome_limpar" class="form-label">Cargo da Vaga</label>
            <input type="text" class="form-control" name="cargo_nome_limpar" id="cargo_nome_limpar" readonly>
          </div>
          <div class="form-group">
            <label for="profissional_nome_limpar">Profissional Vinculado</label>
            <input type="text" class="form-control" name="profissional_nome_limpar" id="profissional_nome_limpar" readonly>
          </div>
          <div class="mb-3">
            <label for="motivo_limpar" class="form-label">Motivo</label>
            <input type="text" class="form-control" name="motivo_limpar" id="motivo_limpar">
          </div>
          <input type="hidden" id="equipeprofissional_id_limpar" name="equipeprofissional_id_limpar" value="">
          <input type="hidden" id="equipe_id_limpar" name="equipe_id_limpar" value="">            
          <button type="submit" class="btn btn-warning"><x-icon icon='x-circle' /> Remover Profissional</button>          
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><x-icon icon='x' /> Fechar</button>
      </div>
    </div>
  </div>
</div>




@endsection



@section('script-footer')
<script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
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
      }
  });
  profissionais.initialize();

  $("#profissional_nome").typeahead({
      hint: true,
      highlight: true,
      minLength: 1,
      limit: 10
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
