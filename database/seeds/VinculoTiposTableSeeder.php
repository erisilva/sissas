<?php

use Illuminate\Database\Seeder;

class VinculoTiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vinculo_tipos')->insert([
            'descricao' => 'teste 1',
        ]);
        DB::table('vinculo_tipos')->insert([
            'descricao' => 'teste 2',
        ]);
        DB::table('vinculo_tipos')->insert([
            'descricao' => 'teste 3',
        ]);
    }
}
