@extends('layouts.app')

@section('title', 'Tipos de Vínculo')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('vinculotipos.index') }}">Tipos de Vínculo</a>
      </li>
    </ol>
  </nav>

  <x-flash-message status='success'  message='message' />

  <x-btn-group label='MenuPrincipal' class="py-1">

    @can('vinculotipo.create')
    <a class="btn btn-primary" href="{{ route('vinculotipos.create') }}" role="button"><x-icon icon='file-earmark'/> {{ __('New') }}</a>
    @endcan
     
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon icon='funnel'/> {{ __('Filters') }}</button>

    @can('vinculotipo.export')
    <x-dropdown-menu title='Reports' icon='printer'>

      <li>
        <a class="dropdown-item" href="{{route('vinculotipos.export.xls')}}"><x-icon icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' XLS' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('vinculotipos.export.csv')}}"><x-icon icon='file-earmark-spreadsheet-fill'/> {{ __('Export') . ' CSV' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('vinculotipos.export.pdf')}}"><x-icon icon='file-pdf-fill' /> {{ __('Export') . ' PDF' }}</a>
      </li>
    
    </x-dropdown-menu>
    @endcan

  </x-btn-group>
  
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>{{ __('Name') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($vinculotipos as $vinculotipo)
            <tr>
                <td class="text-nowrap">
                  {{$vinculotipo->nome}}
                </td>
                <td>
                  <x-btn-group label='Opções'>

                    @can('vinculotipo.edit')
                    <a href="{{route('vinculotipos.edit', $vinculotipo->id)}}" class="btn btn-primary btn-sm" role="button"><x-icon icon='pencil-square'/></a>
                    @endcan

                    @can('vinculotipo.delete')
                    <a href="{{route('vinculotipos.show', $vinculotipo->id)}}" class="btn btn-info btn-sm" role="button"><x-icon icon='eye'/></a>
                    @endcan

                  </x-btn-group>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  
  <x-pagination :query="$vinculotipos" />

</div>

<x-modal-filter :perpages="$perpages" icon='funnel' title='Filtros' />

@endsection
@section('script-footer')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var perpage = document.getElementById('perpage');
    perpage.addEventListener('change', function() {
        perpage = this.options[this.selectedIndex].value;
        window.open("{{ route('vinculotipos.index') }}" + "?perpage=" + perpage,"_self");
    });
});
</script>
@endsection