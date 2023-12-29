<?php

namespace App\Http\Controllers;

use App\Models\EquipeView;
use App\Models\Perpage;
use App\Models\Cargo;
use Illuminate\Http\Request;

class EquipeViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('gestao.equipe.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('equipes.view.index', [
            'equipeviewdata' => EquipeView::orderBy('equipe_id', 'asc')->filter(request(['name','description']))->paginate(session('perPage', '5'))->appends(request(['name', 'description'])),
            'perpages' => Perpage::orderBy('valor')->get(),
            'cargos' => Cargo::orderBy('nome')->get(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipeView $equipeView)
    {
        $this->authorize('gestao.equipe.show');

        return view('equipes.view.show', compact('equipeView'));
    }
}
