<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

use Illuminate\View\View;

use App\Models\Equipe;
use App\Models\Perpage;
use App\Models\Distrito;
use App\Models\EquipeTipo;
use App\Models\Cargo;
use App\Models\EquipeProfissional;



use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\EquipesExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel


class EquipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('equipe.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('equipes.index', [
            'equipes' => Equipe::orderBy('descricao', 'asc')
                ->filter(request(['descricao','numero', 'cnes', 'ine', 'minima', 'unidade', 'distrito', 'tipo']))
                ->paginate(session('perPage', '5'))
                ->appends(request(['descricao','numero', 'cnes', 'ine', 'minima', 'unidade', 'distrito', 'tipo']))
                ->withPath(env('APP_URL', null) .  '/equipes'),
            'distritos' => auth()->user()->distritos->sortBy('nome'),
            'equipetipos' => EquipeTipo::orderBy('nome')->get(),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('equipe.create');

        return view('equipes.create', [
            'equipetipos' => EquipeTipo::orderBy('nome')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('equipe.create');

        $data = $request->validate([
            'descricao' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'cnes' => 'required|string|max:255',
            'ine' => 'required|string|max:255',
            'minima' => 'required|string|max:255',
            'unidade_id' => 'required|integer|exists:unidades,id',
            "equipe_tipo_id" => "required|integer|exists:equipe_tipos,id",

        ]);

        $data['user_id'] = auth()->user()->id;

        $equipe = Equipe::create($data);

        return redirect()->route('equipes.edit', $equipe)->with('message', 'Equipe cadastrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipe $equipe) : View
    {
        $this->authorize('equipe.show');

        return view('equipes.show', [
            'equipe' => $equipe,
            'equipeprofissionais' => EquipeProfissional::select('equipe_profissionals.id', 'equipe_profissionals.profissional_id', 'equipe_profissionals.cargo_id', 'equipe_profissionals.equipe_id', 'equipe_profissionals.created_at', 'equipe_profissionals.updated_at')                                    
                                     ->join('cargos', 'equipe_profissionals.cargo_id', '=', 'cargos.id')
                                     ->where('equipe_profissionals.equipe_id', '=', $equipe->id)
                                     ->orderBy('cargos.nome')->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipe $equipe) : View
    {
        $this->authorize('equipe.edit');

        return view('equipes.edit', [
            'equipe' => $equipe,
            'equipetipos' => EquipeTipo::orderBy('nome')->get(),
            'cargos' => Cargo::orderBy('nome')->get(),
            'equipeprofissionais' => EquipeProfissional::select('equipe_profissionals.id', 'equipe_profissionals.profissional_id', 'equipe_profissionals.cargo_id', 'equipe_profissionals.equipe_id', 'equipe_profissionals.created_at', 'equipe_profissionals.updated_at')                                    
            ->join('cargos', 'equipe_profissionals.cargo_id', '=', 'cargos.id')
            ->where('equipe_profissionals.equipe_id', '=', $equipe->id)
            ->orderBy('cargos.nome')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipe $equipe) : RedirectResponse
    {

        $this->authorize('equipe.edit');

        $data = $request->validate([
            'descricao' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'cnes' => 'required|string|max:255',
            'ine' => 'required|string|max:255',
            'minima' => 'required|string|max:255',
            'unidade_id' => 'required|integer|exists:unidades,id',
            "equipe_tipo_id" => "required|integer|exists:equipe_tipos,id",
        ]);

        $equipe->update($data);

        return redirect()->route('equipes.edit', $equipe)->with('message', 'Equipe atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipe $equipe) : RedirectResponse
    {
        $this->authorize('equipe.delete');

        DB::beginTransaction();

        try {
            $equipe->delete();

            DB::commit();
            return redirect(route('equipes.index'))->with('message', 'Equipe excluída com sucesso!');

        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->route('equipes.index')->with('message', __('Error saving record!') . ' ' . $e->getMessage());
        }
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('equipe.export');

        return Pdf::loadView('equipes.report', [
            'dataset' => Equipe::orderBy('descricao', 'asc')->filter(request(['descricao','numero', 'cnes', 'ine', 'minima', 'unidade', 'distrito', 'tipo']))->get()
        ])->download('EquipesVagas_' .  date("Y-m-d H:i:s") . '.pdf');
    }
    
    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('equipe.export');

        return Excel::download(new EquipesExport(request(['descricao','numero', 'cnes', 'ine', 'minima', 'unidade', 'distrito', 'tipo'])),  'EquipesVagas_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('equipe.export');

        return Excel::download(new EquipesExport(request(['descricao','numero', 'cnes', 'ine', 'minima', 'unidade', 'distrito', 'tipo'])),  'EquipesVagas_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }    
}
