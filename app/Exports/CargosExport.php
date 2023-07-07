<?php

namespace App\Exports;

use App\Models\Cargo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CargosExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export DistritosExport --model=Permission
    * 
    * https://laravel-excel.com/
    * 
    *
    */

    public function query()
    {
        return Cargo::query()->select('nome', 'cbo')->orderBy('nome', 'asc');
    }

    public function headings(): array
    {
        return ["Nome", "CBO"];
    }
}
