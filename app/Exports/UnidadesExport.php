<?php

namespace App\Exports;

use App\Models\Unidade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UnidadesExport implements FromQuery, WithHeadings
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

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function query()
    {
        return Unidade::query()
            ->select('unidades.nome',
                     'distritos.nome as distrito_nome',
                     'unidades.logradouro'
                    )
            ->join('distritos', 'distritos.id', '=', 'unidades.distrito_id')
            ->orderBy('unidades.nome', 'asc')
            ->filter($this->filter);
    }

    public function headings(): array
    {
        return ["Nome", "Distrito", "Logradouro"];
    }
}
