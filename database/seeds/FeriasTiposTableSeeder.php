<?php

use Illuminate\Database\Seeder;

class FeriasTiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ferias_tipos')->insert([
            'descricao' => 'Férias Normal',
        ]);
        DB::table('ferias_tipos')->insert([
            'descricao' => 'Férias 1º Parcela',
        ]);
        DB::table('ferias_tipos')->insert([
            'descricao' => 'Férias 2º Parcela',
        ]);
        DB::table('ferias_tipos')->insert([
            'descricao' => 'Férias Prêmias',
        ]);
    }
}
