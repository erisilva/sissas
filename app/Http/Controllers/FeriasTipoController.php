<?php

namespace App\Http\Controllers;

use App\FeriasTipo;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

class FeriasTipoController extends Controller
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
    public function __construct(\App\Reports\FeriasTipoReport $pdf)
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
        if (Gate::denies('feriastipo.index')) {
            abort(403, 'Acesso negado.');
        }

        $feriastipos = new FeriasTipo;

        // ordena
        $feriastipos = $feriastipos->orderBy('descricao', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $feriastipos = $feriastipos->paginate(session('perPage', '5'));

        return view('feriastipos.index', compact('feriastipos', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('feriastipo.create')) {
            abort(403, 'Acesso negado.');
        }

        return view('feriastipos.create');
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
        ]);

        $feriastipo = $request->all();

        FeriasTipo::create($feriastipo); //salva

        Session::flash('create_feriastipo', 'Tipo de férias cadastrado com sucesso!');

        return redirect(route('feriastipos.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('feriastipo.show')) {
            abort(403, 'Acesso negado.');
        }

        $feriastipo = FeriasTipo::findOrFail($id);

        return view('feriastipos.show', compact('feriastipo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('feriastipo.edit')) {
            abort(403, 'Acesso negado.');
        }

        $feriastipo = FeriasTipo::findOrFail($id);

        return view('feriastipos.edit', compact('feriastipo'));
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
        ]);

        $feriastipo = FeriasTipo::findOrFail($id);
            
        $feriastipo->update($request->all());
        
        Session::flash('edited_feriastipo', 'Tipo de férias alterado com sucesso!');

        return redirect(route('feriastipos.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('feriastipo.delete')) {
            abort(403, 'Acesso negado.');
        }

        FeriasTipo::findOrFail($id)->delete();

        Session::flash('deleted_feriastipo', 'Tipo de férias excluído com sucesso!');

        return redirect(route('feriastipos.index'));
    }

 /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {
        if (Gate::denies('feriastipo.export')) {
            abort(403, 'Acesso negado.');
        }

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv; charset=UTF-8'
            ,   'Content-Disposition' => 'attachment; filename=TiposdeFérias_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $feriastipos = DB::table('ferias_tipos');

        $feriastipos = $feriastipos->select('descricao');

        $feriastipos = $feriastipos->orderBy('descricao', 'asc');

        $list = $feriastipos->get()->toArray();

        # converte os objetos para uma array
        $list = json_decode(json_encode($list), true);

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

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
        if (Gate::denies('feriastipo.export')) {
            abort(403, 'Acesso negado.');
        }

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->AddPage();

        $feriastipos = DB::table('ferias_tipos');

        $feriastipos = $feriastipos->select('descricao');

        $feriastipos = $feriastipos->orderBy('descricao', 'asc');    

        $feriastipos = $feriastipos->get();

        foreach ($feriastipos as $feriastipo) {
            $this->pdf->Cell(186, 6, utf8_decode($feriastipo->descricao), 0, 0,'L');
            $this->pdf->Ln();
        }

        $this->pdf->Output('D', 'TiposdeFérias_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;

    }          
}
