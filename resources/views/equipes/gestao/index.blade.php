@extends('layouts.app')

@section('title', 'Equipes')

@section('content')
<div class="container-fluid">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <a href="{{ route('equipegestao.index') }}">
          <x-icon icon='people' /> Equipes
        </a>
      </li>
    </ol>
  </nav>

  <x-flash-message status='success'  message='message' />

  <x-btn-group label='MenuPrincipal' class="py-1">
     
    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalFilter"><x-icon icon='funnel'/> {{ __('Filters') }}</button>

    @can('equipe.export')
    <x-dropdown-menu title='Reports' icon='printer'>
      {{-- compact(request()->input(['descricao', 'cnes', ...]))  --}}
      <li>
        <a class="dropdown-item" href="{{ route('equipegestao.export.xls', ['descricao' => request()->input('descricao'), 'numero' => request()->input('numero'), 'cnes' => request()->input('cnes'), 'ine' => request()->input('ine'), 'minima' => request()->input('minima'), 'unidade' => request()->input('unidade'), 'distrito' => request()->input('distrito'), 'tipo' => request()->input('tipo')]) }}"><x-icon icon='file-earmark-spreadsheet-fill' /> {{ __('Export') . ' XLS' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('equipegestao.export.csv', ['descricao' => request()->input('descricao'), 'numero' => request()->input('numero'), 'cnes' => request()->input('cnes'), 'ine' => request()->input('ine'), 'minima' => request()->input('minima'), 'unidade' => request()->input('unidade'), 'distrito' => request()->input('distrito'), 'tipo' => request()->input('tipo')]) }}"><x-icon icon='file-earmark-spreadsheet-fill'/> {{ __('Export') . ' CSV' }}</a>
      </li>
      <li>
        <a class="dropdown-item" href="{{ route('equipegestao.export.pdf', ['descricao' => request()->input('descricao'), 'numero' => request()->input('numero'), 'cnes' => request()->input('cnes'), 'ine' => request()->input('ine'), 'minima' => request()->input('minima'), 'unidade' => request()->input('unidade'), 'distrito' => request()->input('distrito'), 'tipo' => request()->input('tipo')]) }}"><x-icon icon='file-pdf-fill' /> {{ __('Export') . ' PDF' }}</a>
      </li>
    
    </x-dropdown-menu>
    @endcan

  </x-btn-group>
  
  <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th><strong>Tipo</strong></th>
                <th>Descrição</th>
                <th>Nº</th>
                <th>CNES</th>
                <th>INE</th>
                <th>Unidade</th>
                <th>Distrito</th>
                <th>Mínima</th>
                <th class="text-end">Total</th>
                <th class="text-end">Preenchidas</th>
                <th class="text-end">Livres</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipes as $equipe)
            <tr>
                <td>
                  <strong>
                    {{ $equipe->equipeTipo->nome }}
                  </strong>
                </td>
                <td>
                  {{ $equipe->descricao }}
                </td>
                <td class="text-nowrap">
                  {{ $equipe->numero }}
                </td>
                <td class="text-nowrap">
                  {{ $equipe->cnes }}
                </td>
                <td class="text-nowrap">
                  {{ $equipe->ine }}
                </td>                
                <td>
                  {{ $equipe->unidade->nome }}
                </td>
                <td>
                  {{ $equipe->unidade->distrito->nome }}
                </td>
                <td class="text-nowrap">
                  {{ ($equipe->minima  == 's' ? 'Sim' : 'Não' ) }}
                </td>
                <td class="text-end">
                  {{ $equipe->total_vagas }}
                </td>
                <td class="text-end">
                  {{ $equipe->vagas_preenchidas }}
                </td>
                <td class="text-end">
                  {{ $equipe->vagas_disponiveis }}
                </td>
                <td>
                  @can('gestao.equipe.show')
                  <x-btn-group label='Opções'>
                    <a href="{{ route('equipegestao.show', $equipe->id) }}" class="btn btn-info btn-sm" role="button"><x-icon icon='eye'/></a>
                  </x-btn-group>
                  @endcan
                </td>
            </tr>    
            @endforeach                                                 
        </tbody>
    </table>
  </div>
  
  <x-pagination :query="$equipes" />

</div>

<x-modal-filter class="modal-xl" :perpages="$perpages" icon='funnel' title='Filters'>

  <div class="container">
    <form method="GET" action="{{ route('equipegestao.index') }}">



      <div class="row g-3">


        <div class="col-md-4">
          <label for="tipo" class="form-label">Tipo</label>
          <select class="form-select" id="tipo" name="tipo">
              <option value="" selected="true">Mostrar Todos ...</option> 
              @foreach($equipetipos as $equipetipo)
              <option value="{{ $equipetipo->id }}" @selected(session()->get('equipe_tipo') == $equipetipo->id) >
                {{ $equipetipo->nome }}
              </option>
              @endforeach
          </select>
        </div>

        <div class="col-md-8">
          <label for="descricao" class="form-label">Descrição</label>
          <input type="text" class="form-control" id="descricao" name="descricao" value="{{ session()->get('equipe_descricao') }}">
        </div>


        <div class="col-md-4">
          <label for="numero" class="form-label">Número</label>
          <input type="text" class="form-control" id="numero" name="numero" value="{{ session()->get('equipe_numero') }}">
        </div>

        <div class="col-md-4">
          <label for="cnes" class="form-label">CNES</label>
          <input type="text" class="form-control" id="cnes" name="cnes" value="{{ session()->get('equipe_cnes') }}">
        </div>

        <div class="col-md-4">
          <label for="ine" class="form-label">INE</label>
          <input type="text" class="form-control" id="ine" name="ine" value="{{ session()->get('equipe_ine') }}">
        </div>

        <div class="col-md-6">
          <label for="unidade" class="form-label">Unidade</label>
          <input type="text" class="form-control" id="unidade" name="unidade" value="{{ session()->get('equipe_unidade') }}">
        </div>

        <div class="col-md-4">
          <label for="distrito" class="form-label">Distrito</label>
          <select class="form-select" id="distrito" name="distrito">
              <option value="" selected="true">Mostrar Todos ...</option> 
              @foreach($distritos as $distrito)
              <option value="{{ $distrito->id }}" @selected(session()->get('equipe_distrito') == $distrito->id) >
                {{ $distrito->nome }}
              </option>
              @endforeach
          </select>
        </div>

        <div class="col-md-2">
          <label for="minima" class="form-label">Mínima</label>
          <select class="form-select" aria-label="Mínima filtro"  name="minima" id="minima">  
            <option value="">Mostrar todos</option>         
            <option value="s" @checked(session()->get('equipe_minima') == 's')>Sim</option>
            <option value="n" @checked(session()->get('equipe_minima') == 'n')>Não</option>
          </select>
        </div>
        
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-sm"><x-icon icon='search'/> {{ __('Search') }}</button>
      
          {{-- Reset the Filter --}}
          <a href="{{ route('equipes.index', ['descricao' => '', 'numero' => '', 'cnes' => '', 'ine' => '', 'minima' => '', 'unidade' => '', 'distrito' => '', 'tipo' => '' ]) }}" class="btn btn-secondary btn-sm" role="button"><x-icon icon='stars'/> {{ __('Reset') }}</a>
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
        window.open("{{ route('equipegestao.index') }}" + "?perpage=" + perpage,"_self");
    });
});
</script>
@endsection