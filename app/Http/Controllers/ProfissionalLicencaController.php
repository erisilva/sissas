<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\Licenca;
use App\Models\LicencaTipo;
use App\Models\Historico;

class ProfissionalLicencaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('licenca.create');

        $request->validate([
            'licenca_profissional_id' => 'required|integer|exists:profissionals,id',
            'licenca_tipo_id' => 'required|integer|exists:licenca_tipos,id',
            'licenca_inicio' => 'required|date_format:d/m/Y',
            'licenca_fim' => 'required|date_format:d/m/Y',
          ]);

        $licenca = [
            'profissional_id' => $request->licenca_profissional_id,
            'licenca_tipo_id' => $request->licenca_tipo_id,
            'inicio' => date('Y-m-d', strtotime(str_replace('/', '-', $request->licenca_inicio))),
            'fim' => date('Y-m-d', strtotime(str_replace('/', '-', $request->licenca_fim))),
            'observacao' => $request->licenca_observacao,
            'user_id' => auth()->id(),
        ];  
  
        $new_licenca = Licenca::create($licenca);

        // guarda o histórico
        $historico = new Historico;
        $historico->user_id = auth()->id();
        $historico->profissional_id = $new_licenca->profissional->id;
        $historico->historico_tipo_id = 7; // Foi cadastrado uma licença para o profissional
        $historico->observacao = 'Período entre ' . $new_licenca->inicio . ' e ' . $new_licenca->fim . ', observação: ' . $new_licenca->observacao;
        $historico->save();

        return redirect(route('profissionals.edit', $licenca['profissional_id']))->with('message', 'Licença cadastrada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Licenca $licenca)
    {
        $this->authorize('licenca.delete');

        $licenca_profissional_id = $licenca->profissional_id;

        // guarda o histórico
        $historico = new Historico;
        $historico->user_id = auth()->id();
        $historico->profissional_id = $licenca->profissional->id;
        $historico->historico_tipo_id = 8; // Foi excluído uma licença do profissional
        $historico->observacao = 'Período entre ' . $licenca->inicio . ' e ' . $licenca->fim . ', observações: ' . $licenca->observacao;
        $historico->changes = json_encode($licenca);
        $historico->save();

        $licenca->delete();

        return redirect(route('profissionals.edit', $licenca_profissional_id))->with('message', 'Licença excluída com sucesso!');
    }    
}
