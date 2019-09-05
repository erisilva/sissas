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
        if (Gate::denies('gestao.equipe.index')) {
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
        if (Gate::denies('gestao.equipe.show')) {
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
        if (Gate::denies('gestao.equipe.vincular.vaga')) {
            abort(403, 'Acesso negado.');
        }

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
      if (Gate::denies('gestao.equipe.desvincular.vaga')) {
            abort(403, 'Acesso negado.');
      }

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

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=equipes_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $equipes = DB::table('equipes');

        // join
        $equipes = $equipes->join('unidades', 'unidades.id', '=', 'equipes.unidade_id');
        $equipes = $equipes->join('distritos', 'distritos.id', '=', 'unidades.distrito_id');
        // select
        $equipes = $equipes->select(
          'equipes.descricao', 
          'equipes.numero', 
          'equipes.cnes', 
          'equipes.ine', 
          'equipes.minima', 
          'unidades.descricao as unidade', 
          'distritos.nome as distrito'
        );

        //filtros
        if (request()->has('descricao')){
            $equipes = $equipes->where('equipes.descricao', 'like', '%' . request('descricao') . '%');
        }
        if (request()->has('numero')){
            $equipes = $equipes->where('equipes.numero', 'like', '%' . request('numero') . '%');
        }
        if (request()->has('cnes')){
            $equipes = $equipes->where('equipes.cnes', 'like', '%' . request('cnes') . '%');
        }
        if (request()->has('unidade')){
            $equipes = $equipes->where('unidades.descricao', 'like', '%' . request('unidade') . '%');
        }
        if (request()->has('distrito_id')){
            if (request('distrito_id') != ""){
                $equipes = $equipes->where('unidades.distrito_id', '=', request('distrito_id'));
            }
        }
        if (request()->has('minima')){
            if (request('minima') != ""){
                $equipes = $equipes->where('equipes.minima', 'like', '%' . request('minima') . '%');
            }    
        }
        $user = Auth::user(); // usuario logado
        $distritos = $user->distritos->pluck(['id']); // array com os ids dos distritos que o usuário tem acesso
        $equipes = $equipes->whereIn('distritos.id', $distritos); // exporta apenas os distritos que o operador tiver acesso

        $equipes = $equipes->orderBy('equipes.descricao', 'asc');

        $list = $equipes->get()->toArray();

        # converte os objetos para uma array
        $list = json_decode(json_encode($list), true);

        # add headers for each column in the CSV download
        if (!empty($list)){
          array_unshift($list, array_keys($list[0]));
        }

       $callback = function() use ($list)
        {
            $FH = fopen('php://output', 'w');
            fputs($FH, $bom = ( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
            foreach ($list as $row) {
                fputcsv($FH, $row, chr(9));
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
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

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=equipes_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $equipes = DB::table('equipes');

        // join
        $equipes = $equipes->join('equipe_profissionals', 'equipe_profissionals.equipe_id', '=', 'equipes.id');
          $equipes = $equipes->join('cargos', 'cargos.id', '=', 'equipe_profissionals.cargo_id');  
          $equipes = $equipes->leftjoin('profissionals', 'profissionals.id', '=', 'equipe_profissionals.profissional_id');  
        $equipes = $equipes->join('unidades', 'unidades.id', '=', 'equipes.unidade_id');
        $equipes = $equipes->join('distritos', 'distritos.id', '=', 'unidades.distrito_id');
        // select
        $equipes = $equipes->select(
          'unidades.descricao as unidade',
          'distritos.nome as distrito',
          'equipes.descricao', 
          'equipes.numero', 'equipes.cnes', 'equipes.ine', 'equipes.minima',
          'cargos.nome as cargo',
          'cargos.cbo',
          DB::raw("coalesce(profissionals.nome, '') as profissional"),
          DB::raw("coalesce(profissionals.matricula, '') as matricula")
        );

        //filtros
        if (request()->has('descricao')){
            $equipes = $equipes->where('equipes.descricao', 'like', '%' . request('descricao') . '%');
        }
        if (request()->has('numero')){
            $equipes = $equipes->where('equipes.numero', 'like', '%' . request('numero') . '%');
        }
        if (request()->has('cnes')){
            $equipes = $equipes->where('equipes.cnes', 'like', '%' . request('cnes') . '%');
        }
        if (request()->has('unidade')){
            $equipes = $equipes->where('unidades.descricao', 'like', '%' . request('unidade') . '%');
        }
        if (request()->has('distrito_id')){
            if (request('distrito_id') != ""){
                $equipes = $equipes->where('unidades.distrito_id', '=', request('distrito_id'));
            }
        }
        if (request()->has('minima')){
            if (request('minima') != ""){
                $equipes = $equipes->where('equipes.minima', 'like', '%' . request('minima') . '%');
            }    
        }
        $user = Auth::user(); // usuario logado
        $distritos = $user->distritos->pluck(['id']); // array com os ids dos distritos que o usuário tem acesso
        $equipes = $equipes->whereIn('distritos.id', $distritos); // exporta apenas os distritos que o operador tiver acesso
        // ordena
        $equipes->orders = array(
          array('column' => 'unidades.descricao', 'direction' => 'asc'), 
          array('column' => 'distritos.nome', 'direction' => 'asc'),
          array('column' => 'equipes.descricao', 'direction' => 'asc')
        );

        $list = $equipes->get()->toArray();

        # converte os objetos para uma array
        $list = json_decode(json_encode($list), true);

        # add headers for each column in the CSV download
        if (!empty($list)){
          array_unshift($list, array_keys($list[0]));
        }

       $callback = function() use ($list)
        {
            $FH = fopen('php://output', 'w');
            fputs($FH, $bom = ( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
            foreach ($list as $row) {
                fputcsv($FH, $row, chr(9));
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
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

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 11);
        $this->pdf->AddPage();

        $equipes = DB::table('equipes');
        // join
        $equipes = $equipes->join('unidades', 'unidades.id', '=', 'equipes.unidade_id');
        $equipes = $equipes->join('distritos', 'distritos.id', '=', 'unidades.distrito_id');
        // select
        $equipes = $equipes->select(
          'equipes.id as id', 
          'equipes.descricao', 
          'equipes.numero', 
          'equipes.cnes', 
          'equipes.ine', 
          'equipes.minima', 
          'unidades.descricao as unidade', 
          'distritos.nome as distrito'
        );
        //filtros
        if (request()->has('descricao')){
            $equipes = $equipes->where('equipes.descricao', 'like', '%' . request('descricao') . '%');
        }
        if (request()->has('numero')){
            $equipes = $equipes->where('equipes.numero', 'like', '%' . request('numero') . '%');
        }
        if (request()->has('cnes')){
            $equipes = $equipes->where('equipes.cnes', 'like', '%' . request('cnes') . '%');
        }
        if (request()->has('unidade')){
            $equipes = $equipes->where('unidades.descricao', 'like', '%' . request('unidade') . '%');
        }
        if (request()->has('distrito_id')){
            if (request('distrito_id') != ""){
                $equipes = $equipes->where('unidades.distrito_id', '=', request('distrito_id'));
            }
        }
        if (request()->has('minima')){
            if (request('minima') != ""){
                $equipes = $equipes->where('equipes.minima', 'like', '%' . request('minima') . '%');
            }    
        }
        $user = Auth::user(); // usuario logado
        $distritos = $user->distritos->pluck(['id']); // array com os ids dos distritos que o usuário tem acesso
        $equipes = $equipes->whereIn('distritos.id', $distritos); // exporta apenas os distritos que o operador tiver acesso
        // ordena
        $equipes = $equipes->orderBy('equipes.descricao', 'asc');
        // get
        $equipes = $equipes->get();

        foreach ($equipes as $equipe) {
          $this->pdf->Cell(126, 6, utf8_decode('Descrição'), 1, 0,'L');
          $this->pdf->Cell(60, 6, utf8_decode('Número'), 1, 0,'L');
          $this->pdf->Ln();
          $this->pdf->Cell(126, 6, utf8_decode($equipe->descricao), 1, 0,'L');
          $this->pdf->Cell(60, 6, utf8_decode($equipe->numero), 1, 0,'L');
          $this->pdf->Ln();

          $this->pdf->Cell(62, 6, utf8_decode('CNES'), 1, 0,'L');
          $this->pdf->Cell(62, 6, utf8_decode('INE'), 1, 0,'L');
          $this->pdf->Cell(62, 6, utf8_decode('Mínima'), 1, 0,'L');
          $this->pdf->Ln();
          $this->pdf->Cell(62, 6, utf8_decode($equipe->cnes), 1, 0,'L');
          $this->pdf->Cell(62, 6, utf8_decode($equipe->ine), 1, 0,'L');
          $minima = ($equipe->distrito == 's') ? 'Sim' : 'Não';
          $this->pdf->Cell(62, 6, utf8_decode($minima), 1, 0,'L');
          $this->pdf->Ln();

          $this->pdf->Cell(106, 6, utf8_decode('Unidade'), 1, 0,'L');
          $this->pdf->Cell(80, 6, utf8_decode('Distrito'), 1, 0,'L');
          $this->pdf->Ln();
          $this->pdf->Cell(106, 6, utf8_decode($equipe->unidade), 1, 0,'L');
          $this->pdf->Cell(80, 6, utf8_decode($equipe->distrito), 1, 0,'L');
          $this->pdf->Ln();

          // vagas da equipe
          $vagaequipes = DB::table('equipe_profissionals');
          // joins
          $vagaequipes = $vagaequipes->join('cargos', 'cargos.id', '=', 'equipe_profissionals.cargo_id');
          $vagaequipes = $vagaequipes->leftjoin('profissionals', 'profissionals.id', '=', 'equipe_profissionals.profissional_id');          
          // select
          $vagaequipes = $vagaequipes->select(
            'equipe_profissionals.descricao', 
            'cargos.nome as cargonome', 
            'cargos.cbo', 
            DB::raw("coalesce(profissionals.nome, 'Não Vinculado') as nome"), 
            DB::raw("coalesce(profissionals.matricula, '') as matricula")
          );
          // filter
          $vagaequipes = $vagaequipes->where('equipe_profissionals.equipe_id', '=', $equipe->id);
          // ordena
          $vagaequipes = $vagaequipes->orderBy('equipe_profissionals.id', 'desc');
          // get
          $vagaequipes = $vagaequipes->get();

          if (count($vagaequipes)){
                $this->pdf->Cell(186, 6, utf8_decode('Vagas/Profissionais'), 'B', 0,'L');
                $this->pdf->Ln();
                // diminui a fonte
                $this->pdf->SetFont('Arial', '', 10);
                foreach ($vagaequipes as $vagaequipe) {
                    $this->pdf->Cell(110, 5, utf8_decode('Cargo: ' . $vagaequipe->cargonome), 1, 0,'L');
                    $this->pdf->Cell(76, 5, utf8_decode('CBO: ' . $vagaequipe->cbo), 1, 0,'L');
                    $this->pdf->Ln();
                    $this->pdf->Cell(110, 5, utf8_decode('Profissional: ' . $vagaequipe->nome), 1, 0,'L');
                    $this->pdf->Cell(76, 5, utf8_decode('Matrícula: ' . $vagaequipe->matricula), 1, 0,'L');
                    $this->pdf->Ln();
                    $this->pdf->Ln(1);
                }
            }

          $this->pdf->SetFont('Arial', '', 12);

          $this->pdf->Ln(4);
        }  

        $this->pdf->Output('D', 'Equipes_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;
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

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 11);
        $this->pdf->AddPage();

        $equipe = DB::table('equipes');
        // join
        $equipe = $equipe->join('unidades', 'unidades.id', '=', 'equipes.unidade_id');
        $equipe = $equipe->join('distritos', 'distritos.id', '=', 'unidades.distrito_id');
        // select
        $equipe = $equipe->select(
          'equipes.id as id', 
          'equipes.descricao', 
          'equipes.numero', 
          'equipes.cnes', 
          'equipes.ine', 
          'equipes.minima', 
          'unidades.descricao as unidade', 
          'distritos.nome as distrito'
        );
        //filtros
        $equipe = $equipe->where('equipes.id', '=', $id);
        // ordena
        $equipe = $equipe->orderBy('equipes.descricao', 'asc');
        // get
        $equipe = $equipe->get()->first();

        $this->pdf->Cell(126, 6, utf8_decode('Descrição'), 1, 0,'L');
        $this->pdf->Cell(60, 6, utf8_decode('Número'), 1, 0,'L');
        $this->pdf->Ln();
        $this->pdf->Cell(126, 6, utf8_decode($equipe->descricao), 1, 0,'L');
        $this->pdf->Cell(60, 6, utf8_decode($equipe->numero), 1, 0,'L');
        $this->pdf->Ln();

        $this->pdf->Cell(62, 6, utf8_decode('CNES'), 1, 0,'L');
        $this->pdf->Cell(62, 6, utf8_decode('INE'), 1, 0,'L');
        $this->pdf->Cell(62, 6, utf8_decode('Mínima'), 1, 0,'L');
        $this->pdf->Ln();
        $this->pdf->Cell(62, 6, utf8_decode($equipe->cnes), 1, 0,'L');
        $this->pdf->Cell(62, 6, utf8_decode($equipe->ine), 1, 0,'L');
        $minima = ($equipe->distrito == 's') ? 'Sim' : 'Não';
        $this->pdf->Cell(62, 6, utf8_decode($minima), 1, 0,'L');
        $this->pdf->Ln();

        $this->pdf->Cell(106, 6, utf8_decode('Unidade'), 1, 0,'L');
        $this->pdf->Cell(80, 6, utf8_decode('Distrito'), 1, 0,'L');
        $this->pdf->Ln();
        $this->pdf->Cell(106, 6, utf8_decode($equipe->unidade), 1, 0,'L');
        $this->pdf->Cell(80, 6, utf8_decode($equipe->distrito), 1, 0,'L');
        $this->pdf->Ln();

        // vagas da equipe
        $vagaequipes = DB::table('equipe_profissionals');
        // joins
        $vagaequipes = $vagaequipes->join('cargos', 'cargos.id', '=', 'equipe_profissionals.cargo_id');
        $vagaequipes = $vagaequipes->leftjoin('profissionals', 'profissionals.id', '=', 'equipe_profissionals.profissional_id');          
        // select
        $vagaequipes = $vagaequipes->select(
          'equipe_profissionals.descricao', 
          'cargos.nome as cargonome', 
          'cargos.cbo', 
          DB::raw("coalesce(profissionals.nome, 'Não Vinculado') as nome"), 
          DB::raw("coalesce(profissionals.matricula, '') as matricula")
        );
        // filter
        $vagaequipes = $vagaequipes->where('equipe_profissionals.equipe_id', '=', $equipe->id);
        // ordena
        $vagaequipes = $vagaequipes->orderBy('equipe_profissionals.id', 'desc');
        // get
        $vagaequipes = $vagaequipes->get();

        if (count($vagaequipes)){
            $this->pdf->Cell(186, 6, utf8_decode('Vagas/Profissionais'), 'B', 0,'L');
            $this->pdf->Ln();
            // diminui a fonte
            $this->pdf->SetFont('Arial', '', 10);
            foreach ($vagaequipes as $vagaequipe) {
                $this->pdf->Cell(110, 5, utf8_decode('Cargo: ' . $vagaequipe->cargonome), 1, 0,'L');
                $this->pdf->Cell(76, 5, utf8_decode('CBO: ' . $vagaequipe->cbo), 1, 0,'L');
                $this->pdf->Ln();
                $this->pdf->Cell(110, 5, utf8_decode('Profissional: ' . $vagaequipe->nome), 1, 0,'L');
                $this->pdf->Cell(76, 5, utf8_decode('Matrícula: ' . $vagaequipe->matricula), 1, 0,'L');
                $this->pdf->Ln();
                $this->pdf->Ln(1);
            }
        }

        $this->pdf->SetFont('Arial', '', 12);

        $this->pdf->Ln(4);

        $this->pdf->Output('D', 'Equipes_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;
  }     

}
