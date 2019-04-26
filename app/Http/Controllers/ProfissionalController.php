<?php

namespace App\Http\Controllers;

use App\Profissional;
use App\Cargo;
use App\Vinculo;
use App\VinculoTipo;
use App\CargaHoraria;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon; // tratamento de datas

use App\Rules\Cpf; // validação de um cpf

class ProfissionalController extends Controller
{
    protected $pdf;

    /**
     * Construtor.
     *
     * precisa estar logado ao sistema
     * precisa ter a conta ativa (access)
     *
     * @return 
     */
    public function __construct(\App\Reports\ProfissionalReport $pdf)
    {
        $this->middleware(['middleware' => 'auth']);
        $this->middleware(['middleware' => 'hasaccess']);

        $this->pdf = $pdf;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('vinculotipo.index')) {
            abort(403, 'Acesso negado.');
        }

        $profissionals = new Profissional;

        // ordena
        $profissionals = $profissionals->orderBy('nome', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $profissionals = $profissionals->paginate(session('perPage', '5'));

        return view('profissionals.index', compact('profissionals', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // consulta a tabela dos cargos
        $cargos = Cargo::orderBy('nome', 'asc')->get();

        // consulta a tabela dos vínculos
        $vinculos = Vinculo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos tipos de vínculos
        $vinculotipos = VinculoTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos carga horária
        $cargahorarias = CargaHoraria::orderBy('descricao', 'asc')->get();

        return view('profissionals.create', compact('cargos', 'vinculos', 'vinculotipos', 'cargahorarias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'nome' => 'required',
          'matricula' => 'required',
          'cpf' => 'required',
          'cpf' => new Cpf,
          'cargo_id' => 'required',
          'carga_horaria_id' => 'required',
          'vinculo_id' => 'required',
          'vinculo_tipo_id' => 'required',
          'admissao' => 'required',
        ],
        [
            'cargo_id.required' => 'Selecione na lista o cargo do funcionário',
            'carga_horaria_id.required' => 'Selecione na lista a carga horária',
            'vinculo_id.required' => 'Selecione na lista o vínculo',
            'vinculo_tipo_id.required' => 'Selecione na lista o tipo de vínculo',
            'admissao.required' => 'Preencha a data de admissão',
        ]);

        $profissional = $request->all();

        // ajusta data
        if ($profissional['admissao'] != ""){
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('admissao'))->format('Y-m-d');           
            $profissional['admissao'] =  $dataFormatadaMysql;            
        } 

        Profissional::create($profissional); //salva

        Session::flash('create_profissional', 'Profissional cadastrado com sucesso!');

        return redirect(route('profissionals.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('vinculotipo.show')) {
            abort(403, 'Acesso negado.');
        }

        $profissional = Profissional::findOrFail($id);

        return view('profissionals.show', compact('profissional'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('vinculotipo.edit')) {
            abort(403, 'Acesso negado.');
        }

        $profissional = Profissional::findOrFail($id);

        // consulta a tabela dos cargos
        $cargos = Cargo::orderBy('nome', 'asc')->get();

        // consulta a tabela dos vínculos
        $vinculos = Vinculo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos tipos de vínculos
        $vinculotipos = VinculoTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos carga horária
        $cargahorarias = CargaHoraria::orderBy('descricao', 'asc')->get();

        return view('profissionals.edit', compact('profissional', 'cargos', 'vinculos', 'vinculotipos', 'cargahorarias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
