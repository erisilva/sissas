@extends('layouts.app')

@section('title', 'Tipos de Capacitação')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('capacitacaotipos.index') }}">Tipos de Capacitação</a>
      </li>
    </ol>
  </nav>

  <x-flash-message status='success'  message='message' />

  <x-btn-group label='MenuPrincipal' class="py-1">

    @can('capacitacaotipo.create')
    <a class="btn btn-primary" href="{{ route('capacitacaotipos.create') }}" role="button"><x-icon icon='file-earmark'/> {{ __('New') }}</a>
    @endcan
     
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon icon='funnel'/> {{ __('Filters') }}</button>

    @can('capacitacaotipo.export')
    <x-dropdown-menu title='Reports' icon='printer'>

      <li>
        <a class="dropdown-item" href="{{route('capacitacaotipos.export.xls')}}"><x-icon icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' XLS' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('capacitacaotipos.export.csv')}}"><x-icon icon='file-earmark-spreadsheet-fill'/> {{ __('Export') . ' CSV' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('capacitacaotipos.export.pdf')}}"><x-icon icon='file-pdf-fill' /> {{ __('Export') . ' PDF' }}</a>
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
            @foreach($capacitacaotipos as $capacitacaotipo)
            <tr>
                <td class="text-nowrap">
                  {{ $capacitacaotipo->nome }}
                </td>
                <td>
                  <x-btn-group label='Opções'>

                    @can('capacitacaotipo.edit')
                    <a href="{{route('capacitacaotipos.edit', $capacitacaotipo->id)}}" class="btn btn-primary btn-sm" role="button"><x-icon icon='pencil-square'/></a>
                    @endcan

                    @can('capacitacaotipo.delete')
                    <a href="{{route('capacitacaotipos.show', $capacitacaotipo->id)}}" class="btn btn-info btn-sm" role="button"><x-icon icon='eye'/></a>
                    @endcan

                  </x-btn-group>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  
  <x-pagination :query="$capacitacaotipos" />

</div>

<x-modal-filter :perpages="$perpages" icon='funnel' title='Filtros' />

@endsection
@section('script-footer')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var perpage = document.getElementById('perpage');
    perpage.addEventListener('change', function() {
        perpage = this.options[this.selectedIndex].value;
        window.open("{{ route('capacitacaotipos.index') }}" + "?perpage=" + perpage,"_self");
    });
});
</script>
@endsection