<?php

namespace App\Exports;

use App\Models\EquipeView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class EquipeViewSimplesExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export EquipeViewSimplesExport --model=Equipe
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
        return EquipeView::query()
            ->select(   DB::raw('COALESCE(nome, \' \') AS profissional'),
                        DB::raw('COALESCE(matricula, \' \') AS matricula'),
                        DB::raw('COALESCE(cpf, \' \') AS cpf'),
                        DB::raw('COALESCE(vinculo, \' \') AS vinculo'),
                        DB::raw('COALESCE(tipo_de_vinculo, \' \') AS tipo_de_vinculo'),
                        'cargo',
                        'equipe',
                        'equipe_tipo',
                        'equipe_numero',
                        'cnes',
                        'ine',
                        'unidade',
                        'distrito',
                        )
            ->filter($this->filter);
    }

    public function headings(): array
    {
        return ["Nome", 
                "Matrícula", 
                "CPF",
                "Vínculo", 
                "Tipo de Vínculo",
                "Cargo da Vaga",
                "Equipe",
                "Tipo de Equipe",
                "Número da Equipe",
                "CNES",
                "INE",
                "Unidade",
                "Distrito",
            
            ];
    }
}
