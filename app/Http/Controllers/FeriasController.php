<?php

namespace App\Http\Controllers;

use App\Profissional;
use App\Ferias;

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

use Illuminate\Support\Facades\DB;

class FeriasController extends Controller
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
          'ferias_inicio' => 'required',
          'ferias_final' => 'required',
          'ferias_tipo_id' => 'required',
        ],
        [
            'ferias_inicio.required' => 'Data inicial do período deve ser preenchida',
            'ferias_final.required' => 'Data final do período deve ser preenchida',
            'ferias_tipo_id.required' => 'Selecione na lista o tipo de férias',
        ]);

        $input_ferias = $request->all();

        if ($input_ferias['ferias_inicio'] != ""){
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('ferias_inicio'))->format('Y-m-d');
            // salva a data formatada com a variável correta        
            $input_ferias['inicio'] =  $dataFormatadaMysql;            
        }

        if ($input_ferias['ferias_final'] != ""){
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('ferias_final'))->format('Y-m-d');
            // salva a data formatada com a variável correta        
            $input_ferias['fim'] =  $dataFormatadaMysql;            
        }

        // ajusta a observação e justificativa
        $input_ferias['justificativa'] = $input_ferias['ferias_justificativa'];
        $input_ferias['observacao'] = $input_ferias['ferias_observacao'];


        // recebi o usuário logado no sistema
        $user = Auth::user();

        $input_ferias['user_id'] = $user->id;

        // salva
        Ferias::create($input_ferias);



        // consulta a tabela dos cargos
        $cargos = Cargo::orderBy('nome', 'asc')->get();

        // consulta a tabela dos vínculos
        $vinculos = Vinculo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos tipos de vínculos
        $vinculotipos = VinculoTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos carga horária
        $cargahorarias = CargaHoraria::orderBy('descricao', 'asc')->get();

        // consulta os dados do profissional
        $profissional = Profissional::find($input_ferias['profissional_id']);

        // consulta todas férias do profissional
        $ferias = Ferias::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();


        Session::flash('create_ferias', 'Período de férias inserido com sucesso!');        

        return Redirect::route('profissionals.edit', $profissional->id)->with('profissional', 'cargos', 'vinculos', 'vinculotipos', 'cargahorarias', 'ferias,
            ');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $ferias_deletar = Ferias::findOrFail($id);

         // consulta a tabela dos cargos
        $cargos = Cargo::orderBy('nome', 'asc')->get();

        // consulta a tabela dos vínculos
        $vinculos = Vinculo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos tipos de vínculos
        $vinculotipos = VinculoTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos carga horária
        $cargahorarias = CargaHoraria::orderBy('descricao', 'asc')->get();

        // consulta os dados do profissional
        $profissional = Profissional::find($ferias_deletar->profissional_id);

        // consulta todas férias do profissional
        $ferias = Ferias::where('profissional_id', '=', $ferias_deletar->profissional_id)->orderBy('id', 'desc')->get();

        $ferias_deletar->delete();        

        Session::flash('delete_ferias', 'Período de férias excluído com sucesso!');

        return Redirect::route('profissionals.edit', $ferias_deletar->profissional_id)->with('profissional', 'cargos', 'vinculos', 'vinculotipos', 'cargahorarias', 'ferias,
            ');

    }
}
