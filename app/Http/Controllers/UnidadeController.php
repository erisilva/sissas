<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Models\Perpage;
use App\Models\Distrito;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\UnidadesExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

use Illuminate\Support\Facades\DB;

class UnidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('unidade.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('unidades.index', [
            'unidades' => Unidade::orderBy('nome', 'asc')->filter(request(['nome', 'distrito_id']))->paginate(session('perPage', '5'))->appends(request(['nome', 'descricao'])),
            'perpages' => Perpage::orderBy('valor')->get(),
            'distritos' => Distrito::orderBy('nome')->get(),
        ]);

        // with('author')
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('unidade.create');

        return view('unidades.create', [
            'distritos' => Distrito::orderBy('nome')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('unidade.create');

        $request->validate([
            'nome' => 'required|max:255',
            'distrito_id' => 'required|Integer|exists:distritos,id',
            'porte' => 'required|max:10',
        ]);
  
        Unidade::create($request->all());

        return redirect(route('unidades.index'))->with('message', 'Unidade cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unidade $unidade) : View
    {
        $this->authorize('unidade.show');

        return view('unidades.show', [
            'unidade' => $unidade,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unidade $unidade) : View
    {
        $this->authorize('unidade.edit');

        return view('unidades.edit', [
            'unidade' => $unidade,
            'distritos' => Distrito::orderBy('nome')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unidade $unidade) : RedirectResponse
    {
        $this->authorize('unidade.edit');

        $request->validate([
            'nome' => 'required|max:255',
            'distrito_id' => 'required|Integer|exists:distritos,id',
            'porte' => 'required|max:10',
        ]);

        $unidade->update($request->all());

        return redirect(route('unidades.index'))->with('message', 'Unidade atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unidade $unidade) : RedirectResponse
    {
        $this->authorize('unidade.delete');

        DB::beginTransaction();   
        try {
  
            $unidade->delete();

            DB::commit();
  
            return redirect(route('unidades.index'))->with('message', 'Registro excluído com sucesso!');
  
        } catch(\Exception $e){
            DB::rollback();
            return redirect()->route('unidades.index')->with('message', 'Erro ao excluir : ' . $e->getMessage());
        }
    }

        /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('unidade.export');

        return Pdf::loadView('unidades.report', [
            'dataset' => Unidade::orderBy('nome', 'asc')->filter(request(['nome', 'distrito_id']))->get()
        ])->download('Unidades_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('unidade.export');

        return Excel::download(new UnidadesExport(request(['nome', 'distrito_id'])),  'Unidades_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('unidade.export');

        return Excel::download(new UnidadesExport(request(['nome', 'distrito_id'])),  'Unidades_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
