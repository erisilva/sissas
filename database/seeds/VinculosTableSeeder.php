<?php

use Illuminate\Database\Seeder;

class VinculosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vinculos')->insert([
            'descricao' => 'SMS',
        ]);
        DB::table('vinculos')->insert([
            'descricao' => 'PMC',
        ]);
    }
}
