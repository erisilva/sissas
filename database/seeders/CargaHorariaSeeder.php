<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargaHorariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('carga_horarias')->insert([
            'nome' => '20 h/semana',
        ]);
        DB::table('carga_horarias')->insert([
            'nome' => '30 h/semana',
        ]);
        DB::table('carga_horarias')->insert([
            'nome' => '40 h/semana',
        ]);
    }
}
