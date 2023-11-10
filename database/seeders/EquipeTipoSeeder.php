<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipeTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('equipe_tipos')->insert([
            'id' => 1,
            'nome' => 'Saúde'
        ]);

        DB::table('equipe_tipos')->insert([
            'id' => 2,
            'nome' => 'Técnica'
        ]);

        DB::table('equipe_tipos')->insert([
            'id' => 3,
            'nome' => 'Outro tipo'
        ]);
    }
}
