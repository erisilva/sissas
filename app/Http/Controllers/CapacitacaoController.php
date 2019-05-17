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

class CapacitacaoController extends Controller
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
        $this->validate($request, [
            'capacitacao_inicio' => 'required',
            'capacitacao_final' => 'required',
            'capacitacao_tipo_id' => 'required',
        ],
        [
            'capacitacao_inicio.required' => 'Data inicial do período deve ser preenchida',
            'capacitacao_final.required' => 'Data final do período deve ser preenchida',
            'capacitacao_tipo_id.required' => 'Selecione na lista o tipo de capacitação',
        ]);

        $input_capacitacao = $request->all();

        if ($input_capacitacao['capacitacao_inicio'] != ""){
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('capacitacao_inicio'))->format('Y-m-d');
            // salva a data formatada com a variável correta  
            $input_capacitacao['inicio'] =  $dataFormatadaMysql;      
        }

        if ($input_capacitacao['capacitacao_final'] != ""){
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('capacitacao_final'))->format('Y-m-d');
            // salva a data formatada com a variável correta        
            $input_capacitacao['fim'] =  $dataFormatadaMysql;       
        }

        // ajusta a observação
        $input_capacitacao['observacao'] = $input_capacitacao['capacitacao_observacao'];
        $input_capacitacao['cargaHoraria'] = $input_capacitacao['capacitacao_cargahoraria'];


        // recebi o usuário logado no sistema
        $user = Auth::user();

        $input_capacitacao['user_id'] = $user->id;

        // salva
        Capacitacao::create($input_capacitacao);


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
        $profissional = Profissional::find($input_capacitacao['profissional_id']);

        // consulta todas férias do profissional
        $ferias = Ferias::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $licencas = Licenca::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $capacitacaos = Capacitacao::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        Session::flash('create_capacitacao', 'Capacitação inserida com sucesso!');        

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
        $capacitacao_deletar = Capacitacao::findOrFail($id);

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
        $profissional = Profissional::find($capacitacao_deletar->profissional_id);

        // consulta todas férias do profissional
        $ferias = Ferias::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $licencas = Licenca::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $capacitacaos = Capacitacao::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        $capacitacao_deletar->delete();        

        Session::flash('delete_licenca', 'Capacitação excluída com sucesso!');

        return Redirect::route('profissionals.edit', $capacitacao_deletar->profissional_id)->with('profissional', 'cargos', 'vinculos', 'vinculotipos', 'cargahorarias', 'ferias', 'licencas', 'capacitacaotipos', 'capacitacaos');
    }
}
