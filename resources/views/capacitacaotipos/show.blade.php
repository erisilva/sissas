@extends('layouts.app')

@section('title', 'Tipos de Capacitação - ' . __('Show'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('capacitacaotipos.index') }}">
          Tipos de Capacitação
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<x-card title="Tipos de Capacitação">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      {{ __('Name') . ' : ' . $capacitacaotipo->nome }}
    </li>
  </ul>
</x-card>

@can('capacitacaotipo.delete')
<x-btn-trash />
@endcan

<x-btn-back route="capacitacaotipos.index" />

@can('capacitacaotipo.delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('capacitacaotipos.destroy', $capacitacaotipo->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
