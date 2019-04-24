<?php

namespace App\Http\Controllers;

use App\CapacitacaoTipo;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

class CapacitacaoTipoController extends Controller
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
    public function __construct(\App\Reports\CapacitacaoTipoReport $pdf)
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
        if (Gate::denies('capacitacaotipo.index')) {
            abort(403, 'Acesso negado.');
        }

        $capacitacaotipos = new CapacitacaoTipo;

        // ordena
        $capacitacaotipos = $capacitacaotipos->orderBy('descricao', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $capacitacaotipos = $capacitacaotipos->paginate(session('perPage', '5'));

        return view('capacitacaotipos.index', compact('capacitacaotipos', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('capacitacaotipo.create')) {
            abort(403, 'Acesso negado.');
        }

        return view('capacitacaotipos.create');
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

        $capacitacaotipo = $request->all();

        CapacitacaoTipo::create($capacitacaotipo); //salva

        Session::flash('create_capacitacaotipo', 'Tipo de capacitação cadastrado com sucesso!');

        return redirect(route('capacitacaotipos.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('capacitacaotipo.show')) {
            abort(403, 'Acesso negado.');
        }

        $capacitacaotipo = CapacitacaoTipo::findOrFail($id);

        return view('capacitacaotipos.show', compact('capacitacaotipo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('capacitacaotipo.edit')) {
            abort(403, 'Acesso negado.');
        }

        $capacitacaotipo = CapacitacaoTipo::findOrFail($id);

        return view('capacitacaotipos.edit', compact('capacitacaotipo'));
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

        $capacitacaotipo = CapacitacaoTipo::findOrFail($id);
            
        $capacitacaotipo->update($request->all());
        
        Session::flash('edited_capacitacaotipo', 'Tipo de capacitação alterado com sucesso!');

        return redirect(route('capacitacaotipos.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('capacitacaotipo.delete')) {
            abort(403, 'Acesso negado.');
        }

        CapacitacaoTipo::findOrFail($id)->delete();

        Session::flash('deleted_capacitacaotipo', 'Tipo de capacitação excluído com sucesso!');

        return redirect(route('capacitacaotipos.index'));
    }

    /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {
        if (Gate::denies('capacitacaotipo.export')) {
            abort(403, 'Acesso negado.');
        }

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=TiposdeCapacitações_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $capacitacaotipos = DB::table('capacitacao_tipos');

        $capacitacaotipos = $capacitacaotipos->select('descricao');

        $capacitacaotipos = $capacitacaotipos->orderBy('descricao', 'asc');

        $list = $capacitacaotipos->get()->toArray();

        # converte os objetos para uma array
        $list = json_decode(json_encode($list), true);

        # add headers for each column in the CSV download
        array_unshift($list, array_keys($list[0]));

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
        if (Gate::denies('capacitacaotipo.export')) {
            abort(403, 'Acesso negado.');
        }

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->AddPage();

        $capacitacaotipos = DB::table('capacitacao_tipos');

        $capacitacaotipos = $capacitacaotipos->select('descricao');

        $capacitacaotipos = $capacitacaotipos->orderBy('descricao', 'asc');    

        $capacitacaotipos = $capacitacaotipos->get();

        foreach ($capacitacaotipos as $capacitacaotipo) {
            $this->pdf->Cell(186, 6, utf8_decode($capacitacaotipo->descricao), 0, 0,'L');
            $this->pdf->Ln();
        }

        $this->pdf->Output('D', 'TiposdeCapacitações_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;

    }            
}
