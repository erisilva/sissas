<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class Update2023Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        // SISAS 2.0
        // Profissionais->férias
        DB::table('permissions')->insert([
            'name' => 'ferias.index',
            'description' => 'Registrar férias para os profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'ferias.create',
            'description' => 'Registrar férias para os profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'ferias.edit',
            'description' => 'Alterar dados de férias dos profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'ferias.delete',
            'description' => 'Excluir férias dos profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'ferias.show',
            'description' => 'Mostrar dados das férias dos profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'ferias.export',
            'description' => 'Exportação de dados das férias dos profissionais',
        ]);
        


        // SISAS 2.0
        // Profissionais->licença
        DB::table('permissions')->insert([
            'name' => 'licenca.index',
            'description' => 'Registrar licença para os profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'licenca.create',
            'description' => 'Registrar licença para os profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'licenca.edit',
            'description' => 'Alterar dados de licença dos profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'licenca.delete',
            'description' => 'Excluir licença dos profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'licenca.show',
            'description' => 'Mostrar dados das licenças dos profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'licenca.export',
            'description' => 'Exportação de dados das licenças dos profissionais',
        ]);
        
        // SISAS 2.0
        // Profissionais->capacitacao
        DB::table('permissions')->insert([
            'name' => 'capacitacao.create',
            'description' => 'Registrar uma capacitação para os profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'capacitacao.delete',
            'description' => 'Excluir uma capacitação dos profissionais',
        ]);

        // SISAS 2.0
        // Tipos de equipe, para o cadastro de equipes
        DB::table('permissions')->insert([
            'name' => 'equipetipo.index',
            'description' => 'Registrar tipo de equipe para os profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'equipetipo.create',
            'description' => 'Registrar tipo de equipe para os profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'equipetipo.edit',
            'description' => 'Alterar dados de tipo de equipe dos profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'equipetipo.delete',
            'description' => 'Excluir tipo de equipe dos profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'equipetipo.show',
            'description' => 'Mostrar dados das tipo de equipe dos profissionais',
        ]);
        DB::table('permissions')->insert([
            'name' => 'equipetipo.export',
            'description' => 'Exportação de dados das tipo de equipes dos profissionais',
        ]);


        // SISAS 2.0
        // Tipos de equipe, para o cadastro de equipes
        DB::table('permissions')->insert([
            'name' => 'mapa.index',
            'description' => 'Acessar o Mapa de Equipes',
        ]);
        DB::table('permissions')->insert([
            'name' => 'mapa.show',
            'description' => 'Mostrar dados do Mapa de Equipes',
        ]);
        DB::table('permissions')->insert([
            'name' => 'mapa.export',
            'description' => 'Exportação de dados do Mapa de Equipes',
        ]);


        DB::table('permissions')->insert([
            'name' => 'gestao.equipe.cadastrar.profissional.vaga',
            'description' => 'Registrar um profissional a uma vaga da equipe',
        ]);



        //ACL
        // recebi os perfis
        $administrador_perfil = Role::where('name', '=', 'admin')->get()->first();
        $gerente_perfil = Role::where('name', '=', 'gerente')->get()->first();
        $operador_perfil = Role::where('name', '=', 'operador')->get()->first();
        $leitor_perfil = Role::where('name', '=', 'leitor')->get()->first();

        // para profissionais->férias
        $profissional_ferias_index = Permission::where('name', '=', 'ferias.index')->get()->first();
        $profissional_ferias_create = Permission::where('name', '=', 'ferias.create')->get()->first();
        $profissional_ferias_edit = Permission::where('name', '=', 'ferias.edit')->get()->first(); 
        $profissional_ferias_delete = Permission::where('name', '=', 'ferias.delete')->get()->first();
        $profissional_ferias_show = Permission::where('name', '=', 'ferias.show')->get()->first();
        $profissional_ferias_export = Permission::where('name', '=', 'ferias.export')->get()->first();
        // para profissionais->licenças
        $profissional_licenca_index = Permission::where('name', '=', 'licenca.index')->get()->first();
        $profissional_licenca_create = Permission::where('name', '=', 'licenca.create')->get()->first();
        $profissional_licenca_edit = Permission::where('name', '=', 'licenca.edit')->get()->first(); 
        $profissional_licenca_delete = Permission::where('name', '=', 'licenca.delete')->get()->first();
        $profissional_licenca_show = Permission::where('name', '=', 'licenca.show')->get()->first();
        $profissional_licenca_export = Permission::where('name', '=', 'licenca.export')->get()->first();
        // para profissionais->capacitações
        $profissional_capacitacao_create = Permission::where('name', '=', 'capacitacao.create')->get()->first();  
        $profissional_capacitacao_delete = Permission::where('name', '=', 'capacitacao.delete')->get()->first();
        // para tipos de equipe
        $profissional_tipo_equipe_index = Permission::where('name', '=', 'equipetipo.index')->get()->first();
        $profissional_tipo_equipe_create = Permission::where('name', '=', 'equipetipo.create')->get()->first();
        $profissional_tipo_equipe_edit = Permission::where('name', '=', 'equipetipo.edit')->get()->first(); 
        $profissional_tipo_equipe_delete = Permission::where('name', '=', 'equipetipo.delete')->get()->first();
        $profissional_tipo_equipe_show = Permission::where('name', '=', 'equipetipo.show')->get()->first();
        $profissional_tipo_equipe_export = Permission::where('name', '=', 'equipetipo.export')->get()->first();
        // para mapas
        $profissional_mapa_index = Permission::where('name', '=', 'mapa.index')->get()->first();
        $profissional_mapa_show = Permission::where('name', '=', 'mapa.show')->get()->first();
        $profissional_mapa_export = Permission::where('name', '=', 'mapa.export')->get()->first();
        // para cadastro de profissional na vinculação de equipes
        $gestaoequipecadastrarprofissional = Permission::where('name', '=', 'gestao.equipe.cadastrar.profissional.vaga')->get()->first();



        # Profissionais->férias
        $administrador_perfil->permissions()->attach($profissional_ferias_index);
        $administrador_perfil->permissions()->attach($profissional_ferias_create);
        $administrador_perfil->permissions()->attach($profissional_ferias_edit);
        $administrador_perfil->permissions()->attach($profissional_ferias_delete);
        $administrador_perfil->permissions()->attach($profissional_ferias_show);
        $administrador_perfil->permissions()->attach($profissional_ferias_export);
        # Profissionais->licenças
        $administrador_perfil->permissions()->attach($profissional_licenca_index);
        $administrador_perfil->permissions()->attach($profissional_licenca_create);
        $administrador_perfil->permissions()->attach($profissional_licenca_edit);
        $administrador_perfil->permissions()->attach($profissional_licenca_delete);
        $administrador_perfil->permissions()->attach($profissional_licenca_show);
        $administrador_perfil->permissions()->attach($profissional_licenca_export);
        # Profissionais->capacitações
        $administrador_perfil->permissions()->attach($profissional_capacitacao_create);
        $administrador_perfil->permissions()->attach($profissional_capacitacao_delete);
        # tipoEquipe
        $administrador_perfil->permissions()->attach($profissional_tipo_equipe_index);
        $administrador_perfil->permissions()->attach($profissional_tipo_equipe_create);
        $administrador_perfil->permissions()->attach($profissional_tipo_equipe_edit);
        $administrador_perfil->permissions()->attach($profissional_tipo_equipe_delete);
        $administrador_perfil->permissions()->attach($profissional_tipo_equipe_show);
        $administrador_perfil->permissions()->attach($profissional_tipo_equipe_export);
        # mapa
        $administrador_perfil->permissions()->attach($profissional_mapa_index);
        $administrador_perfil->permissions()->attach($profissional_mapa_show);
        $administrador_perfil->permissions()->attach($profissional_mapa_export);
        // para cadastro de profissional na vinculação de equipes
        $administrador_perfil->permissions()->attach($gestaoequipecadastrarprofissional);
        
        


        # Profissionais->férias
        $gerente_perfil->permissions()->attach($profissional_ferias_index);
        $gerente_perfil->permissions()->attach($profissional_ferias_create);
        $gerente_perfil->permissions()->attach($profissional_ferias_edit);
        $gerente_perfil->permissions()->attach($profissional_ferias_delete);
        $gerente_perfil->permissions()->attach($profissional_ferias_show);
        $gerente_perfil->permissions()->attach($profissional_ferias_export);
        # Profissionais->licenças
        $gerente_perfil->permissions()->attach($profissional_licenca_index);
        $gerente_perfil->permissions()->attach($profissional_licenca_create);
        $gerente_perfil->permissions()->attach($profissional_licenca_edit);
        $gerente_perfil->permissions()->attach($profissional_licenca_delete);
        $gerente_perfil->permissions()->attach($profissional_licenca_show);
        $gerente_perfil->permissions()->attach($profissional_licenca_export);
        # Profissionais->capacitações
        $gerente_perfil->permissions()->attach($profissional_capacitacao_create);
        $gerente_perfil->permissions()->attach($profissional_capacitacao_delete);
        # Profissionais tipos de equipe (não possui acesso)
        #mapa
        $gerente_perfil->permissions()->attach($profissional_mapa_index);
        $gerente_perfil->permissions()->attach($profissional_mapa_show);
        $gerente_perfil->permissions()->attach($profissional_mapa_export);
        // para cadastro de profissional na vinculação de equipes
        $gerente_perfil->permissions()->attach($gestaoequipecadastrarprofissional);


        # profissionais->férias
        $operador_perfil->permissions()->attach($profissional_ferias_index);
        $operador_perfil->permissions()->attach($profissional_ferias_edit);
        $operador_perfil->permissions()->attach($profissional_ferias_create);
        $operador_perfil->permissions()->attach($profissional_ferias_show);
        $operador_perfil->permissions()->attach($profissional_ferias_export);
        # profissionais->licenças
        $operador_perfil->permissions()->attach($profissional_licenca_index);
        $operador_perfil->permissions()->attach($profissional_licenca_edit);
        $operador_perfil->permissions()->attach($profissional_licenca_create);
        $operador_perfil->permissions()->attach($profissional_licenca_show);
        $operador_perfil->permissions()->attach($profissional_licenca_export);
        # profissionais->capacitações
        $operador_perfil->permissions()->attach($profissional_capacitacao_create);
        # Profissionais tipos de equipe (não possui acesso)
        #mapa
        $operador_perfil->permissions()->attach($profissional_mapa_index);
        $operador_perfil->permissions()->attach($profissional_mapa_show);


        # podem ver as férias e licencas
        $leitor_perfil->permissions()->attach($profissional_ferias_index);
        $leitor_perfil->permissions()->attach($profissional_ferias_show);
        $leitor_perfil->permissions()->attach($profissional_licenca_index);
        $leitor_perfil->permissions()->attach($profissional_licenca_show);
        # Profissionais tipos de equipe (não possui acesso)
        #mapa
        $leitor_perfil->permissions()->attach($profissional_mapa_index);
        $leitor_perfil->permissions()->attach($profissional_mapa_show);

    }
}
