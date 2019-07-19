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

        //carga horária
        DB::table('permissions')->insert([
            'name' => 'cargahoraria.index',
            'description' => 'Lista de cargas horárias',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cargahoraria.create',
            'description' => 'Registrar nova carga horária',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cargahoraria.edit',
            'description' => 'Alterar dados de uma carga horária',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cargahoraria.delete',
            'description' => 'Excluir carga horária',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cargahoraria.show',
            'description' => 'Mostrar dados das cargas horárias',
        ]);
        DB::table('permissions')->insert([
            'name' => 'cargahoraria.export',
            'description' => 'Exportação de dados das cargas horárias',
        ]);

        //vínculos
        DB::table('permissions')->insert([
            'name' => 'vinculo.index',
            'description' => 'Lista de vínculos',
        ]);
        DB::table('permissions')->insert([
            'name' => 'vinculo.create',
            'description' => 'Registrar novo vínculo',
        ]);
        DB::table('permissions')->insert([
            'name' => 'vinculo.edit',
            'description' => 'Alterar dados de um vínculo',
        ]);
        DB::table('permissions')->insert([
            'name' => 'vinculo.delete',
            'description' => 'Excluir vínculo',
        ]);
        DB::table('permissions')->insert([
            'name' => 'vinculo.show',
            'description' => 'Mostrar dados dos vínculos',
        ]);
        DB::table('permissions')->insert([
            'name' => 'vinculo.export',
            'description' => 'Exportação de dados dos vínculos',
        ]);

        //tipos vínculos
        DB::table('permissions')->insert([
            'name' => 'vinculotipo.index',
            'description' => 'Lista de tipos vínculos',
        ]);
        DB::table('permissions')->insert([
            'name' => 'vinculotipo.create',
            'description' => 'Registrar novo tipo de vínculo',
        ]);
        DB::table('permissions')->insert([
            'name' => 'vinculotipo.edit',
            'description' => 'Alterar dados de um tipo de vínculo',
        ]);
        DB::table('permissions')->insert([
            'name' => 'vinculotipo.delete',
            'description' => 'Excluir tipo de vínculo',
        ]);
        DB::table('permissions')->insert([
            'name' => 'vinculotipo.show',
            'description' => 'Mostrar dados dos tipos de vínculos',
        ]);
        DB::table('permissions')->insert([
            'name' => 'vinculotipo.export',
            'description' => 'Exportação de dados dos tipos vínculos',
        ]);

        //tipos de licenças
        DB::table('permissions')->insert([
            'name' => 'licencatipo.index',
            'description' => 'Lista de tipos de licenças',
        ]);
        DB::table('permissions')->insert([
            'name' => 'licencatipo.create',
            'description' => 'Registrar novo tipo de licença',
        ]);
        DB::table('permissions')->insert([
            'name' => 'licencatipo.edit',
            'description' => 'Alterar dados de um tipo de licença',
        ]);
        DB::table('permissions')->insert([
            'name' => 'licencatipo.delete',
            'description' => 'Excluir tipo de licença',
        ]);
        DB::table('permissions')->insert([
            'name' => 'licencatipo.show',
            'description' => 'Mostrar dados dos tipos de licença',
        ]);
        DB::table('permissions')->insert([
            'name' => 'licencatipo.export',
            'description' => 'Exportação de dados dos tipos de licença',
        ]);


        //tipos de Férias
        DB::table('permissions')->insert([
            'name' => 'feriastipo.index',
            'description' => 'Lista de tipos de férias',
        ]);
        DB::table('permissions')->insert([
            'name' => 'feriastipo.create',
            'description' => 'Registrar novo tipo de férias',
        ]);
        DB::table('permissions')->insert([
            'name' => 'feriastipo.edit',
            'description' => 'Alterar dados de um tipo de férias',
        ]);
        DB::table('permissions')->insert([
            'name' => 'feriastipo.delete',
            'description' => 'Excluir tipo de férias',
        ]);
        DB::table('permissions')->insert([
            'name' => 'feriastipo.show',
            'description' => 'Mostrar dados dos tipos de férias',
        ]);
        DB::table('permissions')->insert([
            'name' => 'feriastipo.export',
            'description' => 'Exportação de dados dos tipos de férias',
        ]);

        //tipos de Capacitações
        DB::table('permissions')->insert([
            'name' => 'capacitacaotipo.index',
            'description' => 'Lista de tipos de Capacitações',
        ]);
        DB::table('permissions')->insert([
            'name' => 'capacitacaotipo.create',
            'description' => 'Registrar novo tipo de capacitação',
        ]);
        DB::table('permissions')->insert([
            'name' => 'capacitacaotipo.edit',
            'description' => 'Alterar dados de um tipo de capacitação',
        ]);
        DB::table('permissions')->insert([
            'name' => 'capacitacaotipo.delete',
            'description' => 'Excluir tipo de capacitação',
        ]);
        DB::table('permissions')->insert([
            'name' => 'capacitacaotipo.show',
            'description' => 'Mostrar dados dos tipos de capacitação',
        ]);
        DB::table('permissions')->insert([
            'name' => 'capacitacaotipo.export',
            'description' => 'Exportação de dados dos tipos de Capacitações',
        ]);

        // Profissionais
        DB::table('permissions')->insert([
            'name' => 'profissional.index',
            'description' => 'Lista de profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'profissional.create',
            'description' => 'Registrar novo profissional',
        ]);
        DB::table('permissions')->insert([
            'name' => 'profissional.edit',
            'description' => 'Alterar dados de um profissional',
        ]);
        DB::table('permissions')->insert([
            'name' => 'profissional.delete',
            'description' => 'Enviar profissional para lixeira',
        ]);
        DB::table('permissions')->insert([
            'name' => 'profissional.show',
            'description' => 'Mostrar dados dos profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'profissional.export',
            'description' => 'Exportação de dados dos profissionais',
        ]);

        // Profissionais (LIXEIRA)
        DB::table('permissions')->insert([
            'name' => 'profissional.trash.index',
            'description' => 'Exibir a lixeira de profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'profissional.trash.restore',
            'description' => 'Restaurar registro da lixeira de profissionais',
        ]);

        // Profissionais->férias
        DB::table('permissions')->insert([
            'name' => 'profissional.ferias.create',
            'description' => 'Registrar férias para os profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'profissional.ferias.delete',
            'description' => 'Excluir férias dos profissionais',
        ]);

        // Profissionais->licença
        DB::table('permissions')->insert([
            'name' => 'profissional.licenca.create',
            'description' => 'Registrar licença para os profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'profissional.licenca.delete',
            'description' => 'Excluir licença dos profissionais',
        ]);

        // Profissionais->capacitação
        DB::table('permissions')->insert([
            'name' => 'profissional.capacitacao.create',
            'description' => 'Registrar capacitação para os profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'profissional.capacitacao.delete',
            'description' => 'Excluir capacitação dos profissionais',
        ]);

        // Orgão Emissor
        DB::table('permissions')->insert([
            'name' => 'orgaoemissor.index',
            'description' => 'Lista de orgãos emissores',
        ]);
        DB::table('permissions')->insert([
            'name' => 'orgaoemissor.create',
            'description' => 'Registrar novo orgão emissor',
        ]);
        DB::table('permissions')->insert([
            'name' => 'orgaoemissor.edit',
            'description' => 'Alterar dados de um orgão emissor',
        ]);
        DB::table('permissions')->insert([
            'name' => 'orgaoemissor.delete',
            'description' => 'Excluir orgão emissor',
        ]);
        DB::table('permissions')->insert([
            'name' => 'orgaoemissor.show',
            'description' => 'Mostrar dados dos orgãos emissores',
        ]);
        DB::table('permissions')->insert([
            'name' => 'orgaoemissor.export',
            'description' => 'Exportação de dados dos orgãos emissores',
        ]);
    }
}
