<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use App\Models\Perpage;
use App\Models\Cargo;
use App\Models\Vinculo;
use App\Models\VinculoTipo;
use App\Models\CargaHoraria;
use App\Models\OrgaoEmissor;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\UnidadesExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ProfissionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('profissional.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('profissionals.index', [
            'profissionals' => Profissional::orderBy('nome', 'asc')
                ->filter(request(['nome', 'cargo_id', 'vinculo_id', 'matricula']))
                ->paginate(session('perPage', '5'))
                ->appends(request(['nome', 'cargo_id', 'vinculo_id', 'matricula'])),
            'perpages' => Perpage::orderBy('valor')->get(),
            'cargos' => Cargo::orderBy('nome')->get(),
            'vinculos' => Vinculo::orderBy('nome')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('profissional.create');

        return view('profissionals.create', [
            'cargos' => Cargo::orderBy('nome')->get(),
            'vinculos' => Vinculo::orderBy('nome')->get(),
            'vinculotipos' => VinculoTipo::orderBy('nome')->get(),
            'cargahorarias' => CargaHoraria::orderBy('nome')->get(),
            'orgaoemissors' => OrgaoEmissor::orderBy('nome')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('profissional.create');

        // verificar se o cpf pode ser único, deveria, mas...
        $request->validate([
            'nome' => 'required|max:255',
            'cpf' => 'required|max:15|unique:profissionals,cpf',
            'cargo_id' => 'required|integer|exists:cargos,id',
            'vinculo_id' => 'required|integer|exists:vinculos,id',
            'vinculo_tipo_id' => 'required|integer|exists:vinculo_tipos,id',
            'carga_horaria_id' => 'required|integer|exists:carga_horarias,id',
            'orgao_emissor_id' => 'required|integer|exists:orgao_emissors,id',
            'matricula' => 'required|max:20',
            'admissao' => 'required|date_format:d/m/Y',
        ]);

        $profissional = $request->all();

        if (isset($request->admissao)) {
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', $request->admissao)->format('Y-m-d'); 
            $profissional['admissao'] = $dataFormatadaMysql;
        }        
        
        Profissional::create($profissional);

        return redirect()->route('profissionals.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Profissional $profissional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profissional $profissional)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profissional $profissional)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profissional $profissional)
    {
        //
    }
}
