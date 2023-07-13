@extends('layouts.app')

@section('title', 'Vínculos - ' . __('Show'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('vinculos.index') }}">
          Vínculos
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<x-card title="Vínculos">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      {{ __('Name') . ' : ' . $vinculo->nome }}
    </li>
  </ul>
</x-card>

@can('vinculo.delete')
<x-btn-trash />
@endcan

<x-btn-back route="vinculos.index" />

@can('vinculo.delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('vinculos.destroy', $vinculo->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
