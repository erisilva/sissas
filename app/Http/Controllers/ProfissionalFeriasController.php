<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\Ferias;
use App\Models\Historico;

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
  
        $new_ferias = Ferias::create($ferias);

        // guarda o histórico
        $historico = new Historico;
        $historico->user_id = auth()->id();
        $historico->profissional_id = $new_ferias->profissional->id;
        $historico->historico_tipo_id = 5; //Foi cadastrado uma férias para o profissional
        $historico->observacao = 'Período entre ' . date('d/m/Y', strtotime($new_ferias->inicio)) . ' e ' . date('d/m/Y', strtotime($new_ferias->fim)) . ', justificativa: ' . $new_ferias->justificativa;
        $historico->save();

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

        // guarda o histórico
        $historico = new Historico;
        $historico->user_id = auth()->id();
        $historico->profissional_id = $ferias->profissional->id;
        $historico->historico_tipo_id = 6; //Foi excluído uma férias do profissional
        $historico->observacao = $ferias->descricao . ', período entre ' . $ferias->inicio . ' e ' . $ferias->fim . ', justificativa: ' . $ferias->justificativa;
        $historico->changes = json_encode($ferias);
        $historico->save();

        $ferias->delete();

        return redirect(route('profissionals.edit', $profissional_id))->with('message', 'Férias excluída com sucesso!');     
    }  
}
