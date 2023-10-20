<?php

namespace App\Exports;

use App\Models\Ferias;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class FeriasExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export LicencaTiposExport --model=Permission
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
        return Ferias::query()
        ->select('profissionals.nome as profissional',
                 'profissionals.matricula',
                 'cargos.nome as cargo',
                    'ferias_tipos.nome as tipo_de_ferias',
                    DB::raw('DATE_FORMAT(ferias.inicio, \'%d/%m/%Y\') AS data_incio'),
                    DB::raw('DATE_FORMAT(ferias.fim, \'%d/%m/%Y\') AS data_final'),
                    'ferias.justificativa',
                 )
        ->join('profissionals', 'profissionals.id', '=', 'ferias.profissional_id')
        ->join('cargos', 'cargos.id', '=', 'profissionals.cargo_id')
        ->join('ferias_tipos', 'ferias_tipos.id', '=', 'ferias.ferias_tipo_id')
        ->filter($this->filter)
        ->orderBy('profissionals.nome', 'asc');
    }

    public function headings(): array
    {
        return ["Profissional",
                "Matrícula",
                "Cargo",
                "Tipo de Férias",
                "Data de Início",
                "Data Final",
                "Justificativa",        
        ];
    }
}