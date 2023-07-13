<?php

namespace App\Http\Controllers;

use App\Models\VinculoTipo;
use App\Models\Perpage;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\VinculoTiposExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class VinculoTipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('vinculotipo.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('vinculotipos.index', [
            'vinculotipos' => VinculoTipo::orderBy('nome', 'asc')->paginate(session('perPage', '5')),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('vinculotipo.create');

        return view('vinculotipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('vinculotipo.create');

        $vinculotipo = $request->validate([
            'nome' => 'required|max:255',
          ]);
  
        VinculoTipo::create($vinculotipo);

        return redirect(route('vinculotipos.index'))->with('message', 'Tipo de vínculo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(VinculoTipo $vinculotipo) : View
    {
        $this->authorize('vinculotipo.show');

        return view('vinculotipos.show', [
            'vinculotipo' => $vinculotipo
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VinculoTipo $vinculotipo) : View
    {
        $this->authorize('vinculotipo.edit');

        return view('vinculotipos.edit', [
          'vinculotipo' => $vinculotipo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VinculoTipo $vinculotipo) : RedirectResponse
    {
        $this->authorize('vinculotipo.edit');
  
        $vinculotipo->update($request->validate(['nome' => 'required|max:255']));

        return redirect(route('vinculotipos.index'))->with('message', 'Tipo de vínculo alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VinculoTipo $vinculotipo)  : RedirectResponse
    {
        $this->authorize('vinculotipo.delete');
     
        DB::beginTransaction();   
        try {
  
            $vinculotipo->delete();

            DB::commit();
  
            return redirect(route('vinculotipos.index'))->with('message', 'Registro excluído com sucesso!');
  
        } catch(\Exception $e){
            DB::rollback();
            return redirect()->route('vinculotipos.index')->with('message', 'Erro ao excluir : <br> ' . $e->getMessage());
        }
 
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('vinculotipo.export');

        return Pdf::loadView('vinculotipos.report', [
            'dataset' => VinculoTipo::orderBy('nome', 'asc')->get()
        ])->download('VinculoTipos_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('vinculotipo.export');

        return Excel::download(new VinculoTiposExport(), 'VinculoTipos_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('vinculotipo.export');

        return Excel::download(new VinculoTiposExport(), 'VinculoTipos_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }    
}
