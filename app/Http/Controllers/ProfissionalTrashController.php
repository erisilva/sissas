<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use App\Models\Perpage;
use App\Models\Cargo;
use App\Models\Vinculo;
use App\Models\VinculoTipo;
use App\Models\CargaHoraria;
use App\Models\EquipeProfissional;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ProfissionalTrashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('profissional.trash.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('profissionals.trash.index', [
            'profissionals' => Profissional::orderBy('nome', 'asc')
                ->onlyTrashed()
                ->filter(request(['nome', 'matricula', 'cpf', 'cns', 'cargo_id', 'vinculo_id', 'vinculo_tipo_id', 'carga_horaria_id', 'flexibilizacao']))
                ->paginate(session('perPage', '5'))
                ->appends(request(['nome', 'matricula', 'cpf', 'cns', 'cargo_id', 'vinculo_id', 'vinculo_tipo_id', 'carga_horaria_id', 'flexibilizacao'])),
            'perpages' => Perpage::orderBy('valor')->get(),
            'cargos' => Cargo::orderBy('nome')->get(),
            'vinculos' => Vinculo::orderBy('nome')->get(),
            'vinculotipos' => VinculoTipo::orderBy('nome')->get(),
            'cargahorarias' => CargaHoraria::orderBy('nome')->get(),
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id) : View
    {
        $this->authorize('profissional.trash.index');

        return view('profissionals.trash.show', [
            'profissional' => Profissional::withTrashed()->find($id),
            'equipeprofissionals' => EquipeProfissional::where('profissional_id', $id)->orderBy('id', 'desc')->get(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function restore(string $id) : RedirectResponse
    {
        $this->authorize('profissional.trash.restore');

        $profissional = Profissional::withTrashed()->findOrFail($id)->restore();

        return Redirect::route('profissionals.index')->with('message', 'Profissional restaurado com sucesso');

    }
}
