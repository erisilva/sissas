<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Perpage;
use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\DB;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\CargosExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('cargo.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('cargos.index', [
            'cargos' => Cargo::orderBy('nome', 'asc')->paginate(session('perPage', '5'))->withPath(env('APP_URL', null) .  '/cargos'),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('cargo.create');

        return view('cargos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('cargo.create');

        Cargo::create(
            $request->validate([
                'nome' => 'required|max:255',
                'cbo' => 'required|max:80',
                ])
        );

        return redirect(route('cargos.index'))->with('message', 'Cargo do Profissional criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cargo $cargo) : View
    {
        $this->authorize('cargo.show');

        return view('cargos.show', compact('cargo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cargo $cargo)
    {
        $this->authorize('cargo.edit');

        return view('cargos.edit', [
          'cargo' => $cargo
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cargo $cargo)
    {
        $this->authorize('cargo.edit');
  
        $cargo->update($request->validate([
            'nome' => 'required|max:255',
            'cbo' => 'required|max:80',
            ])
        );

        return redirect(route('cargos.index'))->with('message', 'Cargo do Profissional alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo)
    {
        $this->authorize('cargo.delete');
     
        DB::beginTransaction();   
        try {
  
            $cargo->delete();

            DB::commit();
  
            return redirect(route('cargos.index'))->with('message', 'Registro excluído com sucesso!');
  
        } catch(\Exception $e){
            DB::rollback();
            return redirect()->route('cargos.index')->with('message', 'Erro ao excluir : ' . $e->getMessage());
        }
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('cargo.export');

        return Pdf::loadView('cargos.report', [
            'dataset' => Cargo::orderBy('nome', 'asc')->get()
        ])->download('Cargos_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('cargo.export');

        return Excel::download(new CargosExport(), 'Cargos_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('cargo.export');

        return Excel::download(new CargosExport(), 'Cargos_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }        
}
