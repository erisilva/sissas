<?php

namespace App\Http\Controllers;

use App\LicencaTipo;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

class LicencaTipoController extends Controller
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
    public function __construct(\App\Reports\LicencaTipoReport $pdf)
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
        if (Gate::denies('licencatipo.index')) {
            abort(403, 'Acesso negado.');
        }

        $licencatipos = new LicencaTipo;

        // ordena
        $licencatipos = $licencatipos->orderBy('descricao', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $licencatipos = $licencatipos->paginate(session('perPage', '5'));

        return view('licencatipos.index', compact('licencatipos', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('licencatipo.create')) {
            abort(403, 'Acesso negado.');
        } 

        return view('licencatipos.create');
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

        $licencatipo = $request->all();

        LicencaTipo::create($licencatipo); //salva

        Session::flash('create_licencatipo', 'Tipo de licença cadastrado com sucesso!');

        return redirect(route('licencatipos.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('licencatipo.show')) {
            abort(403, 'Acesso negado.');
        }

        $licencatipo = LicencaTipo::findOrFail($id);

        return view('licencatipos.show', compact('licencatipo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('licencatipo.edit')) {
            abort(403, 'Acesso negado.');
        }

        $licencatipo = LicencaTipo::findOrFail($id);

        return view('licencatipos.edit', compact('licencatipo'));
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

        $licencatipo = LicencaTipo::findOrFail($id);
            
        $licencatipo->update($request->all());
        
        Session::flash('edited_licencatipo', 'Tipo de licença alterado com sucesso!');

        return redirect(route('licencatipos.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('licencatipo.delete')) {
            abort(403, 'Acesso negado.');
        }

        LicencaTipo::findOrFail($id)->delete();

        Session::flash('deleted_licencatipo', 'Tipo de licença excluído com sucesso!');

        return redirect(route('licencatipos.index'));
    }

    /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {
        if (Gate::denies('licencatipo.export')) {
            abort(403, 'Acesso negado.');
        }

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=TiposdeLicença_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $licencatipos = DB::table('licenca_tipos');

        $licencatipos = $licencatipos->select('descricao');

        $licencatipos = $licencatipos->orderBy('descricao', 'asc');

        $list = $licencatipos->get()->toArray();

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
        if (Gate::denies('licencatipo.export')) {
            abort(403, 'Acesso negado.');
        }

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->AddPage();

        $licencatipos = DB::table('licenca_tipos');

        $licencatipos = $licencatipos->select('descricao');


        $licencatipos = $licencatipos->orderBy('descricao', 'asc');    


        $licencatipos = $licencatipos->get();

        foreach ($licencatipos as $licencatipo) {
            $this->pdf->Cell(186, 6, utf8_decode($licencatipo->descricao), 0, 0,'L');
            $this->pdf->Ln();
        }

        $this->pdf->Output('D', 'TiposdeLicença_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;

    }   
}
