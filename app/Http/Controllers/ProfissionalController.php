<?php

namespace App\Http\Controllers;

use App\Profissional;
use App\Cargo;
use App\Vinculo;
use App\VinculoTipo;
use App\OrgaoEmissor;
use App\CargaHoraria;
use App\Perpage;

use App\FeriasTipo;
use App\Ferias;

use App\LicencaTipo;
use App\Licenca;

use App\Capacitacao;
use App\CapacitacaoTipo;

use App\Historico;

use Response;

use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon; // tratamento de datas

use App\Rules\Cpf; // validação de um cpf

use Illuminate\Support\Facades\Redirect; // para poder usar o redirect

class ProfissionalController extends Controller
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
    public function __construct(\App\Reports\ProfissionalReport $pdf)
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
        if (Gate::denies('profissional.index')) {
            abort(403, 'Acesso negado.');
        }

        $profissionals = new Profissional;

        // filtros
        if (request()->has('matricula')){
            $profissionals = $profissionals->where('matricula', 'like', '%' . request('matricula') . '%');
        }

        if (request()->has('nome')){
            $profissionals = $profissionals->where('nome', 'like', '%' . request('nome') . '%');
        }

        if (request()->has('cargo_id')){
            if (request('cargo_id') != ""){
                $profissionals = $profissionals->where('cargo_id', '=', request('cargo_id'));
            }
        } 

        if (request()->has('vinculo_id')){
            if (request('vinculo_id') != ""){
                $profissionals = $profissionals->where('vinculo_id', '=', request('vinculo_id'));
            }
        } 

        // ordena
        $profissionals = $profissionals->orderBy('nome', 'asc');

        // se a requisição tiver um novo valor para a quantidade
        // de páginas por visualização ele altera aqui
        if(request()->has('perpage')) {
            session(['perPage' => request('perpage')]);
        }

        // consulta a tabela perpage para ter a lista de
        // quantidades de paginação
        $perpages = Perpage::orderBy('valor')->get();

        // paginação
        $profissionals = $profissionals->paginate(session('perPage', '5'))->appends([          
            'matricula' => request('matricula'),
            'nome' => request('nome'),
            'cargo_id' => request('cargo_id'),
            'vinculo_id' => request('vinculo_id'),         
            ]);

        // consulta a tabela dos cargos
        $cargos = Cargo::orderBy('nome', 'asc')->get();

        // consulta a tabela dos vínculos
        $vinculos = Vinculo::orderBy('descricao', 'asc')->get();

        return view('profissionals.index', compact('profissionals', 'perpages', 'cargos', 'vinculos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('profissional.create')) {
            abort(403, 'Acesso negado.');
        }

        // consulta a tabela dos cargos
        $cargos = Cargo::orderBy('nome', 'asc')->get();

        // consulta a tabela dos vínculos
        $vinculos = Vinculo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos tipos de vínculos
        $vinculotipos = VinculoTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos orgão emissores 
        $orgaoemissores = OrgaoEmissor::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos carga horária
        $cargahorarias = CargaHoraria::orderBy('descricao', 'asc')->get();

        return view('profissionals.create', compact('cargos', 'vinculos', 'vinculotipos', 'cargahorarias', 'orgaoemissores'));
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
          'matricula' => 'required',
          'cpf' => 'required|unique:cpf',
          'cpf' => new Cpf,
          'cargo_id' => 'required',
          'carga_horaria_id' => 'required',
          'vinculo_id' => 'required',
          'vinculo_tipo_id' => 'required',
          'admissao' => 'required',
        ],
        [
            'cargo_id.required' => 'Selecione na lista o cargo do funcionário',
            'carga_horaria_id.required' => 'Selecione na lista a carga horária',
            'vinculo_id.required' => 'Selecione na lista o vínculo',
            'vinculo_tipo_id.required' => 'Selecione na lista o tipo de vínculo',
            'admissao.required' => 'Preencha a data de admissão',
        ]);

        $profissional = $request->all();

        // ajusta data
        if ($profissional['admissao'] != ""){
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('admissao'))->format('Y-m-d');           
            $profissional['admissao'] =  $dataFormatadaMysql;            
        } 

        $professional_new = Profissional::create($profissional); //salva

        Session::flash('create_profissional', 'Profissional cadastrado com sucesso!');

        // guarda o histórico
        $user = Auth::user();
        $historico = new Historico;
        $historico->user_id = $user->id;
        $historico->profissional_id = $professional_new->id;
        $historico->historico_tipo_id = 1; //Profissional registrado no sistema
        $historico->save();

        return Redirect::route('profissionals.edit', $professional_new->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('profissional.show')) {
            abort(403, 'Acesso negado.');
        }

        $profissional = Profissional::findOrFail($id);

        // consulta todas férias do profissional
        $ferias = Ferias::where('profissional_id', '=', $id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $licencas = Licenca::where('profissional_id', '=', $id)->orderBy('id', 'desc')->get();

        // consulta todas capacitações do profissional
        $capacitacaos = Capacitacao::where('profissional_id', '=', $id)->orderBy('id', 'desc')->get();

        return view('profissionals.show', compact('profissional', 'ferias', 'licencas', 'capacitacaos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('profissional.edit')) {
            abort(403, 'Acesso negado.');
        }

        $profissional = Profissional::findOrFail($id);

        // consulta a tabela dos de tipo de férias
        $feriastipos = FeriasTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos de tipo de licenças
        $licencatipos = LicencaTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos de tipo de capacitacaoes
        $capacitacaotipos = CapacitacaoTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos cargos
        $cargos = Cargo::orderBy('nome', 'asc')->get();

        // consulta a tabela dos vínculos
        $vinculos = Vinculo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos tipos de vínculos
        $vinculotipos = VinculoTipo::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos orgão emissores 
        $orgaoemissores = OrgaoEmissor::orderBy('descricao', 'asc')->get();

        // consulta a tabela dos carga horária
        $cargahorarias = CargaHoraria::orderBy('descricao', 'asc')->get();

        // consulta todas férias do profissional
        $ferias = Ferias::where('profissional_id', '=', $id)->orderBy('id', 'desc')->get();

        // consulta todas licenças do profissional
        $licencas = Licenca::where('profissional_id', '=', $id)->orderBy('id', 'desc')->get();

        // consulta todas capacitações do profissional
        $capacitacaos = Capacitacao::where('profissional_id', '=', $id)->orderBy('id', 'desc')->get();

        return view('profissionals.edit', compact('profissional', 'cargos', 'vinculos', 'vinculotipos', 'cargahorarias', 'feriastipos', 'ferias', 'licencatipos', 'licencas', 'capacitacaos', 'capacitacaotipos', 'orgaoemissores'));
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
          'matricula' => 'required',
          'cpf' => 'required|unique:cpf',
          'cpf' => new Cpf,
          'cargo_id' => 'required',
          'carga_horaria_id' => 'required',
          'vinculo_id' => 'required',
          'vinculo_tipo_id' => 'required',
          'admissao' => 'required',
        ],
        [
            'cargo_id.required' => 'Selecione na lista o cargo do funcionário',
            'carga_horaria_id.required' => 'Selecione na lista a carga horária',
            'vinculo_id.required' => 'Selecione na lista o vínculo',
            'vinculo_tipo_id.required' => 'Selecione na lista o tipo de vínculo',
            'admissao.required' => 'Preencha a data de admissão',
        ]);

        $profissional = Profissional::findOrFail($id);

        $input = $request->all();

        // ajusta data
        if ($input['admissao'] != ""){
            $dataFormatadaMysql = Carbon::createFromFormat('d/m/Y', request('admissao'))->format('Y-m-d');           
            $input['admissao'] =  $dataFormatadaMysql;            
        }

        $user = Auth::user();

        // guarda o histórico de alteração do registro como um todo     
        $historico = new Historico;
        $historico->user_id = $user->id;
        $historico->profissional_id = $id;
        $historico->historico_tipo_id = 2; //Registro do profissional alterado
        $historico->save();

        if ($profissional->carga_horaria_id != $input['carga_horaria_id']){
          // guarda o histórico caso a alteração seja a carga horária
          $historico = new Historico;
          $historico->user_id = $user->id;
          $historico->profissional_id = $id;
          $historico->historico_tipo_id = 15; //A carga horária no registro do profissional alterado
          $cargaHorariaTemp = CargaHoraria::findOrFail($input['carga_horaria_id']);
          $historico->observacao = 'Alterado de ' . $profissional->cargaHoraria->descricao . ' para ' . $cargaHorariaTemp->descricao;
          $historico->save();
        }

        if ($profissional->cargo_id != $input['cargo_id']){
          // guarda o histórico caso a alteração seja o cargo
          $historico = new Historico;
          $historico->user_id = $user->id;
          $historico->profissional_id = $id;
          $historico->historico_tipo_id = 16; //O cargo no registro do profissional alterado
          $cargoTemp = Cargo::findOrFail($input['cargo_id']);
          $historico->observacao = 'Alterado de ' . $profissional->cargo->nome . ' para ' . $cargoTemp->nome;
          $historico->save();
        }

        if ($profissional->vinculo_id != $input['vinculo_id']){
          // guarda o histórico caso a alteração seja o vinculo
          $historico = new Historico;
          $historico->user_id = $user->id;
          $historico->profissional_id = $id;
          $historico->historico_tipo_id = 17; //O vínculo no registro do profissional alterado
          $vinculoTemp = Vinculo::findOrFail($input['vinculo_id']);
          $historico->observacao = 'Alterado de ' . $profissional->vinculo->descricao . ' para ' . $vinculoTemp->descricao;
          $historico->save();
        }
            
        $profissional->update($input);
        
        Session::flash('edited_profissional', 'Profissional alterado com sucesso!');

        return redirect(route('profissionals.edit', $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (Gate::denies('profissional.delete')) {
            abort(403, 'Acesso negado.');
        }

        $profissional = Profissional::findOrFail($id);

        $input = $request->all();

        // apaga todos relacionamentos com a unidade
        $profissional->unidadeProfissionals()->delete();

        // apaga todos relacionamentos com equipes
        $equipes = $profissional->equipeProfissionals;
        if (count($equipes)){
          foreach ($equipes as $equipe) {
            $equipe->profissional_id = null;
            $equipe->save();
          }  
        }
        
        $profissional->delete();

        Session::flash('deleted_profissional', 'Profissional enviado para lixeira!');

        // guarda o histórico
        $user = Auth::user();
        $historico = new Historico;
        $historico->user_id = $user->id;
        $historico->profissional_id = $id;
        $historico->historico_tipo_id = 3; //Registro do profissional enviado à lixeira
        $historico->observacao = $input['motivo'];
        $historico->save();

        return redirect(route('profissionals.index'));
    }

     /**
     * Exportação para planilha (csv)
     *
     * @param  int  $id
     * @return Response::stream()
     */
    public function exportcsv()
    {
        if (Gate::denies('profissional.export')) {
            abort(403, 'Acesso negado.');
        }

       $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv; charset=UTF-8'
            ,   'Content-Disposition' => 'attachment; filename=Profissionais_' .  date("Y-m-d H:i:s") . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        $profissionais = DB::table('profissionals');
        //joins
        $profissionais = $profissionais->join('cargos', 'cargos.id', '=', 'profissionals.cargo_id');
        $profissionais = $profissionais->join('carga_horarias', 'carga_horarias.id', '=', 'profissionals.carga_horaria_id');
        $profissionais = $profissionais->join('vinculos', 'vinculos.id', '=', 'profissionals.vinculo_id');
        $profissionais = $profissionais->join('vinculo_tipos', 'vinculo_tipos.id', '=', 'profissionals.vinculo_tipo_id');
        // select
        $profissionais = $profissionais->select(
          'profissionals.nome', 
          'profissionals.matricula', 
          'profissionals.cns', 
          'profissionals.cpf', 
          'profissionals.flexibilizacao', 
          DB::raw('DATE_FORMAT(profissionals.admissao, \'%d/%m/%Y\') AS data_admissao'), 
          'profissionals.observacao', 
          'profissionals.tel', 
          'profissionals.cel', 
          'profissionals.email', 
          'profissionals.cep', 
          'profissionals.logradouro', 
          'profissionals.bairro', 
          'profissionals.numero', 
          'profissionals.complemento', 
          'profissionals.cidade', 
          'profissionals.uf', 
          'cargos.nome as cargo', 
          'carga_horarias.descricao as carga_horaria', 
          'vinculos.descricao as vinculo', 
          'vinculo_tipos.descricao as vinculo_tipo'
        );
        //filtros
        if (request()->has('matricula')){
            $profissionais = $profissionais->where('profissionals.matricula', 'like', '%' . request('matricula') . '%');
        }
        if (request()->has('nome')){
            $profissionais = $profissionais->where('profissionals.nome', 'like', '%' . request('nome') . '%');
        }
        if (request()->has('cargo_id')){
            if (request('cargo_id') != ""){
                $profissionais = $profissionais->where('cargos.id', '=', request('cargo_id'));
            }
        } 
        if (request()->has('vinculo_id')){
            if (request('vinculo_id') != ""){
                $profissionais = $profissionais->where('vinculos.id', '=', request('vinculo_id'));
            }
        } 
        $profissionais = $profissionais->whereNull('profissionals.deleted_at'); 
        // order
        $profissionais = $profissionais->orderBy('nome', 'asc');
        // get
        $list = $profissionais->get()->toArray();

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
        if (Gate::denies('profissional.export')) {
            abort(403, 'Acesso negado.');
        }

        $profissionais = DB::table('profissionals');
        //joins
        $profissionais = $profissionais->join('cargos', 'cargos.id', '=', 'profissionals.cargo_id');
        $profissionais = $profissionais->join('carga_horarias', 'carga_horarias.id', '=', 'profissionals.carga_horaria_id');
        $profissionais = $profissionais->join('vinculos', 'vinculos.id', '=', 'profissionals.vinculo_id');
        $profissionais = $profissionais->join('vinculo_tipos', 'vinculo_tipos.id', '=', 'profissionals.vinculo_tipo_id');
        // select
        $profissionais = $profissionais->select(
          'profissionals.id', 
          'profissionals.nome', 
          'profissionals.matricula', 
          'profissionals.cns', 
          'profissionals.cpf', 
          'profissionals.flexibilizacao', 
           DB::raw("DATE_FORMAT(profissionals.admissao, '%d/%m/%Y') AS data_admissao"), 
          'profissionals.observacao', 
          'profissionals.tel', 
          'profissionals.cel', 
          'profissionals.email', 
          'profissionals.cep', 
          'profissionals.logradouro', 
          'profissionals.bairro', 
          'profissionals.numero', 
          'profissionals.complemento', 
          'profissionals.cidade', 
          'profissionals.uf', 
          'cargos.nome as cargo', 
          'carga_horarias.descricao as carga_horaria', 
          'vinculos.descricao as vinculo', 
          'vinculo_tipos.descricao as vinculo_tipo'
        );
        //filtros
        if (request()->has('matricula')){
            $profissionais = $profissionais->where('profissionals.matricula', 'like', '%' . request('matricula') . '%');
        }
        if (request()->has('nome')){
            $profissionais = $profissionais->where('profissionals.nome', 'like', '%' . request('nome') . '%');
        }
        if (request()->has('cargo_id')){
            if (request('cargo_id') != ""){
                $profissionais = $profissionais->where('cargos.id', '=', request('cargo_id'));
            }
        } 
        if (request()->has('vinculo_id')){
            if (request('vinculo_id') != ""){
                $profissionais = $profissionais->where('vinculos.id', '=', request('vinculo_id'));
            }
        }
        $profissionais = $profissionais->whereNull('profissionals.deleted_at'); 
        // order
        $profissionais = $profissionais->orderBy('nome', 'asc'); 
        //get
        $profissionais = $profissionais->get();

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->AddPage();


        foreach ($profissionais as $profissional) {
            $this->pdf->Cell(20, 6, utf8_decode('Matrícula'), 1, 0,'L');
            $this->pdf->Cell(86, 6, utf8_decode('Funcionário'), 1, 0,'L');
            $this->pdf->Cell(80, 6, utf8_decode('Cargo'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(20, 6, utf8_decode($profissional->matricula), 1, 0,'L');
            $this->pdf->Cell(86, 6, utf8_decode($profissional->nome), 1, 0,'L');
            $this->pdf->Cell(80, 6, utf8_decode($profissional->cargo), 1, 0,'L');
            $this->pdf->Ln();

            $this->pdf->Cell(20, 6, utf8_decode('Vínculo'), 1, 0,'L');
            $this->pdf->Cell(73, 6, utf8_decode('Tipo de Vínculo'), 1, 0,'L');
            $this->pdf->Cell(36, 6, utf8_decode('Carga Horária'), 1, 0,'L');
            $this->pdf->Cell(30, 6, utf8_decode('Flexibilização'), 1, 0,'L');
            $this->pdf->Cell(27, 6, utf8_decode('Data Admissão'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(20, 6, utf8_decode($profissional->vinculo), 1, 0,'L');
            $this->pdf->Cell(73, 6, utf8_decode($profissional->vinculo_tipo), 1, 0,'L');
            $this->pdf->Cell(36, 6, utf8_decode($profissional->carga_horaria), 1, 0,'L');
            $this->pdf->Cell(30, 6, utf8_decode($profissional->flexibilizacao), 1, 0,'L');
            $this->pdf->Cell(27, 6, utf8_decode($profissional->data_admissao), 1, 0,'L');
            $this->pdf->Ln();

            $this->pdf->Cell(30, 6, utf8_decode('CPF'), 1, 0,'L');
            $this->pdf->Cell(76, 6, utf8_decode('CNS'), 1, 0,'L');
            $this->pdf->Cell(40, 6, utf8_decode('Celular'), 1, 0,'L');
            $this->pdf->Cell(40, 6, utf8_decode('Telefone'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(30, 6, utf8_decode($profissional->cpf), 1, 0,'L');
            $this->pdf->Cell(76, 6, utf8_decode($profissional->cns), 1, 0,'L');
            $this->pdf->Cell(40, 6, utf8_decode($profissional->cel), 1, 0,'L');
            $this->pdf->Cell(40, 6, utf8_decode($profissional->tel), 1, 0,'L');
            $this->pdf->Ln();

            $this->pdf->Cell(186, 6, utf8_decode('E-mail'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(186, 6, utf8_decode($profissional->email), 1, 0,'L');
            $this->pdf->Ln();

            $this->pdf->Cell(20, 6, utf8_decode('CEP'), 1, 0,'L');
            $this->pdf->Cell(86, 6, utf8_decode('Logradouro'), 1, 0,'L');
            $this->pdf->Cell(20, 6, utf8_decode('Nº'), 1, 0,'L');
            $this->pdf->Cell(60, 6, utf8_decode('Complemento'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(20, 6, utf8_decode($profissional->cep), 1, 0,'L');
            $this->pdf->Cell(86, 6, utf8_decode($profissional->logradouro), 1, 0,'L');
            $this->pdf->Cell(20, 6, utf8_decode($profissional->numero), 1, 0,'L');
            $this->pdf->Cell(60, 6, utf8_decode($profissional->complemento), 1, 0,'L');
            $this->pdf->Ln();

            $this->pdf->Cell(80, 6, utf8_decode('Bairro'), 1, 0,'L');
            $this->pdf->Cell(86, 6, utf8_decode('Cidade'), 1, 0,'L');
            $this->pdf->Cell(20, 6, utf8_decode('UF'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(80, 6, utf8_decode($profissional->bairro), 1, 0,'L');
            $this->pdf->Cell(86, 6, utf8_decode($profissional->cidade), 1, 0,'L');
            $this->pdf->Cell(20, 6, utf8_decode($profissional->uf), 1, 0,'L');
            $this->pdf->Ln();

            if ($profissional->observacao != ''){
                $this->pdf->Cell(186, 6, utf8_decode('Observações'), 1, 0,'L');
                $this->pdf->Ln();
                $this->pdf->MultiCell(186, 6, utf8_decode($profissional->observacao), 1, 'L', false);
            }

            // Férias
            // consulta secundaria
            $ferias = DB::table('ferias');
            // joins
            $ferias = $ferias->join('ferias_tipos', 'ferias_tipos.id', '=', 'ferias.ferias_tipo_id');
            // select
            $ferias = $ferias->select(
              DB::raw("DATE_FORMAT(ferias.inicio, '%d/%m/%Y') AS datainicio"), 
              DB::raw("DATE_FORMAT(ferias.fim, '%d/%m/%Y') AS datafim"), 
              'ferias_tipos.descricao as tipo', 
              'ferias.justificativa', 
              'ferias.observacao' );
            // filter
            $ferias = $ferias->where('ferias.profissional_id', '=', $profissional->id);
            // get
            $ferias = $ferias->get();

            if (count($ferias)){
                $this->pdf->Cell(186, 6, utf8_decode('Férias'), 'B', 0,'L');
                $this->pdf->Ln();
                foreach ($ferias as $ferias_index) {
                    $this->pdf->Cell(40, 6, utf8_decode('Data inicial'), 0, 0,'L');
                    $this->pdf->Cell(40, 6, utf8_decode('Data Final'), 0, 0,'L');
                    $this->pdf->Cell(106, 6, utf8_decode('Descrição'), 0, 0,'L');
                    $this->pdf->Ln();
                    $this->pdf->Cell(40, 6, utf8_decode($ferias_index->datainicio ?? '-'), 0, 0,'L');
                    $this->pdf->Cell(40, 6, utf8_decode($ferias_index->datafim ?? '-'), 0, 0,'L');
                    $this->pdf->Cell(106, 6, utf8_decode($ferias_index->tipo), 0, 0,'L');
                    $this->pdf->Ln();
                    if ($ferias_index->justificativa != ''){
                        $this->pdf->MultiCell(186, 6, utf8_decode('Justificativa: ' . $ferias_index->justificativa), 0, 'L', false);
                    }
                    if ($ferias_index->observacao != ''){
                        $this->pdf->MultiCell(186, 6, utf8_decode('Observações: ' . $ferias_index->observacao), 0, 'L', false);
                    }
                } 
            }

            // Licenças
            // consulta secundaria
            $licencas = DB::table('licencas');
            // joins
            $licencas = $licencas->join('licenca_tipos', 'licenca_tipos.id', '=', 'licencas.licenca_tipo_id');
            // select
            $licencas = $licencas->select(
              DB::raw("DATE_FORMAT(licencas.inicio, '%d/%m/%Y') AS datainicio"), 
              DB::raw("DATE_FORMAT(licencas.fim, '%d/%m/%Y') AS datafim"), 
              'licenca_tipos.descricao as tipo', 
              'licencas.observacao' 
            );
            // filter
            $licencas = $licencas->where('licencas.profissional_id', '=', $profissional->id);
            // get
            $licencas = $licencas->get();

            if (count($licencas)){
                $this->pdf->Cell(186, 6, utf8_decode('Licenças'), 'B', 0,'L');
                $this->pdf->Ln();
                foreach ($licencas as $licenca) {
                    $this->pdf->Cell(40, 6, utf8_decode('Data inicial'), 0, 0,'L');
                    $this->pdf->Cell(40, 6, utf8_decode('Data Final'), 0, 0,'L');
                    $this->pdf->Cell(106, 6, utf8_decode('Descrição'), 0, 0,'L');
                    $this->pdf->Ln();
                    $this->pdf->Cell(40, 6, utf8_decode($licenca->datainicio ?? '-'), 0, 0,'L');
                    $this->pdf->Cell(40, 6, utf8_decode($licenca->datafim ?? '-'), 0, 0,'L');
                    $this->pdf->Cell(106, 6, utf8_decode($licenca->tipo), 0, 0,'L');
                    $this->pdf->Ln();
                    if ($licenca->observacao != ''){
                        $this->pdf->MultiCell(186, 6, utf8_decode('Observações: ' . $licenca->observacao), 0, 'L', false);
                    }
                } 
            }

            // Capacitações
            // consulta secundaria
            $capacitacaos = DB::table('capacitacaos');
            // joins
            $capacitacaos = $capacitacaos->join('capacitacao_tipos', 'capacitacao_tipos.id', '=', 'capacitacaos.capacitacao_tipo_id');
            // select
            $capacitacaos = $capacitacaos->select(
              DB::raw("DATE_FORMAT(capacitacaos.inicio, '%d/%m/%Y') AS datainicio"), 
              DB::raw("DATE_FORMAT(capacitacaos.fim, '%d/%m/%Y') AS datafim"), 
              'capacitacao_tipos.descricao as tipo', 
              'capacitacaos.observacao', 
              'capacitacaos.cargaHoraria' 
            );
            // filter
            $capacitacaos = $capacitacaos->where('capacitacaos.profissional_id', '=', $profissional->id);
            // get
            $capacitacaos = $capacitacaos->get();

            if (count($capacitacaos)){
                $this->pdf->Cell(186, 6, utf8_decode('Capacitações'), 'B', 0,'L');
                $this->pdf->Ln();
                foreach ($capacitacaos as $capacitacao) {
                    $this->pdf->Cell(40, 6, utf8_decode('Data inicial'), 0, 0,'L');
                    $this->pdf->Cell(40, 6, utf8_decode('Data Final'), 0, 0,'L');
                    $this->pdf->Cell(53, 6, utf8_decode('Descrição'), 0, 0,'L');
                    $this->pdf->Cell(53, 6, utf8_decode('Carga Horária'), 0, 0,'L');
                    $this->pdf->Ln();
                    $this->pdf->Cell(40, 6, utf8_decode($capacitacao->datainicio ?? '-'), 0, 0,'L');
                    $this->pdf->Cell(40, 6, utf8_decode($capacitacao->datafim ?? '-'), 0, 0,'L');
                    $this->pdf->Cell(53, 6, utf8_decode($capacitacao->tipo), 0, 0,'L');
                    $this->pdf->Cell(53, 6, utf8_decode($capacitacao->cargaHoraria), 0, 0,'L');
                    $this->pdf->Ln();
                    if ($capacitacao->observacao != ''){
                        $this->pdf->MultiCell(186, 6, utf8_decode('Observações: ' . $capacitacao->observacao), 0, 'L', false);
                    }
                } 
            }

            $this->pdf->Ln(4);
        }

        $this->pdf->Output('D', 'Profissionais_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;
    }

    /**
     * Exportação para pdf
     *
     * @param  
     * @return 
     */
    public function exportpdfsimples()
    {
        if (Gate::denies('profissional.export')) {
            abort(403, 'Acesso negado.');
        }

        $profissionais = DB::table('profissionals');
        //joins
        $profissionais = $profissionais->join('cargos', 'cargos.id', '=', 'profissionals.cargo_id');
        $profissionais = $profissionais->join('carga_horarias', 'carga_horarias.id', '=', 'profissionals.carga_horaria_id');
        $profissionais = $profissionais->join('vinculos', 'vinculos.id', '=', 'profissionals.vinculo_id');
        $profissionais = $profissionais->join('vinculo_tipos', 'vinculo_tipos.id', '=', 'profissionals.vinculo_tipo_id');
        // select
        $profissionais = $profissionais->select(
          'profissionals.id', 
          'profissionals.nome', 
          'profissionals.matricula', 
          'profissionals.cns', 
          'profissionals.cpf', 
          'profissionals.flexibilizacao', 
          DB::raw("DATE_FORMAT(profissionals.admissao, '%d/%m/%Y') AS data_admissao"), 
          'profissionals.observacao', 
          'profissionals.tel', 
          'profissionals.cel', 
          'profissionals.email', 
          'profissionals.cep', 
          'profissionals.logradouro', 
          'profissionals.bairro', 
          'profissionals.numero', 
          'profissionals.complemento', 
          'profissionals.cidade', 
          'profissionals.uf', 
          'cargos.nome as cargo', 
          'carga_horarias.descricao as carga_horaria', 
          'vinculos.descricao as vinculo', 
          'vinculo_tipos.descricao as vinculo_tipo'
        );
        //filtros
        if (request()->has('matricula')){
            $profissionais = $profissionais->where('profissionals.matricula', 'like', '%' . request('matricula') . '%');
        }
        if (request()->has('nome')){
            $profissionais = $profissionais->where('profissionals.nome', 'like', '%' . request('nome') . '%');
        }
        if (request()->has('cargo_id')){
            if (request('cargo_id') != ""){
                $profissionais = $profissionais->where('cargos.id', '=', request('cargo_id'));
            }
        } 
        if (request()->has('vinculo_id')){
            if (request('vinculo_id') != ""){
                $profissionais = $profissionais->where('vinculos.id', '=', request('vinculo_id'));
            }
        }
        $profissionais = $profissionais->whereNull('profissionals.deleted_at'); 
        // order
        $profissionais = $profissionais->orderBy('nome', 'asc'); 
        // get
        $profissionais = $profissionais->get();

        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->AddPage();

        foreach ($profissionais as $profissional) {
            $this->pdf->Cell(20, 6, utf8_decode('Matrícula'), 1, 0,'L');
            $this->pdf->Cell(86, 6, utf8_decode('Funcionário'), 1, 0,'L');
            $this->pdf->Cell(80, 6, utf8_decode('Cargo'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(20, 6, utf8_decode($profissional->matricula), 1, 0,'L');
            $this->pdf->Cell(86, 6, utf8_decode($profissional->nome), 1, 0,'L');
            $this->pdf->Cell(80, 6, utf8_decode($profissional->cargo), 1, 0,'L');
            $this->pdf->Ln();

            $this->pdf->Cell(20, 6, utf8_decode('Vínculo'), 1, 0,'L');
            $this->pdf->Cell(73, 6, utf8_decode('Tipo de Vínculo'), 1, 0,'L');
            $this->pdf->Cell(36, 6, utf8_decode('Carga Horária'), 1, 0,'L');
            $this->pdf->Cell(30, 6, utf8_decode('Flexibilização'), 1, 0,'L');
            $this->pdf->Cell(27, 6, utf8_decode('Data Admissão'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(20, 6, utf8_decode($profissional->vinculo), 1, 0,'L');
            $this->pdf->Cell(73, 6, utf8_decode($profissional->vinculo_tipo), 1, 0,'L');
            $this->pdf->Cell(36, 6, utf8_decode($profissional->carga_horaria), 1, 0,'L');
            $this->pdf->Cell(30, 6, utf8_decode($profissional->flexibilizacao), 1, 0,'L');
            $this->pdf->Cell(27, 6, utf8_decode($profissional->data_admissao), 1, 0,'L');
            $this->pdf->Ln();

            $this->pdf->Cell(30, 6, utf8_decode('CPF'), 1, 0,'L');
            $this->pdf->Cell(76, 6, utf8_decode('CNS'), 1, 0,'L');
            $this->pdf->Cell(40, 6, utf8_decode('Celular'), 1, 0,'L');
            $this->pdf->Cell(40, 6, utf8_decode('Telefone'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(30, 6, utf8_decode($profissional->cpf), 1, 0,'L');
            $this->pdf->Cell(76, 6, utf8_decode($profissional->cns), 1, 0,'L');
            $this->pdf->Cell(40, 6, utf8_decode($profissional->cel), 1, 0,'L');
            $this->pdf->Cell(40, 6, utf8_decode($profissional->tel), 1, 0,'L');
            $this->pdf->Ln();

            $this->pdf->Cell(186, 6, utf8_decode('E-mail'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->Cell(186, 6, utf8_decode($profissional->email), 1, 0,'L');
            $this->pdf->Ln();

            if ($profissional->observacao != ''){
                $this->pdf->Cell(186, 6, utf8_decode('Observações'), 1, 0,'L');
                $this->pdf->Ln();
                $this->pdf->MultiCell(186, 6, utf8_decode($profissional->observacao), 1, 'L', false);
            }

            $this->pdf->Ln(4);
        }

        $this->pdf->Output('D', 'Profissionais_' .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;
    }

    /**
     * Exportação para pdf por protocolo
     *
     * @param  $id, id do protocolo
     * @return pdf
     */
    public function exportpdfindividual($id)
    {
        if (Gate::denies('profissional.export')) {
            abort(403, 'Acesso negado.');
        }

        $profissional = DB::table('profissionals');
        //joins
        $profissional = $profissional->join('cargos', 'cargos.id', '=', 'profissionals.cargo_id');
        $profissional = $profissional->join('carga_horarias', 'carga_horarias.id', '=', 'profissionals.carga_horaria_id');
        $profissional = $profissional->join('vinculos', 'vinculos.id', '=', 'profissionals.vinculo_id');
        $profissional = $profissional->join('vinculo_tipos', 'vinculo_tipos.id', '=', 'profissionals.vinculo_tipo_id');
        // select
        $profissional = $profissional->select(
          'profissionals.id', 
          'profissionals.nome', 
          'profissionals.matricula', 
          'profissionals.cns', 
          'profissionals.cpf', 
          'profissionals.flexibilizacao', 
          DB::raw("DATE_FORMAT(profissionals.admissao, '%d/%m/%Y') AS data_admissao"), 
          'profissionals.observacao', 
          'profissionals.tel', 
          'profissionals.cel', 
          'profissionals.email', 
          'profissionals.cep', 
          'profissionals.logradouro', 
          'profissionals.bairro', 
          'profissionals.numero', 
          'profissionals.complemento', 
          'profissionals.cidade', 
          'profissionals.uf', 
          'cargos.nome as cargo', 
          'carga_horarias.descricao as carga_horaria', 
          'vinculos.descricao as vinculo', 
          'vinculo_tipos.descricao as vinculo_tipo'
        );

        //filtros
        $profissional = $profissional->where('profissionals.id', '=', $id);
        // get
        $profissional = $profissional->get()->first();

        // configura o relatório
        $this->pdf->AliasNbPages();   
        $this->pdf->SetMargins(12, 10, 12);
        $this->pdf->SetFont('Arial', '', 10);
        $this->pdf->AddPage();

        // imprimi os dados principais
        $this->pdf->Cell(20, 6, utf8_decode('Matrícula'), 1, 0,'L');
        $this->pdf->Cell(86, 6, utf8_decode('Funcionário'), 1, 0,'L');
        $this->pdf->Cell(80, 6, utf8_decode('Cargo'), 1, 0,'L');
        $this->pdf->Ln();
        $this->pdf->Cell(20, 6, utf8_decode($profissional->matricula), 1, 0,'L');
        $this->pdf->Cell(86, 6, utf8_decode($profissional->nome), 1, 0,'L');
        $this->pdf->Cell(80, 6, utf8_decode($profissional->cargo), 1, 0,'L');
        $this->pdf->Ln();

        $this->pdf->Cell(20, 6, utf8_decode('Vínculo'), 1, 0,'L');
        $this->pdf->Cell(73, 6, utf8_decode('Tipo de Vínculo'), 1, 0,'L');
        $this->pdf->Cell(36, 6, utf8_decode('Carga Horária'), 1, 0,'L');
        $this->pdf->Cell(30, 6, utf8_decode('Flexibilização'), 1, 0,'L');
        $this->pdf->Cell(27, 6, utf8_decode('Data Admissão'), 1, 0,'L');
        $this->pdf->Ln();
        $this->pdf->Cell(20, 6, utf8_decode($profissional->vinculo), 1, 0,'L');
        $this->pdf->Cell(73, 6, utf8_decode($profissional->vinculo_tipo), 1, 0,'L');
        $this->pdf->Cell(36, 6, utf8_decode($profissional->carga_horaria), 1, 0,'L');
        $this->pdf->Cell(30, 6, utf8_decode($profissional->flexibilizacao), 1, 0,'L');
        $this->pdf->Cell(27, 6, utf8_decode($profissional->data_admissao), 1, 0,'L');
        $this->pdf->Ln();

        $this->pdf->Cell(30, 6, utf8_decode('CPF'), 1, 0,'L');
        $this->pdf->Cell(76, 6, utf8_decode('CNS'), 1, 0,'L');
        $this->pdf->Cell(40, 6, utf8_decode('Celular'), 1, 0,'L');
        $this->pdf->Cell(40, 6, utf8_decode('Telefone'), 1, 0,'L');
        $this->pdf->Ln();
        $this->pdf->Cell(30, 6, utf8_decode($profissional->cpf), 1, 0,'L');
        $this->pdf->Cell(76, 6, utf8_decode($profissional->cns), 1, 0,'L');
        $this->pdf->Cell(40, 6, utf8_decode($profissional->cel), 1, 0,'L');
        $this->pdf->Cell(40, 6, utf8_decode($profissional->tel), 1, 0,'L');
        $this->pdf->Ln();

        $this->pdf->Cell(186, 6, utf8_decode('E-mail'), 1, 0,'L');
        $this->pdf->Ln();
        $this->pdf->Cell(186, 6, utf8_decode($profissional->email), 1, 0,'L');
        $this->pdf->Ln();

        $this->pdf->Cell(20, 6, utf8_decode('CEP'), 1, 0,'L');
        $this->pdf->Cell(86, 6, utf8_decode('Logradouro'), 1, 0,'L');
        $this->pdf->Cell(20, 6, utf8_decode('Nº'), 1, 0,'L');
        $this->pdf->Cell(60, 6, utf8_decode('Complemento'), 1, 0,'L');
        $this->pdf->Ln();
        $this->pdf->Cell(20, 6, utf8_decode($profissional->cep), 1, 0,'L');
        $this->pdf->Cell(86, 6, utf8_decode($profissional->logradouro), 1, 0,'L');
        $this->pdf->Cell(20, 6, utf8_decode($profissional->numero), 1, 0,'L');
        $this->pdf->Cell(60, 6, utf8_decode($profissional->complemento), 1, 0,'L');
        $this->pdf->Ln();

        $this->pdf->Cell(80, 6, utf8_decode('Bairro'), 1, 0,'L');
        $this->pdf->Cell(86, 6, utf8_decode('Cidade'), 1, 0,'L');
        $this->pdf->Cell(20, 6, utf8_decode('UF'), 1, 0,'L');
        $this->pdf->Ln();
        $this->pdf->Cell(80, 6, utf8_decode($profissional->bairro), 1, 0,'L');
        $this->pdf->Cell(86, 6, utf8_decode($profissional->cidade), 1, 0,'L');
        $this->pdf->Cell(20, 6, utf8_decode($profissional->uf), 1, 0,'L');
        $this->pdf->Ln();

        if ($profissional->observacao != ''){
            $this->pdf->Cell(186, 6, utf8_decode('Observações'), 1, 0,'L');
            $this->pdf->Ln();
            $this->pdf->MultiCell(186, 6, utf8_decode($profissional->observacao), 1, 'L', false);
        }

        // Férias
        // consulta secundaria
        $ferias = DB::table('ferias');
        // joins
        $ferias = $ferias->join('ferias_tipos', 'ferias_tipos.id', '=', 'ferias.ferias_tipo_id');
        // select
        $ferias = $ferias->select(
          DB::raw("DATE_FORMAT(ferias.inicio, '%d/%m/%Y') AS datainicio"), 
          DB::raw("DATE_FORMAT(ferias.fim, '%d/%m/%Y') AS datafim"), 
          'ferias_tipos.descricao as tipo', 
          'ferias.justificativa', 
          'ferias.observacao' 
        );
        // filter
        $ferias = $ferias->where('ferias.profissional_id', '=', $profissional->id);
        // get
        $ferias = $ferias->get();

        if (count($ferias)){
            $this->pdf->Cell(186, 6, utf8_decode('Férias'), 'B', 0,'L');
            $this->pdf->Ln();
            foreach ($ferias as $ferias_index) {
                $this->pdf->Cell(40, 6, utf8_decode('Data inicial'), 0, 0,'L');
                $this->pdf->Cell(40, 6, utf8_decode('Data Final'), 0, 0,'L');
                $this->pdf->Cell(106, 6, utf8_decode('Descrição'), 0, 0,'L');
                $this->pdf->Ln();
                $this->pdf->Cell(40, 6, utf8_decode($ferias_index->datainicio ?? '-'), 0, 0,'L');
                $this->pdf->Cell(40, 6, utf8_decode($ferias_index->datafim ?? '-'), 0, 0,'L');
                $this->pdf->Cell(106, 6, utf8_decode($ferias_index->tipo), 0, 0,'L');
                $this->pdf->Ln();
                if ($ferias_index->justificativa != ''){
                    $this->pdf->MultiCell(186, 6, utf8_decode('Justificativa: ' . $ferias_index->justificativa), 0, 'L', false);
                }
                if ($ferias_index->observacao != ''){
                    $this->pdf->MultiCell(186, 6, utf8_decode('Observações: ' . $ferias_index->observacao), 0, 'L', false);
                }
            } 
        }

        // Licenças
        // consulta secundaria
        $licencas = DB::table('licencas');
        // joins
        $licencas = $licencas->join('licenca_tipos', 'licenca_tipos.id', '=', 'licencas.licenca_tipo_id');
        // select
        $licencas = $licencas->select(
          DB::raw("DATE_FORMAT(licencas.inicio, '%d/%m/%Y') AS datainicio"),
          DB::raw("DATE_FORMAT(licencas.fim, '%d/%m/%Y') AS datafim"),
          'licenca_tipos.descricao as tipo', 
          'licencas.observacao' 
        );
        // filter
        $licencas = $licencas->where('licencas.profissional_id', '=', $profissional->id);
        // get
        $licencas = $licencas->get();

        if (count($licencas)){
            $this->pdf->Cell(186, 6, utf8_decode('Licenças'), 'B', 0,'L');
            $this->pdf->Ln();
            foreach ($licencas as $licenca) {
                $this->pdf->Cell(40, 6, utf8_decode('Data inicial'), 0, 0,'L');
                $this->pdf->Cell(40, 6, utf8_decode('Data Final'), 0, 0,'L');
                $this->pdf->Cell(106, 6, utf8_decode('Descrição'), 0, 0,'L');
                $this->pdf->Ln();
                $this->pdf->Cell(40, 6, utf8_decode($licenca->datainicio ?? '-'), 0, 0,'L');
                $this->pdf->Cell(40, 6, utf8_decode($licenca->datafim ?? '-'), 0, 0,'L');
                $this->pdf->Cell(106, 6, utf8_decode($licenca->tipo), 0, 0,'L');
                $this->pdf->Ln();
                if ($licenca->observacao != ''){
                    $this->pdf->MultiCell(186, 6, utf8_decode('Observações: ' . $licenca->observacao), 0, 'L', false);
                }
            } 
        }

        // Capacitações
        // consulta secundaria
        $capacitacaos = DB::table('capacitacaos');
        // joins
        $capacitacaos = $capacitacaos->join('capacitacao_tipos', 'capacitacao_tipos.id', '=', 'capacitacaos.capacitacao_tipo_id');
        // select
        $capacitacaos = $capacitacaos->select(
          DB::raw("DATE_FORMAT(capacitacaos.inicio, '%d/%m/%Y') AS datainicio"),
          DB::raw("DATE_FORMAT(capacitacaos.fim, '%d/%m/%Y') AS datafim"), 
          'capacitacao_tipos.descricao as tipo', 
          'capacitacaos.observacao', 
          'capacitacaos.cargaHoraria' 
        );
        // filter
        $capacitacaos = $capacitacaos->where('capacitacaos.profissional_id', '=', $profissional->id);
        // get
        $capacitacaos = $capacitacaos->get();

        if (count($capacitacaos)){
            $this->pdf->Cell(186, 6, utf8_decode('Capacitações'), 'B', 0,'L');
            $this->pdf->Ln();
            foreach ($capacitacaos as $capacitacao) {
                $this->pdf->Cell(40, 6, utf8_decode('Data inicial'), 0, 0,'L');
                $this->pdf->Cell(40, 6, utf8_decode('Data Final'), 0, 0,'L');
                $this->pdf->Cell(53, 6, utf8_decode('Descrição'), 0, 0,'L');
                $this->pdf->Cell(53, 6, utf8_decode('Carga Horária'), 0, 0,'L');
                $this->pdf->Ln();
                $this->pdf->Cell(40, 6, utf8_decode($capacitacao->datainicio ?? '-'), 0, 0,'L');
                $this->pdf->Cell(40, 6, utf8_decode($capacitacao->datafim ?? '-'), 0, 0,'L');
                $this->pdf->Cell(53, 6, utf8_decode($capacitacao->tipo), 0, 0,'L');
                $this->pdf->Cell(53, 6, utf8_decode($capacitacao->cargaHoraria), 0, 0,'L');
                $this->pdf->Ln();
                if ($capacitacao->observacao != ''){
                    $this->pdf->MultiCell(186, 6, utf8_decode('Observações: ' . $capacitacao->observacao), 0, 'L', false);
                }
            } 
        }

        $this->pdf->Output('D', 'Profissional_' . $profissional->nome .  date("Y-m-d H:i:s") . '.pdf', true);
        exit;
    } 


    /**
     * Função de autocompletar para ser usada pelo typehead
     *
     * @param  
     * @return json
     */
    public function autocomplete(Request $request)
    {

        $profissionais = DB::table('profissionals');

        // join
        $profissionais = $profissionais->join('cargos', 'cargos.id', '=', 'profissionals.cargo_id');

        // select
        $profissionais = $profissionais->select(
          'profissionals.nome as text', 
          'profissionals.id as value', 
          'cargos.nome as cargo', 
          'cargos.id as cargo_id', 
          'profissionals.matricula as matricula'
        );
        
        //where
        $profissionais = $profissionais->where("profissionals.nome","LIKE","%{$request->input('query')}%");

        //get
        $profissionais = $profissionais->get();


        return response()->json($profissionais, 200, ['Content-type'=> 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    } 

}
