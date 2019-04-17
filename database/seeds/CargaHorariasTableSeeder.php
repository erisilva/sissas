<?php

use Illuminate\Database\Seeder;

class CargaHorariasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('carga_horarias')->insert([
            'descricao' => '20 h/semana',
        ]);
        DB::table('carga_horarias')->insert([
            'descricao' => '30 h/semana',
        ]);
        DB::table('carga_horarias')->insert([
            'descricao' => '40 h/semana',
        ]);
    }
}
