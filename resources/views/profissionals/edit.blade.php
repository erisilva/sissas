@extends('layouts.app')

@section('css-header')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('profissionals.index') }}">Lista de Profissionais</a></li>
      <li class="breadcrumb-item active" aria-current="page">Alterar Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  {{-- avisa se uma permissão foi alterada --}}
  @if(Session::has('edited_profissional'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('edited_profissional') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <form method="POST" action="{{ route('profissionals.update', $profissional->id) }}">
    @csrf
    @method('PUT')
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="nome">Nome</label>
        <input type="text" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" name="nome" value="{{ old('nome') ?? $profissional->nome }}">
        @if ($errors->has('nome'))
        <div class="invalid-feedback">
        {{ $errors->first('nome') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-2">
        <label for="matricula">Matrícula</label>
        <input type="text" class="form-control{{ $errors->has('matricula') ? ' is-invalid' : '' }}" name="matricula" value="{{ old('matricula') ?? $profissional->matricula }}">
        @if ($errors->has('matricula'))
        <div class="invalid-feedback">
        {{ $errors->first('matricula') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-2">
        <label for="cpf">CPF</label>
        <input type="text" class="form-control{{ $errors->has('cpf') ? ' is-invalid' : '' }}" name="cpf" id="cpf" value="{{ old('cpf') ?? $profissional->cpf }}">
        @if ($errors->has('cpf'))
        <div class="invalid-feedback">
        {{ $errors->first('cpf') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-2">
        <label for="cns">CNS</label>
        <input type="text" class="form-control{{ $errors->has('cns') ? ' is-invalid' : '' }}" name="cns" value="{{ old('cns') ?? $profissional->cns }}">
        @if ($errors->has('cns'))
        <div class="invalid-feedback">
        {{ $errors->first('cns') }}
        </div>
        @endif
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="email">E-mail</label>  
        <input type="text" class="form-control" name="email" id="email" value="{{ old('email') ?? $profissional->email }}">
      </div>
      <div class="form-group col-md-3">  
        <label for="tel">Tel</label>  
        <input type="text" class="form-control" name="tel" id="tel" value="{{ old('tel') ?? $profissional->tel }}">
      </div> 
      <div class="form-group col-md-3">  
        <label for="cel">Cel</label>  
        <input type="text" class="form-control" name="cel" id="cel" value="{{ old('cel') ?? $profissional->cel }}">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="cep">CEP</label>  
        <input type="text" class="form-control" name="cep" id="cep" value="{{ old('cep') ?? $profissional->cep }}">
      </div>
      <div class="form-group col-md-5">  
        <label for="logradouro">Logradouro</label>  
        <input type="text" class="form-control" name="logradouro" id="logradouro" value="{{ old('logradouro') ?? $profissional->logradouro }}">
      </div> 
      <div class="form-group col-md-2">  
        <label for="numero">Nº</label>  
        <input type="text" class="form-control" name="numero" id="numero" value="{{ old('numero') ?? $profissional->numero }}">
      </div>
      <div class="form-group col-md-3">  
        <label for="complemento">Complemento</label>  
        <input type="text" class="form-control" name="complemento" id="complemento" value="{{ old('complemento') ?? $profissional->complemento }}">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="bairro">Bairro</label>  
        <input type="text" class="form-control" name="bairro" id="bairro" value="{{ old('bairro') ?? $profissional->bairro }}">
      </div>
      <div class="form-group col-md-6">  
        <label for="cidade">Cidade</label>  
        <input type="text" class="form-control" name="cidade" id="cidade" value="{{ old('cidade') ?? $profissional->cidade }}">
      </div> 
      <div class="form-group col-md-2">  
        <label for="uf">UF</label>  
        <input type="text" class="form-control" name="uf" id="uf" value="{{ old('uf') ?? $profissional->uf }}">
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-5">
        <label for="cargo_id">Cargo</label>
        <select class="form-control {{ $errors->has('cargo_id') ? ' is-invalid' : '' }}" name="cargo_id" id="cargo_id">
          <option value="{{$profissional->cargo_id}}" selected="true">&rarr; {{ $profissional->cargo->nome . 'CBO:' . $profissional->cargo->cbo }}</option>        
          @foreach($cargos as $cargo)
          <option value="{{$cargo->id}}">{{$cargo->nome . ' CBO:' . $cargo->cbo}}</option>
          @endforeach
        </select>
        @if ($errors->has('cargo_id'))
        <div class="invalid-feedback">
        {{ $errors->first('cargo_id') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-3">
        <label for="vinculo_id">Vínculo</label>
        <select class="form-control {{ $errors->has('vinculo_id') ? ' is-invalid' : '' }}" name="vinculo_id" id="vinculo_id">
          <option value="{{ $profissional->vinculo_id }}" selected="true">&rarr; {{ $profissional->vinculo->descricao }}</option>        
          @foreach($vinculos as $vinculo)
          <option value="{{$vinculo->id}}">{{$vinculo->descricao}}</option>
          @endforeach
        </select>
        @if ($errors->has('vinculo_id'))
        <div class="invalid-feedback">
        {{ $errors->first('vinculo_id') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-4">
        <label for="vinculo_tipo_id">Tipo de Vínculo</label>
        <select class="form-control {{ $errors->has('vinculo_tipo_id') ? ' is-invalid' : '' }}" name="vinculo_tipo_id" id="vinculo_tipo_id">
          <option value="{{ $profissional->vinculo_tipo_id }}" selected="true">&rarr; {{ $profissional->vinculoTipo->descricao }}</option>        
          @foreach($vinculotipos as $vinculotipo)
          <option value="{{$vinculotipo->id}}">{{$vinculotipo->descricao}}</option>
          @endforeach
        </select>
        @if ($errors->has('vinculo_tipo_id'))
        <div class="invalid-feedback">
        {{ $errors->first('vinculo_tipo_id') }}
        </div>
        @endif
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="carga_horaria_id">Carga Horária</label>
        <select class="form-control {{ $errors->has('carga_horaria_id') ? ' is-invalid' : '' }}" name="carga_horaria_id" id="carga_horaria_id">
          <option value="{{ $profissional->carga_horaria_id }}" selected="true">&rarr; {{ $profissional->cargaHoraria->descricao }}</option>        
          @foreach($cargahorarias as $cargahoraria)
          <option value="{{$cargahoraria->id}}">{{$cargahoraria->descricao}}</option>
          @endforeach
        </select>
        @if ($errors->has('carga_horaria_id'))
        <div class="invalid-feedback">
        {{ $errors->first('carga_horaria_id') }}
        </div>
        @endif
      </div>
      <div class="form-group col-md-6">
        <p>Flexibilização</p>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="flexibilizacao" id="inlineRadio1" value="Nenhum" {{ ($profissional->flexibilizacao == 'Nenhum') ? ' checked' : '' }}>
          <label class="form-check-label" for="inlineRadio1">Nenhum</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="flexibilizacao" id="inlineRadio2" value="Extensão" {{ ($profissional->flexibilizacao == 'Extensão') ? ' checked' : '' }}>
          <label class="form-check-label" for="inlineRadio2">Extensão</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="flexibilizacao" id="inlineRadio3" value="Redução"{{ ($profissional->flexibilizacao == 'Redução') ? ' checked' : '' }}>
          <label class="form-check-label" for="inlineRadio3">Redução</label>
        </div>
      </div>
      <div class="form-group col-md-3">  
        <label for="admissao">Admissão</label>  
        <input type="text" class="form-control{{ $errors->has('admissao') ? ' is-invalid' : '' }}" name="admissao" id="admissao" value="{{ old('admissao') ?? $profissional->admissao->format('d/m/Y') }}" autocomplete="off">
        @if ($errors->has('admissao'))
        <div class="invalid-feedback">
        {{ $errors->first('admissao') }}
        </div>
        @endif
      </div>    
    </div> 
    <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Alterar Dados do Profissional</button>
  </form>
</div>
<br>
<div class="container">
  @if(Session::has('delete_ferias'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('delete_ferias') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('create_ferias'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('create_ferias') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('delete_licenca'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('delete_licenca') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('create_licenca'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('create_licenca') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
    @if(Session::has('delete_capacitacao'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('delete_capacitacao') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('create_capacitacao'))
  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Info!</strong>  {{ session('create_capacitacao') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="ferias-tab" data-toggle="tab" href="#ferias" role="tab" aria-controls="ferias" aria-selected="true">Férias</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="licenca-tab" data-toggle="tab" href="#licenca" role="tab" aria-controls="licenca" aria-selected="false">Licenças</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="capacitacao-tab" data-toggle="tab" href="#capacitacao" role="tab" aria-controls="capacitacao" aria-selected="false">Capacitações</a>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="ferias" role="tabpanel" aria-labelledby="ferias-tab">     
      <div class="container">
        <br>     
        <form method="POST" action="{{ route('ferias.store') }}">
          @csrf
          <input type="hidden" id="profissional_id" name="profissional_id" value="{{ $profissional->id }}">      
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="ferias_tipo_id">Tipo do Férias</label>
              <select class="form-control {{ $errors->has('ferias_tipo_id') ? ' is-invalid' : '' }}" name="ferias_tipo_id" id="ferias_tipo_id">
                <option value="" selected>Selecionar ... </option>
                @foreach($feriastipos as $feriastipo)
                <option value="{{$feriastipo->id}}">{{$feriastipo->descricao}}</option>
                @endforeach
              </select>
              @if ($errors->has('ferias_tipo_id'))
              <div class="invalid-feedback">
              {{ $errors->first('ferias_tipo_id') }}
              </div>
              @endif
            </div>
            <div class="form-group col-md-3">
              <label for="ferias_inicio">Data inicial</label>
              <input type="text" class="form-control{{ $errors->has('ferias_inicio') ? ' is-invalid' : '' }}" id="ferias_inicio" name="ferias_inicio" value="{{ old('ferias_inicio') ?? '' }}" autocomplete="off">
              @if ($errors->has('ferias_inicio'))
              <div class="invalid-feedback">
              {{ $errors->first('ferias_inicio') }}
              </div>
              @endif  
            </div>
            <div class="form-group col-md-3">
              <label for="ferias_final">Data final</label>
              <input type="text" class="form-control{{ $errors->has('ferias_final') ? ' is-invalid' : '' }}" id="ferias_final" name="ferias_final" value="{{ old('ferias_final') ?? '' }}" autocomplete="off">
              @if ($errors->has('ferias_final'))
              <div class="invalid-feedback">
              {{ $errors->first('ferias_final') }}
              </div>
              @endif 
            </div>  
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="ferias_justificativa">Justificativa</label>  
              <input type="text" class="form-control" name="ferias_justificativa"  value="{{ old('ferias_justificativa') ?? '' }}">
            </div>
            <div class="form-group col-md-6">
              <label for="ferias_observacao">Observações</label>  
              <input type="text" class="form-control" name="ferias_observacao"  value="{{ old('ferias_observacao') ?? '' }}">
            </div>              
          </div>    
          <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Incluir Período de Férias</button> 
        </form>
        <br>
        @if (count($ferias))
        <div class="table-responsive">
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th scope="col">Tipo</th>
                      <th scope="col">Inicial</th>
                      <th scope="col">Final</th>
                      <th scope="col">Justificativa</th>
                      <th scope="col">Observações</th>
                      <th scope="col"></th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($ferias as $ferias_index)
                  <tr>
                      <td>{{ $ferias_index->feriasTipo->descricao }}</td>
                      <td>{{ isset($ferias_index->inicio) ?  $ferias_index->inicio->format('d/m/Y') : '-' }}</td>
                      <td>{{ isset($ferias_index->fim) ?  $ferias_index->fim->format('d/m/Y') : '-' }}</td>
                      <td>{{ $ferias_index->justificativa }}</td>
                      <td>{{ $ferias_index->observacao }}</td>
                      <td>
                        <form method="post" action="{{route('ferias.destroy', $ferias_index->id)}}">
                          @csrf
                          @method('DELETE')  
                          <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                        </form>
                      </td>
                  </tr>
                  @endforeach                                                 
              </tbody>
          </table>
        </div>
        @endif
      </div>  
    </div>
    <div class="tab-pane fade" id="licenca" role="tabpanel" aria-labelledby="licenca-tab">
      <div class="container">
        <br>
        <form method="POST" action="{{ route('licencas.store') }}">
          @csrf
          <input type="hidden" id="profissional_id" name="profissional_id" value="{{ $profissional->id }}">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="licenca_tipo_id">Tipo do Licença</label>
              <select class="form-control {{ $errors->has('licenca_tipo_id') ? ' is-invalid' : '' }}" name="licenca_tipo_id" id="licenca_tipo_id">
                <option value="" selected>Selecionar ... </option>
                @foreach($licencatipos as $licencatipo)
                <option value="{{$licencatipo->id}}">{{$licencatipo->descricao}}</option>
                @endforeach
              </select>
              @if ($errors->has('licenca_tipo_id'))
              <div class="invalid-feedback">
              {{ $errors->first('licenca_tipo_id') }}
              </div>
              @endif
            </div>
            <div class="form-group col-md-3">
              <label for="licenca_inicio">Data inicial</label>
              <input type="text" class="form-control{{ $errors->has('licenca_inicio') ? ' is-invalid' : '' }}" id="licenca_inicio" name="licenca_inicio" value="{{ old('licenca_inicio') ?? '' }}" autocomplete="off">
              @if ($errors->has('licenca_inicio'))
              <div class="invalid-feedback">
              {{ $errors->first('licenca_inicio') }}
              </div>
              @endif  
            </div>
            <div class="form-group col-md-3">
              <label for="licenca_final">Data final</label>
              <input type="text" class="form-control{{ $errors->has('licenca_final') ? ' is-invalid' : '' }}" id="licenca_final" name="licenca_final" value="{{ old('licenca_final') ?? '' }}" autocomplete="off">
              @if ($errors->has('licenca_final'))
              <div class="invalid-feedback">
              {{ $errors->first('licenca_final') }}
              </div>
              @endif 
            </div>  
          </div>
          <div class="form-group">
            <label for="licenca_observacao">Observações</label>  
            <input type="text" class="form-control" name="licenca_observacao"  value="{{ old('licenca_observacao') ?? '' }}">
          </div> 
          <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Incluir Período de Licença</button> 
        </form>
        <br>
        @if (count($licencas))
        <div class="table-responsive">
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th scope="col">Tipo</th>
                      <th scope="col">Inicial</th>
                      <th scope="col">Final</th>
                      <th scope="col">Observações</th>
                      <th scope="col"></th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($licencas as $licenca)
                  <tr>
                      <td>{{ $licenca->licencaTipo->descricao }}</td>
                      <td>{{ isset($licenca->inicio) ?  $licenca->inicio->format('d/m/Y') : '-' }}</td>
                      <td>{{ isset($licenca->fim) ?  $licenca->fim->format('d/m/Y') : '-' }}</td>
                      <td>{{ $licenca->observacao }}</td>
                      <td>
                        <form method="post" action="{{route('licencas.destroy', $licenca->id)}}">
                          @csrf
                          @method('DELETE')  
                          <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                        </form>
                      </td>
                  </tr>
                  @endforeach                                                 
              </tbody>
          </table>
        </div>
        @endif
      </div>  
    </div>
    <div class="tab-pane fade" id="capacitacao" role="tabpanel" aria-labelledby="capacitacao-tab">
      <div class="container">
        <br>
        <form method="POST" action="{{ route('capacitacaos.store') }}">
          @csrf
          <input type="hidden" id="profissional_id" name="profissional_id" value="{{ $profissional->id }}">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="capacitacao_tipo_id">Tipo do Capacitação</label>
              <select class="form-control {{ $errors->has('capacitacao_tipo_id') ? ' is-invalid' : '' }}" name="capacitacao_tipo_id" id="capacitacao_tipo_id">
                <option value="" selected>Selecionar ... </option>
                @foreach($capacitacaotipos as $capacitacaotipo)
                <option value="{{$capacitacaotipo->id}}">{{$capacitacaotipo->descricao}}</option>
                @endforeach
              </select>
              @if ($errors->has('capacitacao_tipo_id'))
              <div class="invalid-feedback">
              {{ $errors->first('capacitacao_tipo_id') }}
              </div>
              @endif
            </div>
            <div class="form-group col-md-3">
              <label for="capacitacao_inicio">Data inicial</label>
              <input type="text" class="form-control{{ $errors->has('capacitacao_inicio') ? ' is-invalid' : '' }}" id="capacitacao_inicio" name="capacitacao_inicio" value="{{ old('capacitacao_inicio') ?? '' }}" autocomplete="off">
              @if ($errors->has('capacitacao_inicio'))
              <div class="invalid-feedback">
              {{ $errors->first('capacitacao_inicio') }}
              </div>
              @endif  
            </div>
            <div class="form-group col-md-3">
              <label for="capacitacao_final">Data final</label>
              <input type="text" class="form-control{{ $errors->has('capacitacao_final') ? ' is-invalid' : '' }}" id="capacitacao_final" name="capacitacao_final" value="{{ old('capacitacao_final') ?? '' }}" autocomplete="off">
              @if ($errors->has('capacitacao_final'))
              <div class="invalid-feedback">
              {{ $errors->first('capacitacao_final') }}
              </div>
              @endif 
            </div>  
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="capacitacao_cargahoraria">Carga Horária</label>  
              <input type="text" class="form-control" name="capacitacao_cargahoraria"  value="{{ old('capacitacao_cargahoraria') ?? '' }}">
            </div>
            <div class="form-group col-md-9">
              <label for="capacitacao_observacao">Observações</label>  
              <input type="text" class="form-control" name="capacitacao_observacao"  value="{{ old('capacitacao_observacao') ?? '' }}">
            </div>              
          </div>
          <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Incluir Capacitação</button> 
        </form>
        <br>
        @if (count($capacitacaos))
        <div class="table-responsive">
          <table class="table table-striped">
              <thead>
                  <tr>
                      <th scope="col">Tipo</th>
                      <th scope="col">Inicial</th>
                      <th scope="col">Final</th>
                      <th scope="col">Justificativa</th>
                      <th scope="col">Observações</th>
                      <th scope="col"></th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($capacitacaos as $capacitacao_index)
                  <tr>
                      <td>{{ $capacitacao_index->capacitacaoTipo->descricao }}</td>
                      <td>{{ isset($capacitacao_index->inicio) ?  $capacitacao_index->inicio->format('d/m/Y') : '-' }}</td>
                      <td>{{ isset($capacitacao_index->fim) ?  $capacitacao_index->fim->format('d/m/Y') : '-' }}</td>
                      <td>{{ $capacitacao_index->cargahoraria }}</td>
                      <td>{{ $capacitacao_index->observacao }}</td>
                      <td>
                        <form method="post" action="{{route('capacitacaos.destroy', $ferias_index->id)}}">
                          @csrf
                          @method('DELETE')  
                          <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                        </form>
                      </td>
                  </tr>
                  @endforeach                                                 
              </tbody>
          </table>
        </div>
        @endif
      </div>    
    </div>
  </div>

</div>
<br>

<div class="container">
  <div class="float-right">
    <a href="{{ route('profissionals.index') }}" class="btn btn-secondary btn-sm" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
  </div>
</div>
@endsection

@section('script-footer')
<script src="{{ asset('js/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('locales/bootstrap-datepicker.pt-BR.min.js') }}"></script>
<script>
  $(document).ready(function(){

      $('#admissao').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        clearBtn: true,
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true
      });

      $('#ferias_final').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        clearBtn: true,
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true
      });

      $('#ferias_inicio').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        clearBtn: true,
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true
      });

      $('#licenca_final').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        clearBtn: true,
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true
      });

      $('#licenca_inicio').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        clearBtn: true,
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true
      });

      $('#capacitacao_final').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        clearBtn: true,
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true
      });

      $('#capacitacao_inicio').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        clearBtn: true,
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true
      });

      $("#cel").inputmask({"mask": "(99) 99999-9999"});
      $("#tel").inputmask({"mask": "(99) 9999-9999"});
      $("#cep").inputmask({"mask": "99.999-999"});
      $("#cpf").inputmask({"mask": "999.999.999-99"});

      function limpa_formulario_cep() {
          $("#logradouro").val("");
          $("#bairro").val("");
          $("#cidade").val("");
          $("#uf").val("");
      }

      $("#cep").blur(function () {
          var cep = $(this).val().replace(/\D/g, '');
          if (cep != "") {
              var validacep = /^[0-9]{8}$/;
              if(validacep.test(cep)) {
                  $("#logradouro").val("...");
                  $("#bairro").val("...");
                  $("#cidade").val("...");
                  $("#uf").val("...");
                  $.ajax({
                      dataType: "json",
                      url: "https://erisilva.net/cep/?value=" + cep + "&field=cep&method=json",
                      type: "GET",
                      success: function(json) {
                          if (json['erro']) {
                              limpa_formulario_cep();
                              console.log('cep inválido');
                          } else {
                              $("#bairro").val(json[0]['bairro']);
                              $("#cidade").val(json[0]['cidade']);
                              $("#uf").val(json[0]['uf'].toUpperCase());
                              var tipo = json[0]['tipo'];
                              var logradouro = json[0]['logradouro'];
                              $("#logradouro").val(tipo + ' ' + logradouro);
                          }
                      }
                  });
              } else {
                  limpa_formulario_cep();
              }
          } else {
              limpa_formulario_cep();
          }
      });
  });

$(document).ready(function() {
  if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }
    $(document.body).on("click", "a[data-toggle]", function(event) {
        location.hash = this.getAttribute("href");
    });
});
$(window).on("popstate", function() {
    var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
    $("a[href='" + anchor + "']").tab("show");
});
</script>

@endsection
