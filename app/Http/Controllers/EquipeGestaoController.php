<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\Equipe;
use App\Models\Perpage;
use App\Models\Distrito;
use App\Models\EquipeTipo;
use App\Models\Cargo;
use App\Models\EquipeProfissional;


use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\EquipeGestaoExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel

class EquipeGestaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $this->authorize('gestao.equipe.index');

        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        return view('equipes.gestao.index', [
            'equipes' => Equipe::orderBy('descricao', 'asc')->filter(request(['descricao','numero', 'cnes', 'ine', 'minima', 'unidade', 'distrito', 'tipo']))->paginate(session('perPage', '5'))->appends(request(['name', 'description'])),
            'distritos' => Distrito::orderBy('nome')->get(),
            'equipetipos' => EquipeTipo::orderBy('nome')->get(),
            'perpages' => Perpage::orderBy('valor')->get()
        ]);        
    }

    

    /**
     * Display the specified resource.
     */
    public function show($id) : View
    {
        $this->authorize('gestao.equipe.show');

        return view('equipes.gestao.show', [
            'equipe' => Equipe::findOrFail($id),
            'equipeprofissionais' => EquipeProfissional::where('equipe_id', '=', $id)->orderBy('cargo_id', 'desc')->get()
        ]);
    }

   /**
     * Preenche a vaga com o funcionario selecionado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function preenchervaga(Request $request)
    {
        $this->authorize('gestao.equipe.vincular.vaga');

        $input = $this->validate($request, [
            'equipe_id' => 'required|integer|exists:equipes,id',
            'profissional_id' => 'required|integer|exists:profissionals,id',
            'cargo_id' => 'required|integer|exists:cargos,id',
            'equipeprofissional_id' => 'required',
            'cargo_profissional_id' => 'required',
        ]);

    }
    
    
    /**
     * Limpa a vaga da equipe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function limparvaga(Request $request)
    {
      if (Gate::denies('gestao.equipe.desvincular.vaga')) {
            abort(403, 'Acesso negado.');
      }

    }
    
    
     /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {
        if (Gate::denies('gestao.equipe.export')) {
            abort(403, 'Acesso negado.');
        }

    }

         /**
     * Exportação para planilha (xls)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportxls()
    {
        if (Gate::denies('gestao.equipe.export')) {
            abort(403, 'Acesso negado.');
        }

    }

    /**
     * Exportação para planilha (csv), traz todos dados, com redundancias na planilha
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsvcompleto()
    {
        if (Gate::denies('gestao.equipe.export')) {
            abort(403, 'Acesso negado.');
        }

    }
    
        /**
     * Exportação para pdf
     *
     * @param  
     * @return 
     */
    public function exportpdf()
    {
        if (Gate::denies('gestao.equipe.export')) {
            abort(403, 'Acesso negado.');
        }

    }
    
    /**
     * Exportação para pdf por protocolo
     *
     * @param  $id, id do protocolo
     * @return pdf
     */
    public function exportpdfindividual($id)
    {
        if (Gate::denies('gestao.equipe.export')) {
            abort(403, 'Acesso negado.');
        }    

    }    
}
