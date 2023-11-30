<?php

namespace App\Exports;

use App\Models\Equipe;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class EquipesExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export EquipesExport --model=Equipe
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
                        'distritos.nome as distrito',
                        'cargos.nome as cargo',
                        'cargos.cbo as cbo',
                        DB::raw('COALESCE(profissionals.nome, \'Não Vínculado\') AS profissional'),
                        DB::raw('COALESCE(profissionals.matricula, \'-\') AS matricula'),
                        DB::raw('COALESCE(profissionals.cpf, \'-\') AS cpf'),
                        DB::raw('COALESCE(profissionals.cns, \'-\') AS cns'),
                        DB::raw('COALESCE(vinculos.nome, \'-\') AS vinculo'),
                        )
            ->join('unidades', 'unidades.id', '=', 'equipes.unidade_id')
            ->join('distritos', 'distritos.id', '=', 'unidades.distrito_id')
            ->join('equipe_tipos', 'equipe_tipos.id', '=', 'equipes.equipe_tipo_id')
                ->join('equipe_profissionals', 'equipe_profissionals.equipe_id', '=', 'equipes.id')
                ->leftjoin('profissionals', 'profissionals.id', '=', 'equipe_profissionals.profissional_id')
                    ->leftjoin('vinculos', 'vinculos.id', '=', 'profissionals.vinculo_id')
                ->join('cargos', 'cargos.id', '=', 'equipe_profissionals.cargo_id')
            ->orderBy('equipes.id', 'asc')
            ->orderBy('cargos.nome', 'asc')
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
                "Distrito",
                "Cargo",
                "CBO",
                "Profissional",
                "Matrícula",
                "CPF",
                "CNS",
                "Vínculo"
            
            ];
    }
}
