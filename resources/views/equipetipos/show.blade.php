@extends('layouts.app')

@section('title', 'Tipos de Equipe - ' . __('Show'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('equipetipos.index') }}">
          Tipos de Equipe
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<x-card title="Tipos de Equipe">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      {{ __('Name') . ' : ' . $equipetipo->nome }}
    </li>
  </ul>
</x-card>

@can('equipetipo.delete')
<x-btn-trash />
@endcan

<x-btn-back route="equipetipos.index" />

@can('equipetipo.delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{ route('equipetipos.destroy', $equipetipo->id) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
