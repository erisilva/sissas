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
use App\Perpage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon; // tratamento de datas
use Illuminate\Support\Facades\Redirect; // para poder usar o redirect
use Auth; // receber o id do operador logado no sistema
use App\Historico;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('distrito.index')) {
            abort(403, 'Acesso negado.');
        }

        $ferias = new Ferias;

        // ordena
        $ferias = $ferias->orderBy('id', 'desc');


        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $ferias = $ferias->paginate(session('perPage', '5'));

        // consulta a tabela dos de tipo de férias
        $feriastipos = FeriasTipo::orderBy('descricao', 'asc')->get();

        return view('profissionals.ferias.index', compact('ferias', 'perpages', 'feriastipos'));
    }    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('profissional.ferias.create')) {
            abort(403, 'Acesso negado.');
        }

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
        $profissional = Profissional::find($input_ferias['profissional_id']);

        // consulta todas férias do profissional
        $ferias = Ferias::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $licencas = Licenca::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $capacitacaos = Capacitacao::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        // guarda o histórico
        $user = Auth::user();
        $historico = new Historico;
        $historico->user_id = $user->id;
        $historico->profissional_id = $profissional->id;
        $historico->historico_tipo_id = 5; //Foi cadastrado uma férias para o profissional
        $feriasTipoTemp = FeriasTipo::findOrFail($input_ferias['ferias_tipo_id']);
        $historico->observacao = $feriasTipoTemp->descricao . ', periodo entre ' . $input_ferias['ferias_inicio'] . ' e ' . $input_ferias['ferias_final'];
        $historico->save();

        Session::flash('create_ferias', 'Período de férias inserido com sucesso!');        

        return Redirect::route('profissionals.edit', $profissional->id)->with('profissional', 'cargos', 'vinculos', 'vinculotipos', 'cargahorarias', 'ferias', 'feriastipos', 'licencatipos', 'licencas', 'capacitacaotipos', 'capacitacaos');
        #Nota mental, não é necessário passar todos dados para a view com with, o proprio redirect já faz a chamada a esses dados pelo controlador
        #do profissional, não vou alterar pra deixar marcado meu erro, mas não é um erro, é só um jeito mais complexo
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('profissional.ferias.delete')) {
            abort(403, 'Acesso negado.');
        }
        
        $ferias_deletar = Ferias::findOrFail($id);

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
        $profissional = Profissional::find($ferias_deletar->profissional_id);

        // consulta todas férias do profissional
        $ferias = Ferias::where('profissional_id', '=', $ferias_deletar->profissional_id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $licencas = Licenca::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $capacitacaos = Capacitacao::where('profissional_id', '=', $profissional->id)->orderBy('id', 'desc')->get();

        // guarda o histórico
        $user = Auth::user();
        $historico = new Historico;
        $historico->user_id = $user->id;
        $historico->profissional_id = $profissional->id;
        $historico->historico_tipo_id = 6; //Foi excluído uma férias do profissional
        $historico->observacao = $ferias_deletar->feriasTipo->descricao . ' excluida(o). Período entre ' . $ferias_deletar->inicio->format('d/m/Y') . ' e ' . $ferias_deletar->fim->format('d/m/Y');
        $historico->save();

        $ferias_deletar->delete();

    
        Session::flash('delete_ferias', 'Período de férias excluído com sucesso!');

        return Redirect::route('profissionals.edit', $ferias_deletar->profissional_id)->with('profissional', 'cargos', 'vinculos', 'vinculotipos', 'cargahorarias', 'ferias', 'licencas', 'feriastipos', 'licencatipos', 'capacitacaotipos', 'capacitacaos');

    }
}
