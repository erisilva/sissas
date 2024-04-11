@extends('layouts.app')

@section('title', 'Profissionais - Lixeira' )

@section('content')
<div class="container-fluid">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ route('profissionals.index') }}">
            <x-icon icon='file-person' /> Profissionais
          </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          <a href="{{ route('profissionals.trash') }}">
            <x-icon icon='trash' /> Lixeira
          </a>
        </li>
      </ol>
    </nav>
    
    <x-flash-message status='success'  message='message' />

    <x-btn-group label='MenuPrincipal' class="py-1">
       
      <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon icon='funnel'/> {{ __('Filters') }}</button>
  
      @can('profissional.export')
      <x-dropdown-menu title='Reports' icon='printer'>
  
        <li>
          <a class="dropdown-item" href="{{route('profissionals.export.xls', ['nome' => request()->input('nome'), 'matricula' => request()->input('matricula'), 'cpf' => request()->input('cpf'), 'cns' => request()->input('cns'), 'cargo_id' => request()->input('cargo_id'), 'vinculo_id' => request()->input('vinculo_id'), 'vinculo_tipo_id' => request()->input('vinculo_tipo_id'), 'carga_horaria_id' => request()->input('carga_horaria_id'), 'flexibilizacao' => request()->input('flexibilizacao')])}}"><x-icon icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' XLS' }}</a>
        </li>
        
        <li>
          <a class="dropdown-item" href="{{route('profissionals.export.csv', ['nome' => request()->input('nome'), 'matricula' => request()->input('matricula'), 'cpf' => request()->input('cpf'), 'cns' => request()->input('cns'), 'cargo_id' => request()->input('cargo_id'), 'vinculo_id' => request()->input('vinculo_id'), 'vinculo_tipo_id' => request()->input('vinculo_tipo_id'), 'carga_horaria_id' => request()->input('carga_horaria_id'), 'flexibilizacao' => request()->input('flexibilizacao')])}}"><x-icon icon='file-earmark-spreadsheet-fill'/> {{ __('Export') . ' CSV' }}</a>
        </li>
  
        <li>
          <a class="dropdown-item" href="{{route('profissionals.export.pdf', ['nome' => request()->input('nome'), 'matricula' => request()->input('matricula'), 'cpf' => request()->input('cpf'), 'cns' => request()->input('cns'), 'cargo_id' => request()->input('cargo_id'), 'vinculo_id' => request()->input('vinculo_id'), 'vinculo_tipo_id' => request()->input('vinculo_tipo_id'), 'carga_horaria_id' => request()->input('carga_horaria_id'), 'flexibilizacao' => request()->input('flexibilizacao')])}}"><x-icon icon='file-pdf-fill' /> {{ __('Export') . ' PDF' }}</a>
        </li>
      
      </x-dropdown-menu>
      @endcan
  
    </x-btn-group>
    
    <div class="table-responsive">
      <table class="table table-striped">
          <thead>
              <tr>
                  <th>{{ __('Name') }}</th>                
                  <th>Matricula</th>
                  <th>CPF</th>
                  <th>CNS</th>
                  <th>Cargo</th>
                  <th>Vínculo</th>
                  <th>Tipo</th>
                  <th>CHR</th>
                  <th>Flex.</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
              @foreach($profissionals as $professional)
              <tr>
                  <td class="text-nowrap">
                    <strong class="text-danger">{{ $professional->nome }}</strong>
                  </td>                
                  <td class="text-nowrap">
                    {{ $professional->matricula }}
                  </td>
                  <td class="text-nowrap">
                    {{ $professional->cpf }}
                  </td>
                  <td class="text-nowrap">
                    {{ $professional->cns }}
                  </td>
                  <td class="text-nowrap">
                    {{ $professional->cargo->nome }}
                  </td>
                  <td class="text-nowrap">
                    {{ $professional->vinculo->nome }}
                  </td>
                  <td class="text-nowrap">
                    {{ $professional->vinculoTipo->nome }}
                  </td>
                  <td class="text-nowrap">
                    {{ $professional->cargaHoraria->nome }}
                  </td>
                  <td class="text-nowrap">
                    {{ $professional->flexibilizacao }}
                  </td>
                  <td>
                    <x-btn-group label='Opções'>
  
                      @can('profissional.trash.index')
                      <a href="{{route('profissionals.trash.show', $professional->id)}}" class="btn btn-info btn-sm" role="button"><x-icon icon='eye'/></a>
                      @endcan
  
                    </x-btn-group>
                  </td>
              </tr>    
              @endforeach                                                 
          </tbody>
      </table>
    </div>
    
    <x-pagination :query="$profissionals" />
  
  </div>
  
  <x-modal-filter class="modal-lg" :perpages="$perpages" icon='funnel' title='Filtros'>
  
    <div class="container">
      <form method="GET" action="{{ route('profissionals.trash') }}">
  
        <div class="row g-3">
          <div class="col-md-4">
            <label for="nome" class="form-label">{{ __('Name') }}</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ session()->get('profissional_nome') }}">
          </div>
          <div class="col-md-4">
            <label for="matricula" class="form-label">Matrícula</label>
          <input type="text" class="form-control" id="matricula" name="matricula" value="{{ session()->get('profissional_matricula') }}">
          </div>
          <div class="col-md-4">
            <label for="cpf" class="form-label">CPF</label>
          <input type="text" class="form-control" id="cpf" name="cpf" value="{{ session()->get('profissional_cpf') }}">
          </div>
          <div class="col-md-4">
            <label for="cns" class="form-label">CNS</label>
          <input type="text" class="form-control" id="cns" name="cns" value="{{ session()->get('profissional_cns') }}">
          </div>
          <div class="col-md-4">
            <label for="cargo_id" class="form-label">Cargo</label>
            <select class="form-select" id="cargo_id" name="cargo_id">
                <option value="" selected="true">Clique ...</option> 
                @foreach($cargos as $cargo)
                <option value="{{ $cargo->id }}" @selected(session()->get('profissional_cargo_id') == $cargo->id) >
                  {{ $cargo->nome }}
                </option>
                @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="vinculo_id" class="form-label">Vínculo</label>
            <select class="form-select" id="vinculo_id" name="vinculo_id">
                <option value="" selected="true">Clique ...</option> 
                @foreach($vinculos as $vinculo)
                <option value="{{ $vinculo->id }}" @selected(session()->get('profissional_vinculo_id') == $vinculo->id) >
                  {{ $vinculo->nome }}
                </option>
                @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="vinculo_tipo_id" class="form-label">Tipo Vínculo</label>
            <select class="form-select" id="vinculo_tipo_id" name="vinculo_tipo_id">
                <option value="" selected="true">Clique ...</option> 
                @foreach($vinculotipos as $vinculo_tipo)
                <option value="{{ $vinculo_tipo->id }}" @selected(session()->get('profissional_vinculo_tipo_id') == $vinculo_tipo->id) >
                  {{ $vinculo_tipo->nome }}
                </option>
                @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <label for="carga_horaria_id" class="form-label">Carga Horária</label>
            <select class="form-select" id="carga_horaria_id" name="carga_horaria_id">
                <option value="" selected="true">Clique ...</option> 
                @foreach($cargahorarias as $cargahoraria)
                <option value="{{ $cargahoraria->id }}" @selected(session()->get('profissional_carga_horaria_id') == $cargahoraria->id) >
                  {{ $cargahoraria->nome }}
                </option>
                @endforeach
            </select>
          </div>
  
          <div class="col-md-4">
            <label for="flexibilizacao" class="form-label">Flexibilização</label>
            <select class="form-select" id="flexibilizacao" name="flexibilizacao">
                <option value="" selected="true">Clique ...</option>
                <option value="Nenhum" @selected(session()->get('profissional_flexibilizacao') == 'Nenhum') >Nenhum</option>
                <option value="Extensão" @selected(session()->get('profissional_flexibilizacao') == 'Extensão') >Extensão</option>
                <option value="Redução" @selected(session()->get('profissional_flexibilizacao') == 'Redução') >Redução</option>
            </select>
          </div>
  
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search'/> {{ __('Search') }}</button>
        
            {{-- Reset the Filter --}}
            <a href="{{ route('profissionals.trash', ['nome' => '', 'matricula' => '', 'cpf' => '', 'cms' => '', 'cargo_id' => '', 'vinculo_id' => '', 'vinculo_tipo_id' => '', 'carga_horaria_id' => '', 'flexibilizacao' => '']) }}" class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars'/> {{ __('Reset') }}</a>
          </div> 
        </div> 
      </form>
    </div>  
  
  </x-modal-filter>  
  
  @endsection
  @section('script-footer')
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      var perpage = document.getElementById('perpage');
      perpage.addEventListener('change', function() {
          perpage = this.options[this.selectedIndex].value;
          window.open("{{ route('profissionals.trash') }}" + "?perpage=" + perpage,"_self");
      });
  });
  </script>
  @endsection