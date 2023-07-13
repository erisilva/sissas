<?php

namespace App\Exports;

use App\Models\FeriasTipo;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FeriasTiposExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export FeriasTiposExport --model=Permission
    * 
    * https://laravel-excel.com/
    * 
    *
    */

    public function query()
    {
        return FeriasTipo::query()->select('nome')->orderBy('nome', 'asc');
    }

    public function headings(): array
    {
        return ["Nome"];
    }
}