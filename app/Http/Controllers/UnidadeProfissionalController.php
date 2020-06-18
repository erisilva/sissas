<?php

namespace App\Http\Controllers;

use App\UnidadeProfissional;
use App\Profissional;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

use App\Historico;
use Auth;

class UnidadeProfissionalController extends Controller
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
        if (Gate::denies('unidade.profissional.create')) {
            abort(403, 'Acesso negado.');
        }

        $this->validate($request, [
          'profissional_id' => 'required',
        ],
        [
            'profissional_id.required' => 'Nenhum funcionário foi selecionado',
        ]);

        $input_profissional = $request->all();

        UnidadeProfissional::create($input_profissional); //salva

        // guarda o histórico
        $user = Auth::user();
        $historico = new Historico;
        $historico->user_id = $user->id;
        $historico->profissional_id = $input_profissional['profissional_id']; 
        $historico->unidade_id = $input_profissional['unidade_id'];
        $historico->historico_tipo_id = 11; //Profissional foi vinculado a uma unidade
        $historico->save();

        Session::flash('create_unidadeprofissional', 'Profissional adicionado a unidade com sucesso!');

        return Redirect::route('unidades.edit', $input_profissional['unidade_id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('unidade.profissional.delete')) {
            abort(403, 'Acesso negado.');
        }
        
        $profissional = UnidadeProfissional::findOrFail($id);

        $unidade_id = $profissional->unidade_id;

        // guarda o histórico
        $user = Auth::user();
        $historico = new Historico;
        $historico->user_id = $user->id;
        $historico->profissional_id = $profissional->profissional_id;
        $historico->historico_tipo_id = 12; //Profissional foi desvinculado de uma unidade
        $historico->save();

        $profissional->delete();      

        Session::flash('create_unidadeprofissional', 'profissional removido da unidade com sucesso!');

        return Redirect::route('unidades.edit', $unidade_id);
    }
}
