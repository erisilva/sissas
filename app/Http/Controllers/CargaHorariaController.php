<?php

namespace App\Http\Controllers;

use App\Models\CargaHoraria;
use App\Models\Perpage;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\CargaHorariasExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class CargaHorariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('cargahoraria.index');

        if (request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('cargahorarias.index', [
            'cargahorarias' => CargaHoraria::orderBy('nome', 'asc')->paginate(session('perPage', '5'))->withPath(env('APP_URL', null) .  '/cargahorarias'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('cargahoraria.create');

        return view('cargahorarias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('cargahoraria.create');

        CargaHoraria::create($request->validate([
                'nome' => 'required|max:255',
            ])
        );

        return redirect(route('cargahorarias.index'))->with('message', 'Carga horária criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CargaHoraria $cargahoraria) : View
    {
        $this->authorize('cargahoraria.show');

        return view('cargahorarias.show', compact('cargahoraria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CargaHoraria $cargahoraria) : View
    {
        $this->authorize('cargahoraria.edit');

        return view('cargahorarias.edit', compact('cargahoraria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CargaHoraria $cargahoraria) : RedirectResponse
    {
        $this->authorize('cargahoraria.edit');

        $cargahoraria->update($request->validate([
                'nome' => 'required|max:255',
            ])
        );

        return redirect(route('cargahorarias.index'))->with('message', 'Carga horária atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CargaHoraria $cargahoraria)
    {
        $this->authorize('cargahoraria.delete');
     
        DB::beginTransaction();   
        try {
  
            $cargahoraria->delete();

            DB::commit();
  
            return redirect(route('cargahorarias.index'))->with('message', 'Registro excluído com sucesso!');
  
        } catch(\Exception $e){
            DB::rollback();
            return redirect()->route('cargahorarias.index')->with('message', 'Erro ao excluir : <br> ' . $e->getMessage());
        }

        return redirect(route('cargahorarias.index'))->with('message', 'Carga horária excluída com sucesso!');
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('cargahoraria.export');

        return Pdf::loadView('cargahorarias.report', [
            'dataset' => CargaHoraria::orderBy('nome', 'asc')->get()
        ])->download('CargaHorarias_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('cargahoraria.export');

        return Excel::download(new CargaHorariasExport(), 'CargaHorarias_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('cargahoraria.export');

        return Excel::download(new CargaHorariasExport(), 'CargaHorarias_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }        
}
