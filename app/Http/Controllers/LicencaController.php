<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\Licenca;
use App\Models\Perpage;
use App\Models\Log;
use App\Models\LicencaTipo;
use App\Models\Historico;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\LicencasExport;
use Maatwebsite\Excel\Facades\Excel;

class LicencaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('licenca.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('licencas.index', [
            'licencas' => Licenca::orderBy('id', 'desc')->filter(request(['data_inicio','data_fim', 'profissional', 'ferias_tipo_id']))
                                                    ->paginate(session('perPage', '5'))
                                                    ->appends(request(['data_inicio','data_fim', 'profissional', 'ferias_tipo_id'])),
            'perpages' => Perpage::orderBy('valor')->get(),
            'licencatipos' => LicencaTipo::orderBy('nome')->get(),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('licenca.create');

        return view('licencas.create', [
            'licencas' => Licenca::orderBy('id', 'desc')->get(),
            'licencatipos' => LicencaTipo::orderBy('nome')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('licenca.create');

        $request->validate([
            'profissional_id' => 'required|integer|exists:profissionals,id',
            'licenca_tipo_id' => 'required|integer|exists:licenca_tipos,id',
            'inicio' => 'required|date_format:d/m/Y',
            'fim' => 'required|date_format:d/m/Y',
          ]);

        $licenca = [
            'profissional_id' => $request->profissional_id,
            'licenca_tipo_id' => $request->licenca_tipo_id,
            'inicio' => date('Y-m-d', strtotime(str_replace('/', '-', $request->inicio))),
            'fim' => date('Y-m-d', strtotime(str_replace('/', '-', $request->fim))),
            'observacao' => $request->observacao,
            'user_id' => auth()->id(),
        ];  
  
        $new_licenca = Licenca::create($licenca);

        // guarda o histórico
        $historico = new Historico;
        $historico->user_id = auth()->id();
        $historico->profissional_id = $new_licenca->profissional->id;
        $historico->historico_tipo_id = 7; // Foi cadastrado uma licença para o profissional
        $historico->observacao = 'Período entre ' . $new_licenca->inicio . ' e ' . $new_licenca->fim . ', observações: ' . $new_licenca->observacao;
        $historico->save();

        return redirect(route('licencas.index'))->with('message', 'Licença cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Licenca $licenca) : View
    {
        $this->authorize('licenca.show');

        return view('licencas.show', [
            'licenca' => $licenca,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Licenca $licenca) : View
    {
        $this->authorize('licenca.edit');

        return view('licencas.edit', [
            'licenca' => $licenca,
            'licencatipos' => LicencaTipo::orderBy('nome')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Licenca $licenca) : RedirectResponse
    {
        $this->authorize('licenca.edit');

        $request->validate([
            'profissional_id' => 'required|integer|exists:profissionals,id',
            'licenca_tipo_id' => 'required|integer|exists:licenca_tipos,id',
            'inicio' => 'required|date_format:d/m/Y',
            'fim' => 'required|date_format:d/m/Y',
          ]);

        $licenca->update([
            'profissional_id' => $request->profissional_id,
            'licenca_tipo_id' => $request->licenca_tipo_id,
            'inicio' => date('Y-m-d', strtotime(str_replace('/', '-', $request->inicio))),
            'fim' => date('Y-m-d', strtotime(str_replace('/', '-', $request->fim))),
            'observacao' => $request->observacao,
            'user_id' => auth()->id(),
        ]);  
  
        return redirect(route('licencas.index'))->with('message', 'Licença alterada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Licenca $licenca) : RedirectResponse
    {
        $this->authorize('licenca.delete');

        // guarda o histórico
        $historico = new Historico;
        $historico->user_id = auth()->id();
        $historico->profissional_id = $licenca->profissional->id;
        $historico->historico_tipo_id = 8; // Foi excluído uma licença do profissional
        $historico->observacao = 'Período entre ' . $licenca->inicio . ' e ' . $licenca->fim . ', observações: ' . $licenca->observacao;
        $historico->save();

        $licenca->delete();

        return redirect(route('licencas.index'))->with('message', 'Licença excluída com sucesso!');
    }


    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('licenca.export');

        return Pdf::loadView('licencas.report', [
            'dataset' => Licenca::orderBy('id', 'asc')->filter(request(['data_inicio','data_fim', 'profissional', 'licenca_tipo_id']))->get()
        ])->download(__('Licencas') . '_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('licenca.export');

        return Excel::download(new LicencasExport(request(['data_inicio','data_fim', 'profissional', 'licenca_tipo_id'])),  __('Licencas') . '_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('licenca.export');

        return Excel::download(new LicencasExport(request(['data_inicio','data_fim', 'profissional', 'licenca_tipo_id'])),  __('Licencas') . '_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
