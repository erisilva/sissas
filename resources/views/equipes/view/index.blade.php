@extends('layouts.app')

@section('title', 'Mapa')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('equipeview.index') }}">
          <x-icon icon='compass' /> Mapa
        </a>
      </li>
    </ol>
  </nav>

  <x-flash-message status='success'  message='message' />

  <x-btn-group label='MenuPrincipal' class="py-1">
     
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon icon='funnel'/> {{ __('Filters') }}</button>

    @can('mapa-export')
    <x-dropdown-menu title='Reports' icon='printer'>

      <li>
        <a class="dropdown-item" href="{{route('equipeview.export.xls.simples', ['nome' => request()->input('nome'), 'matricula' => request()->input('matricula'), 'cpf' => request()->input('cpf'), 'cargo_id' => request()->input('cargo_id'), 'vinculo_id' => request()->input('vinculo_id'), 'vinculo_tipo_id' => request()->input('vinculo_tipo_id'), 'carga_horaria_id' => request()->input('carga_horaria_id'), 'equipe' => request()->input('equipe'), 'cnes' => request()->input('cnes'), 'ine' => request()->input('ine'), 'unidade' => request()->input('unidade'), 'distrito_id' => request()->input('distrito_id')])}}"><x-icon icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' XLS' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('equipeview.export.csv.simples', ['nome' => request()->input('nome'), 'matricula' => request()->input('matricula'), 'cpf' => request()->input('cpf'), 'cargo_id' => request()->input('cargo_id'), 'vinculo_id' => request()->input('vinculo_id'), 'vinculo_tipo_id' => request()->input('vinculo_tipo_id'), 'carga_horaria_id' => request()->input('carga_horaria_id'), 'equipe' => request()->input('equipe'), 'cnes' => request()->input('cnes'), 'ine' => request()->input('ine'), 'unidade' => request()->input('unidade'), 'distrito_id' => request()->input('distrito_id')])}}"><x-icon icon='file-earmark-spreadsheet-fill'/> {{ __('Export') . ' CSV' }}</a>
      </li>

      <li>
        <hr class="dropdown-divider">
      </li>

      <li>
        <a class="dropdown-item" href="{{route('equipeview.export.xls.completo', ['nome' => request()->input('nome'), 'matricula' => request()->input('matricula'), 'cpf' => request()->input('cpf'), 'cargo_id' => request()->input('cargo_id'), 'vinculo_id' => request()->input('vinculo_id'), 'vinculo_tipo_id' => request()->input('vinculo_tipo_id'), 'carga_horaria_id' => request()->input('carga_horaria_id'), 'equipe' => request()->input('equipe'), 'cnes' => request()->input('cnes'), 'ine' => request()->input('ine'), 'unidade' => request()->input('unidade'), 'distrito_id' => request()->input('distrito_id')])}}"><x-icon icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' XLS (Completo)' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{route('equipeview.export.csv.completo', ['nome' => request()->input('nome'), 'matricula' => request()->input('matricula'), 'cpf' => request()->input('cpf'), 'cargo_id' => request()->input('cargo_id'), 'vinculo_id' => request()->input('vinculo_id'), 'vinculo_tipo_id' => request()->input('vinculo_tipo_id'), 'carga_horaria_id' => request()->input('carga_horaria_id'), 'equipe' => request()->input('equipe'), 'cnes' => request()->input('cnes'), 'ine' => request()->input('ine'), 'unidade' => request()->input('unidade'), 'distrito_id' => request()->input('distrito_id')])}}"><x-icon icon='file-earmark-spreadsheet-fill'/> {{ __('Export') . ' CSV (Completo)' }}</a>
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
                <th>Vínculo</th>
                <th>Tipo</th>
                <th>CHR</th>
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
                <td>
                  @if ($equipeviewdata_item->profissional_id)
                      {{ $equipeviewdata_item->vinculo }}
                  @else
                      <span class="badge text-bg-info">Vaga Livre</span>                          
                  @endif
                </td>
                <td>
                  @if ($equipeviewdata_item->profissional_id)
                      {{ $equipeviewdata_item->tipo_de_vinculo }}
                  @else
                      <span class="badge text-bg-info">Vaga Livre</span>                          
                  @endif
                </td>

                <td>
                  @if ($equipeviewdata_item->profissional_id)
                      {{ $equipeviewdata_item->carga_horaria }}
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
                    <a href="{{route('equipeview.show', $equipeviewdata_item)}}" class="btn btn-info btn-sm" role="button"><x-icon icon='eye'/></a>
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
        
        <div class="col-md-6">
          <label for="nome" class="form-label">Profissional</label>
          <input type="text" class="form-control" id="nome" name="nome" value="{{ session()->get('equipe_view_nome') }}">
        </div>
  
        <div class="col-md-3">
          <label for="matricula" class="form-label">Matrícula</label>
          <input type="text" class="form-control" id="matricula" name="matricula" value="{{ session()->get('equipe_view_matricula') }}">
        </div>

        <div class="col-md-3">
          <label for="cpf" class="form-label">CPF</label>
          <input type="text" class="form-control" id="cpf" name="cpf" value="{{ session()->get('equipe_view_cpf') }}">
        </div>

        <div class="col-md-4">
          <label for="cargo_id" class="form-label">Cargo</label>
          <select class="form-select" id="cargo_id" name="cargo_id">
              <option value="" selected="true">Clique ...</option> 
              @foreach($cargos as $cargo)
              <option value="{{ $cargo->id }}" @selected(session()->get('equipe_view_cargo_id') == $cargo->id) >
                {{ $cargo->nome }}
              </option>
              @endforeach
          </select>
        </div>

        <div class="col-md-3">
          <label for="vinculo_id" class="form-label">Vínculo</label>
          <select class="form-select" id="vinculo_id" name="vinculo_id">
              <option value="" selected="true">Clique ...</option> 
              @foreach($vinculos as $vinculo)
              <option value="{{ $vinculo->id }}" @selected(session()->get('equipe_view_vinculo_id') == $vinculo->id) >
                {{ $vinculo->nome }}
              </option>
              @endforeach
          </select>
        </div>

        <div class="col-md-3">
          <label for="vinculo_tipo_id" class="form-label">Tipo de Vínculo</label>
          <select class="form-select" id="vinculo_tipo_id" name="vinculo_tipo_id">
              <option value="" selected="true">Clique ...</option> 
              @foreach($vinculo_tipos as $vinculotipo)
              <option value="{{ $vinculotipo->id }}" @selected(session()->get('equipe_view_vinculo_tipo_id') == $vinculotipo->id) >
                {{ $vinculotipo->nome }}
              </option>
              @endforeach
          </select>
        </div>

        <div class="col-md-2">
          <label for="carga_horaria_id" class="form-label">CHR</label>
          <select class="form-select" id="carga_horaria_id" name="carga_horaria_id">
              <option value="" selected="true">Clique ...</option> 
              @foreach($carga_horarias as $carga_horaria)
              <option value="{{ $carga_horaria->id }}" @selected(session()->get('equipe_view_carga_horaria_id') == $carga_horaria->id) >
                {{ $carga_horaria->nome }}
              </option>
              @endforeach
          </select>
        </div>

        <div class="col-md-4">
          <label for="equipe" class="form-label">Equipe</label>
          <input type="text" class="form-control" id="equipe" name="equipe" value="{{ session()->get('equipe_view_equipe') }}">
        </div>

        <div class="col-md-4">
          <label for="equipe_tipo_id" class="form-label">Tipo</label>
          <select class="form-select" id="equipe_tipo_id" name="equipe_tipo_id">
              <option value="" selected="true">Clique ...</option>
              @foreach($equipe_tipos as $equipe_tipo)
              <option value="{{ $equipe_tipo->id }}" @selected(session()->get('equipe_view_equipe_tipo_id') == $equipe_tipo->id) >
                {{ $equipe_tipo->nome }}
              </option>
              @endforeach
          </select>
        </div>

        <div class="col-md-2">
          <label for="numero" class="form-label">Nº</label>
          <input type="text" class="form-control" id="numero" name="numero" value="{{ session()->get('equipe_view_numero') }}">
        </div>
        
        <div class="col-md-2">
          <label for="cnes" class="form-label">CNES</label>
          <input type="text" class="form-control" id="cnes" name="cnes" value="{{ session()->get('equipe_view_cnes') }}">
        </div>

        <div class="col-md-2">
          <label for="ine" class="form-label">INE</label>
          <input type="text" class="form-control" id="ine" name="ine" value="{{ session()->get('equipe_view_ine') }}">
        </div>

        <div class="col-md-4">
          <label for="unidade" class="form-label">Unidade</label>
          <input type="text" class="form-control" id="unidade" name="unidade" value="{{ session()->get('equipe_view_unidade') }}">
        </div>

        <div class="col-md-4">
          <label for="distrito_id" class="form-label">Distrito</label>
          <select class="form-select" id="distrito_id" name="distrito_id">
              <option value="" selected="true">Clique ...</option>
              @foreach($distritos as $distrito)
              <option value="{{ $distrito->id }}" @selected(session()->get('equipe_view_distrito_id') == $equipe_tipo->id) >
                {{ $distrito->nome }}
              </option>
              @endforeach
          </select>
        </div>

        <div class="col-md-2">
          <label for="mostrar_vagas" class="form-label">Mostrar Vagas</label>
          <select class="form-select" id="mostrar_vagas" name="mostrar_vagas">
              <option value="1" @selected(session()->get('equipe_view_mostrar_vagas') == 1)>Todas</option>
              <option value="2" @selected(session()->get('equipe_view_mostrar_vagas') == 2)>Livres</option>
              <option value="3" @selected(session()->get('equipe_view_mostrar_vagas') == 3)>Preenchidas</option>
          </select>
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search'/> {{ __('Search') }}</button>
      
          {{-- Reset the Filter --}}
          <a href="{{ route('equipeview.index', ['nome' => '', 'matricula' => '', 'cpf' => '', 'cargo_id' => '', 'vinculo_id' => '', 'vinculo_tipo_id' => '', 'carga_horaria_id' => '', 'equipe' => '', 'equipe_tipo_id' => '', 'numero' => '', 'cnes' => '', 'ine' => '', 'unidade' => '', 'distrito_id' => '', 'mostrar_vagas' => '1']) }}" class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars'/> {{ __('Reset') }}</a>
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