@extends('layouts.app')

@section('title', 'Cargos dos Profissionais  - ' . __('Edit'))

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{ route('cargos.index') }}">
          Cargos dos Profissionais
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

    <form method="POST" action="{{ route('cargos.update', $cargo->id) }}">
    @csrf
    @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label for="nome" class="form-label">{{ __('Name') }} <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') ?? $cargo->nome }}">
        @error('nome')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror 
      </div>

      <div class="col-md-6">
        <label for="cbo" class="form-label">CBO <strong  class="text-danger">(*)</strong></label>
        <input type="text" class="form-control @error('cbo') is-invalid @enderror" name="cbo" value="{{ old('cbo') ?? $cargo->cbo }}">
        @error('cbo')
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

<x-btn-back route="cargos.index" />
@endsection
