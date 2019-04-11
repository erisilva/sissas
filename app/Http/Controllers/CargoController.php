<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;


class CargoController extends Controller
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
    public function __construct(\App\Reports\CargoReport $pdf)
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
        if (Gate::denies('cargo.index')) {
            abort(403, 'Acesso negado.');
        }

        $cargos = new Cargo;

        // ordena
        $cargos = $cargos->orderBy('nome', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $cargos = $cargos->paginate(session('perPage', '5'));

        return view('cargos.index', compact('cargos', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('cargo.create')) {
            abort(403, 'Acesso negado.');
        } 

        return view('cargos.create');
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
          'cbo' => 'required',
        ]);

        $cargo = $request->all();

        Cargo::create($cargo); //salva

        Session::flash('create_cargo', 'Cargo cadastrado com sucesso!');

        return redirect(route('cargos.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('cargo.show')) {
            abort(403, 'Acesso negado.');
        }

        $cargo = Cargo::findOrFail($id);

        return view('cargos.show', compact('cargo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('cargo.edit')) {
            abort(403, 'Acesso negado.');
        }

        $cargo = Cargo::findOrFail($id);

        return view('cargos.edit', compact('cargo'));
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
          'cbo' => 'required',
        ]);

        $cargo = Cargo::findOrFail($id);
            
        $cargo->update($request->all());
        
        Session::flash('edited_cargo', 'Cargo alterado com sucesso!');

        return redirect(route('cargos.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cargo::findOrFail($id)->delete();

        Session::flash('deleted_cargo', 'Cargo excluído com sucesso!');

        return redirect(route('cargos.index'));
    }

    /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=Cargos_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $cargos = DB::table('cargos');

        $cargos = $cargos->select('nome', 'cbo');

        $cargos = $cargos->orderBy('nome', 'asc');

        $list = $cargos->get()->toArray();

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

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->AddPage();

        $cargos = DB::table('cargos');

        $cargos = $cargos->select('nome', 'cbo');


        $cargos = $cargos->orderBy('nome', 'asc');    


        $cargos = $cargos->get();

        foreach ($cargos as $cargo) {
            $this->pdf->Cell(100, 6, utf8_decode($cargo->nome), 0, 0,'L');
            $this->pdf->Cell(86, 6, utf8_decode($cargo->cbo), 0, 0,'L');
            $this->pdf->Ln();
        }

        $this->pdf->Output('D', 'Distritos_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;

    }       
}
