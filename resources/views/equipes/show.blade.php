@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('equipes.index') }}">Lista de Equipes e Vagas</a></li>
      <li class="breadcrumb-item active" aria-current="page">Exibir Registro</li>
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
  @if (count($equipeprofissionais))
  <br>
  <div class="container bg-primary text-white">
    <p class="text-center">Vagas</p>
  </div>
  <div class="container">
    <div class="table-responsive">
      <table class="table table-striped">
          <thead>
              <tr>
                  <th scope="col">Cargo</th>
                  <th scope="col">CBO</th>
                  <th scope="col">Profissional</th>
                  <th scope="col">Matrícula</th>
              </tr>
          </thead>
          <tbody>
              @foreach($equipeprofissionais as $equipeprofissional)
              <tr>
                <td>{{ $equipeprofissional->cargo->nome }}</td>
                <td>{{ $equipeprofissional->cargo->cbo }}</td>
                <td>{{ isset($equipeprofissional->profissional->nome) ?  $equipeprofissional->profissional->nome : 'Não Vinculado' }}</td>
                <td>{{ isset($equipeprofissional->profissional->matricula) ?  $equipeprofissional->profissional->matricula : '-' }}</td>
              </tr>    
              @endforeach                                             
          </tbody>
      </table>
    </div>  
  </div>
  @endif
  <br>
  <div class="container">
    <form method="post" action="{{route('equipes.destroy', $equipe->id)}}">
      @csrf
      @method('DELETE')
      <a href="{{ route('equipes.index') }}" class="btn btn-primary" role="button"><i class="fas fa-long-arrow-alt-left"></i> Voltar</i></a>
      <a href="{{ route('equipes.export.pdf.individual', $equipe->id) }}" class="btn btn-primary" role="button"><i class="fas fa-print"></i> Exportar para PDF</a>
      <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Enviar para Lixeira</button>
    </form>
  </div>
</div>

@endsection
