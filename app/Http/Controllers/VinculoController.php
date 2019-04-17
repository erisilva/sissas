<?php

namespace App\Http\Controllers;

use App\Vinculo;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

class VinculoController extends Controller
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
    public function __construct(\App\Reports\VinculoReport $pdf)
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
        if (Gate::denies('vinculo.index')) {
            abort(403, 'Acesso negado.');
        }

        $vinculos = new Vinculo;

        // ordena
        $vinculos = $vinculos->orderBy('descricao', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $vinculos = $vinculos->paginate(session('perPage', '5'));

        return view('vinculos.index', compact('vinculos', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('vinculo.create')) {
            abort(403, 'Acesso negado.');
        } 

        return view('vinculos.create');
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

        $vinculo = $request->all();

        Vinculo::create($vinculo); //salva

        Session::flash('create_vinculo', 'Vínculo cadastrado com sucesso!');

        return redirect(route('vinculos.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('vinculo.show')) {
            abort(403, 'Acesso negado.');
        }

        $vinculo = Vinculo::findOrFail($id);

        return view('vinculos.show', compact('vinculo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('vinculo.edit')) {
            abort(403, 'Acesso negado.');
        }

        $vinculo = Vinculo::findOrFail($id);

        return view('vinculos.edit', compact('vinculo'));
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

        $vinculo = Vinculo::findOrFail($id);
            
        $vinculo->update($request->all());
        
        Session::flash('edited_vinculo', 'Vínculo alterado com sucesso!');

        return redirect(route('vinculos.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('vinculo.delete')) {
            abort(403, 'Acesso negado.');
        }

        Vinculo::findOrFail($id)->delete();

        Session::flash('deleted_vinculo', 'Vínculo excluído com sucesso!');

        return redirect(route('vinculos.index'));
    }

    /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {
        if (Gate::denies('vinculo.export')) {
            abort(403, 'Acesso negado.');
        }

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=Vinculos_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $vinculo = DB::table('vinculos');

        $vinculo = $vinculo->select('descricao');

        $vinculo = $vinculo->orderBy('descricao', 'asc');

        $list = $vinculo->get()->toArray();

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
        if (Gate::denies('vinculo.export')) {
            abort(403, 'Acesso negado.');
        }

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->AddPage();

        $vinculos = DB::table('vinculos');

        $vinculos = $vinculos->select('descricao');


        $vinculos = $vinculos->orderBy('descricao', 'asc');    


        $vinculos = $vinculos->get();

        foreach ($vinculos as $vinculo) {
            $this->pdf->Cell(186, 6, utf8_decode($vinculo->descricao), 0, 0,'L');
            $this->pdf->Ln();
        }

        $this->pdf->Output('D', 'Vinculos_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;

    }       
}
