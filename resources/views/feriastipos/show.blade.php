@extends('layouts.app')

@section('title', 'Tipo de Férias - ' . __('Show'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('feriastipos.index') }}">
          Tipos de Férias
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<x-card title="Tipo de Férias">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      {{ __('Name') . ' : ' . $feriastipo->nome }}
    </li>
  </ul>
</x-card>

@can('feriastipo.delete')
<x-btn-trash />
@endcan

<x-btn-back route="feriastipos.index" />

@can('feriastipo.delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('feriastipos.destroy', $feriastipo->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
