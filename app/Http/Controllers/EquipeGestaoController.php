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
use Auth;

class EquipeGestaoController extends Controller
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
        
        // mostrar somente os distritos que o usuário logado pode acessar
        $equipes = $equipes->whereHas('unidade', function ($query) {
                                                    $user = Auth::user(); // usuario logado
                                                    $distritos = $user->distritos->pluck(['id']); // array com os ids dos distritos que o usuário tem acesso
                                                    $query->whereIn('distrito_id', $distritos);
                                                }); 

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

        return view('equipes.gestao.index', compact('equipes', 'perpages', 'distritos'));
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

        $equipeprofissionais = EquipeProfissional::where('equipe_id', '=', $id)->orderBy('id', 'desc')->get();

        return view('equipes.gestao.show', compact('equipe', 'equipeprofissionais'));
    }

    /**
     * Preenche a vaga com o funcionario selecionado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function preenchervaga(Request $request)
    {

        $this->validate($request, [
          'equipe_id' => 'required', // preenchimento automático, cajo hava erro no script js
          'cargo_id' => 'required|same:cargo_profissional_id', // preenchimento automático, cajo hava erro no script js
          'equipeprofissional_id' => 'required', // preenchimento automático, cajo hava erro no script js          
          'cargo_profissional_id' => 'required', // preenchimento automático, cajo hava erro no script js
          'profissional_id' => 'required',
        ],
        [
            'equipe_id.required' => 'Erro no sistema. Id da equipe não selecionado',
            'cargo_id.required' => 'Erro no sistema. Id do cargo não selecionado',
            'equipeprofissional_id.required' => 'Erro no sistema. Id da equipe/profissional não selecionado',
            'cargo_profissional_id.required' => 'Erro no sistema. Id da cargo/profissional não selecionado',
            'cargo_id.same' => 'O cargo do profissional escolhido não é compatível com a vaga',
            'profissional_id.required' => 'O profissional não foi escolhido',
        ]);

        $input = $request->all();

        $vaga = EquipeProfissional::findOrFail($input['equipeprofissional_id']);

        if (!isset($vaga->profissional_id)){
          $vaga->profissional_id = $input['profissional_id'];

          $vaga->save();

          Session::flash('equipe_vincula', 'Profissional vinculado a equipe com sucesso!');
        } else {
          Session::flash('equipe_vincula', 'Já existe um profissional vinculado a essa vaga!');
        }
        return redirect(route('equipegestao.show', $input['equipe_id']));
    }

    /**
     * Limpa a vaga da equipe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function limparvaga(Request $request)
    {
      $this->validate($request, [
          'equipe_id_limpar' => 'required', // preenchimento automático, cajo hava erro no script js
          'equipeprofissional_id_limpar' => 'required', // preenchimento automático, cajo hava erro no script js          
        ],
        [
            'equipe_id_limpar.required' => 'Erro no sistema. Id da equipe não selecionado',
            'equipeprofissional_id_limpar.required' => 'Erro no sistema. Id da equipe/profissional não selecionado',
        ]);

      $input = $request->all();
      
      $vaga = EquipeProfissional::findOrFail($input['equipeprofissional_id_limpar']);

      if (isset($vaga->profissional_id)){
        $vaga->profissional_id = null;

        $vaga->save();

        Session::flash('equipe_vincula', 'Profissional desvinculado da vaga!');
      } else {
        Session::flash('equipe_vincula', 'Essa vaga já está desvinculada!');
      }
      return redirect(route('equipegestao.show', $input['equipe_id_limpar']));      

    }     

}
