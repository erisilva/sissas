<?php

namespace App\Http\Controllers;

use App\Models\EquipeView;
use App\Models\Perpage;
use App\Models\Cargo;
use App\Models\EquipeTipo;
use App\Models\Distrito;
use App\Models\Vinculo;
use App\Models\VinculoTipo;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\EquipeViewSimplesExport;
use App\Exports\EquipeViewCompletoExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class EquipeViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('mapa.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('equipes.view.index', [
            'equipeviewdata' => EquipeView::orderBy('equipe_id', 'asc')->filter(request(['nome','matricula', 'cpf', 'cargo_id', 'vinculo_id', 'vinculo_tipo_id', 'equipe', 'equipe_tipo_id', 'numero', 'cnes', 'ine', 'unidade', 'distrito_id', 'mostrar_vagas']))->paginate(session('perPage', '5'))->appends(request(['nome','matricula', 'cpf', 'cargo_id', 'vinculo_id', 'vinculo_tipo_id', 'equipe', 'equipe_tipo_id', 'numero', 'cnes', 'ine', 'unidade', 'distrito_id', 'mostrar_vagas'])),
            'perpages' => Perpage::orderBy('valor')->get(),
            'cargos' => Cargo::orderBy('nome')->get(),
            'equipe_tipos' => EquipeTipo::orderBy('nome')->get(),
            'distritos' => auth()->user()->distritos->sortBy('nome'),
            'vinculos' => Vinculo::orderBy('nome')->get(),
            'vinculo_tipos' => VinculoTipo::orderBy('nome')->get(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipeView $equipeView)
    {
        $this->authorize('mapa.show');

        return view('equipes.view.show', compact('equipeView'));
    }


    /**
     * Export the specified resource to Excel.
     */
    public function exportcsvsimples() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('mapa.export');

        return Excel::download(new EquipeViewSimplesExport(request(['nome','matricula', 'cpf', 'cargo_id', 'vinculo_id', 'vinculo_tipo_id', 'equipe', 'equipe_tipo_id', 'numero', 'cnes', 'ine', 'unidade', 'distrito_id', 'mostrar_vagas'])),  'Mapa_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxlssimples() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('mapa.export');

        return Excel::download(new EquipeViewSimplesExport(request(['nome','matricula', 'cpf', 'cargo_id', 'vinculo_id', 'vinculo_tipo_id', 'equipe', 'equipe_tipo_id', 'numero', 'cnes', 'ine', 'unidade', 'distrito_id', 'mostrar_vagas'])),  'Mapa_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

        /**
     * Export the specified resource to Excel.
     */
    public function exportcsvcompleto() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('mapa.export');

        return Excel::download(new EquipeViewCompletoExport(request(['nome','matricula', 'cpf', 'cargo_id', 'vinculo_id', 'vinculo_tipo_id', 'equipe', 'equipe_tipo_id', 'numero', 'cnes', 'ine', 'unidade', 'distrito_id', 'mostrar_vagas'])),  'Mapa_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxlscompleto() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('mapa.export');

        return Excel::download(new EquipeViewCompletoExport(request(['nome','matricula', 'cpf', 'cargo_id', 'vinculo_id', 'vinculo_tipo_id', 'equipe', 'equipe_tipo_id', 'numero', 'cnes', 'ine', 'unidade', 'distrito_id', 'mostrar_vagas'])),  'Mapa_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
