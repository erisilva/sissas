<?php

namespace App\Http\Controllers;

use App\VinculoTipo;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

class VinculoTipoController extends Controller
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
    public function __construct(\App\Reports\VinculoTipoReport $pdf)
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
        if (Gate::denies('vinculotipo.index')) {
            abort(403, 'Acesso negado.');
        }

        $vinculotipos = new VinculoTipo;

        // ordena
        $vinculotipos = $vinculotipos->orderBy('descricao', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $vinculotipos = $vinculotipos->paginate(session('perPage', '5'));

        return view('vinculotipos.index', compact('vinculotipos', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('vinculotipo.create')) {
            abort(403, 'Acesso negado.');
        }

        return view('vinculotipos.create');
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

        $vinculotipo = $request->all();

        VinculoTipo::create($vinculotipo); //salva

        Session::flash('create_vinculotipo', 'Tipo de vínculo cadastrado com sucesso!');

        return redirect(route('vinculotipos.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('vinculotipo.show')) {
            abort(403, 'Acesso negado.');
        }

        $vinculotipo = VinculoTipo::findOrFail($id);

        return view('vinculotipos.show', compact('vinculotipo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('vinculotipo.edit')) {
            abort(403, 'Acesso negado.');
        }

        $vinculotipo = VinculoTipo::findOrFail($id);

        return view('vinculotipos.edit', compact('vinculotipo'));
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

        $vinculotipo = VinculoTipo::findOrFail($id);
            
        $vinculotipo->update($request->all());
        
        Session::flash('edited_vinculotipo', 'Tipo de vínculo alterado com sucesso!');

        return redirect(route('vinculotipos.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('vinculotipo.delete')) {
            abort(403, 'Acesso negado.');
        }

        VinculoTipo::findOrFail($id)->delete();

        Session::flash('deleted_vinculotipo', 'Tipo de vínculo excluído com sucesso!');

        return redirect(route('vinculotipos.index'));
    }

    /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {
        if (Gate::denies('vinculotipo.export')) {
            abort(403, 'Acesso negado.');
        }

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv; charset=UTF-8'
            ,   'Content-Disposition' => 'attachment; filename=TiposdeVinculos_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $vinculotipos = DB::table('vinculo_tipos');

        $vinculotipos = $vinculotipos->select('descricao');

        $vinculotipos = $vinculotipos->orderBy('descricao', 'asc');

        $list = $vinculotipos->get()->toArray();

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
        if (Gate::denies('vinculotipo.export')) {
            abort(403, 'Acesso negado.');
        }

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->AddPage();

        $vinculotipos = DB::table('vinculo_tipos');

        $vinculotipos = $vinculotipos->select('descricao');


        $vinculotipos = $vinculotipos->orderBy('descricao', 'asc');    


        $vinculotipos = $vinculotipos->get();

        foreach ($vinculotipos as $vinculotipo) {
            $this->pdf->Cell(186, 6, utf8_decode($vinculotipo->descricao), 0, 0,'L');
            $this->pdf->Ln();
        }

        $this->pdf->Output('D', 'TiposdeVinculos_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;

    }           
}
