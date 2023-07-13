@extends('layouts.app')

@section('title', 'Carga Horárias' . __('Show'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('cargahorarias.index') }}">
          Carga Horárias
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<x-card title="Carga Horárias">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      {{ __('Name') . ' : ' . $cargahoraria->nome }}
    </li>
  </ul>
</x-card>

@can('cargahoraria.delete')
<x-btn-trash />
@endcan

<x-btn-back route="cargahorarias.index" />

@can('cargahoraria.delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('cargahorarias.destroy', $cargahoraria)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
