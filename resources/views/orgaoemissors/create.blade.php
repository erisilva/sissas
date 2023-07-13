@extends('layouts.app')

@section('title', 'Orgão Emissor - ' . __('New'))

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
      {{ __('New') }}
      </li>
    </ol>
  </nav>
</div>

<div class="container">
  <form method="POST" action="{{ route('orgaoemissors.store') }}">
    @csrf
    <div class="row g-3">
      <div class="col-md-6">
          <label for="nome" class="form-label">{{ __('Name') }} <strong  class="text-danger">(*)</strong></label>
          <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') ?? '' }}">
          @error('nome')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror      
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary"><x-icon icon='plus-circle' /> {{ __('Save') }}</button>  
      </div>
    </div>     
  </form>
</div>

<x-btn-back route="orgaoemissors.index" />
@endsection
