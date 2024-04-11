<?php

namespace App\Http\Controllers;

use App\Models\Historico;
use App\Models\HistoricoTipo;
use App\Models\Perpage;

use App\Exports\HistoricoExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class HistoricoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('historico.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('historicos.index', [
            'historicos' => Historico::orderBy('historicos.created_at', 'desc')
                ->filter(request(['data_inicio', 'data_fim', 'historico_tipo_id', 'nome', 'matricula','cpf', 'user_name', 'equipe_descricao', 'ine', 'unidade_descricao', 'distrito_id']))
                ->paginate(session('perPage', '5'))
                ->appends(request(['data_inicio', 'data_fim', 'historico_tipo_id', 'nome', 'matricula','cpf', 'user_name', 'equipe_descricao', 'ine', 'unidade_descricao', 'distrito_id'])),
            'historicoTipos' => HistoricoTipo::orderBy('descricao')->get(),
            'distritos'=> auth()->user()->distritos->sortBy('nome'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('historico.export');

        // ['data_inicio' => request()->input('data_inicio'), 'data_fim' => request()->input('data_fim'), 'historico_tipo_id' => request()->input('historico_tipo_id'), 'nome' => request()->input('nome'), 'matricula' => request()->input('matricula'), 'cpf' => request()->input('cpf'), 'user_name' => request()->input('user_name'), 'equipe_descricao' => request()->input('equipe_descricao'), 'ine' => request()->input('ine'), 'unidade' => request()->input('unidade'), 'distrito_id' => request()->input('distrito_id')]

        return Excel::download(new HistoricoExport(request(['data_inicio', 'data_fim', 'historico_tipo_id', 'nome', 'matricula','cpf', 'user_name', 'equipe_descricao', 'ine', 'unidade_descricao', 'distrito_id'])),  'Histórico' . '_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('historico.export');

        return Excel::download(new HistoricoExport(request(['data_inicio', 'data_fim', 'historico_tipo_id', 'nome', 'matricula','cpf', 'user_name', 'equipe_descricao', 'ine', 'unidade_descricao', 'distrito_id'])), 'Histórico' . '_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }


}
