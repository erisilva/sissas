<?php

namespace App\Http\Controllers;

use App\Historico;
use App\HistoricoTipo;
use App\Perpage;
use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class HistoricoController extends Controller
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
    public function __construct(\App\Reports\HistoricoReport $pdf)
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
        if (Gate::denies('historico.index')) {
            abort(403, 'Acesso negado.');
        }

        $historicos = new Historico;

        //filtros
        if (request()->has('dtainicio')){
             if (request('dtainicio') != ""){
                $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('dtainicio'))->format('Y-m-d 00:00:00');           
                $historicos = $historicos->where('created_at', '>=', $dataFormatadaMysql);                
             }
        }

        if (request()->has('dtafinal')){
             if (request('dtafinal') != ""){
                $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('dtafinal'))->format('Y-m-d 23:59:59');         
                $historicos = $historicos->where('created_at', '<=', $dataFormatadaMysql);                
             }
        }
        
        if (request()->has('profissional')){
            $historicos = $historicos->whereHas('profissional', function ($query) {
                                                $query->where('nome', 'like', '%' . request('profissional') . '%');
                                            });
        }

        if (request()->has('hist_filtro') && !empty(request('hist_filtro')) ){    
            $historicos = $historicos->whereIn('historico_tipo_id', request('hist_filtro'));
        }

        // ordena
        $historicos = $historicos->orderBy('created_at', 'desc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $historicos = $historicos->paginate(session('perPage', '5'))->appends([
            'profissional' => request('profissional'),
            'dtainicio' => request('dtainicio'),
            'dtafinal' => request('dtafinal'),          
            'hist_filtro' => request('hist_filtro'),          
            ]);

        // tipos de histórico
        $historicotipos = HistoricoTipo::orderBy('descricao', 'asc')->get();

        return view('historicos.index', compact('historicos', 'perpages', 'historicotipos'));
    }

     /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {
        if (Gate::denies('historico.export')) {
            abort(403, 'Acesso negado.');
        }

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv; charset=UTF-8'
            ,   'Content-Disposition' => 'attachment; filename=HistoricoProfissionais_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $historicos = DB::table('historicos');
        //joins
        $historicos = $historicos->join('historico_tipos', 'historico_tipos.id', '=', 'historicos.historico_tipo_id');
        $historicos = $historicos->join('profissionals', 'profissionals.id', '=', 'historicos.profissional_id');
            $historicos = $historicos->join('cargos', 'cargos.id', '=', 'profissionals.cargo_id');
        $historicos = $historicos->join('users', 'users.id', '=', 'historicos.user_id');
        //select
        $historicos = $historicos->select(
            DB::raw('DATE_FORMAT(historicos.created_at, \'%d/%m/%Y\') AS data'),
            DB::raw('DATE_FORMAT(historicos.created_at, \'%H:%i\') AS hora'),
            'historico_tipos.descricao as tipo_de_historico',
            'profissionals.nome as profissional',
            'profissionals.matricula as matricula',
            'profissionals.cns as CNS',
            'cargos.nome as cargo',
            'users.name as operador',
            'historicos.observacao',
        );
        //filtros
        if (request()->has('operador')){
            $historicos = $historicos->where('users.name', 'like', '%' . request('operador') . '%');
        }
        if (request()->has('dtainicio') && !empty(request('dtainicio'))){
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('dtainicio'))->format('Y-m-d 00:00:00');           
            $historicos = $historicos->where('historicos.created_at', '>=', $dataFormatadaMysql);                
        }
        if (request()->has('dtafinal') && !empty(request('dtafinal'))){
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('dtafinal'))->format('Y-m-d 23:59:59');         
            $historicos = $historicos->where('historicos.created_at', '<=', $dataFormatadaMysql);                
        }
        if (request()->has('profissional')){
            $historicos = $historicos->where('profissionals.nome', 'like', '%' . request('profissional') . '%');
        }

        // order
        $historicos = $historicos->orderBy('historicos.created_at', 'desc');
        // get
        $list = $historicos->get()->toArray();
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
        if (Gate::denies('historico.export')) {
            abort(403, 'Acesso negado.');
        }

        $historicos = DB::table('historicos');
        //joins
        $historicos = $historicos->join('historico_tipos', 'historico_tipos.id', '=', 'historicos.historico_tipo_id');
        $historicos = $historicos->join('profissionals', 'profissionals.id', '=', 'historicos.profissional_id');
            $historicos = $historicos->join('cargos', 'cargos.id', '=', 'profissionals.cargo_id');
        $historicos = $historicos->join('users', 'users.id', '=', 'historicos.user_id');
        //select
        $historicos = $historicos->select(
            DB::raw('DATE_FORMAT(historicos.created_at, \'%d/%m/%Y\') AS data'),
            DB::raw('DATE_FORMAT(historicos.created_at, \'%H:%i\') AS hora'),
            'historico_tipos.descricao as tipo_de_historico',
            'profissionals.nome as profissional',
            'profissionals.matricula as matricula',
            'profissionals.cns as CNS',
            'cargos.nome as cargo',
            'users.name as operador',
            'historicos.observacao',
        );
        //filtros
        if (request()->has('operador')){
            $historicos = $historicos->where('users.name', 'like', '%' . request('operador') . '%');
        }
        if (request()->has('dtainicio') && !empty(request('dtainicio'))){
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('dtainicio'))->format('Y-m-d 00:00:00');           
            $historicos = $historicos->where('historicos.created_at', '>=', $dataFormatadaMysql);                
        }
        if (request()->has('dtafinal') && !empty(request('dtafinal'))){
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('dtafinal'))->format('Y-m-d 23:59:59');         
            $historicos = $historicos->where('historicos.created_at', '<=', $dataFormatadaMysql);                
        }
        if (request()->has('profissional')){
            $historicos = $historicos->where('profissionals.nome', 'like', '%' . request('profissional') . '%');
        }
        if (request()->has('profissional_tipo_id') && !empty(request('profissional_tipo_id'))){
            $historicos = $historicos->where('historicos.profissional_tipo_id', '=', request('profissional_tipo_id'));
        }
        // order
        $historicos = $historicos->orderBy('historicos.created_at', 'desc');
        //get
        $historicos = $historicos->get();

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->AddPage();

        foreach ($historicos as $historico) {
            $this->pdf->Cell(40, 6, utf8_decode('Data: ' . $historico->data), 1, 0,'L');
            $this->pdf->Cell(30, 6, utf8_decode('Hora: ' . $historico->hora), 1, 0,'L');
            $this->pdf->Cell(116, 6, utf8_decode('Tipo: ' . $historico->tipo_de_historico), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(110, 6, utf8_decode('Profissional: ' . $historico->profissional), 1, 0,'L');
            $this->pdf->Cell(40, 6, utf8_decode('Matrícula: ' . $historico->matricula), 1, 0,'L');
            $this->pdf->Cell(36, 6, utf8_decode('CNS: ' . $historico->CNS), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(100, 6, utf8_decode('Cargo: ' . $historico->cargo), 1, 0,'L');
            $this->pdf->Cell(86, 6, utf8_decode('Operador: ' . $historico->operador), 1, 0,'L');
            $this->pdf->Ln();
            if ($historico->observacao != ''){
                $this->pdf->Cell(186, 6, utf8_decode('Observações'), 1, 0,'L');
                $this->pdf->Ln();
                $this->pdf->MultiCell(186, 6, utf8_decode($historico->observacao), 1, 'L', false);
            }

            $this->pdf->Ln(4);
        }
        $this->pdf->Output('D', 'Profissionais_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;
    }                       
}
