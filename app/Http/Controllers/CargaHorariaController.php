<?php

namespace App\Http\Controllers;

use App\CargaHoraria;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

class CargaHorariaController extends Controller
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
    public function __construct(\App\Reports\CargaHorariaReport $pdf)
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
        if (Gate::denies('cargahoraria.index')) {
            abort(403, 'Acesso negado.');
        }

        $cargahorarias = new CargaHoraria;

        // ordena
        $cargahorarias = $cargahorarias->orderBy('descricao', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $cargahorarias = $cargahorarias->paginate(session('perPage', '5'));

        return view('cargahorarias.index', compact('cargahorarias', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('cargahoraria.create')) {
            abort(403, 'Acesso negado.');
        }

        return view('cargahorarias.create');
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

        $cargahoraria = $request->all();

        CargaHoraria::create($cargahoraria); //salva

        Session::flash('create_cargahoraria', 'Carga horária cadastrada com sucesso!');

        return redirect(route('cargahorarias.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('cargahoraria.show')) {
            abort(403, 'Acesso negado.');
        }

        $cargahoraria = CargaHoraria::findOrFail($id);

        return view('cargahorarias.show', compact('cargahoraria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('cargahoraria.edit')) {
            abort(403, 'Acesso negado.');
        }

        $cargahoraria = CargaHoraria::findOrFail($id);

        return view('cargahorarias.edit', compact('cargahoraria'));
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

        $cargahoraria = CargaHoraria::findOrFail($id);
            
        $cargahoraria->update($request->all());
        
        Session::flash('edited_cargahoraria', 'Carga horária alterado com sucesso!');

        return redirect(route('cargahorarias.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('cargahoraria.delete')) {
            abort(403, 'Acesso negado.');
        }

        CargaHoraria::findOrFail($id)->delete();

        Session::flash('deleted_cargahoraria', 'Carga horária excluída com sucesso!');

        return redirect(route('cargahorarias.index'));
    }

    /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {
        if (Gate::denies('cargahoraria.export')) {
            abort(403, 'Acesso negado.');
        }

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=CargaHoraria_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $cargahorarias = DB::table('carga_horarias');

        $cargahorarias = $cargahorarias->select('descricao');

        $cargahorarias = $cargahorarias->orderBy('descricao', 'asc');

        $list = $cargahorarias->get()->toArray();

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
        if (Gate::denies('cargahoraria.export')) {
            abort(403, 'Acesso negado.');
        }

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->AddPage();

        $cargahorarias = DB::table('carga_horarias');

        $cargahorarias = $cargahorarias->select('descricao');


        $cargahorarias = $cargahorarias->orderBy('descricao', 'asc');    


        $cargahorarias = $cargahorarias->get();

        foreach ($cargahorarias as $cargahoraria) {
            $this->pdf->Cell(186, 6, utf8_decode($cargahoraria->descricao), 0, 0,'L');
            $this->pdf->Ln();
        }

        $this->pdf->Output('D', 'CargaHoraria_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;

    }      

}
