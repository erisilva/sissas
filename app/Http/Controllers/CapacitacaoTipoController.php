<?php

namespace App\Http\Controllers;

use App\Models\CapacitacaoTipo;
use App\Models\Perpage;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\CapacitacaoTiposExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class CapacitacaoTipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('capacitacaotipo.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('capacitacaotipos.index', [
            'capacitacaotipos' => CapacitacaoTipo::orderBy('nome', 'asc')->paginate(session('perPage', '5'))->withPath(env('APP_URL', null) .  '/capacitacaotipos'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('capacitacaotipo.create');

        return view('capacitacaotipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('capacitacaotipo.create');

        $capacitacaotipo = $request->validate([
            'nome' => 'required|max:255',
          ]);
  
        CapacitacaoTipo::create($capacitacaotipo);

        return redirect(route('capacitacaotipos.index'))->with('message', 'Tipo de capacitação criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CapacitacaoTipo $capacitacaotipo) : View
    {
        $this->authorize('capacitacaotipo.show');

        return view('capacitacaotipos.show', [
            'capacitacaotipo' => $capacitacaotipo
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CapacitacaoTipo $capacitacaotipo) : View
    {
        $this->authorize('capacitacaotipo.edit');

        return view('capacitacaotipos.edit', [
          'capacitacaotipo' => $capacitacaotipo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CapacitacaoTipo $capacitacaotipo) : RedirectResponse
    {
        $this->authorize('capacitacaotipo.edit');
  
        $capacitacaotipo->update($request->validate(['nome' => 'required|max:255']));

        return redirect(route('capacitacaotipos.index'))->with('message', 'Tipo de capacitação alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CapacitacaoTipo $capacitacaotipo)  : RedirectResponse
    {
        $this->authorize('capacitacaotipo.delete');
     
        DB::beginTransaction();   
        try {
  
            $capacitacaotipo->delete();

            DB::commit();
  
            return redirect(route('capacitacaotipos.index'))->with('message', 'Registro excluído com sucesso!');
  
        } catch(\Exception $e){
            DB::rollback();
            return redirect()->route('capacitacaotipos.index')->with('message', 'Erro ao excluir : <br> ' . $e->getMessage());
        }
 
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('capacitacaotipo.export');

        return Pdf::loadView('capacitacaotipos.report', [
            'dataset' => CapacitacaoTipo::orderBy('nome', 'asc')->get()
        ])->download('CapacitacaoTipos_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('capacitacaotipo.export');

        return Excel::download(new CapacitacaoTiposExport(), 'CapacitacaoTipos_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('capacitacaotipo.export');

        return Excel::download(new CapacitacaoTiposExport(), 'CapacitacaoTipos_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }    
}
