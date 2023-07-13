<?php

namespace App\Exports;

use App\Models\CargaHoraria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CargaHorariasExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export CargaHorariasExport --model=Permission
    * 
    * https://laravel-excel.com/
    * 
    *
    */

    public function query()
    {
        return CargaHoraria::query()->select('nome')->orderBy('nome', 'asc');
    }

    public function headings(): array
    {
        return ["Nome"];
    }
}
