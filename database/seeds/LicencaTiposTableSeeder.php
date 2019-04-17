<?php

use Illuminate\Database\Seeder;

class LicencaTiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('licenca_tipos')->insert([
            'descricao' => 'Licença Médica',
        ]);
        DB::table('licenca_tipos')->insert([
            'descricao' => 'Licença Maternidade',
        ]);
        DB::table('licenca_tipos')->insert([
            'descricao' => 'Afastamento Médico',
        ]);
    }
}
