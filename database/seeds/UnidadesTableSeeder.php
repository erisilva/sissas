<?php

use Illuminate\Database\Seeder;

class UnidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// alguns exemplos para testes
		DB::table('unidades')->insert(['descricao' => 'Água Branca', 'porte' => 'III', 'logradouro' => 'avenida seis', 'cel' => '', 'tel' => '', 'distrito_id' => 1,]);
        DB::table('unidades')->insert(['descricao' => 'Alvorada', 'porte' => 'I', 'logradouro' => 'rua joaquim tiburcio custodio', 'tel' => '', 'cel' => '', 'distrito_id' => 6,]);
        DB::table('unidades')->insert(['descricao' => 'Amazonas', 'porte' => 'III', 'logradouro' => 'rua marques de parana', 'tel' => '', 'cel' => '', 'distrito_id' => 2,]);
        DB::table('unidades')->insert(['descricao' => 'Amazonas I', 'porte' => 'III', 'logradouro' => 'rua jose antunes', 'tel' => '', 'cel' => '', 'distrito_id' => 2,]);
        DB::table('unidades')->insert(['descricao' => 'Arvoredo', 'porte' => 'I', 'logradouro' => 'rua eucalipto', 'tel' => '', 'cel' => '', 'distrito_id' => 5,]);
    }
}
