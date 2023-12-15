<?php

namespace App\Exports;

use App\Models\Equipe;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EquipeGestaoExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export EquipeGestaoExport --model=Permission
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
        return Equipe::query()
                        ->select('equipes.descricao as descricao',
                                    'equipes.numero as numero',
                                    'equipe_tipos.nome as tipo',
                                    'equipes.cnes as cnes',
                                    'equipes.ine as ine',
                                    'equipes.minima as minima',   
                                    'unidades.nome as unidade',
                                    'distritos.nome as distrito'
                                    )
                        ->join('unidades', 'unidades.id', '=', 'equipes.unidade_id')
                        ->join('distritos', 'distritos.id', '=', 'unidades.distrito_id')
                        ->join('equipe_tipos', 'equipe_tipos.id', '=', 'equipes.equipe_tipo_id')
                        ->orderBy('equipes.id', 'asc')
                        ->filter($this->filter);
    }

    public function headings(): array
    {
        return ["Equipe", 
                "Número",
                "Tipo",
                "CNES",
                "INE",
                "Mínima",
                "Unidade",
                "Distrito"
            ];
    }
}
