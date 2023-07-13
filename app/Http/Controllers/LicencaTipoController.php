<?php

namespace App\Http\Controllers;

use App\Models\LicencaTipo;
use App\Models\Perpage;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\LicencaTiposExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class LicencaTipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('licencatipo.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('licencatipos.index', [
            'licencatipos' => LicencaTipo::orderBy('nome', 'asc')->paginate(session('perPage', '5')),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('licencatipo.create');

        return view('licencatipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('licencatipo.create');

        $licencatipo = $request->validate([
            'nome' => 'required|max:255',
          ]);
  
        LicencaTipo::create($licencatipo);

        return redirect(route('licencatipos.index'))->with('message', 'LicencaTipo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LicencaTipo $licencatipo) : View
    {
        $this->authorize('licencatipo.show');

        return view('licencatipos.show', [
            'licencatipo' => $licencatipo
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LicencaTipo $licencatipo) : View
    {
        $this->authorize('licencatipo.edit');

        return view('licencatipos.edit', [
          'licencatipo' => $licencatipo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LicencaTipo $licencatipo) : RedirectResponse
    {
        $this->authorize('licencatipo.edit');
  
        $licencatipo->update($request->validate(['nome' => 'required|max:255']));

        return redirect(route('licencatipos.index'))->with('message', 'LicencaTipo alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LicencaTipo $licencatipo)  : RedirectResponse
    {
        $this->authorize('licencatipo.delete');
     
        DB::beginTransaction();   
        try {
  
            $licencatipo->delete();

            DB::commit();
  
            return redirect(route('licencatipos.index'))->with('message', 'Registro excluído com sucesso!');
  
        } catch(\Exception $e){
            DB::rollback();
            return redirect()->route('licencatipos.index')->with('message', 'Erro ao excluir : <br> ' . $e->getMessage());
        }
 
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('licencatipo.export');

        return Pdf::loadView('licencatipos.report', [
            'dataset' => LicencaTipo::orderBy('nome', 'asc')->get()
        ])->download('Distritos_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('licencatipo.export');

        return Excel::download(new LicencaTiposExport(), 'Distritos_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('licencatipo.export');

        return Excel::download(new LicencaTiposExport(), 'Distritos_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }    
}
