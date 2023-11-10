<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\Capacitacao;
use App\Models\CapacitacaoTipo;

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
  
        Capacitacao::create($capacitacao);

        return redirect(route('profissionals.edit', $capacitacao['profissional_id']))->with('message', 'Capacitação cadastrada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Capacitacao $capacitacao)
    {
        $this->authorize('capacitacao.delete');

        $capacitacao_profissional_id = $capacitacao->profissional_id;

        $capacitacao->delete();

        return redirect(route('profissionals.edit', $capacitacao_profissional_id))->with('message', 'Licença excluída com sucesso!');
    }
}
