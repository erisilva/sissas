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

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function query()
    {
        return Permission::query()->select('name', 'description')->orderBy('id', 'asc')->filter($this->filter);
    }

    public function headings(): array
    {
        return ["Nome", "Descrição"];
    }
}
