<?php

namespace App\Http\Controllers;

use App\Equipe;
use App\Perpage;
use App\Distrito;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class EquipeTrashController extends Controller
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
        if (Gate::denies('equipe.trash.index')) {
            abort(403, 'Acesso negado.');
        }

        $equipes = new Equipe;

        $equipes = $equipes->onlyTrashed();

        // filtros
        if (request()->has('descricao')){
            $equipes = $equipes->where('descricao', 'like', '%' . request('descricao') . '%');
        }

        if (request()->has('numero')){
            $equipes = $equipes->where('numero', 'like', '%' . request('numero') . '%');
        }

        if (request()->has('cnes')){
            $equipes = $equipes->where('cnes', 'like', '%' . request('cnes') . '%');
        }

        if (request()->has('unidade')){
            $equipes = $equipes->whereHas('unidade', function ($query) {
                                                $query->where('descricao', 'like', '%' . request('unidade') . '%');
                                            });
        }

        if (request()->has('distrito_id')){
            if (request('distrito_id') != ""){
                $equipes = $equipes->whereHas('unidade', function ($query) {
                                                    $query->where('distrito_id', '=', request('distrito_id'));
                                                });                
            }
        }

        if (request()->has('minima')){
            if (request('minima') != ""){
                $equipes = $equipes->where('minima', 'like', '%' . request('minima') . '%');   
            }
        } 

        // ordena
        $equipes = $equipes->orderBy('descricao', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $equipes = $equipes->paginate(session('perPage', '5'))->appends([          
            'descricao' => request('descricao'),
            'numero' => request('numero'),
            'cnes' => request('cnes'),
            'distrito_id' => request('distrito_id'),         
            'minima' => request('minima'),         
            ]);

        // tabelas auxiliares usadas pelo filtro
        $distritos = Distrito::orderBy('nome', 'asc')->get();

        return view('equipes.trash.index', compact('equipes', 'perpages', 'distritos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('equipe.trash.index')) {
            abort(403, 'Acesso negado.');
        }

        $equipe = Equipe::withTrashed()->findOrFail($id);

        return view('equipes.trash.show', compact('equipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (Gate::denies('equipe.trash.restore')) {
            abort(403, 'Acesso negado.');
        }
        
        $equipe = Equipe::withTrashed()->findOrFail($id)->restore();

        Session::flash('restore_equipe', 'Equipe restaurada com sucesso!');

        return Redirect::route('equipes.index');
    }
}

