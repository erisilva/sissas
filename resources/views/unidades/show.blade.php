@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('unidades.index') }}">Lista de Unidades</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir Registro</li>
    </ol>
  </nav>
</div>
<div class="container">
  <form>
    <div class="form-row">
      <div class="form-group col-md-8">
        <label for="descricao">Descrição</label>
        <input type="text" class="form-control" name="descricao" value="{{ $unidade->descricao }}" readonly>
      </div>
      <div class="form-group col-md-4">
        <label for="distrito">Distrito</label>  
        <input type="text" class="form-control" name="distrito" id="distrito" value="{{ $unidade->distrito->nome }}" readonly>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="email">E-mail</label>  
        <input type="text" class="form-control" name="email" id="email" value="{{ $unidade->email }}" readonly>
      </div>
      <div class="form-group col-md-3">  
        <label for="tel">Tel</label>  
        <input type="text" class="form-control" name="tel" id="tel" value="{{ $unidade->tel }}" readonly>
      </div> 
      <div class="form-group col-md-3">  
        <label for="cel">Cel</label>  
        <input type="text" class="form-control" name="cel" id="cel" value="{{ $unidade->cel }}" readonly>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-2">
        <label for="cep">CEP</label>  
        <input type="text" class="form-control" name="cep" id="cep" value="{{ $unidade->cep }}" readonly>
      </div>
      <div class="form-group col-md-5">  
        <label for="logradouro">Logradouro</label>  
        <input type="text" class="form-control" name="logradouro" id="logradouro" value="{{ $unidade->logradouro }}" readonly>
      </div> 
      <div class="form-group col-md-2">  
        <label for="numero">Nº</label>  
        <input type="text" class="form-control" name="numero" id="numero" value="{{ $unidade->numero }}" readonly>
      </div>
      <div class="form-group col-md-3">  
        <label for="complemento">Complemento</label>  
        <input type="text" class="form-control" name="complemento" id="complemento" value="{{ $unidade->complemento }}" readonly>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="bairro">Bairro</label>  
        <input type="text" class="form-control" name="bairro" id="bairro" value="{{ $unidade->bairro }}" readonly>
      </div>
      <div class="form-group col-md-4">  
        <label for="cidade">Cidade</label>  
        <input type="text" class="form-control" name="cidade" id="cidade" value="{{ $unidade->cidade }}" readonly>
      </div> 
      <div class="form-group col-md-2">  
        <label for="uf">UF</label>  
        <input type="text" class="form-control" name="uf" id="uf" value="{{ $unidade->uf }}" readonly>
      </div>
      <div class="form-group col-md-2">  
        <label for="porte">Porte</label>  
        <input type="text" class="form-control" name="porte" id="porte" value="{{ $unidade->porte }}" readonly>
      </div>      
    </div>
  </form>
  <br>
  <div class="container">
    <form method="post" action="{{route('unidades.destroy', $unidade->id)}}">
      @csrf
      @method('DELETE')
      <a href="{{ route('unidades.index') }}" class="btn btn-primary" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
      <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Excluir</button>
    </form>
  </div>
</div>

@endsection
