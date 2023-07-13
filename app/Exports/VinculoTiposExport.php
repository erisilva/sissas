<?php

namespace App\Exports;

use App\Models\VinculoTipo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VinculoTiposExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export VinculoTiposExport --model=Permission
    * 
    * https://laravel-excel.com/
    * 
    *
    */

    public function query()
    {
        return VinculoTipo::query()->select('nome')->orderBy('nome', 'asc');
    }

    public function headings(): array
    {
        return ["Nome"];
    }
}
