<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\Licenca;
use App\Models\LicencaTipo;

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
  
        Licenca::create($licenca);

        return redirect(route('profissionals.edit', $licenca['profissional_id']))->with('message', 'Licença cadastrada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Licenca $licenca)
    {
        $this->authorize('licenca.delete');

        $licenca_profissional_id = $licenca->profissional_id;

        $licenca->delete();

        return redirect(route('profissionals.edit', $licenca_profissional_id))->with('message', 'Licença excluída com sucesso!');
    }    
}
