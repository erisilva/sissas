<?php

use Illuminate\Database\Seeder;

class CapacitacaoTiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('capacitacao_tipos')->insert([
            'descricao' => 'Doutorado',
        ]);
        DB::table('capacitacao_tipos')->insert([
            'descricao' => 'Mestrado',
        ]);
        DB::table('capacitacao_tipos')->insert([
            'descricao' => 'Especialização',
        ]);
        DB::table('capacitacao_tipos')->insert([
            'descricao' => 'Extensão',
        ]);
        DB::table('capacitacao_tipos')->insert([
            'descricao' => 'Cursos',
        ]);
    }
}
