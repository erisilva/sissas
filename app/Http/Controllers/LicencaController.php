<?php

namespace App\Http\Controllers;

use App\Profissional;

use App\Ferias;
use App\FeriasTipo;

use App\Licenca;
use App\LicencaTipo;

use App\Capacitacao;
use App\CapacitacaoTipo;

use App\Cargo;
use App\Vinculo;
use App\VinculoTipo;
use App\CargaHoraria;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon; // tratamento de datas
use Illuminate\Support\Facades\Redirect; // para poder usar o redirect

use Auth; // receber o id do operador logado no sistema


class LicencaController extends Controller
{

    /**
     * Construtor.
     *
     * precisa estar logado ao sistema
     * precisa ter a conta ativa (access)
     *
     * @return 
     */
    public function __construct()
    {
        $this->middleware(['middleware' => 'auth']);
        $this->middleware(['middleware' => 'hasaccess']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('profissional.licenca.create')) {
            abort(403, 'Acesso negado.');
        }

        $this->validate($request, [
            'licenca_inicio' => 'required',
            'licenca_final' => 'required',
            'licenca_tipo_id' => 'required',
        ],
        [
            'licenca_inicio.required' => 'Data inicial do período deve ser preenchida',
            'licenca_final.required' => 'Data final do período deve ser preenchida',
            'licenca_tipo_id.required' => 'Selecione na lista o tipo de licença',
        ]);

        $input_licenca = $request->all();

        if ($input_licenca['licenca_inicio'] != ""){
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('licenca_inicio'))->format('Y-m-d');
            // salva a data formatada com a variável correta  
            $input_licenca['inicio'] =  $dataFormatadaMysql;      
        }

        if ($input_licenca['licenca_final'] != ""){
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('licenca_final'))->format('Y-m-d');
            // salva a data formatada com a variável correta        
            $input_licenca['fim'] =  $dataFormatadaMysql;       
        }

        // ajusta a observação
        $input_licenca['observacao'] = $input_licenca['licenca_observacao'];


        // recebi o usuário logado no sistema
        $user = Auth::user();

        $input_licenca['user_id'] = $user->id;

        // salva
        Licenca::create($input_licenca);

        // consulta a tabela dos cargos
        $cargos = Cargo::orderBy('nome', 'asc')->get();

        // consulta a tabela dos de tipo de férias
        $feriastipos = FeriasTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos de tipo de licenças
        $licencatipos = LicencaTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos de tipo de capacitacaoes
        $capacitacaotipos = CapacitacaoTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos vínculos
        $vinculos = Vinculo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos tipos de vínculos
        $vinculotipos = VinculoTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos carga horária
        $cargahorarias = CargaHoraria::orderBy('descricao', 'asc')->get();

        // consulta os dados do profissional
        $profissional = Profissional::find($input_licenca['profissional_id']);

        // consulta todas férias do profissional
        $ferias = Ferias::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $licencas = Licenca::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $capacitacaos = Capacitacao::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        Session::flash('create_licenca', 'Período de licença inserido com sucesso!');        

        return Redirect::route('profissionals.edit', $profissional->id)->with('profissional', 'cargos', 'vinculos', 'vinculotipos', 'cargahorarias', 'ferias', 'feriastipos', 'licencatipos', 'licencas', 'capacitacaotipos', 'capacitacaos');


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('licenca.ferias.delete')) {
            abort(403, 'Acesso negado.');
        }

        $licenca_deletar = Licenca::findOrFail($id);

        // consulta a tabela dos cargos
        $cargos = Cargo::orderBy('nome', 'asc')->get();

        // consulta a tabela dos de tipo de férias
        $feriastipos = FeriasTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos de tipo de licenças
        $licencatipos = LicencaTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos de tipo de capacitacaoes
        $capacitacaotipos = CapacitacaoTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos vínculos
        $vinculos = Vinculo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos tipos de vínculos
        $vinculotipos = VinculoTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos carga horária
        $cargahorarias = CargaHoraria::orderBy('descricao', 'asc')->get();

        // consulta os dados do profissional
        $profissional = Profissional::find($licenca_deletar->profissional_id);

        // consulta todas férias do profissional
        $ferias = Ferias::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $licencas = Licenca::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $capacitacaos = Capacitacao::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        $licenca_deletar->delete();        

        Session::flash('delete_licenca', 'Período de licença excluído com sucesso!');

        return Redirect::route('profissionals.edit', $licenca_deletar->profissional_id)->with('profissional', 'cargos', 'vinculos', 'vinculotipos', 'cargahorarias', 'ferias', 'licencas', 'capacitacaotipos', 'capacitacaos');
    }
}
