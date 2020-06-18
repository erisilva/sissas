<?php

namespace App\Http\Controllers;

use App\OrgaoEmissor;
use App\Perpage;

use Response;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

class OrgaoEmissorController extends Controller
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
    public function __construct(\App\Reports\OrgaoEmissorReport $pdf)
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
        if (Gate::denies('orgaoemissor.index')) {
            abort(403, 'Acesso negado.');
        }

        $orgaoemissores = new OrgaoEmissor;

        // ordena
        $orgaoemissores = $orgaoemissores->orderBy('descricao', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $orgaoemissores = $orgaoemissores->paginate(session('perPage', '5'));

        return view('orgaoemissores.index', compact('orgaoemissores', 'perpages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('orgaoemissor.create')) {
            abort(403, 'Acesso negado.');
        }   
        return view('orgaoemissores.create');
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

        $orgaoEmissor = $request->all();

        OrgaoEmissor::create($orgaoEmissor); //salva

        Session::flash('create_orgaoemissor', 'Orgão Emissor cadastrado com sucesso!');

        return redirect(route('orgaoemissores.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('orgaoemissor.show')) {
            abort(403, 'Acesso negado.');
        }

        $orgaoemissores = OrgaoEmissor::findOrFail($id);

        return view('orgaoemissores.show', compact('orgaoemissores'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('orgaoemissor.edit')) {
            abort(403, 'Acesso negado.');
        }

        $orgaoEmissor = OrgaoEmissor::findOrFail($id);

        return view('orgaoemissores.edit', compact('orgaoEmissor'));
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

        $orgaoEmissor = OrgaoEmissor::findOrFail($id);
            
        $orgaoEmissor->update($request->all());
        
        Session::flash('edited_orgaoemissor', 'Orgão Emissor alterado com sucesso!');

        return redirect(route('orgaoemissores.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('orgaoemissor.delete')) {
            abort(403, 'Acesso negado.');
        }

        OrgaoEmissor::findOrFail($id)->delete();

        Session::flash('deleted_orgaoemissor', 'Orgão emissor excluído com sucesso!');

        return redirect(route('orgaoemissores.index'));
    }

    /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {
        if (Gate::denies('orgaoemissor.export')) {
            abort(403, 'Acesso negado.');
        }

        $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv; charset=UTF-8'
            ,   'Content-Disposition' => 'attachment; filename=OrgaoEmissor_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $orgaoemissores = DB::table('orgao_emissors');

        $orgaoemissores = $orgaoemissores->select('descricao');

        $orgaoemissores = $orgaoemissores->orderBy('descricao', 'asc');

        $list = $orgaoemissores->get()->toArray();

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
        if (Gate::denies('orgaoemissor.export')) {
            abort(403, 'Acesso negado.');
        }

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 12);
        $this->pdf->AddPage();

        $orgaoemissores = DB::table('orgao_emissors');

        $orgaoemissores = $orgaoemissores->select('descricao');

        $orgaoemissores = $orgaoemissores->orderBy('descricao', 'asc');    

        $orgaoemissores = $orgaoemissores->get();

        foreach ($orgaoemissores as $orgaoemissor) {
            $this->pdf->Cell(186, 6, utf8_decode($orgaoemissor->descricao), 0, 0,'L');
            $this->pdf->Ln();
        }

        $this->pdf->Output('D', 'OrgãoEmissor_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;
    }      
}
