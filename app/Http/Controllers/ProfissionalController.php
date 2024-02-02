<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use App\Models\Perpage;
use App\Models\Cargo;
use App\Models\Vinculo;
use App\Models\VinculoTipo;
use App\Models\CargaHoraria;
use App\Models\OrgaoEmissor;
use App\Models\FeriasTipo;
use App\Models\LicencaTipo;
use App\Models\CapacitacaoTipo;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

use App\Rules\Cpf; // validação de um cpf

use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\ProfissionalsExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class ProfissionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
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
            'cargahorarias' => CargaHoraria::orderBy('nome')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
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
    public function store(Request $request) : RedirectResponse
    {
        $this->authorize('profissional.create');

        // verificar se o cpf pode ser único, deveria, mas...
        $request->validate([
            'nome' => 'required|max:255',
            'cpf' => 'required|max:15|unique:profissionals,cpf',
            'cpf' => new Cpf,
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
    public function show(Profissional $profissional) : View
    {
        $this->authorize('profissional.show');

        return view('profissionals.show', [
            'profissional' => $profissional,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profissional $profissional) : View
    {
        $this->authorize('profissional.edit');

        return view('profissionals.edit', [
            'profissional' => $profissional,
            'cargos' => Cargo::orderBy('nome')->get(),
            'vinculos' => Vinculo::orderBy('nome')->get(),
            'vinculotipos' => VinculoTipo::orderBy('nome')->get(),
            'cargahorarias' => CargaHoraria::orderBy('nome')->get(),
            'orgaoemissors' => OrgaoEmissor::orderBy('nome')->get(),
            'feriastipos' => FeriasTipo::orderBy('nome')->get(),
            'ferias' => $profissional->ferias()->orderBy('id', 'desc')->get(),
            'licencatipos' => LicencaTipo::orderBy('nome')->get(),
            'licencas' => $profissional->licencas()->orderBy('id', 'desc')->get(),
            'capacitacoes' => $profissional->capacitacaos()->orderBy('id', 'desc')->get(),
            'capacitacaotipos' => CapacitacaoTipo::orderBy('nome')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Profissional $profissional) : RedirectResponse
    {
        $this->authorize('profissional.edit');

        $request->validate([
            'nome' => 'required|max:255',
            'cpf' => 'required|max:15',
            'cargo_id' => 'required|integer|exists:cargos,id',
            'vinculo_id' => 'required|integer|exists:vinculos,id',
            'vinculo_tipo_id' => 'required|integer|exists:vinculo_tipos,id',
            'carga_horaria_id' => 'required|integer|exists:carga_horarias,id',
            'orgao_emissor_id' => 'required|integer|exists:orgao_emissors,id',
            'matricula' => 'required|max:20',
            'admissao' => 'required|date_format:d/m/Y',
        ]);

        $profissional_request = $request->all();

        if (isset($request->admissao)) {
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', $request->admissao)->format('Y-m-d'); 
            $profissional_request['admissao'] = $dataFormatadaMysql;
        }

        $profissional->update($profissional_request);

        return redirect()->route('profissionals.index')->with('message', 'Profissional atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profissional $profissional)
    {
        $this->authorize('profissional.delete');

        $profissional->delete();

        return redirect()->route('profissionals.index')->with('message', 'Profissional excluído com sucesso!');
    }

    /**
     * Export the specified resource to PDF.
     */
    public function exportpdf() : \Illuminate\Http\Response
    {
        $this->authorize('profissional.export');

        return Pdf::loadView('profissionals.report', [
            'dataset' => Profissional::orderBy('nome', 'asc')->filter(request(['nome', 'cargo_id', 'vinculo_id', 'matricula']))->get()
        ])->download('Profissionais_' .  date("Y-m-d H:i:s") . '.pdf');
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('profissional.export');

        return Excel::download(new ProfissionalsExport(request(['nome', 'cargo_id', 'vinculo_id', 'matricula'])),  'Profissionais_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    /**
     * Export the specified resource to Excel.
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('profissional.export');

        return Excel::download(new ProfissionalsExport(request(['nome', 'cargo_id', 'vinculo_id', 'matricula'])),  'Profissionais_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

        /**
     * Função de autocompletar para ser usada pelo typehead
     *
     * @param  
     * @return json
     */
    public function autocomplete(Request $request)
    {
        $this->authorize('profissional.index');

        $profissionais = DB::table('profissionals');

        // join
        $profissionais = $profissionais->join('cargos', 'cargos.id', '=', 'profissionals.cargo_id');

        // select
        $profissionais = $profissionais->select(
          'profissionals.nome as text', 
          'profissionals.id as value', 
          'cargos.nome as cargo', 
          'cargos.id as cargo_id', 
          'profissionals.matricula as matricula'
        );
        
        //where
        $profissionais = $profissionais->where("profissionals.nome","LIKE","%{$request->input('query')}%");
        $profissionais = $profissionais->whereNull('deleted_at');

        //get
        $profissionais = $profissionais->orderBy('profissionals.nome', 'asc')->take(10)->get();

        return response()->json($profissionais, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
