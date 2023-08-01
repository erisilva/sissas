@extends('layouts.app')

@section('title', 'Férias' )

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('profissionals.index') }}">Profissionais</a></li>
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('ferias.index') }}">Férias</a>
      </li>
    </ol>
  </nav>

  <x-flash-message status='success'  message='message' />

  <x-btn-group label='MenuPrincipal' class="py-1">

    <a class="btn btn-primary" href="{{ route('ferias.create') }}" role="button"><x-icon icon='file-earmark'/> {{ __('New') }}</a>  
     
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon icon='funnel'/> {{ __('Filters') }}</button>

    <x-dropdown-menu title='Reports' icon='printer'>

      {{-- Não precisa passar pra rota as variáveis do request, pois a filtragem será feita pelas variáveis da session --}}
      <li>
        <a class="dropdown-item" href="{{route('ferias.export.xls')}}"><x-icon icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' XLS' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('ferias.export.csv')}}"><x-icon icon='file-earmark-spreadsheet-fill'/> {{ __('Export') . ' CSV' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('ferias.export.pdf')}}"><x-icon icon='file-pdf-fill' /> {{ __('Export') . ' PDF' }}</a>
      </li>
    
    </x-dropdown-menu>  

  </x-btn-group>
  
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
              <th scope="col">Profissional</th>
              <th scope="col">Matrícula</th>
              <th scope="col">Cargo</th>
              <th scope="col">Tipo</th>
              <th scope="col">Inicio</th>
              <th scope="col">Fim</th>
              <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($ferias as $ferias_index)
            <tr>
              <td>
                {{$ferias_index->profissional->nome}}
              </td>
              <td>
                {{$ferias_index->profissional->matricula}}
              </td>
              <td>
                {{$ferias_index->profissional->cargo->nome}}
              </td>
              <td>
                {{$ferias_index->feriasTipo->nome}}
              </td>
              <td>
                {{ isset($ferias_index->inicio) ?  $ferias_index->inicio->format('d/m/Y') : '-' }}
              </td>
              <td>
                {{ isset($ferias_index->fim) ?  $ferias_index->fim->format('d/m/y') : '-' }}
              </td> 
              <td>
                <x-btn-group label='Opções'>

                  <a href="{{route('ferias.edit', $ferias_index->id)}}" class="btn btn-primary btn-sm" role="button"><x-icon icon='pencil-square'/></a>

                  <a href="{{route('ferias.show', $ferias_index->id)}}" class="btn btn-info btn-sm" role="button"><x-icon icon='eye'/></a>

                </x-btn-group>
              </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  
  <x-pagination :query="$ferias" />

</div>

<x-modal-filter :perpages="$perpages" icon='funnel' title='Filtros'>

  <form method="GET" action="{{ route('ferias.index') }}">
    
    <div class="mb-3">
      <label for="nome" class="form-label">{{ __('Name') }}</label>
      <input type="text" class="form-control" id="nome" name="nome" value="{{ session()->get('unidade_nome') }}">
    </div>
    
    <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search'/> {{ __('Search') }}</button>
    
    {{-- Reset the Filter --}}
    <a href="{{ route('ferias.index', ['nome' => '', 'distrito_id' => '']) }}" class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars'/> {{ __('Reset') }}</a>

  </form>

</x-modal-filter>  

@endsection
@section('script-footer')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var perpage = document.getElementById('perpage');
    perpage.addEventListener('change', function() {
        perpage = this.options[this.selectedIndex].value;
        window.open("{{ route('ferias.index') }}" + "?perpage=" + perpage,"_self");
    });
});
</script>
@endsection