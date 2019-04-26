@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('profissionals.index') }}">Lista de Profissionais</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir Registro</li>
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
  <br>
  <div class="container">
    <form method="post" action="{{route('profissionals.destroy', $profissional->id)}}">
      @csrf
      @method('DELETE')
      <a href="{{ route('profissionals.index') }}" class="btn btn-primary" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
      <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Excluir</button>
    </form>
  </div>
</div>

@endsection
