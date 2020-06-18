<?php

namespace App\Http\Controllers;

use App\Distrito;
use App\Unidade;
use App\UnidadeProfissional;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

class UnidadeController extends Controller
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
    public function __construct(\App\Reports\UnidadeReport $pdf)
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
        if (Gate::denies('unidade.index')) {
            abort(403, 'Acesso negado.');
        }

        $unidades = new Unidade;

        // filtros
        if (request()->has('descricao')){
            $unidades = $unidades->where('descricao', 'like', '%' . request('descricao') . '%');
        }

        if (request()->has('distrito_id')){
            if (request('distrito_id') != ""){
                $unidades = $unidades->where('distrito_id', '=', request('distrito_id'));
            }
        }         

        // ordena
        $unidades = $unidades->orderBy('descricao', 'asc');

        // consulta a tabela dos distritos
        $distritos = Distrito::orderBy('nome', 'asc')->get();

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $unidades = $unidades->paginate(session('perPage', '5'))->appends([          
            'nome' => request('nome'), 
            'distrito_id' => request('distrito_id'),         
            ]);

        return view('unidades.index', compact('unidades', 'perpages', 'distritos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('unidade.create')) {
            abort(403, 'Acesso negado.');
        } 

        // consulta a tabela dos distritos
        $distritos = Distrito::orderBy('nome', 'asc')->get();

        return view('unidades.create', compact('distritos'));
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
          'distrito_id' => 'required',
          'porte' => 'required',
        ],
        ['distrito_id.required' => 'Selecione na lista o distrito']);

        $unidade = $request->all();

        Unidade::create($unidade); //salva

        Session::flash('create_unidade', 'Unidade cadastrada com sucesso!');

        return redirect(route('unidades.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('unidade.show')) {
            abort(403, 'Acesso negado.');
        }

        $unidade = Unidade::findOrFail($id);

        $unidadeprofissionais = UnidadeProfissional::where('unidade_id', '=', $id)->orderBy('id', 'desc')->get();

        return view('unidades.show', compact('unidade', 'unidadeprofissionais'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('unidade.edit')) {
            abort(403, 'Acesso negado.');
        }

        $unidade = Unidade::findOrFail($id);

        // consulta a tabela dos distritos
        $distritos = Distrito::orderBy('nome', 'asc')->get();

        $unidadeprofissionais = UnidadeProfissional::where('unidade_id', '=', $id)->orderBy('id', 'desc')->get();

        return view('unidades.edit', compact('unidade', 'distritos', 'unidadeprofissionais'));
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
          'distrito_id' => 'required',
          'porte' => 'required',
        ],
        ['distrito_id.required' => 'Selecione na lista o distrito']);

        $unidade = Unidade::findOrFail($id);
            
        $unidade->update($request->all());
        
        Session::flash('edited_unidade', 'Unidade alterada com sucesso!');

        return redirect(route('unidades.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('unidade.delete')) {
            abort(403, 'Acesso negado.');
        }

        Unidade::findOrFail($id)->delete();

        Session::flash('deleted_unidade', 'Unidade excluída com sucesso!');

        return redirect(route('unidades.index'));
    }

    /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {
        if (Gate::denies('unidade.export')) {
            abort(403, 'Acesso negado.');
        }

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv; charset=UTF-8'
            ,   'Content-Disposition' => 'attachment; filename=unidades_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $unidades = DB::table('unidades');

        // join
        $unidades = $unidades->join('distritos', 'distritos.id', '=', 'unidades.distrito_id');

        // select
        $unidades = $unidades->select('unidades.descricao', 'unidades.porte', 'unidades.tel', 'unidades.cel', 'unidades.email', 'unidades.cep', 'unidades.logradouro', 'unidades.bairro', 'unidades.numero', 'unidades.complemento', 'unidades.cidade', 'unidades.uf', 'distritos.nome as distrito');

        //filtros
        if (request()->has('descricao')){
            $unidades = $unidades->where('unidades.descricao', 'like', '%' . request('descricao') . '%');
        }

        if (request()->has('distrito_id')){
            if (request('distrito_id') != ""){
                $unidades = $unidades->where('unidades.distrito_id', '=', request('distrito_id'));
            }
        }

        $unidades = $unidades->orderBy('descricao', 'asc');

        $list = $unidades->get()->toArray();

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
                fputcsv($FH, $row, chr(59));
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
        if (Gate::denies('unidade.export')) {
            abort(403, 'Acesso negado.');
        }

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 11);
        $this->pdf->AddPage();

        $unidades = DB::table('unidades');

        // join
        $unidades = $unidades->join('distritos', 'distritos.id', '=', 'unidades.distrito_id');

        // select
        $unidades = $unidades->select('unidades.descricao', 'unidades.porte', 'unidades.tel', 'unidades.cel', 'unidades.email', 'unidades.cep', 'unidades.logradouro', 'unidades.bairro', 'unidades.numero', 'unidades.complemento', 'unidades.cidade', 'unidades.uf', 'distritos.nome as distrito', 'unidades.id');

        //filtros
        if (request()->has('descricao')){
            $unidades = $unidades->where('unidades.descricao', 'like', '%' . request('descricao') . '%');
        }

        if (request()->has('distrito_id')){
            if (request('distrito_id') != ""){
                $unidades = $unidades->where('unidades.distrito_id', '=', request('distrito_id'));
            }
        }

        $unidades = $unidades->orderBy('descricao', 'asc');


        $unidades = $unidades->get();

        foreach ($unidades as $unidade) {
            $this->pdf->Cell(96, 6, utf8_decode('Descrição'), 1, 0,'L');
            $this->pdf->Cell(60, 6, utf8_decode('Distrito'), 1, 0,'L');
            $this->pdf->Cell(30, 6, utf8_decode('Porte'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(96, 6, utf8_decode($unidade->descricao), 1, 0,'L');
            $this->pdf->Cell(60, 6, utf8_decode($unidade->distrito), 1, 0,'L');
            $this->pdf->Cell(30, 6, utf8_decode($unidade->porte), 1, 0,'L');
            $this->pdf->Ln();

            $this->pdf->Cell(25, 6, utf8_decode('CEP'), 1, 0,'L');
            $this->pdf->Cell(95, 6, utf8_decode('Logradouro'), 1, 0,'L');
            $this->pdf->Cell(30, 6, utf8_decode('Nº'), 1, 0,'L');
            $this->pdf->Cell(36, 6, utf8_decode('Complemento'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(25, 6, utf8_decode($unidade->cep), 1, 0,'L');
            $this->pdf->Cell(95, 6, utf8_decode($unidade->logradouro), 1, 0,'L');
            $this->pdf->Cell(30, 6, utf8_decode($unidade->numero), 1, 0,'L');
            $this->pdf->Cell(36, 6, utf8_decode($unidade->complemento), 1, 0,'L');
            $this->pdf->Ln();

            $this->pdf->Cell(106, 6, utf8_decode('Bairro'), 1, 0,'L');
            $this->pdf->Cell(50, 6, utf8_decode('Cidade'), 1, 0,'L');
            $this->pdf->Cell(30, 6, utf8_decode('UF'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(106, 6, utf8_decode($unidade->bairro), 1, 0,'L');
            $this->pdf->Cell(50, 6, utf8_decode($unidade->cidade), 1, 0,'L');
            $this->pdf->Cell(30, 6, utf8_decode($unidade->uf), 1, 0,'L');
            $this->pdf->Ln();

            $this->pdf->Cell(96, 6, utf8_decode('E-mail'), 1, 0,'L');
            $this->pdf->Cell(45, 6, utf8_decode('TEL'), 1, 0,'L');
            $this->pdf->Cell(45, 6, utf8_decode('CEL'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(96, 6, utf8_decode($unidade->email), 1, 0,'L');
            $this->pdf->Cell(45, 6, utf8_decode($unidade->tel), 1, 0,'L');
            $this->pdf->Cell(45, 6, utf8_decode($unidade->cel), 1, 0,'L');
            $this->pdf->Ln();

            // profissionais da unidade
            $profissionais = DB::table('unidade_profissionals');
            // joins
            $profissionais = $profissionais->join('profissionals', 'profissionals.id', '=', 'unidade_profissionals.profissional_id');
            $profissionais = $profissionais->join('cargos', 'cargos.id', '=', 'profissionals.cargo_id');
            // select
            $profissionais = $profissionais->select('profissionals.nome as profissional', 'profissionals.matricula', 'cargos.nome as cargo');
            // filter
            $profissionais = $profissionais->where('unidade_profissionals.unidade_id', '=', $unidade->id);
            // ordena
            $profissionais = $profissionais->orderBy('unidade_profissionals.id', 'desc');
            // get
            $profissionais = $profissionais->get();

            if (count($profissionais)){
                $this->pdf->Cell(186, 6, utf8_decode('Profissionais'), 'B', 0,'L');
                $this->pdf->Ln();
                // diminui a fonte
                $this->pdf->SetFont('Arial', '', 10);
                foreach ($profissionais as $profissional) {
                    $this->pdf->Cell(86, 5, utf8_decode($profissional->profissional), 1, 0,'L');
                    $this->pdf->Cell(70, 5, utf8_decode($profissional->cargo), 1, 0,'L');
                    $this->pdf->Cell(30, 5, utf8_decode($profissional->matricula), 1, 0,'L');

                    $this->pdf->Ln();
                }
            }

            $this->pdf->SetFont('Arial', '', 12);

            $this->pdf->Ln(4);
        }

        $this->pdf->Output('D', 'Unidades_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;
    }


    /**
     * Função de autocompletar para ser usada pelo typehead
     *
     * @param  
     * @return json
     */
    public function autocomplete(Request $request)
    {
        $unidades = DB::table('unidades');

        // join
        $unidades = $unidades->join('distritos', 'distritos.id', '=', 'unidades.distrito_id');

        // select
        $unidades = $unidades->select('unidades.descricao as text', 'unidades.id as value', 'distritos.nome as distrito');
        
        //where
        $unidades = $unidades->where("unidades.descricao","LIKE","%{$request->input('query')}%");

        //get
        $unidades = $unidades->get();

        return response()->json($unidades, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }      
}
