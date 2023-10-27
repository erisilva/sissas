<?php

namespace App\Exports;

use App\Models\Licenca;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class LicencasExport implements FromQuery, WithHeadings
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
        return Licenca::query()
        ->select('profissionals.nome as profissional',
                 'profissionals.matricula',
                 'cargos.nome as cargo',
                    'licenca_tipos.nome as tipo_de_licenca',
                    DB::raw('DATE_FORMAT(licencas.inicio, \'%d/%m/%Y\') AS data_incio'),
                    DB::raw('DATE_FORMAT(licencas.fim, \'%d/%m/%Y\') AS data_final'),
                    'licencas.observacao',
                 )
        ->join('profissionals', 'profissionals.id', '=', 'licencas.profissional_id')
        ->join('cargos', 'cargos.id', '=', 'profissionals.cargo_id')
        ->join('licenca_tipos', 'licenca_tipos.id', '=', 'licencas.licenca_tipo_id')
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
                "Observações",        
        ];
    }
}