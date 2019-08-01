<?php

namespace App\Http\Controllers;

use App\EquipeProfissional;
use App\Profissional;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class EquipeVagasController extends Controller
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
        // if (Gate::denies('equipe.vagas.create')) {
        //     abort(403, 'Acesso negado.');
        // }

        $this->validate($request, [
          'cargo_id' => 'required',
        ],
        ['cargo_id.required' => 'Selecione na lista o cargo']);

        $input_vaga = $request->all();

        EquipeProfissional::create($input_vaga); //salva

        Session::flash('create_equipevaga', 'Vaga adicionada a equipe com sucesso!');

        return Redirect::route('equipes.edit', $input_vaga['equipe_id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (Gate::denies('equipe.vagas.delete')) {
        //     abort(403, 'Acesso negado.');
        // }
        
        $equipevaga = EquipeProfissional::findOrFail($id);

        $equipe_id = $equipevaga->equipe_id;

        $equipevaga->delete();        

        Session::flash('create_equipevaga', 'Vaga removida da equipe com sucesso!');

        return Redirect::route('equipes.edit', $equipe_id);
    }
}
