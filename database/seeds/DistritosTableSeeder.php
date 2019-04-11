<?php

use Illuminate\Database\Seeder;

class DistritosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('distritos')->insert([
            'nome' => 'Eldorado',
        ]);
        DB::table('distritos')->insert([
            'nome' => 'Industrial',
        ]);
        DB::table('distritos')->insert([
            'nome' => 'Nacional',
        ]);
        DB::table('distritos')->insert([
            'nome' => 'Petrolândia',
        ]);
        DB::table('distritos')->insert([
            'nome' => 'Ressaca',
        ]);
        DB::table('distritos')->insert([
            'nome' => 'Sede',
        ]);
        DB::table('distritos')->insert([
            'nome' => 'Vargem das Flores',
        ]);
        DB::table('distritos')->insert([
            'nome' => 'Riacho',
        ]);
    }
}
