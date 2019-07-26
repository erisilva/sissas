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

        $input_profissional = $request->all();

        UnidadeProfissional::create($input_profissional); //salva

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

        $profissional->delete();        

        Session::flash('create_unidadeprofissional', 'profissional removido da unidade com sucesso!');

        return Redirect::route('unidades.edit', $unidade_id);
    }
}
