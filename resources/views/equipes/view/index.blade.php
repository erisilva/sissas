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
                      <span class="fw-light">-</span>                          
                  @endif
                </td>
                <td>
                  @if ($equipeviewdata_item->profissional_id)
                      {{ $equipeviewdata_item->cpf }}
                  @else
                      <span class="fw-light">-</span>                          
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

<x-modal-filter class="modal-lg" :perpages="$perpages" icon='funnel' title='Filters'>

  <form method="GET" action="{{ route('equipeview.index') }}">
    
    <div class="row g-3">
        
        <div class="col-md-6">
          <div class="mb-3">
            <label for="nome" class="form-label">Profissional</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{ session()->get('equipe_view_nome') }}">
          </div>
        </div>
  
        <div class="col-md-6">
          <div class="mb-3">
            <label for="matricula" class="form-label">Matrícula</label>
            <input type="text" class="form-control" id="matricula" name="matricula" value="{{ session()->get('equipe_view_matricula') }}">
          </div>
        </div>



    </div>  



    <div class="mb-3">
      <label for="name" class="form-label">{{ __('Name') }}</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ session()->get('permission_name') }}">
    </div>
    
    <div class="mb-3">
      <label for="description" class="form-label">{{ __('Description') }}</label>
      <input type="text" class="form-control" id="description" name="description" value="{{ session()->get('permission_description') }}">
    </div>
    
    <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search'/> {{ __('Search') }}</button>
    
    <a href="{{ route('equipeview.index', ['name' => '', 'description' => '']) }}" class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars'/> {{ __('Reset') }}</a>

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