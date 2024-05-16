<?php

namespace App\Http\Controllers;

use App\Models\FeriasTipo;
use App\Models\Perpage;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\FeriasTiposExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class FeriasTipoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('feriastipo.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('feriastipos.index', [
            'feriastipos' => FeriasTipo::orderBy('nome', 'asc')->paginate(session('perPage', '5'))->withPath(env('APP_URL', null) .  '/feriastipos'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('feriastipo.create');

        return view('feriastipos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('feriastipo.create');

        $feriastipo = $request->validate([
            'nome' => 'required|max:255',
          ]);
  
        FeriasTipo::create($feriastipo);

        return redirect(route('feriastipos.index'))->with('message', 'Tipo de férias criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FeriasTipo $feriastipo) : View
    {
        $this->authorize('feriastipo.show');

        return view('feriastipos.show', [
            'feriastipo' => $feriastipo
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FeriasTipo $feriastipo) : View
    {
        $this->authorize('feriastipo.edit');

        return view('feriastipos.edit', [
          'feriastipo' => $feriastipo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FeriasTipo $feriastipo) : RedirectResponse
    {
        $this->authorize('feriastipo.edit');
  
        $feriastipo->update($request->validate(['nome' => 'required|max:255']));

        return redirect(route('feriastipos.index'))->with('message', 'Tipo de férias alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeriasTipo $feriastipo)  : RedirectResponse
    {
        $this->authorize('feriastipo.delete');
     
        DB::beginTransaction();   
        try {
  
            $feriastipo->delete();

            DB::commit();
  
            return redirect(route('feriastipos.index'))->with('message', 'Registro excluído com sucesso!');
  
        } catch(\Exception $e){
            DB::rollback();
            return redirect()->route('feriastipos.index')->with('message', 'Erro ao excluir : <br> ' . $e->getMessage());
        }
 
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('feriastipo.export');

        return Pdf::loadView('feriastipos.report', [
            'dataset' => FeriasTipo::orderBy('nome', 'asc')->get()
        ])->download('FeriasTipo_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('feriastipo.export');

        return Excel::download(new FeriasTiposExport(), 'FeriasTipo_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('feriastipo.export');

        return Excel::download(new FeriasTiposExport(), 'FeriasTipo_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }    
}
