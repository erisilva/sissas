<?php

use Illuminate\Database\Seeder;

class CargosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 DB::table('cargos')->insert([
            'nome' => 'medico da estrategia do saude da família',
            'cbo' => '225142',
        ]);

        DB::table('cargos')->insert([
            'nome' => 'enfermeiro da estrategia de saude da família',
            'cbo' => '223565',
        ]);

        DB::table('cargos')->insert([
            'nome' => 'tecnico de enfermagem da est. saude da família',
            'cbo' => '322245',
        ]);

        DB::table('cargos')->insert([
            'nome' => 'agente comunitario de saude',
            'cbo' => '515105',
        ]);

        DB::table('cargos')->insert([
            'nome' => 'auxiliar de servicos gerais',
            'cbo' => 'não definido',
        ]);

        DB::table('cargos')->insert([
            'nome' => 'assistente administrativo',
            'cbo' => '411010',
        ]);

        DB::table('cargos')->insert([
            'nome' => 'cirurgiao dentista da est. de saude da família',
            'cbo' => '223293',
        ]);

        DB::table('cargos')->insert([
            'nome' => 'auxiliar de saude bucal do saude da família',
            'cbo' => '322430',
        ]);

        DB::table('cargos')->insert([
            'nome' => 'tecnico em saude bucal',
            'cbo' => '322405',
        ]);

        DB::table('cargos')->insert([
            'nome' => 'gerente de servicos de saude',
            'cbo' => '131210',
        ]);

        DB::table('cargos')->insert([
            'nome' => 'teste 1 apagar',
            'cbo' => '11111111',
        ]);

        DB::table('cargos')->insert([
            'nome' => 'teste 2 apagar',
            'cbo' => '222222222',
        ]);
    }
}
