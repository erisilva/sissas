@extends('layouts.app')

@section('title', 'Históricos')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('historico.index') }}">
            Históricos
        </a>
      </li>
    </ol>
  </nav>

  <x-flash-message status='success'  message='message' />

  <x-btn-group label='MenuPrincipal' class="py-1">
     
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon icon='funnel'/> {{ __('Filters') }}</button>

    @can('permission-export')
    <x-dropdown-menu title='Reports' icon='printer'>

      <li>
        <a class="dropdown-item" href="{{route('historico.export.xls', ['description' => request()->input('description'), 'name' => request()->input('name')])}}"><x-icon icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' XLS' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('historico.export.csv', ['description' => request()->input('description'), 'name' => request()->input('name')])}}"><x-icon icon='file-earmark-spreadsheet-fill'/> {{ __('Export') . ' CSV' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('historico.export.pdf', ['description' => request()->input('description'), 'name' => request()->input('name')])}}"><x-icon icon='file-pdf-fill' /> {{ __('Export') . ' PDF' }}</a>
      </li>
    
    </x-dropdown-menu>
    @endcan

  </x-btn-group>
  
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Data</th>
                <th scope="col">Hora</th>
                <th scope="col">Descrição</th>
                <th scope="col">Profissional</th>
                <th scope="col">Matrícula</th>
                <th scope="col">Operador</th>
                <th scope="col">Equipe</th>
                <th scope="col">Unidade</th>
                <th scope="col">Distrito</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historicos as $historico)
            <tr>
                <td>
                    <strong>{{ $historico->created_at->format('d/m/Y') }}</strong>
                </td>
                <td>
                    <strong>{{ $historico->created_at->format('H:i') }}</strong>
                </td>
                <td>
                    {{ $historico->historicoTipo->descricao }}
                </td>
                <td>
                    {{ $historico->profissional->nome }}
                </td>
                <td>
                    {{ $historico->profissional->matricula }}
                </td>
                <td>
                    {{ $historico->user->name }}
                </td>
                <td>
                    {{$historico->equipe->descricao ?? '-'}}
                </td>
                <td>
                    {{ $historico->equipe->unidade->nome ?? '-' }}
                </td>
                <td>
                    {{ $historico->equipe->unidade->distrito->nome ?? '-' }}
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  
  <x-pagination :query="$historicos" />

</div>

<x-modal-filter class="modal-lg" :perpages="$perpages" icon='funnel' title='Filters'>

  <form method="GET" action="{{ route('historico.index') }}">
    
    <div class="mb-3">
      <label for="name" class="form-label">{{ __('Name') }}</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ session()->get('permission_name') }}">
    </div>
    
    <div class="mb-3">
      <label for="description" class="form-label">{{ __('Description') }}</label>
      <input type="text" class="form-control" id="description" name="description" value="{{ session()->get('permission_description') }}">
    </div>
    
    <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search'/> {{ __('Search') }}</button>
    
    <a href="{{ route('historico.index', ['name' => '', 'description' => '']) }}" class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars'/> {{ __('Reset') }}</a>

  </form>

</x-modal-filter>  

@endsection
@section('script-footer')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var perpage = document.getElementById('perpage');
    perpage.addEventListener('change', function() {
        perpage = this.options[this.selectedIndex].value;
        window.open("{{ route('historico.index') }}" + "?perpage=" + perpage,"_self");
    });
});
</script>
@endsection