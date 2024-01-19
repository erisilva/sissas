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
            ->select(   DB::raw('COALESCE(nome, \'Vaga Livre\') AS profissional'),
                        DB::raw('COALESCE(matricula, \'Vaga Livre\') AS matricula'),
                        DB::raw('COALESCE(cpf, \'Vaga Livre\') AS cpf'),
                        DB::raw('COALESCE(vinculo, \'Vaga Livre\') AS vinculo'),
                        DB::raw('COALESCE(tipo_de_vinculo, \'Vaga Livre\') AS tipo_de_vinculo'),
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
                "Cargo",
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
