@extends('layouts.app')

@section('title', 'Profissionais e Equipes')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('equipeview.index') }}">
          Profissionais e Equipes
        </a>
      </li>
    </ol>
  </nav>

  <x-flash-message status='success'  message='message' />

  <x-btn-group label='MenuPrincipal' class="py-1">
     
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon icon='funnel'/> {{ __('Filters') }}</button>

    @can('permission-export')
    <x-dropdown-menu title='Reports' icon='printer'>

      <li>
        <a class="dropdown-item" href="{{route('equipeview.export.xls', ['description' => request()->input('description'), 'name' => request()->input('name')])}}"><x-icon icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' XLS' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('equipeview.export.csv', ['description' => request()->input('description'), 'name' => request()->input('name')])}}"><x-icon icon='file-earmark-spreadsheet-fill'/> {{ __('Export') . ' CSV' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('equipeview.export.pdf', ['description' => request()->input('description'), 'name' => request()->input('name')])}}"><x-icon icon='file-pdf-fill' /> {{ __('Export') . ' PDF' }}</a>
      </li>
    
    </x-dropdown-menu>
    @endcan

  </x-btn-group>
  
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Profissional</th>
                <th>Matrícula</th>
                <th>CPF</th>
                <th>Cargo</th>
                <th>Equipe</th>
                <th>Tipo</th>
                <th>Nº</th>
                <th>CNES</th>
                <th>INE</th>
                <th>Unidade</th>
                <th>Distrito</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipeviewdata as $equipeviewdata_item)
            <tr>
                <td>
                  @if ($equipeviewdata_item->profissional_id)
                      {{ $equipeviewdata_item->nome }}
                  @else
                      <span class="badge text-bg-info">Vaga Livre</span>                         
                  @endif
                </td>
                <td>
                  @if ($equipeviewdata_item->profissional_id)
                      {{ $equipeviewdata_item->matricula }}
                  @else
                      <span class="badge text-bg-info">Vaga Livre</span>                         
                  @endif
                </td>
                <td>
                  @if ($equipeviewdata_item->profissional_id)
                      {{ $equipeviewdata_item->cpf }}
                  @else
                      <span class="badge text-bg-info">Vaga Livre</span>                          
                  @endif
                </td>
                
                <td class="text-nowrap">
                  {{ $equipeviewdata_item->cargo }}
                </td>

                <td class="text-nowrap">
                  {{ $equipeviewdata_item->equipe }}
                </td>

                <td class="text-nowrap">
                  {{ $equipeviewdata_item->equipe_tipo }}
                </td>

                <td class="text-nowrap">
                  {{ $equipeviewdata_item->equipe_numero }}
                </td>

                <td class="text-nowrap">
                  {{ $equipeviewdata_item->cnes }}
                </td>

                <td class="text-nowrap">
                  {{ $equipeviewdata_item->ine }}
                </td>

                <td class="text-nowrap">
                  {{ $equipeviewdata_item->unidade }}
                </td>

                <td class="text-nowrap">
                  {{ $equipeviewdata_item->distrito }}
                </td>

                <td>
                  <x-btn-group label='Opções'>



                    @can('gestao.equipe.show')
                    <a href="{{route('equipeview.show', $equipeviewdata_item->id)}}" class="btn btn-info btn-sm" role="button"><x-icon icon='eye'/></a>
                    @endcan

                  </x-btn-group>
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  
  <x-pagination :query="$equipeviewdata" />

</div>


{{-- Modal Filter --}}

<x-modal-filter class="modal-xl" :perpages="$perpages" icon='funnel' title='Filters'>

  <form method="GET" action="{{ route('equipeview.index') }}">
    
    <div class="row g-3">
        
        <div class="col-md-4">
          <label for="nome" class="form-label">Profissional</label>
          <input type="text" class="form-control" id="nome" name="nome" value="{{ session()->get('equipe_view_nome') }}">
        </div>
  
        <div class="col-md-2">
          <label for="matricula" class="form-label">Matrícula</label>
          <input type="text" class="form-control" id="matricula" name="matricula" value="{{ session()->get('equipe_view_matricula') }}">
        </div>

        <div class="col-md-2">
          <label for="cpf" class="form-label">CPF</label>
          <input type="text" class="form-control" id="cpf" name="cpf" value="{{ session()->get('equipe_view_cpf') }}">
        </div>

        <div class="col-md-4">
          <label for="cargo_id" class="form-label">Cargo</label>
          <select class="form-control" id="cargo_id" name="cargo_id">
              <option value="" selected="true">Clique ...</option> 
              @foreach($cargos as $cargo)
              <option value="{{ $cargo->id }}" @selected(session()->get('equipe_view_cargo_id') == $cargo->id) >
                {{ $cargo->nome }}
              </option>
              @endforeach
          </select>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label for="cargo" class="form-label">Cargo</label>
            <input type="text" class="form-control" id="cargo" name="cargo" value="{{ session()->get('equipe_view_cargo') }}">
          </div>
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search'/> {{ __('Search') }}</button>
      
          {{-- Reset the Filter --}}
          <a href="{{ route('equipeview.index', ['nome' => '', 'matricula' => '', 'cargo_id' => '', 'vinculo_id' => '']) }}" class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars'/> {{ __('Reset') }}</a>
        </div>

    </div>

  </form>

</x-modal-filter>  

@endsection
@section('script-footer')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var perpage = document.getElementById('perpage');
    perpage.addEventListener('change', function() {
        perpage = this.options[this.selectedIndex].value;
        window.open("{{ route('equipeview.index') }}" + "?perpage=" + perpage,"_self");
    });
});
</script>
@endsection