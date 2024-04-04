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

@section('title', 'Equipes e Vagas')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('equipes.index') }}">
          Equipes e Vagas
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Edit') }}
      </li>
    </ol>
  </nav>
</div>

<div class="container">
    <x-flash-message status='success'  message='message' />

    <form method="POST" action="{{ route('equipes.update', $equipe->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-3">



      <div class="col-md-8">
        <label for="descricao" class="form-label">Descrição <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('descricao') is-invalid @enderror" name="descricao" id="descricao" value="{{ old('descricao') ?? $equipe->descricao }}">
        @error('descricao')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror 
      </div>
      <div class="col-md-4">
        <label for="numero" class="form-label">Número <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" id="numero" value="{{ old('numero') ?? $equipe->numero }}">
        @error('numero')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror       
      </div>



      <div class="col-md-3">
        <label for="cnes" class="form-label">CNES <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('cnes') is-invalid @enderror" name="cnes" id="cnes" value="{{ old('cnes') ?? $equipe->cnes }}">
        @error('cnes')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror       
      </div>
      <div class="col-md-3">
        <label for="ine" class="form-label">INE <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('ine') is-invalid @enderror" name="ine" id="ine" value="{{ old('ine') ?? $equipe->ine }}">
        @error('ine')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror       
      </div>
      <div class="col-md-3">
        <p>Mínima <strong  class="text-danger">(*)</strong></p>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="minima" id="minima_s" value="s" @checked($equipe->minima == 's')>
          <label class="form-check-label" for="minima_s">Sim</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="minima" id="minima_n" value="n" @checked($equipe->minima == 'n')>
          <label class="form-check-label" for="minima_n">Não</label>
        </div>      
      </div>
      <div class="col-md-3">        
      <label for="equipe_tipo_id" class="form-label">Tipo <strong  class="text-danger">(*)</strong></label>
      <select class="form-select" id="equipe_tipo_id" name="equipe_tipo_id">
        <option value="{{ $equipe->equipe_tipo_id }}" selected="true">
          &rarr; {{ $equipe->equipeTipo->nome }}
        </option> 
        @foreach($equipetipos as $equipetipo)
        <option value="{{ $equipetipo->id }}" @selected(old('equipe_tipo_id') == $equipetipo->id)>
          {{$equipetipo->nome}}
        </option>
        @endforeach
      </select>
      @error('equipe_tipo_id')
        <div class="invalid-feedback">{{ $message }}</div>
      @enderror
    </div>



    <div class="col-md-8">
      <label for="unidade_descricao" class="form-label">Unidade <strong  class="text-danger">(*)</strong></label>
      <input type="text" class="form-control @error('unidade_descricao') is-invalid @enderror" name="unidade_descricao" id="unidade_descricao" value="{{ old('unidade_descricao') ?? $equipe->unidade->nome }}" autocomplete="off">
      @error('unidade_id')
        <div class="text-danger">
          {{ $message }}
        </div>
      @enderror    
    </div>
    <div class="col-md-4">
        <label for="distrito_descricao" class="form-label">Distrito</label>
        <input type="text" class="form-control @error('distrito_descricao') is-invalid @enderror" name="distrito_descricao" id="distrito_descricao" value="{{ old('distrito_descricao') ?? $equipe->unidade->distrito->nome }}" readonly>
        @error('distrito_descricao')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror       
    </div>

    <input type="hidden" id="unidade_id" name="unidade_id" value="{{ old('unidade_id') ?? $equipe->unidade_id }}">

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



    <div class="col-12">
      <button type="submit" class="btn btn-primary">
        <x-icon icon='pencil-square' />{{ __('Edit') }}
      </button> 
    </div>
  </div>  
  </form>
</div>

<div class="container py-2">
  <p class="text-center bg-primary text-white">
    <strong>Cargos e Vagas</strong>  
  </p>  
</div>

{{-- Inclusão de Vagas --}}

<div class="container">
  <form method="POST" action="{{ route('equipevagas.store') }}">
    @csrf
    <input type="hidden" id="equipe_id" name="equipe_id" value="{{ $equipe->id }}">
    <div class="row g-3">
      <div class="col-12">
        <label for="cargo_id" class="form-label">Cargo</label>
        <select class="form-select {{ $errors->has('cargo_id') ? ' is-invalid' : '' }}" name="cargo_id" id="cargo_id">
          <option value="" selected="true">Selecione ...</option>        
          @foreach($cargos as $cargo)
          <option value="{{$cargo->id}}">{{$cargo->nome . ' CBO:' . $cargo->cbo}}</option>
          @endforeach
        </select>
        @error('equipe_tipo_id')
        <div class="text-danger">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary"><x-icon icon='plus-circle' /> Incluir Vaga nessa Equipe</button>  
      </div>
    </div>
  </form>
</div>

{{-- Listagem das Vagas --}}

