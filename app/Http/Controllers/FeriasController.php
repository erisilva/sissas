<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\Ferias;
use App\Models\Perpage;
use App\Models\Log;
use App\Models\FeriasTipo;
use App\Models\Historico;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\FeriasExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class FeriasController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('ferias.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('ferias.index', [
            'ferias' => Ferias::orderBy('id', 'desc')->filter(request(['data_inicio','data_fim', 'profissional', 'ferias_tipo_id']))
                                                    ->paginate(session('perPage', '5'))
                                                    ->appends(request(['data_inicio','data_fim', 'profissional', 'ferias_tipo_id'])),
            'perpages' => Perpage::orderBy('valor')->get(),
            'feriastipos' => FeriasTipo::orderBy('nome')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('ferias.create');

        return view('ferias.create', [
            'feriastipos' => FeriasTipo::orderBy('nome')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('ferias.create');

        $request->validate([
            'profissional_id' => 'required|integer|exists:profissionals,id',
            'feriastipo_id' => 'required|integer|exists:ferias_tipos,id',
            'inicio' => 'required|date_format:d/m/Y',
            'fim' => 'required|date_format:d/m/Y',
          ]);

        $ferias = [
            'profissional_id' => $request->profissional_id,
            'ferias_tipo_id' => $request->feriastipo_id,
            'inicio' => date('Y-m-d', strtotime(str_replace('/', '-', $request->inicio))),
            'fim' => date('Y-m-d', strtotime(str_replace('/', '-', $request->fim))),
            'justificativa' => $request->justificativa,
            'user_id' => auth()->id(),
        ];  
  
        $new_ferias = Ferias::create($ferias);

        // guarda o histórico
        $historico = new Historico;
        $historico->user_id = auth()->id();
        $historico->profissional_id = $new_ferias->profissional->id;
        $historico->historico_tipo_id = 5; // Foi cadastrado uma férias para o profissional
        $historico->observacao = 'Período entre ' . date('d/m/Y', strtotime($new_ferias->inicio)) . ' e ' . date('d/m/Y', strtotime($new_ferias->fim)) . ', justificativa: ' . $new_ferias->justificativa;
        $historico->save();

        return redirect(route('ferias.index'))->with('message', 'Férias cadastradas com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show($id) : View
    {
        $this->authorize('ferias.show');

        $ferias = Ferias::findorfail($id);

        return view('ferias.show', [
            'ferias' => $ferias
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) : View
    {
        $this->authorize('ferias.edit');

        return view('ferias.edit', [
            'ferias' => Ferias::findorfail($id),
            'feriastipos' => FeriasTipo::orderBy('nome')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) : RedirectResponse
    {
        $this->authorize('ferias.edit');

        $request->validate([
            'profissional_id' => 'required|integer|exists:profissionals,id',
            'feriastipo_id' => 'required|integer|exists:ferias_tipos,id',
            'inicio' => 'required|date_format:d/m/Y',
            'fim' => 'required|date_format:d/m/Y',
          ]);

        $ferias_request = [
            'profissional_id' => $request->profissional_id,
            'ferias_tipo_id' => $request->feriastipo_id,
            'inicio' => date('Y-m-d', strtotime(str_replace('/', '-', $request->inicio))),
            'fim' => date('Y-m-d', strtotime(str_replace('/', '-', $request->fim))),
            'justificativa' => $request->justificativa,
            'user_id' => auth()->id(),
        ];  
        
        Ferias::findorfail($id)->update($ferias_request);


        return redirect(route('ferias.index'))->with('message', __('Ferias updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) : RedirectResponse
    {
        $this->authorize('ferias.delete');

        $ferias = Ferias::findorfail($id);

        // guarda o histórico
        $historico = new Historico;
        $historico->user_id = auth()->id();
        $historico->profissional_id = $ferias->profissional->id;
        $historico->historico_tipo_id = 6; // Foi excluído uma férias do profissional
        $historico->observacao = 'Período entre ' . $ferias->inicio . ' e ' . $ferias->fim . ', justificativa: ' . $ferias->justificativa;
        $historico->save();

        Ferias::findorfail($id)->delete();

        return redirect(route('ferias.index'))->with('message', __('Ferias deleted successfully!'));       
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('ferias.export');

        return Pdf::loadView('ferias.report', [
            'dataset' => Ferias::orderBy('id', 'asc')->filter(request(['data_inicio','data_fim', 'profissional', 'ferias_tipo_id']))->get()
        ])->download(__('Ferias') . '_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('ferias.export');

        return Excel::download(new FeriasExport(request(['data_inicio','data_fim', 'profissional', 'ferias_tipo_id'])),  __('Ferias') . '_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('ferias.export');

        return Excel::download(new FeriasExport(request(['data_inicio','data_fim', 'profissional', 'ferias_tipo_id'])),  __('Ferias') . '_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
