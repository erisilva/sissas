@extends('layouts.app')

@section('title', 'Orgão Emissor - ' . __('Show'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('orgaoemissors.index') }}">
          Orgão Emissor
        </a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        {{ __('Show') }}
      </li>
    </ol>
  </nav>
</div>

<x-card title="orgão Emissor">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      {{ __('Name') . ' : ' . $orgaoemissor->nome }}
    </li>
  </ul>
</x-card>

@can('orgaoemissor.delete')
<x-btn-trash />
@endcan

<x-btn-back route="orgaoemissors.index" />

@can('orgaoemissor.delete')
<x-modal-trash class="modal-sm">
  <form method="post" action="{{route('orgaoemissors.destroy', $orgaoemissor->id)}}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">
      <x-icon icon='trash' /> {{ __('Delete this record?') }}
    </button>
  </form>
</x-modal-trash>
@endcan

@endsection