<div class="container py-2">
  @if($equipeprofissionais->count() > 0)


  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Cargo</th>
                <th scope="col">CBO</th>
                <th scope="col">Profissional</th>
                <th scope="col">Matrícula</th>
                <th scope="col">CPF</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipeprofissionais as $equipeprofissional)
            <tr>
                <td><strong>{{ $equipeprofissional->cargo->nome }}</strong></td>
                <td>{{ $equipeprofissional->cargo->cbo }}</td>
                <td>
                  @if(isset($equipeprofissional->profissional->id))
                  <span>
                    <a class="btn btn-sm btn-success" role="button" data-bs-toggle="modal" data-bs-target="#ProfissionalModal" data-profissional-id="{{ $equipeprofissional->profissional->id }}">
                      <x-icon icon='people' />
                    </a> 
                        {{ $equipeprofissional->profissional->nome }}
                  </span>
                  @else
                  <span class="badge text-bg-info">Vaga Livre</span>
                  @endif
                </td>
                <td>
                  {{ isset($equipeprofissional->profissional_id) ?  $equipeprofissional->profissional->matricula : '-' }}
                </td>
                <td>
                  {{ isset($equipeprofissional->profissional_id) ?  $equipeprofissional->profissional->cpf : '-' }}
                </td>
                <td>
                  <form method="post" action="{{route('equipevagas.destroy', $equipeprofissional->id)}}" onsubmit="return confirm('Você tem certeza que quer remover essa vaga?');">
                    @csrf
                    @method('DELETE')  
                    <button type="submit" class="btn btn-danger btn-sm"><x-icon icon='trash' /></button>
                  </form>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>  

  @else
  <div class="alert alert-info" role="alert">
    Essa Unidade não Possui Vagas Preenchidas!
  </div>
  @endif
</div>

<div class="container py-4">
  <div class="float-sm-end">
    <a href="{{ route('equipes.create') }}" class="btn btn-primary btn-lg" role="button">
      <x-icon icon='file-earmark' />
      {{ __('New') }}
   </a>
    <a href="{{ route('equipes.index') }}" class="btn btn-secondary btn-lg" role="button">
       <x-icon icon='arrow-left-square' />
       {{ __('Back') }}
    </a>
  </div>      
</div>

<!-- Profissional Modal -->
<div class="modal fade modal-xl" id="ProfissionalModal" tabindex="-1" aria-labelledby="Profissional" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"><x-icon icon='people' /> Profissional</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control" name="modal_nome" id="modal_nome" value="" readonly disabled>
            </div>
            <div class="col-md-2">
              <label for="matricula" class="form-label">Matricula</label>
              <input type="text" class="form-control" name="modal_matricula" id="modal_matricula" value="" readonly disabled>
            </div>
            <div class="col-md-2">
              <label for="cpf" class="form-label">CPF</label>
              <input type="text" class="form-control" name="modal_cpf" id="modal_cpf" value="" readonly disabled>
            </div>
            <div class="col-md-2">
              <label for="cns" class="form-label">CNS</label>
              <input type="text" class="form-control" name="modal_cns" id="modal_cns" value="" readonly disabled>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">E-mail</label>
              <input type="text" class="form-control" name="modal_email" id="modal_email" value="" readonly disabled>
            </div>
            <div class="col-md-3">
              <label for="tel" class="form-label">TEL</label>
              <input type="text" class="form-control" name="modal_tel" id="modal_tel" value="" readonly disabled>
            </div>
            <div class="col-md-3">
              <label for="cel" class="form-label">CEL</label>
              <input type="text" class="form-control" name="modal_cel" id="modal_cel" value="" readonly disabled>
            </div>
            <div class="col-md-2">
              <label for="cep" class="form-label">CEP</label>
              <input type="text" class="form-control" name="modal_cep" id="modal_cep" value="" readonly disabled>
            </div>
            <div class="col-md-5">
              <label for="logradouro" class="form-label">Logradouro</label>
              <input type="text" class="form-control" name="modal_logradouro" id="modal_logradouro" value="" readonly disabled>
            </div>
            <div class="col-md-2">
              <label for="numero" class="form-label">Nº</label>
              <input type="text" class="form-control" name="modal_numero" id="modal_numero" value="" readonly disabled>
            </div>
            <div class="col-md-3">
              <label for="complemento" class="form-label">Complemento</label>
              <input type="text" class="form-control" name="modal_complemento" id="modal_complemento" value="" readonly disabled>
            </div>
            <div class="col-md-5">
              <label for="bairro" class="form-label">Bairro</label>
              <input type="text" class="form-control" name="modal_bairro" id="modal_bairro" value="" readonly disabled>
            </div>
            <div class="col-md-5">
              <label for="cidade" class="form-label">Cidade</label>
              <input type="text" class="form-control" name="modal_cidade" id="modal_cidade" value="" readonly disabled>
            </div>
            <div class="col-md-2">
              <label for="uf" class="form-label">UF</label>
              <input type="text" class="form-control" name="modal_uf" id="modal_uf" value="" readonly disabled>
            </div>
            <div class="col-md-5">
              <label for="cargo" class="form-label">Cargo</label>
              <input type="text" class="form-control" name="modal_cargo" id="modal_cargo" value="" readonly disabled>
            </div>
            <div class="col-md-3">
              <label for="vinculo" class="form-label">Vinculo</label>
              <input type="text" class="form-control" name="modal_vinculo" id="modal_vinculo" value="" readonly disabled>
            </div>
            <div class="col-md-4">
              <label for="vinculotipo" class="form-label">Tipo de Vínculo</label>
              <input type="text" class="form-control" name="modal_vinculotipo" id="modal_vinculotipo" value="" readonly disabled>
            </div>
            <div class="col-md-3">
              <label for="cargahoraria" class="form-label">Carga Horária</label>
              <input type="text" class="form-control" name="modal_cargahoraria" id="modal_cargahoraria" value="" readonly disabled>
            </div>
            <div class="col-md-6">
              <label for="flexibilizacao" class="form-label">Flexibilização</label>
              <input type="text" class="form-control" name="modal_flexibilizacao" id="modal_flexibilizacao" value="" readonly disabled>
            </div>
            <div class="col-md-3">
              <label for="admissao" class="form-label">Admissão</label>
              <input type="text" class="form-control" name="modal_admissao" id="modal_admissao" value="" readonly disabled>
            </div>
            <div class="col-md-4">
              <label for="registroClasse" class="form-label">Registro de Classe</label>
              <input type="text" class="form-control" name="modal_registroClasse" id="modal_registroClasse" value="" readonly disabled>
            </div>
            <div class="col-md-4">
              <label for="orgao_emissor" class="form-label">Orgão Emissor</label>
              <input type="text" class="form-control" name="modal_orgao_emissor" id="modal_orgao_emissor" value="" readonly disabled>
            </div>
            <div class="col-md-4">
              <label for="ufOrgaoEmissor" class="form-label">UF/SSP</label>
              <input type="text" class="form-control" name="modal_ufOrgaoEmissor" id="modal_ufOrgaoEmissor" value="" readonly disabled>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <x-icon icon='x' /> Fechar
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script-footer')
<script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>

