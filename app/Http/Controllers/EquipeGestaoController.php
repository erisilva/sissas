<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;

use App\Models\Equipe;
use App\Models\Perpage;
use App\Models\Cargo;
use App\Models\Vinculo;
use App\Models\VinculoTipo;
use App\Models\CargaHoraria;
use App\Models\OrgaoEmissor;
use App\Models\EquipeProfissional;
use App\Models\EquipeTipo;



use Barryvdh\DomPDF\Facade\Pdf; // Export PDF

use App\Exports\EquipeGestaoExport;
use Maatwebsite\Excel\Facades\Excel; // Export Excel
use App\Models\Historico;

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
            'equipes' => Equipe::orderBy('descricao', 'asc')
                ->filter(request(['descricao','numero', 'cnes', 'ine', 'minima', 'unidade', 'distrito', 'tipo']))
                ->paginate(session('perPage', '5')
                )->appends(request(['descricao','numero', 'cnes', 'ine', 'minima', 'unidade', 'distrito', 'tipo'])),
            'distritos' => auth()->user()->distritos->sortBy('nome'),
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
            'equipeprofissionais' => EquipeProfissional::where('equipe_id', '=', $id)->orderBy('cargo_id', 'desc')->get(),
            'cargos' => Cargo::orderBy('nome')->get(),
            'vinculos' => Vinculo::orderBy('nome')->get(),
            'vinculotipos' => VinculoTipo::orderBy('nome')->get(),
            'cargahorarias' => CargaHoraria::orderBy('nome')->get(),
            'orgaoemissors' => OrgaoEmissor::orderBy('nome')->get(),
        ]);
    }

   /**
     * Preenche a vaga com o funcionario selecionado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function preenchervaga(Request $request) : RedirectResponse
    {
        $this->authorize('gestao.equipe.vincular.vaga');

        $input = $this->validate($request, [
            'equipe_id' => 'required|integer|exists:equipes,id',
            'profissional_id' => 'required|integer|exists:profissionals,id',
            'cargo_id' => 'required|integer|exists:cargos,id|same:cargo_profissional_id',
            'equipeprofissional_id' => 'required|integer',
            'cargo_profissional_id' => 'required|integer',
        ],[
            'cargo_id.same' => 'O cargo selecionado não é compatível com o profissional selecionado.'
        ]
        );

        $vaga = EquipeProfissional::findOrFail($input['equipeprofissional_id']);

        if (!isset($vaga->profissional_id)){
            $vaga->profissional_id = $input['profissional_id'];
            $vaga->save();
            $historico = new Historico;
            $historico->user_id = auth()->id();
            $historico->profissional_id = $input['profissional_id'];
            $historico->historico_tipo_id = 13; //Profissional foi vinculado a uma equipe
            $historico->equipe_id = $vaga->equipe_id;
            $historico->unidade_id = $vaga->unidade_id;
            $historico->save();
            $mensagem = 'Profissional vinculado a equipe com sucesso!' ;
        } else {
            $mensagem = 'Vaga já preenchida!' ;
        }    

        return redirect()->route('equipegestao.show', $input['equipe_id'])->with('message', $mensagem);
    }
    
    
    /**
     * Limpa a vaga da equipe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function limparvaga(Request $request) : RedirectResponse
    {
      $this->authorize('gestao.equipe.vincular.vaga');

        $input = $this->validate($request, [
            'equipeprofissional_id_limpar' => 'required|integer|exists:equipe_profissionals,id',
            'equipe_id_limpar' => 'required|integer|exists:equipes,id',
        ]);

        $vaga = EquipeProfissional::findOrFail($input['equipeprofissional_id_limpar']);

        if (isset($vaga->profissional_id)){
        
            $historico = new Historico;
            $historico->user_id = auth()->id();
            $historico->profissional_id = $vaga->profissional_id;
            $historico->historico_tipo_id = 14; //Profissional foi desvinculado de uma equipe
            $historico->observacao = $request['motivo_limpar'];
            $historico->equipe_id = $vaga->equipe_id;
            $historico->unidade_id = $vaga->unidade_id;
            $historico->save();
            
            $vaga->profissional_id = null;
            $vaga->save();
            $mensagem = 'Vaga limpa com sucesso!' ;
        } else {
            $mensagem = 'Vaga já está limpa!' ;
        }    

        return redirect()->route('equipegestao.show', $input['equipe_id_limpar'])->with('message', $mensagem);
    }

        /**
     * Limpa a vaga da equipe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registrarvaga(Request $request) : RedirectResponse
    {
        $this->authorize('gestao.equipe.cadastrar.profissional.vaga'); 

        //code ..

        return redirect()->route('equipegestao.show', $request['equipe_id'])->with('message', 'Registrar');
    }
    
    
     /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('gestao.equipe.export');

        return Excel::download(new EquipeGestaoExport(request(['descricao','numero', 'cnes', 'ine', 'minima', 'unidade', 'distrito', 'tipo'])),  'EquipesGestao_' .  date("Y-m-d H:i:s") . '.csv', \Maatwebsite\Excel\Excel::CSV);

    }

    /**
     * Exportação para planilha (xls)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportxls() : \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $this->authorize('gestao.equipe.export');

        return Excel::download(new EquipeGestaoExport(request(['descricao','numero', 'cnes', 'ine', 'minima', 'unidade', 'distrito', 'tipo'])),  'EquipesGestao_' .  date("Y-m-d H:i:s") . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
    
    /**
     * Exportação para pdf
     *
     * @param  
     * @return 
     */
    public function exportpdf()  : \Illuminate\Http\Response
    {
        $this->authorize('gestao.equipe.export');

        return Pdf::loadView('equipes.gestao.report', [
            'dataset' => Equipe::orderBy('descricao', 'asc')->filter(request(['descricao','numero', 'cnes', 'ine', 'minima', 'unidade', 'distrito', 'tipo']))->get()
        ])->download('EquipesGestao_' .  date("Y-m-d H:i:s") . '.pdf');

    }
     
}
