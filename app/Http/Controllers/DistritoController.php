<?php

namespace App\Http\Controllers;

use App\Models\Distrito;
use App\Models\Perpage;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\DistritosExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class DistritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('distrito.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('distritos.index', [
            'distritos' => Distrito::orderBy('nome', 'asc')->paginate(session('perPage', '5')),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('distrito.create');

        return view('distritos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('distrito.create');

        $distrito = $request->validate([
            'nome' => 'required|max:255',
          ]);
  
        Distrito::create($distrito);

        return redirect(route('distritos.index'))->with('message', 'Distrito criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Distrito $distrito) : View
    {
        $this->authorize('distrito.show');

        return view('distritos.show', [
            'distrito' => $distrito
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Distrito $distrito) : View
    {
        $this->authorize('distrito.edit');

        return view('distritos.edit', [
          'distrito' => $distrito
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Distrito $distrito) : RedirectResponse
    {
        $this->authorize('distrito.edit');
  
        $distrito->update($request->validate(['nome' => 'required|max:255']));

        return redirect(route('distritos.index'))->with('message', 'Distrito alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distrito $distrito)  : RedirectResponse
    {
        $this->authorize('distrito.delete');
     
        DB::beginTransaction();   
        try {
  
            $distrito->delete();

            DB::commit();
  
            return redirect(route('distritos.index'))->with('message', 'Registro excluído com sucesso!');
  
        } catch(\Exception $e){
            DB::rollback();
            return redirect()->route('distritos.index')->with('message', 'Erro ao excluir : <br> ' . $e->getMessage());
        }
 
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('distrito.export');

        return Pdf::loadView('distritos.report', [
            'dataset' => Distrito::orderBy('nome', 'asc')->get()
        ])->download('Distritos_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('distrito.export');

        return Excel::download(new DistritosExport(), 'Distritos_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('distrito.export');

        return Excel::download(new DistritosExport(), 'Distritos_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }    
}