var unidades = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.obj.whitespace("text"),
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
          url: "{{route('unidades.autocomplete')}}?query=%QUERY",
          wildcard: '%QUERY'
      }
      
  });
  unidades.initialize();

  $("#unidade_descricao").typeahead({
      hint: true,
      highlight: true,
      minLength: 1
  },
  {
      name: "unidades",
      displayKey: "text",
      limit: 10,

      source: unidades.ttAdapter(),
      templates: {
        empty: [
          '<div class="empty-message">',
            '<p class="text-center font-weight-bold text-warning">Não foi encontrado nenhuma unidade com o texto digitado.</p>',
          '</div>'
        ].join('\n'),
        suggestion: function(data) {
            return '<div class="text-bg-primary py-1">' + data.text + '<strong> - Distrito: ' + data.distrito + '</strong>' + '</div>';
          }
      }    
      }).on("typeahead:selected", function(obj, datum, name) {
          console.log(datum);
          $(this).data("seletectedId", datum.value);
          $('#unidade_id').val(datum.value);
          $('#distrito_descricao').val(datum.distrito);
          console.log(datum.value);
          console.log(datum.distrito);
      }).on('typeahead:autocompleted', function (e, datum) {
          console.log(datum);
          $(this).data("seletectedId", datum.value);
          $('#unidade_id').val(datum.value);
          $('#distrito_descricao').val(datum.distrito);
          console.log(datum.value);
          console.log(datum.distrito);
  });


  $('#ProfissionalModal').on('show.bs.modal', function(e) {
          var profissionalid = $(e.relatedTarget).data('profissional-id');

          $.ajax({
            dataType: "json",
            url: "{{url('/')}}" + "/profissionals/export/json/" + profissionalid,
            type: "GET",
            success: function(json) {
                    $("#modal_nome").val(json['nome']);
                    $("#modal_cpf").val(json['cpf']);
                    $("#modal_cns").val(json['cns']);
                    $("#modal_matricula").val(json['matricula']);
                    $("#modal_email").val(json['email']);
                    $("#modal_tel").val(json['tel']);
                    $("#modal_cel").val(json['cel']);
                    $("#modal_cep").val(json['cep']);
                    $("#modal_logradouro").val(json['logradouro']);
                    $("#modal_numero").val(json['numero']);
                    $("#modal_complemento").val(json['complemento']);
                    $("#modal_bairro").val(json['bairro']);
                    $("#modal_cidade").val(json['cidade']);
                    $("#modal_uf").val(json['uf']);
                    $("#modal_cargo").val(json['cargo']['nome']);
                    $("#modal_vinculo").val(json['vinculo']['nome']);
                    $("#modal_vinculotipo").val(json['vinculotipo']['nome']);
                    $("#modal_cargahoraria").val(json['cargahoraria']['nome']);
                    $("#modal_flexibilizacao").val(json['flexibilizacao']);
                    var admissaoDate = moment(json['admissao']).format('DD/MM/YYYY');
                    $("#modal_admissao").val(admissaoDate);
                    $("#modal_registroClasse").val(json['registroClasse']);
                    $("#modal_orgao_emissor").val(json['orgaoemissor']['nome']);
                    $("#modal_ufOrgaoEmissor").val(json['ufOrgaoEmissor']);

            }
        });
      });
</script>

@endsection
