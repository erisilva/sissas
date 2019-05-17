<?php

namespace App\Http\Controllers;

use App\Profissional;
use App\Cargo;
use App\Vinculo;
use App\VinculoTipo;
use App\CargaHoraria;
use App\Perpage;

use App\FeriasTipo;
use App\Ferias;

use App\LicencaTipo;
use App\Licenca;

use App\Capacitacao;
use App\CapacitacaoTipo;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Carbon\Carbon; // tratamento de datas

use Illuminate\Support\Facades\Redirect; // para poder usar o redirect

class ProfissionalTrashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('profissional.trash.index')) {
            abort(403, 'Acesso negado.');
        }

        $profissionals = new Profissional;

        $profissionals = $profissionals->onlyTrashed();

        // filtros
        if (request()->has('matricula')){
            $profissionals = $profissionals->where('matricula', 'like', '%' . request('matricula') . '%');
        }

        if (request()->has('nome')){
            $profissionals = $profissionals->where('nome', 'like', '%' . request('nome') . '%');
        }

        if (request()->has('cargo_id')){
            if (request('cargo_id') != ""){
                $profissionals = $profissionals->where('cargo_id', '=', request('cargo_id'));
            }
        } 

        if (request()->has('vinculo_id')){
            if (request('vinculo_id') != ""){
                $profissionals = $profissionals->where('vinculo_id', '=', request('vinculo_id'));
            }
        } 

        // ordena
        $profissionals = $profissionals->orderBy('nome', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $profissionals = $profissionals->paginate(session('perPage', '5'))->appends([          
            'matricula' => request('matricula'),
            'nome' => request('nome'),
            'cargo_id' => request('cargo_id'),
            'vinculo_id' => request('vinculo_id'),         
            ]);

        // consulta a tabela dos cargos
        $cargos = Cargo::orderBy('nome', 'asc')->get();

        // consulta a tabela dos vínculos
        $vinculos = Vinculo::orderBy('descricao', 'asc')->get();

        return view('profissionals.trash.index', compact('profissionals', 'perpages', 'cargos', 'vinculos'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('profissional.trash.index')) {
            abort(403, 'Acesso negado.');
        }

        $profissional = Profissional::withTrashed()->findOrFail($id);   

        // consulta todas férias do profissional
        $ferias = Ferias::where('profissional_id', '=', $id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $licencas = Licenca::where('profissional_id', '=', $id)->orderBy('id', 'desc')->get();

        // consulta todas capacitações do profissional
        $capacitacaos = Capacitacao::where('profissional_id', '=', $id)->orderBy('id', 'desc')->get();

        return view('profissionals.trash.show', compact('profissional', 'ferias', 'licencas', 'capacitacaos'));
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
        if (Gate::denies('profissional.trash.restore')) {
            abort(403, 'Acesso negado.');
        }
        
        $profissional = Profissional::withTrashed()->findOrFail($id)->restore();

        Session::flash('restore_profissional', 'Profissional restaurado com sucesso!');

        return Redirect::route('profissionals.index');
    }

}
