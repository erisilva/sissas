<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Models\Perpage;
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
            'distritos' => auth()->user()->distritos->sortBy('nome'),
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
            'distritos' => auth()->user()->distritos->sortBy('nome'),
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
  
        $unidade = Unidade::create($request->all());

        return redirect(route('unidades.edit', $unidade))->with('message', 'Unidade criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unidade $unidade) : View
    {
        $this->authorize('unidade.show');

        return view('unidades.show', [
            'unidade' => $unidade,
            'equipes' => $unidade->equipes()->orderBy('descricao', 'asc')->get(),
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
            'distritos' => auth()->user()->distritos->sortBy('nome'),
            'equipes' => $unidade->equipes()->orderBy('descricao', 'asc')->get(),
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

        return redirect(route('unidades.edit', $unidade))->with('message', 'Unidade alterada com sucesso!');
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

        /**
     * Função de autocompletar para ser usada pelo typehead
     *
     * @param  
     * @return json
     */
    public function autocomplete(Request $request)
    {
        $this->authorize('unidade.index'); // verifica se o usuário possui acesso para listar

        $unidades = DB::table('unidades');

        // join
        $unidades = $unidades->join('distritos', 'distritos.id', '=', 'unidades.distrito_id');

        // select
        $unidades = $unidades->select('unidades.nome as text', 'unidades.id as value', 'distritos.nome as distrito');
        
        //where
        $unidades = $unidades->where("unidades.nome","LIKE","%{$request->input('query')}%");

        //mostrar apenas as unidades dos distritos que o usuário logado tem acesso 
        $unidades = $unidades->whereIn("distritos.id", auth()->user()->distritos->pluck('id'));

        //get
        $unidades = $unidades->get();

        return response()->json($unidades, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
