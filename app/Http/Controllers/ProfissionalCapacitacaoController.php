<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\Capacitacao;
use App\Models\CapacitacaoTipo;
use App\Models\Historico;

class ProfissionalCapacitacaoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('capacitacao.create');

        $request->validate([
            'capacitacao_profissional_id' => 'required|integer|exists:profissionals,id',
            'capacitacao_tipo_id' => 'required|integer|exists:capacitacao_tipos,id',
            'capacitacao_inicio' => 'required|date_format:d/m/Y',
            'capacitacao_fim' => 'required|date_format:d/m/Y',
          ]);

        $capacitacao = [
            'profissional_id' => $request->capacitacao_profissional_id,
            'capacitacao_tipo_id' => $request->capacitacao_tipo_id,
            'inicio' => date('Y-m-d', strtotime(str_replace('/', '-', $request->capacitacao_inicio))),
            'fim' => date('Y-m-d', strtotime(str_replace('/', '-', $request->capacitacao_fim))),
            'observacao' => $request->capacitacao_observacao,
            'cargaHoraria' => $request->capacitacao_carga_horaria,
            'user_id' => auth()->id(),
        ];  
  
        
        $new_capacitacao = Capacitacao::create($capacitacao);

        // guarda o histórico
        $historico = new Historico;
        $historico->user_id = auth()->id();
        $historico->profissional_id = $new_capacitacao->profissional->id;
        $historico->historico_tipo_id = 9; // Foi cadastrado uma capacitação para o profissional
        $historico->observacao = 'Período entre ' . $new_capacitacao->inicio . ' e ' . $new_capacitacao->fim . ', observação: ' . $new_capacitacao->observacao;
        $historico->save();

        return redirect(route('profissionals.edit', $capacitacao['profissional_id']))->with('message', 'Capacitação cadastrada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Capacitacao $capacitacao)
    {
        $this->authorize('capacitacao.delete');

        $capacitacao_profissional_id = $capacitacao->profissional_id;

        // guarda o histórico
        $historico = new Historico;
        $historico->user_id = auth()->id();
        $historico->profissional_id = $capacitacao->profissional->id;
        $historico->historico_tipo_id = 10; // Foi excluído uma capacitação do profissional
        $historico->observacao = 'Período entre ' . $capacitacao->inicio . ' e ' . $capacitacao->fim . ', observações: ' . $capacitacao->observacao;
        $historico->changes = json_encode($capacitacao);
        $historico->save();

        $capacitacao->delete();

        return redirect(route('profissionals.edit', $capacitacao_profissional_id))->with('message', 'Capacitação excluída com sucesso!');
    }
}
