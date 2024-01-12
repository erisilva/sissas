<?php

namespace App\Http\Controllers;

use App\Models\EquipeView;
use App\Models\Perpage;
use App\Models\Cargo;
use App\Models\EquipeTipo;
use App\Models\Distrito;
use Illuminate\Http\Request;

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

                // nome (do profissional)
        // matricula
        // cpf
        // cargo_id
        // equipe (descricao)
        // equipe_tipo_id
        // numero
        // cnes
        // ine
        // unidade (descricao)
        // distrito_id
        // mostrar_vagas (1=todas, 2= somente vagas, 3= somente ocupadas)

        return view('equipes.view.index', [
            'equipeviewdata' => EquipeView::orderBy('equipe_id', 'asc')->filter(request(['nome','matricula', 'cpf', 'cargo_id', 'equipe', 'equipe_tipo_id', 'numero', 'cnes', 'ine', 'unidade', 'distrito_id', 'mostrar_vagas']))->paginate(session('perPage', '5'))->appends(request(['nome','matricula', 'cpf', 'cargo_id', 'equipe', 'equipe_tipo_id', 'numero', 'cnes', 'ine', 'unidade', 'distrito_id', 'mostrar_vagas'])),
            'perpages' => Perpage::orderBy('valor')->get(),
            'cargos' => Cargo::orderBy('nome')->get(),
            'equipe_tipos' => EquipeTipo::orderBy('nome')->get(),
            'distritos' => auth()->user()->distritos->sortBy('nome'),
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
}
