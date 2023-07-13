<?php

namespace App\Exports;

use App\Models\Vinculo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VinculosExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    * 
    * php artisan make:export VinculosExport --model=Permission
    * 
    * https://laravel-excel.com/
    * 
    *
    */

    public function query()
    {
        return Vinculo::query()->select('nome')->orderBy('nome', 'asc');
    }

    public function headings(): array
    {
        return ["Nome"];
    }
}
