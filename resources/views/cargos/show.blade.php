@extends('layouts.app')

@section('title', 'Cargos dos Profissionais  - ' . __('Show'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('cargos.index') }}">
          cargos
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<x-card title="cargo">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      {{ __('Name') . ' : ' . $cargo->nome }}
    </li>
    <li class="list-group-item">
      {{ 'CBO : ' . $cargo->cbo }}
    </li>
  </ul>
</x-card>

@can('cargo.delete')
<x-btn-trash />
@endcan

<x-btn-back route="cargos.index" />

@can('cargo.delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('cargos.destroy', $cargo->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
