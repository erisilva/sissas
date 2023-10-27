<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\Ferias;

class ProfissionalFeriasController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('ferias.create');

        $request->validate([
            'ferias_profissional_id' => 'required|integer|exists:profissionals,id',
            'feriastipo_id' => 'required|integer|exists:ferias_tipos,id',
            'ferias_inicio' => 'required|date_format:d/m/Y',
            'ferias_fim' => 'required|date_format:d/m/Y',
          ]);

        $ferias = [
            'profissional_id' => $request->ferias_profissional_id,
            'ferias_tipo_id' => $request->feriastipo_id,
            'inicio' => date('Y-m-d', strtotime(str_replace('/', '-', $request->ferias_inicio))),
            'fim' => date('Y-m-d', strtotime(str_replace('/', '-', $request->ferias_fim))),
            'justificativa' => $request->ferias_justificativa,
            'user_id' => auth()->id(),
        ];  
  
        Ferias::create($ferias);

        return redirect(route('profissionals.edit', $ferias['profissional_id']))->with('message', 'Férias cadastradas com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) : RedirectResponse
    {
        $this->authorize('ferias.delete');

        $ferias = Ferias::findorfail($id);

        $profissional_id = $ferias->profissional_id;

        $ferias->delete();

        return redirect(route('profissionals.edit', $profissional_id))->with('message', 'Férias excluída com sucesso!');     
    }  
}
