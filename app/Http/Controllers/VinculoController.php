<?php

namespace App\Http\Controllers;

use App\Models\Vinculo;
use App\Models\Perpage;
use Illuminate\Http\Request;
use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\VinculosExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class VinculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('vinculo.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('vinculos.index', [
            'vinculos' => Vinculo::orderBy('nome', 'asc')->paginate(session('perPage', '5'))->withPath(env('APP_URL', null) .  '/vinculos'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('vinculo.create');

        return view('vinculos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('vinculo.create');

        $vinculo = $request->validate([
            'nome' => 'required|max:255',
          ]);
  
        Vinculo::create($vinculo);

        return redirect(route('vinculos.index'))->with('message', 'Vínculo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vinculo $vinculo) : View
    {
        $this->authorize('vinculo.show');

        return view('vinculos.show', [
            'vinculo' => $vinculo
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vinculo $vinculo) : View
    {
        $this->authorize('vinculo.edit');

        return view('vinculos.edit', [
          'vinculo' => $vinculo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vinculo $vinculo) : RedirectResponse
    {
        $this->authorize('vinculo.edit');
  
        $vinculo->update($request->validate(['nome' => 'required|max:255']));

        return redirect(route('vinculos.index'))->with('message', 'Vínculo alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vinculo $vinculo)  : RedirectResponse
    {
        $this->authorize('vinculo.delete');
     
        DB::beginTransaction();   
        try {
  
            $vinculo->delete();

            DB::commit();
  
            return redirect(route('vinculos.index'))->with('message', 'Registro excluído com sucesso!');
  
        } catch(\Exception $e){
            DB::rollback();
            return redirect()->route('vinculos.index')->with('message', 'Erro ao excluir : <br> ' . $e->getMessage());
        }
 
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('vinculo.export');

        return Pdf::loadView('vinculos.report', [
            'dataset' => Vinculo::orderBy('nome', 'asc')->get()
        ])->download('Vinculos_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('vinculo.export');

        return Excel::download(new VinculosExport(), 'Vinculos_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('vinculo.export');

        return Excel::download(new VinculosExport(), 'Vinculos_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }    
}
