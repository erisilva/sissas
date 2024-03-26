<?php

namespace App\Exports;

use App\Models\Historico;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class HistoricoExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export PermissionsExport --model=Permission
    * 
    * https://laravel-excel.com/
    * 
    *
    */

    private $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function query()
    {
        return Historico::query()
            ->select(
                        'historicos.id',
                        DB::raw('DATE_FORMAT(historicos.created_at, \'%d/%m/%Y\') AS data'),
                        DB::raw('DATE_FORMAT(historicos.created_at, \'%h:%m:%s\') AS hora'),
                        'historico_tipos.descricao as tipo',
                        'profissionals.nome as profissional',
                        'profissionals.matricula',
                        'profissionals.cpf',
                        'users.name as usuario', 
                        DB::raw("coalesce(equipes.descricao, 'Não Vinculado') as descricao_equipe"),                   
                        DB::raw("coalesce(equipes.numero, 'Não Vinculado') as numero_equipe"),                   
                        DB::raw("coalesce(equipes.ine, 'Não Vinculado') as ine_equipe"),                   
                        DB::raw("coalesce(equipes.cnes, 'Não Vinculado') as cnes_equipe"),                   
                        DB::raw("coalesce(equipes.cnes, 'Não Vinculado') as cnes_equipe"),
                        DB::raw("coalesce(unidades.nome, 'Não Vinculado') as unidade"),
                        DB::raw("coalesce(distritos.nome, 'Não Vinculado') as distrito"),
                        'historicos.observacao'                  
                        
                    )
            ->join('users', 'users.id', '=', 'historicos.user_id')
            ->join('profissionals', 'profissionals.id', '=', 'historicos.profissional_id')
            ->join('historico_tipos', 'historico_tipos.id', '=', 'historicos.historico_tipo_id')
            ->leftjoin('equipes','equipes.id','=','historicos.equipe_id')
            ->leftjoin('unidades','unidades.id','=','historicos.unidade_id')
            ->leftjoin('distritos','distritos.id','=','unidades.distrito_id')

            ->orderBy('historicos.id', 'desc')
            ->filter($this->filter);
    }

    public function headings(): array
    {
        return [
            "ID", 
            "Data", 
            "Hora",
            "Tipo de Histórico",
            "Profissional",
            "Matrícula",
            "CPF",
            "Operador",
            "Descrição da Equipe",
            "Número da Equipe",
            "INE da Equipe",
            "CNES da Equipe",
            "Unidade",
            "Distrito",
            "Observação"
        
        ];
    }
}
