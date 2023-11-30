<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\EquipeProfissional;
use App\Models\Profissional;

class EquipeVagasController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('equipe.edit');

        $request->validate([
            'equipe_id' => 'required',
            'cargo_id' => 'required',
        ]);

        $equipeProfissional = new EquipeProfissional();

        $equipeProfissional->equipe_id = $request->equipe_id;

        $equipeProfissional->cargo_id = $request->cargo_id;

        $equipeProfissional->save();

        return redirect()->route('equipes.edit', $equipeProfissional->equipe_id)->with('message', 'Vaga adicionada com sucesso!');
    }

 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('equipe.edit');

        $equipeProfissional = EquipeProfissional::findOrFail($id);

        $equipeProfissional->delete();

        return redirect()->route('equipes.edit', $equipeProfissional->equipe_id)->with('message', 'Vaga removida com sucesso!');
    }
}
