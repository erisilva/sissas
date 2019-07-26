<?php

namespace App\Http\Controllers;

use App\Distrito;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

class DistritoController extends Controller
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
    public function __construct(\App\Reports\DistritoReport $pdf)
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
        if (Gate::denies('distrito.index')) {
            abort(403, 'Acesso negado.');
        }

        $distritos = new Distrito;

        // ordena
        $distritos = $distritos->orderBy('nome', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $distritos = $distritos->paginate(session('perPage', '5'));

        return view('distritos.index', compact('distritos', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('distrito.create')) {
            abort(403, 'Acesso negado.');
        } 

        return view('distritos.create');
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
          'nome' => 'required',
        ]);

        $distrito = $request->all();

        Distrito::create($distrito); //salva

        Session::flash('create_distrito', 'Distrito cadastrado com sucesso!');

        return redirect(route('distritos.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('distrito.show')) {
            abort(403, 'Acesso negado.');
        }

        $distrito = Distrito::findOrFail($id);

        return view('distritos.show', compact('distrito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('distrito.edit')) {
            abort(403, 'Acesso negado.');
        }

        $distrito = Distrito::findOrFail($id);

        return view('distritos.edit', compact('distrito'));
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
          'nome' => 'required',
        ]);

        $distrito = Distrito::findOrFail($id);
            
        $distrito->update($request->all());
        
        Session::flash('edited_distrito', 'Distrito alterado com sucesso!');

        return redirect(route('distritos.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('distrito.delete')) {
            abort(403, 'Acesso negado.');
        }

        Distrito::findOrFail($id)->delete();

        Session::flash('deleted_distrito', 'Distrito excluido!');

        return redirect(route('distritos.index'));
    }

    /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {
        if (Gate::denies('distrito.export')) {
            abort(403, 'Acesso negado.');
        }

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=Distritos_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $distritos = DB::table('distritos');

        $distritos = $distritos->select('nome');

        $distritos = $distritos->orderBy('nome', 'asc');

        $list = $distritos->get()->toArray();

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
        if (Gate::denies('distrito.export')) {
            abort(403, 'Acesso negado.');
        }

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->AddPage();

        $distritos = DB::table('distritos');

        $distritos = $distritos->select('nome');


        $distritos = $distritos->orderBy('nome', 'asc');    


        $distritos = $distritos->get();

        foreach ($distritos as $distrito) {
            $this->pdf->Cell(186, 6, utf8_decode($distrito->nome), 0, 0,'L');
            $this->pdf->Ln();
        }

        $this->pdf->Output('D', 'Distritos_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;

    }      
}
