@extends('layouts.app')

@section('title', 'Tipos de Licenças - ' . __('Show'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('licencatipos.index') }}">
          Tipos de Licenças
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<x-card title="Tipos de Licenças">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      {{ __('Name') . ' : ' . $licencatipo->nome }}
    </li>
  </ul>
</x-card>

@can('licencatipo.delete')
<x-btn-trash />
@endcan

<x-btn-back route="licencatipos.index" />

@can('licencatipo.delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('licencatipos.destroy', $licencatipo->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
