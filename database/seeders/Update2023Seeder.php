<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Update2023Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // essas permissões não existem na versão 1 do sistema
        // DB::table('permissions')->insert([
        //     'name' => 'profissional.ferias.index',
        //     'description' => 'Lista das férias dos profissionais',
        // ]);

        // DB::table('permissions')->insert([
        //     'name' => 'profissional.ferias.edit',
        //     'description' => 'Alterar dados das férias de um profissional',
        // ]);

        // DB::table('permissions')->insert([
        //     'name' => 'profissional.ferias.show',
        //     'description' => 'Mostrar dados dos tipos das férias de um profissional',
        // ]);
        // DB::table('permissions')->insert([
        //     'name' => 'profissional.ferias.export',
        //     'description' => 'Exportação de dados das férias dos profissionais',
        // ]);


        // // Licenca
        // DB::table('permissions')->insert([
        //     'name' => 'profissional.licenca.index',
        //     'description' => 'Lista das licenças dos profissionais',
        // ]);

        // DB::table('permissions')->insert([
        //     'name' => 'profissional.licenca.edit',
        //     'description' => 'Alterar dados das licenças de um profissional',
        // ]);

        // DB::table('permissions')->insert([
        //     'name' => 'profissional.licenca.show',
        //     'description' => 'Mostrar dados dos tipos das licenças de um profissional',
        // ]);
        // DB::table('permissions')->insert([
        //     'name' => 'profissional.licenca.export',
        //     'description' => 'Exportação de dados das licenças dos profissionais',
        // ]);

    }
}
