<?php

namespace App\Http\Controllers;

use App\Equipe;
use App\EquipeProfissional;
use App\Perpage;
use App\Distrito;
use App\Cargo;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Redirect; // para poder usar o redirect

use Illuminate\Database\Eloquent\Builder; // para poder usar o whereHas nos filtros

class EquipeController extends Controller
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
    public function __construct(\App\Reports\EquipeReport $pdf)
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
        if (Gate::denies('equipe.index')) {
            abort(403, 'Acesso negado.');
        }

        $equipes = new Equipe;
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

        return view('equipes.index', compact('equipes', 'perpages', 'distritos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('equipe.create')) {
            abort(403, 'Acesso negado.');
        }   
        return view('equipes.create');
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
          'descricao' => 'required',
          'numero' => 'required',
          'cnes' => 'required',
          'cnes' => 'required',
          'ine' => 'required',
          'minima' => 'required',
          'unidade_id' => 'required',
        ],
        [
            'unidade_id.required' => 'Preencha o campo de unidade',
        ]);

        $equipe_input = $request->all();

        $equipe = Equipe::create($equipe_input); //salva

        Session::flash('create_equipe', 'Equipe cadastrada com sucesso!');

        return Redirect::route('equipes.edit', $equipe->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('equipe.show')) {
            abort(403, 'Acesso negado.');
        }

        $equipe = Equipe::findOrFail($id);

        return view('equipes.show', compact('equipe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('equipe.edit')) {
            abort(403, 'Acesso negado.');
        }

        $equipe = Equipe::findOrFail($id);

        $cargos = Cargo::orderBy('nome', 'asc')->get();

        $equipeprofissionais = EquipeProfissional::where('equipe_id', '=', $id)->orderBy('id', 'desc')->get();

        return view('equipes.edit', compact('equipe', 'cargos', 'equipeprofissionais'));
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
        $this->validate($request, [
          'descricao' => 'required',
          'numero' => 'required',
          'cnes' => 'required',
          'cnes' => 'required',
          'ine' => 'required',
          'minima' => 'required',
          'unidade_id' => 'required',
        ],
        [
            'unidade_id.required' => 'Preencha o campo de unidade',
        ]);

        $equipe = Equipe::findOrFail($id);
            
        $equipe->update($request->all());
        
        Session::flash('edited_equipe', 'Equipe alterada com sucesso!');

        return redirect(route('equipes.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('equipe.delete')) {
            abort(403, 'Acesso negado.');
        }

        Equipe::findOrFail($id)->delete();

        Session::flash('deleted_equipe', 'Equipe excluída com sucesso!');

        return redirect(route('equipes.index'));
    }
}
