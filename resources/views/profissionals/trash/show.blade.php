@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('profissionals.index') }}">Lista de Profissionais</a></li>
      <li class="breadcrumb-item"><a href="{{ route('profissionals.trash') }}">Lixeira</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir e Restaurar Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" name="nome" value="{{ $profissional->nome }}" readonly>
      </div>
      <div class="form-group col-md-2">
        <label for="matricula">Matrícula</label>
        <input type="text" class="form-control" name="matricula" value="{{ $profissional->matricula }}" readonly>
      </div>
      <div class="form-group col-md-2">
        <label for="cpf">CPF</label>
        <input type="text" class="form-control" name="cpf" id="cpf" value="{{ $profissional->cpf }}" readonly>
      </div>
      <div class="form-group col-md-2">
        <label for="cns">CNS</label>
        <input type="text" class="form-control" name="cns" value="{{ $profissional->cns }}" readonly>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="email">E-mail</label>  
        <input type="text" class="form-control" name="email" id="email" value="{{ $profissional->email }}" readonly>
      </div>
      <div class="form-group col-md-3">  
        <label for="tel">Tel</label>  
        <input type="text" class="form-control" name="tel" id="tel" value="{{ $profissional->tel }}" readonly>
      </div> 
      <div class="form-group col-md-3">  
        <label for="cel">Cel</label>  
        <input type="text" class="form-control" name="cel" id="cel" value="{{ $profissional->cel }}" readonly>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="cep">CEP</label>  
        <input type="text" class="form-control" name="cep" id="cep" value="{{ $profissional->cep }}" readonly>
      </div>
      <div class="form-group col-md-5">  
        <label for="logradouro">Logradouro</label>  
        <input type="text" class="form-control" name="logradouro" id="logradouro" value="{{ $profissional->logradouro }}" readonly>
      </div> 
      <div class="form-group col-md-2">  
        <label for="numero">Nº</label>  
        <input type="text" class="form-control" name="numero" id="numero" value="{{ $profissional->numero }}" readonly>
      </div>
      <div class="form-group col-md-3">  
        <label for="complemento">Complemento</label>  
        <input type="text" class="form-control" name="complemento" id="complemento" value="{{ $profissional->complemento }}" readonly>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="bairro">Bairro</label>  
        <input type="text" class="form-control" name="bairro" id="bairro" value="{{ $profissional->bairro }}" readonly>
      </div>
      <div class="form-group col-md-6">  
        <label for="cidade">Cidade</label>  
        <input type="text" class="form-control" name="cidade" id="cidade" value="{{ $profissional->cidade }}" readonly>
      </div> 
      <div class="form-group col-md-2">  
        <label for="uf">UF</label>  
        <input type="text" class="form-control" name="uf" id="uf" value="{{ $profissional->uf }}" readonly>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-5">
        <label for="cargo_id">Cargo</label>
        <input type="text" class="form-control" name="cargo_id" value="{{ $profissional->cargo->nome }}" readonly>
      </div>
      <div class="form-group col-md-3">
        <label for="vinculo_id">Vínculo</label>
        <input type="text" class="form-control" name="vinculo_id" value="{{ $profissional->vinculo->descricao }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="vinculo_tipo_id">Tipo de Vínculo</label>
        <input type="text" class="form-control" name="vinculo_tipo_id" value="{{ $profissional->vinculoTipo->descricao }}" readonly>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-3">
        <label for="carga_horaria_id">Carga Horária</label>
        <input type="text" class="form-control" name="carga_horaria_id" value="{{ $profissional->cargaHoraria->descricao }}" readonly>
      </div>
      <div class="form-group col-md-6">
        <label for="flexibilizacao">Flexibilização</label>
        <input type="text" class="form-control" name="flexibilizacao" value="{{ $profissional->flexibilizacao}}" readonly>
      </div>
      <div class="form-group col-md-3">  
        <label for="admissao">Admissão</label>  
        <input type="text" class="form-control" name="admissao" id="admissao" value="{{ $profissional->admissao->format('d/m/Y') }}" readonly>
      </div>
    </div>
  </form>
  @if (count($ferias))
  <br>
  <div class="container bg-primary text-white">
    <p class="text-center">Férias</p>
  </div>
  <div class="container">
    <div class="table-responsive">
      <table class="table table-striped">
          <thead>
              <tr>
                  <th scope="col">Tipo</th>
                  <th scope="col">Inicial</th>
                  <th scope="col">Final</th>
                  <th scope="col">Justificativa</th>
                  <th scope="col">Observações</th>
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
              </tr>    
              @endforeach                                             
          </tbody>
      </table>
    </div>  
  </div>
  @endif
  @if (count($licencas))
  <br>
  <div class="container bg-primary text-white">
    <p class="text-center">Licenças</p>
  </div>
  <div class="container">
    <div class="table-responsive">
      <table class="table table-striped">
          <thead>
              <tr>
                <th scope="col">Tipo</th>
                <th scope="col">Inicial</th>
                <th scope="col">Final</th>
                <th scope="col">Observações</th>
              </tr>
          </thead>
          <tbody>
              @foreach($licencas as $licenca)
              <tr>
                <td>{{ $licenca->licencaTipo->descricao }}</td>
                <td>{{ isset($licenca->inicio) ?  $licenca->inicio->format('d/m/Y') : '-' }}</td>
                <td>{{ isset($licenca->fim) ?  $licenca->fim->format('d/m/Y') : '-' }}</td>
                <td>{{ $licenca->observacao }}</td>
              </tr>    
              @endforeach                                             
          </tbody>
      </table>
    </div>  
  </div>
  @endif
  @if (count($capacitacaos))
  <br>
  <div class="container bg-primary text-white">
    <p class="text-center">Capacitações</p>
  </div>
  <div class="container">
    <div class="table-responsive">
      <table class="table table-striped">
          <thead>
              <tr>
                <th scope="col">Tipo</th>
                <th scope="col">Inicial</th>
                <th scope="col">Final</th>
                <th scope="col">Carga Horária</th>
                <th scope="col">Observações</th>
              </tr>
          </thead>
          <tbody>
              @foreach($capacitacaos as $capacitacao_index)
              <tr>
                <td>{{ $capacitacao_index->capacitacaoTipo->descricao }}</td>
                <td>{{ isset($capacitacao_index->inicio) ?  $capacitacao_index->inicio->format('d/m/Y') : '-' }}</td>
                <td>{{ isset($capacitacao_index->fim) ?  $capacitacao_index->fim->format('d/m/Y') : '-' }}</td>
                <td>{{ $capacitacao_index->cargaHoraria }}</td>
                <td>{{ $capacitacao_index->observacao }}</td>
              </tr>    
              @endforeach                                             
          </tbody>
      </table>
    </div>  
  </div>
  @endif
  <br>
  <div class="container">
    <form method="post" action="{{route('profissionals.trash.restore', array($profissional->id))}}">
      @csrf
      <a href="{{ route('profissionals.trash') }}" class="btn btn-primary" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
      <button type="submit" class="btn btn-success"><i class="fas fa-trash-restore"></i> Restaurar</button>
    </form>
  </div>
</div>

@endsection
