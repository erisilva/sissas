@extends('layouts.app')

@section('title', 'Vínculos - ' . __('Edit'))

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
        {{ __('Edit') }}
      </li>
    </ol>
  </nav>
</div>

<div class="container">
    <x-flash-message status='success'  message='message' />

    <form method="POST" action="{{ route('vinculos.update', $vinculo->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label for="nome" class="form-label">{{ __('Name') }} <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') ?? $vinculo->nome }}">
        @error('nome')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror 
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">
          <x-icon icon='pencil-square' />{{ __('Edit') }}
        </button> 
      </div>  
    </div>  
   </form>
</div>

<x-btn-back route="vinculos.index" />
@endsection
