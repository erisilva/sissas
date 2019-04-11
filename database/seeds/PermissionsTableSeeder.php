<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Permission = permissão
     * essas permições só devem ser configuradas pelo administrador
     * as permissões ficam vinculadas a cada método do controlador
     *
     * @return void
     */
    public function run()
    {
    	// permissões possíveis para o cadastro de operadores do sistema
    	// user = operador
        DB::table('permissions')->insert([
            'name' => 'user.index',
            'description' => 'Lista de operadores',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user.create',
            'description' => 'Registrar novo operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user.edit',
            'description' => 'Alterar dados do operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user.delete',
            'description' => 'Excluir operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user.show',
            'description' => 'Mostrar dados do operador',
        ]);
        DB::table('permissions')->insert([
            'name' => 'user.export',
            'description' => 'Exportação de dados dos operadores',
        ]);


		// permissões possíveis para o cadastro de perfis do sistema
        //role = perfil
        DB::table('permissions')->insert([
            'name' => 'role.index',
            'description' => 'Lista de perfis',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role.create',
            'description' => 'Registrar novo perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role.edit',
            'description' => 'Alterar dados do perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role.delete',
            'description' => 'Excluir perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role.show',
            'description' => 'Alterar dados do perfil',
        ]);
        DB::table('permissions')->insert([
            'name' => 'role.export',
            'description' => 'Exportação de dados dos perfis',
        ]);

        // permissões possíveis para o cadastro de permissões do sistema
        //permission = permissão de acesso
        DB::table('permissions')->insert([
            'name' => 'permission.index',
            'description' => 'Lista de permissões',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission.create',
            'description' => 'Registrar nova permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission.edit',
            'description' => 'Alterar dados da permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission.delete',
            'description' => 'Excluir permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission.show',
            'description' => 'Mostrar dados da permissão',
        ]);
        DB::table('permissions')->insert([
            'name' => 'permission.export',
            'description' => 'Exportação de dados das permissões',
        ]);


        //distritos
        DB::table('permissions')->insert([
            'name' => 'distrito.index',
            'description' => 'Lista de distritos',
        ]);
        DB::table('permissions')->insert([
            'name' => 'distrito.create',
            'description' => 'Registrar novo distrito',
        ]);
        DB::table('permissions')->insert([
            'name' => 'distrito.edit',
            'description' => 'Alterar dados do distrito',
        ]);
        DB::table('permissions')->insert([
            'name' => 'distrito.delete',
            'description' => 'Excluir distrito',
        ]);
        DB::table('permissions')->insert([
            'name' => 'distrito.show',
            'description' => 'Mostrar dados do distrito',
        ]);
        DB::table('permissions')->insert([
            'name' => 'distrito.export',
            'description' => 'Exportação de dados dos distritos',
        ]);

        //unidades
        DB::table('permissions')->insert([
            'name' => 'unidade.index',
            'description' => 'Lista de unidades',
        ]);
        DB::table('permissions')->insert([
            'name' => 'unidade.create',
            'description' => 'Registrar nova unidade',
        ]);
        DB::table('permissions')->insert([
            'name' => 'unidade.edit',
            'description' => 'Alterar dados de uma unidade',
        ]);
        DB::table('permissions')->insert([
            'name' => 'unidade.delete',
            'description' => 'Excluir unidade',
        ]);
        DB::table('permissions')->insert([
            'name' => 'unidade.show',
            'description' => 'Mostrar dados das unidades',
        ]);
        DB::table('permissions')->insert([
            'name' => 'unidade.export',
            'description' => 'Exportação de dados das unidades',
        ]);

        //cargos
        DB::table('permissions')->insert([
            'name' => 'cargo.index',
            'description' => 'Lista de cargos',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cargo.create',
            'description' => 'Registrar novo cargo',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cargo.edit',
            'description' => 'Alterar dados de um cargo',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cargo.delete',
            'description' => 'Excluir cargo',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cargo.show',
            'description' => 'Mostrar dados dos cargos',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cargo.export',
            'description' => 'Exportação de dados dos cargos',
        ]);
    }
}
