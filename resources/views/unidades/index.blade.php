@extends('layouts.app')

@section('title', 'Unidades' )

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('unidades.index') }}">Unidades</a>
      </li>
    </ol>
  </nav>

  <x-flash-message status='success'  message='message' />

  <x-btn-group label='MenuPrincipal' class="py-1">

    <a class="btn btn-primary" href="{{ route('unidades.create') }}" role="button"><x-icon icon='file-earmark'/> {{ __('New') }}</a>  
     
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon icon='funnel'/> {{ __('Filters') }}</button>

    <x-dropdown-menu title='Reports' icon='printer'>

      <li>
        <a class="dropdown-item" href="{{route('unidades.export.xls', ['description' => request()->input('description'), 'name' => request()->input('name')])}}"><x-icon icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' XLS' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('unidades.export.csv', ['description' => request()->input('description'), 'name' => request()->input('name')])}}"><x-icon icon='file-earmark-spreadsheet-fill'/> {{ __('Export') . ' CSV' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('unidades.export.pdf', ['description' => request()->input('description'), 'name' => request()->input('name')])}}"><x-icon icon='file-pdf-fill' /> {{ __('Export') . ' PDF' }}</a>
      </li>
    
    </x-dropdown-menu>  

  </x-btn-group>
  
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th>Distrito</th>
                <th>Tel</th>
                <th>E-mail</th>
                <th>Bairro</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($unidades as $unidade)
            <tr>
                <td class="text-nowrap">
                  {{ $unidade->nome }}
                </td>
                <td class="text-nowrap">
                  {{ $unidade->distrito->nome }}
                </td>
                <td class="text-nowrap">
                  {{ $unidade->tel }}
                </td>
                <td class="text-nowrap">
                  {{ $unidade->email }}
                </td>
                <td>
                  {{ $unidade->bairro }}
                </td>  
                <td>
                  <x-btn-group label='Opções'>

                    <a href="{{route('unidades.edit', $unidade->id)}}" class="btn btn-primary btn-sm" role="button"><x-icon icon='pencil-square'/></a>

                    <a href="{{route('unidades.show', $unidade->id)}}" class="btn btn-info btn-sm" role="button"><x-icon icon='eye'/></a>

                  </x-btn-group>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  
  <x-pagination :query="$unidades" />

</div>

<x-modal-filter :perpages="$perpages" icon='funnel' title='Filtros'>

  <form method="GET" action="{{ route('unidades.index') }}">
    
    <div class="mb-3">
      <label for="nome" class="form-label">{{ __('Name') }}</label>
      <input type="text" class="form-control" id="nome" name="nome" value="{{ session()->get('unidade_nome') }}">
    </div>
    
    <div class="mb-3">
      <label for="distrito_id">Tipo</strong></label>
      <select class="form-control" id="distrito_id" name="distrito_id">
          <option value="" selected="true">Clique ...</option> 
          @foreach($distritos as $distrito)
          <option value="{{ $distrito->id }}" {{ session()->get('unidade_distrito_id') == $distrito->id ? "selected":"" }}>
            {{ $distrito->nome }}
          </option>
          @endforeach
      </select>
    </div>
    
    <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search'/> {{ __('Search') }}</button>
    
    {{-- Reset the Filter --}}
    <a href="{{ route('unidades.index', ['nome' => '', 'distrito_id' => '']) }}" class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars'/> {{ __('Reset') }}</a>

  </form>

</x-modal-filter>  

@endsection
@section('script-footer')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var perpage = document.getElementById('perpage');
    perpage.addEventListener('change', function() {
        perpage = this.options[this.selectedIndex].value;
        window.open("{{ route('unidades.index') }}" + "?perpage=" + perpage,"_self");
    });
});
</script>
@endsection