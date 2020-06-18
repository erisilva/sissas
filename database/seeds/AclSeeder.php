<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Role;
use App\Permission;
use App\Distrito;

use Illuminate\Support\Facades\DB;

class AclSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // apaga todas as tabelas de relacionamento
        DB::table('role_user')->delete();
        DB::table('permission_role')->delete();

        // recebe os operadores principais principais do sistema
        // utilizo o termo operador em vez de usuário por esse
        // significar usuário do SUS, ou usuário do plano, em vez de pessoa ou cliente
        $administrador = User::where('email','=','adm@mail.com')->get()->first();
        $gerente = User::where('email','=','gerente@mail.com')->get()->first();
        $operador = User::where('email','=','operador@mail.com')->get()->first();
        $leitor = User::where('email','=','leitor@mail.com')->get()->first();

        // recebi os perfis
        $administrador_perfil = Role::where('name', '=', 'admin')->get()->first();
        $gerente_perfil = Role::where('name', '=', 'gerente')->get()->first();
        $operador_perfil = Role::where('name', '=', 'operador')->get()->first();
        $leitor_perfil = Role::where('name', '=', 'leitor')->get()->first();

        // salva os relacionamentos entre operador e perfil
        $administrador->roles()->attach($administrador_perfil);
        $gerente->roles()->attach($gerente_perfil);
        $operador->roles()->attach($operador_perfil);
        $leitor->roles()->attach($leitor_perfil);

        // recebi as permissoes
        // para operadores
		$user_index = Permission::where('name', '=', 'user.index')->get()->first();       
		$user_create = Permission::where('name', '=', 'user.create')->get()->first();      
		$user_edit = Permission::where('name', '=', 'user.edit')->get()->first();        
		$user_delete = Permission::where('name', '=', 'user.delete')->get()->first();      
		$user_show = Permission::where('name', '=', 'user.show')->get()->first();        
		$user_export = Permission::where('name', '=', 'user.export')->get()->first();      
		// para perfis
		$role_index = Permission::where('name', '=', 'role.index')->get()->first();       
		$role_create = Permission::where('name', '=', 'role.create')->get()->first();      
		$role_edit = Permission::where('name', '=', 'role.edit')->get()->first();        
		$role_delete = Permission::where('name', '=', 'role.delete')->get()->first();      
		$role_show = Permission::where('name', '=', 'role.show')->get()->first();        
		$role_export = Permission::where('name', '=', 'role.export')->get()->first();      
		// para permissões
		$permission_index = Permission::where('name', '=', 'permission.index')->get()->first(); 
		$permission_create = Permission::where('name', '=', 'permission.create')->get()->first();
		$permission_edit = Permission::where('name', '=', 'permission.edit')->get()->first();  
		$permission_delete = Permission::where('name', '=', 'permission.delete')->get()->first();
		$permission_show = Permission::where('name', '=', 'permission.show')->get()->first();  
		$permission_export = Permission::where('name', '=', 'permission.export')->get()->first();
		// para distritos
		$distrito_index = Permission::where('name', '=', 'distrito.index')->get()->first(); 
		$distrito_create = Permission::where('name', '=', 'distrito.create')->get()->first();
		$distrito_edit = Permission::where('name', '=', 'distrito.edit')->get()->first();  
		$distrito_delete = Permission::where('name', '=', 'distrito.delete')->get()->first();
		$distrito_show = Permission::where('name', '=', 'distrito.show')->get()->first();  
		$distrito_export = Permission::where('name', '=', 'distrito.export')->get()->first();
		// para unidades
		$unidade_index = Permission::where('name', '=', 'unidade.index')->get()->first(); 
		$unidade_create = Permission::where('name', '=', 'unidade.create')->get()->first();
		$unidade_edit = Permission::where('name', '=', 'unidade.edit')->get()->first();  
		$unidade_delete = Permission::where('name', '=', 'unidade.delete')->get()->first();
		$unidade_show = Permission::where('name', '=', 'unidade.show')->get()->first();  
		$unidade_export = Permission::where('name', '=', 'unidade.export')->get()->first();
		# para unidades e profissionais
		$unidade_profissional_create = Permission::where('name', '=', 'unidade.profissional.create')->get()->first();
		$unidade_profissional_delete = Permission::where('name', '=', 'unidade.profissional.delete')->get()->first();
		// para cargos
		$cargo_index = Permission::where('name', '=', 'cargo.index')->get()->first(); 
		$cargo_create = Permission::where('name', '=', 'cargo.create')->get()->first();
		$cargo_edit = Permission::where('name', '=', 'cargo.edit')->get()->first();  
		$cargo_delete = Permission::where('name', '=', 'cargo.delete')->get()->first();
		$cargo_show = Permission::where('name', '=', 'cargo.show')->get()->first();  
		$cargo_export = Permission::where('name', '=', 'cargo.export')->get()->first();
		// para cargas horárias
		$cargahoraria_index = Permission::where('name', '=', 'cargahoraria.index')->get()->first(); 
		$cargahoraria_create = Permission::where('name', '=', 'cargahoraria.create')->get()->first();
		$cargahoraria_edit = Permission::where('name', '=', 'cargahoraria.edit')->get()->first();  
		$cargahoraria_delete = Permission::where('name', '=', 'cargahoraria.delete')->get()->first();
		$cargahoraria_show = Permission::where('name', '=', 'cargahoraria.show')->get()->first();  
		$cargahoraria_export = Permission::where('name', '=', 'cargahoraria.export')->get()->first();
		// para vínculos
		$vinculo_index = Permission::where('name', '=', 'vinculo.index')->get()->first(); 
		$vinculo_create = Permission::where('name', '=', 'vinculo.create')->get()->first();
		$vinculo_edit = Permission::where('name', '=', 'vinculo.edit')->get()->first();  
		$vinculo_delete = Permission::where('name', '=', 'vinculo.delete')->get()->first();
		$vinculo_show = Permission::where('name', '=', 'vinculo.show')->get()->first();  
		$vinculo_export = Permission::where('name', '=', 'vinculo.export')->get()->first();
		// para tipos de vínculos
		$vinculotipo_index = Permission::where('name', '=', 'vinculotipo.index')->get()->first(); 
		$vinculotipo_create = Permission::where('name', '=', 'vinculotipo.create')->get()->first();
		$vinculotipo_edit = Permission::where('name', '=', 'vinculotipo.edit')->get()->first();  
		$vinculotipo_delete = Permission::where('name', '=', 'vinculotipo.delete')->get()->first();
		$vinculotipo_show = Permission::where('name', '=', 'vinculotipo.show')->get()->first();  
		$vinculotipo_export = Permission::where('name', '=', 'vinculotipo.export')->get()->first();
		// para tipos de licenças
		$licencatipo_index = Permission::where('name', '=', 'licencatipo.index')->get()->first(); 
		$licencatipo_create = Permission::where('name', '=', 'licencatipo.create')->get()->first();
		$licencatipo_edit = Permission::where('name', '=', 'licencatipo.edit')->get()->first();  
		$licencatipo_delete = Permission::where('name', '=', 'licencatipo.delete')->get()->first();
		$licencatipo_show = Permission::where('name', '=', 'licencatipo.show')->get()->first();  
		$licencatipo_export = Permission::where('name', '=', 'licencatipo.export')->get()->first();
		// para tipos de licenças
		$feriastipo_index = Permission::where('name', '=', 'feriastipo.index')->get()->first(); 
		$feriastipo_create = Permission::where('name', '=', 'feriastipo.create')->get()->first();
		$feriastipo_edit = Permission::where('name', '=', 'feriastipo.edit')->get()->first();  
		$feriastipo_delete = Permission::where('name', '=', 'feriastipo.delete')->get()->first();
		$feriastipo_show = Permission::where('name', '=', 'feriastipo.show')->get()->first();  
		$feriastipo_export = Permission::where('name', '=', 'feriastipo.export')->get()->first();
		// para tipos de capacitações
		$capacitacaotipo_index = Permission::where('name', '=', 'capacitacaotipo.index')->get()->first(); 
		$capacitacaotipo_create = Permission::where('name', '=', 'capacitacaotipo.create')->get()->first();
		$capacitacaotipo_edit = Permission::where('name', '=', 'capacitacaotipo.edit')->get()->first();  
		$capacitacaotipo_delete = Permission::where('name', '=', 'capacitacaotipo.delete')->get()->first();
		$capacitacaotipo_show = Permission::where('name', '=', 'capacitacaotipo.show')->get()->first();  
		$capacitacaotipo_export = Permission::where('name', '=', 'capacitacaotipo.export')->get()->first();
		// para profissionais
		$profissional_index = Permission::where('name', '=', 'profissional.index')->get()->first(); 
		$profissional_create = Permission::where('name', '=', 'profissional.create')->get()->first();
		$profissional_edit = Permission::where('name', '=', 'profissional.edit')->get()->first();  
		$profissional_delete = Permission::where('name', '=', 'profissional.delete')->get()->first();
		$profissional_show = Permission::where('name', '=', 'profissional.show')->get()->first();  
		$profissional_export = Permission::where('name', '=', 'profissional.export')->get()->first();
		// para profissionais (LIXEIRA)
		$profissional_trash_index = Permission::where('name', '=', 'profissional.trash.index')->get()->first(); 
		$profissional_trash_restore = Permission::where('name', '=', 'profissional.trash.restore')->get()->first();
		// para profissionais->férias
		$profissional_ferias_create = Permission::where('name', '=', 'profissional.ferias.create')->get()->first();  
		$profissional_ferias_delete = Permission::where('name', '=', 'profissional.ferias.delete')->get()->first();
		// para profissionais->licenças
		$profissional_licenca_create = Permission::where('name', '=', 'profissional.licenca.create')->get()->first();  
		$profissional_licenca_delete = Permission::where('name', '=', 'profissional.licenca.delete')->get()->first();
		// para profissionais->capacitações
		$profissional_capacitacao_create = Permission::where('name', '=', 'profissional.capacitacao.create')->get()->first();  
		$profissional_capacitacao_delete = Permission::where('name', '=', 'profissional.capacitacao.delete')->get()->first();
		// para orgão emissores
		$orgaoemissor_index = Permission::where('name', '=', 'orgaoemissor.index')->get()->first(); 
		$orgaoemissor_create = Permission::where('name', '=', 'orgaoemissor.create')->get()->first();
		$orgaoemissor_edit = Permission::where('name', '=', 'orgaoemissor.edit')->get()->first();  
		$orgaoemissor_delete = Permission::where('name', '=', 'orgaoemissor.delete')->get()->first();
		$orgaoemissor_show = Permission::where('name', '=', 'orgaoemissor.show')->get()->first();  
		$orgaoemissor_export = Permission::where('name', '=', 'orgaoemissor.export')->get()->first();
		// para equipes (e vagas)
		$equipe_index = Permission::where('name', '=', 'equipe.index')->get()->first(); 
		$equipe_create = Permission::where('name', '=', 'equipe.create')->get()->first();
		$equipe_edit = Permission::where('name', '=', 'equipe.edit')->get()->first();  
		$equipe_delete = Permission::where('name', '=', 'equipe.delete')->get()->first();
		$equipe_show = Permission::where('name', '=', 'equipe.show')->get()->first();  
		$equipe_export = Permission::where('name', '=', 'equipe.export')->get()->first();
		// para equipes (e vagas) (LIXEIRA)
		$equipe_trash_index = Permission::where('name', '=', 'equipe.trash.index')->get()->first(); 
		$equipe_trash_restore = Permission::where('name', '=', 'equipe.trash.restore')->get()->first();
		// para gestão de equipes
		$equipegestao_index = Permission::where('name', '=', 'gestao.equipe.index')->get()->first();
		$equipegestao_show = Permission::where('name', '=', 'gestao.equipe.show')->get()->first();  
		$equipegestao_export = Permission::where('name', '=', 'gestao.equipe.export')->get()->first();
		$equipegestao_vincular = Permission::where('name', '=', 'gestao.equipe.vincular.vaga')->get()->first();
		$equipegestao_desvincular = Permission::where('name', '=', 'gestao.equipe.desvincular.vaga')->get()->first();
		// para históricos
		$historico_index = Permission::where('name', '=', 'historico.index')->get()->first();               
		$historico_export = Permission::where('name', '=', 'historico.export')->get()->first(); 
		









		// salva os relacionamentos entre perfil e suas permissões
		// o administrador tem acesso total ao sistema, incluindo
		// configurações avançadas de desenvolvimento
		$administrador_perfil->permissions()->attach($user_index);
		$administrador_perfil->permissions()->attach($user_create);
		$administrador_perfil->permissions()->attach($user_edit);
		$administrador_perfil->permissions()->attach($user_delete);
		$administrador_perfil->permissions()->attach($user_show);
		$administrador_perfil->permissions()->attach($user_export);
		$administrador_perfil->permissions()->attach($role_index);
		$administrador_perfil->permissions()->attach($role_create);
		$administrador_perfil->permissions()->attach($role_edit);
		$administrador_perfil->permissions()->attach($role_delete);
		$administrador_perfil->permissions()->attach($role_show);
		$administrador_perfil->permissions()->attach($role_export);
		$administrador_perfil->permissions()->attach($permission_index);
		$administrador_perfil->permissions()->attach($permission_create);
		$administrador_perfil->permissions()->attach($permission_edit);
		$administrador_perfil->permissions()->attach($permission_delete);
		$administrador_perfil->permissions()->attach($permission_show);
		$administrador_perfil->permissions()->attach($permission_export);
		# distritos
		$administrador_perfil->permissions()->attach($distrito_index);
		$administrador_perfil->permissions()->attach($distrito_create);
		$administrador_perfil->permissions()->attach($distrito_edit);
		$administrador_perfil->permissions()->attach($distrito_delete);
		$administrador_perfil->permissions()->attach($distrito_show);
		$administrador_perfil->permissions()->attach($distrito_export);
		# unidades
		$administrador_perfil->permissions()->attach($unidade_index);
		$administrador_perfil->permissions()->attach($unidade_create);
		$administrador_perfil->permissions()->attach($unidade_edit);
		$administrador_perfil->permissions()->attach($unidade_delete);
		$administrador_perfil->permissions()->attach($unidade_show);
		$administrador_perfil->permissions()->attach($unidade_export);
		#unidades e profissionais
		$administrador_perfil->permissions()->attach($unidade_profissional_create);
		$administrador_perfil->permissions()->attach($unidade_profissional_delete);
		# cargos
		$administrador_perfil->permissions()->attach($cargo_index);
		$administrador_perfil->permissions()->attach($cargo_create);
		$administrador_perfil->permissions()->attach($cargo_edit);
		$administrador_perfil->permissions()->attach($cargo_delete);
		$administrador_perfil->permissions()->attach($cargo_show);
		$administrador_perfil->permissions()->attach($cargo_export);
		# cargas horárias
		$administrador_perfil->permissions()->attach($cargahoraria_index);
		$administrador_perfil->permissions()->attach($cargahoraria_create);
		$administrador_perfil->permissions()->attach($cargahoraria_edit);
		$administrador_perfil->permissions()->attach($cargahoraria_delete);
		$administrador_perfil->permissions()->attach($cargahoraria_show);
		$administrador_perfil->permissions()->attach($cargahoraria_export);
		# vínculos
		$administrador_perfil->permissions()->attach($vinculo_index);
		$administrador_perfil->permissions()->attach($vinculo_create);
		$administrador_perfil->permissions()->attach($vinculo_edit);
		$administrador_perfil->permissions()->attach($vinculo_delete);
		$administrador_perfil->permissions()->attach($vinculo_show);
		$administrador_perfil->permissions()->attach($vinculo_export);
		# tipos vínculos
		$administrador_perfil->permissions()->attach($vinculotipo_index);
		$administrador_perfil->permissions()->attach($vinculotipo_create);
		$administrador_perfil->permissions()->attach($vinculotipo_edit);
		$administrador_perfil->permissions()->attach($vinculotipo_delete);
		$administrador_perfil->permissions()->attach($vinculotipo_show);
		$administrador_perfil->permissions()->attach($vinculotipo_export);
		# tipos licenças
		$administrador_perfil->permissions()->attach($licencatipo_index);
		$administrador_perfil->permissions()->attach($licencatipo_create);
		$administrador_perfil->permissions()->attach($licencatipo_edit);
		$administrador_perfil->permissions()->attach($licencatipo_delete);
		$administrador_perfil->permissions()->attach($licencatipo_show);
		$administrador_perfil->permissions()->attach($licencatipo_export);
		# tipos férias
		$administrador_perfil->permissions()->attach($feriastipo_index);
		$administrador_perfil->permissions()->attach($feriastipo_create);
		$administrador_perfil->permissions()->attach($feriastipo_edit);
		$administrador_perfil->permissions()->attach($feriastipo_delete);
		$administrador_perfil->permissions()->attach($feriastipo_show);
		$administrador_perfil->permissions()->attach($feriastipo_export);
		# tipos de capacitações
		$administrador_perfil->permissions()->attach($capacitacaotipo_index);
		$administrador_perfil->permissions()->attach($capacitacaotipo_create);
		$administrador_perfil->permissions()->attach($capacitacaotipo_edit);
		$administrador_perfil->permissions()->attach($capacitacaotipo_delete);
		$administrador_perfil->permissions()->attach($capacitacaotipo_show);
		$administrador_perfil->permissions()->attach($capacitacaotipo_export);
		# Profissionais
		$administrador_perfil->permissions()->attach($profissional_index);
		$administrador_perfil->permissions()->attach($profissional_create);
		$administrador_perfil->permissions()->attach($profissional_edit);
		$administrador_perfil->permissions()->attach($profissional_delete);
		$administrador_perfil->permissions()->attach($profissional_show);
		$administrador_perfil->permissions()->attach($profissional_export);
		#profissionais LIXEIRA
		$administrador_perfil->permissions()->attach($profissional_trash_index);
		$administrador_perfil->permissions()->attach($profissional_trash_restore);
		# Profissionais->férias
		$administrador_perfil->permissions()->attach($profissional_ferias_create);
		$administrador_perfil->permissions()->attach($profissional_ferias_delete);
		# Profissionais->licenças
		$administrador_perfil->permissions()->attach($profissional_licenca_create);
		$administrador_perfil->permissions()->attach($profissional_licenca_delete);
		# Profissionais->capacitações
		$administrador_perfil->permissions()->attach($profissional_capacitacao_create);
		$administrador_perfil->permissions()->attach($profissional_capacitacao_delete);
		# Orgão Emissor
		$administrador_perfil->permissions()->attach($orgaoemissor_index);
		$administrador_perfil->permissions()->attach($orgaoemissor_create);
		$administrador_perfil->permissions()->attach($orgaoemissor_edit);
		$administrador_perfil->permissions()->attach($orgaoemissor_delete);
		$administrador_perfil->permissions()->attach($orgaoemissor_show);
		$administrador_perfil->permissions()->attach($orgaoemissor_export);
		# Equipes (e vagas)
		$administrador_perfil->permissions()->attach($equipe_index);
		$administrador_perfil->permissions()->attach($equipe_create);
		$administrador_perfil->permissions()->attach($equipe_edit);
		$administrador_perfil->permissions()->attach($equipe_delete);
		$administrador_perfil->permissions()->attach($equipe_show);
		$administrador_perfil->permissions()->attach($equipe_export);
		# Equipes (e vagas) LIXEIRA
		$administrador_perfil->permissions()->attach($equipe_trash_index);
		$administrador_perfil->permissions()->attach($equipe_trash_restore);
		# gestão de equipes
		$administrador_perfil->permissions()->attach($equipegestao_index);
		$administrador_perfil->permissions()->attach($equipegestao_show);
		$administrador_perfil->permissions()->attach($equipegestao_export);
		$administrador_perfil->permissions()->attach($equipegestao_vincular);
		$administrador_perfil->permissions()->attach($equipegestao_desvincular);
		# historicos
		$administrador_perfil->permissions()->attach($historico_index);
		$administrador_perfil->permissions()->attach($historico_export);
		






		// o gerente (diretor) pode gerenciar os operadores do sistema
		$gerente_perfil->permissions()->attach($user_index);
		$gerente_perfil->permissions()->attach($user_create);
		$gerente_perfil->permissions()->attach($user_edit);
		$gerente_perfil->permissions()->attach($user_show);
		$gerente_perfil->permissions()->attach($user_export);
		# distritos
		$gerente_perfil->permissions()->attach($distrito_index);
		$gerente_perfil->permissions()->attach($distrito_create);
		$gerente_perfil->permissions()->attach($distrito_edit);
		$gerente_perfil->permissions()->attach($distrito_show);
		$gerente_perfil->permissions()->attach($distrito_export);
		# unidades
		$gerente_perfil->permissions()->attach($unidade_index);
		$gerente_perfil->permissions()->attach($unidade_create);
		$gerente_perfil->permissions()->attach($unidade_edit);
		$gerente_perfil->permissions()->attach($unidade_show);
		$gerente_perfil->permissions()->attach($unidade_export);
		#unidades e profissionais
		$gerente_perfil->permissions()->attach($unidade_profissional_create);
		$gerente_perfil->permissions()->attach($unidade_profissional_delete);
		# cargos
		$gerente_perfil->permissions()->attach($cargo_index);
		$gerente_perfil->permissions()->attach($cargo_create);
		$gerente_perfil->permissions()->attach($cargo_edit);
		$gerente_perfil->permissions()->attach($cargo_show);
		$gerente_perfil->permissions()->attach($cargo_export);
		# cargas horárias
		$gerente_perfil->permissions()->attach($cargahoraria_index);
		$gerente_perfil->permissions()->attach($cargahoraria_create);
		$gerente_perfil->permissions()->attach($cargahoraria_edit);
		$gerente_perfil->permissions()->attach($cargahoraria_show);
		$gerente_perfil->permissions()->attach($cargahoraria_export);
		# vínculos
		$gerente_perfil->permissions()->attach($vinculo_index);
		$gerente_perfil->permissions()->attach($vinculo_create);
		$gerente_perfil->permissions()->attach($vinculo_edit);
		$gerente_perfil->permissions()->attach($vinculo_show);
		$gerente_perfil->permissions()->attach($vinculo_export);
		# tipos vínculos
		$gerente_perfil->permissions()->attach($vinculotipo_index);
		$gerente_perfil->permissions()->attach($vinculotipo_create);
		$gerente_perfil->permissions()->attach($vinculotipo_edit);
		$gerente_perfil->permissions()->attach($vinculotipo_show);
		$gerente_perfil->permissions()->attach($vinculotipo_export);
		# tipos licença
		$gerente_perfil->permissions()->attach($licencatipo_index);
		$gerente_perfil->permissions()->attach($licencatipo_create);
		$gerente_perfil->permissions()->attach($licencatipo_edit);
		$gerente_perfil->permissions()->attach($licencatipo_show);
		$gerente_perfil->permissions()->attach($licencatipo_export);
		# tipos férias
		$gerente_perfil->permissions()->attach($feriastipo_index);
		$gerente_perfil->permissions()->attach($feriastipo_create);
		$gerente_perfil->permissions()->attach($feriastipo_edit);
		$gerente_perfil->permissions()->attach($feriastipo_show);
		$gerente_perfil->permissions()->attach($feriastipo_export);
		# tipos de capacitação
		$gerente_perfil->permissions()->attach($capacitacaotipo_index);
		$gerente_perfil->permissions()->attach($capacitacaotipo_create);
		$gerente_perfil->permissions()->attach($capacitacaotipo_edit);
		$gerente_perfil->permissions()->attach($capacitacaotipo_show);
		$gerente_perfil->permissions()->attach($capacitacaotipo_export);
		# Profissionais -- pode enviar para a lixeira
		$gerente_perfil->permissions()->attach($profissional_index);
		$gerente_perfil->permissions()->attach($profissional_create);
		$gerente_perfil->permissions()->attach($profissional_edit);
		$gerente_perfil->permissions()->attach($profissional_delete);
		$gerente_perfil->permissions()->attach($profissional_show);
		$gerente_perfil->permissions()->attach($profissional_export);
		#profissionais LIXEIRA
		$gerente_perfil->permissions()->attach($profissional_trash_index);
		$gerente_perfil->permissions()->attach($profissional_trash_restore);
		# Profissionais->férias
		$gerente_perfil->permissions()->attach($profissional_ferias_create);
		$gerente_perfil->permissions()->attach($profissional_ferias_delete);
		# Profissionais->licenças
		$gerente_perfil->permissions()->attach($profissional_licenca_create);
		$gerente_perfil->permissions()->attach($profissional_licenca_delete);
		# Profissionais->capacitações
		$gerente_perfil->permissions()->attach($profissional_capacitacao_create);
		$gerente_perfil->permissions()->attach($profissional_capacitacao_delete);
		# Orgão Emissor
		$gerente_perfil->permissions()->attach($orgaoemissor_index);
		$gerente_perfil->permissions()->attach($orgaoemissor_create);
		$gerente_perfil->permissions()->attach($orgaoemissor_edit);
		$gerente_perfil->permissions()->attach($orgaoemissor_show);
		$gerente_perfil->permissions()->attach($orgaoemissor_export);
		# Equipes (e vagas) -- pode enviar para a lixeira
		$gerente_perfil->permissions()->attach($equipe_index);
		$gerente_perfil->permissions()->attach($equipe_create);
		$gerente_perfil->permissions()->attach($equipe_edit);
		$gerente_perfil->permissions()->attach($equipe_delete);
		$gerente_perfil->permissions()->attach($equipe_show);
		$gerente_perfil->permissions()->attach($equipe_export);
		# Equipes (e vagas) LIXEIRA
		$gerente_perfil->permissions()->attach($equipe_trash_index);
		$gerente_perfil->permissions()->attach($equipe_trash_restore);
		#gestão de equipes
		$gerente_perfil->permissions()->attach($equipegestao_index);
		$gerente_perfil->permissions()->attach($equipegestao_show);
		$gerente_perfil->permissions()->attach($equipegestao_export);
		$gerente_perfil->permissions()->attach($equipegestao_vincular);
		$gerente_perfil->permissions()->attach($equipegestao_desvincular);
		# Historico
		$gerente_perfil->permissions()->attach($historico_index);
		$gerente_perfil->permissions()->attach($historico_export);
		





		// o operador é o nível de operação do sistema não pode criar
		// outros operadores
		$operador_perfil->permissions()->attach($user_index);
		$operador_perfil->permissions()->attach($user_show);
		$operador_perfil->permissions()->attach($user_export);
		# distritos
		$operador_perfil->permissions()->attach($distrito_index);
		$operador_perfil->permissions()->attach($distrito_show);
		$operador_perfil->permissions()->attach($distrito_export);
		# unidades
		$operador_perfil->permissions()->attach($unidade_index);
		$operador_perfil->permissions()->attach($unidade_show);
		$operador_perfil->permissions()->attach($unidade_export);
		$operador_perfil->permissions()->attach($unidade_edit); // operador pode criar e editar
		$operador_perfil->permissions()->attach($unidade_create);
		# unidade e profissionais
		$operador_perfil->permissions()->attach($unidade_profissional_create);
		# cargos
		$operador_perfil->permissions()->attach($cargo_index);
		$operador_perfil->permissions()->attach($cargo_show);
		$operador_perfil->permissions()->attach($cargo_export);
		# cargas horárias
		$operador_perfil->permissions()->attach($cargahoraria_index);
		$operador_perfil->permissions()->attach($cargahoraria_show);
		$operador_perfil->permissions()->attach($cargahoraria_export);
		# vínculos
		$operador_perfil->permissions()->attach($vinculo_index);
		$operador_perfil->permissions()->attach($vinculo_show);
		$operador_perfil->permissions()->attach($vinculo_export);
		# tipos de vínculos
		$operador_perfil->permissions()->attach($vinculotipo_index);
		$operador_perfil->permissions()->attach($vinculotipo_show);
		$operador_perfil->permissions()->attach($vinculotipo_export);
		# tipos de licença
		$operador_perfil->permissions()->attach($licencatipo_index);
		$operador_perfil->permissions()->attach($licencatipo_show);
		$operador_perfil->permissions()->attach($licencatipo_export);
		# tipos de férias
		$operador_perfil->permissions()->attach($feriastipo_index);
		$operador_perfil->permissions()->attach($feriastipo_show);
		$operador_perfil->permissions()->attach($feriastipo_export);
		# tipos de capacitação
		$operador_perfil->permissions()->attach($capacitacaotipo_index);
		$operador_perfil->permissions()->attach($capacitacaotipo_show);
		$operador_perfil->permissions()->attach($capacitacaotipo_export);
		# profissionais, o operador pode cadastrar e alterar os dados
		$operador_perfil->permissions()->attach($profissional_index);
		$operador_perfil->permissions()->attach($profissional_edit);
		$operador_perfil->permissions()->attach($profissional_create);
		$operador_perfil->permissions()->attach($profissional_show);
		$operador_perfil->permissions()->attach($profissional_export);
		#profissionais LIXEIRA
		$operador_perfil->permissions()->attach($profissional_trash_index);
		# profissionais->férias
		$operador_perfil->permissions()->attach($profissional_ferias_create);
		# profissionais->licenças
		$operador_perfil->permissions()->attach($profissional_licenca_create);
		# profissionais->capacitações
		$operador_perfil->permissions()->attach($profissional_capacitacao_create);
		# Orgão Emissor
		$operador_perfil->permissions()->attach($orgaoemissor_index);
		$operador_perfil->permissions()->attach($orgaoemissor_edit);
		$operador_perfil->permissions()->attach($orgaoemissor_create);
		$operador_perfil->permissions()->attach($orgaoemissor_show);
		$operador_perfil->permissions()->attach($orgaoemissor_export);
		# Equipe (e vagas)
		$operador_perfil->permissions()->attach($equipe_index);
		$operador_perfil->permissions()->attach($equipe_edit);
		$operador_perfil->permissions()->attach($equipe_create);
		$operador_perfil->permissions()->attach($equipe_show);
		$operador_perfil->permissions()->attach($equipe_export);
		# Equipe (e vagas) LIXEIRA
		$operador_perfil->permissions()->attach($equipe_trash_index);
		# gestão de equipes
		$operador_perfil->permissions()->attach($equipegestao_index);
		$operador_perfil->permissions()->attach($equipegestao_show);
		$operador_perfil->permissions()->attach($equipegestao_export);
		$operador_perfil->permissions()->attach($equipegestao_vincular);
		$operador_perfil->permissions()->attach($equipegestao_desvincular);
		




		// leitura é um tipo de operador que só pode ler
		// os dados na tela
		$leitor_perfil->permissions()->attach($user_index);
		$leitor_perfil->permissions()->attach($user_show);
		# distritos
		$leitor_perfil->permissions()->attach($distrito_index);
		$leitor_perfil->permissions()->attach($distrito_show);
		# unidades
		$leitor_perfil->permissions()->attach($unidade_index);
		$leitor_perfil->permissions()->attach($unidade_show);
		# cargos
		$leitor_perfil->permissions()->attach($cargo_index);
		$leitor_perfil->permissions()->attach($cargo_show);
		# cargas horárias
		$leitor_perfil->permissions()->attach($cargahoraria_index);
		$leitor_perfil->permissions()->attach($cargahoraria_show);
		# vínculos
		$leitor_perfil->permissions()->attach($vinculo_index);
		$leitor_perfil->permissions()->attach($vinculo_show);
		# vínculos tipos
		$leitor_perfil->permissions()->attach($vinculotipo_index);
		$leitor_perfil->permissions()->attach($vinculotipo_show);
		# licença tipo
		$leitor_perfil->permissions()->attach($licencatipo_index);
		$leitor_perfil->permissions()->attach($licencatipo_show);
		# férias tipo
		$leitor_perfil->permissions()->attach($feriastipo_index);
		$leitor_perfil->permissions()->attach($feriastipo_show);
		# tipos de capacitações
		$leitor_perfil->permissions()->attach($capacitacaotipo_index);
		$leitor_perfil->permissions()->attach($capacitacaotipo_show);
		# profissionais
		$leitor_perfil->permissions()->attach($profissional_index);
		$leitor_perfil->permissions()->attach($profissional_show);
		# orgão emissor
		$leitor_perfil->permissions()->attach($orgaoemissor_index);
		$leitor_perfil->permissions()->attach($orgaoemissor_show);
		# equipes (e vagas)
		$leitor_perfil->permissions()->attach($equipe_index);
		$leitor_perfil->permissions()->attach($equipe_show);
		# gestão de equipes
		$leitor_perfil->permissions()->attach($equipegestao_index);
		$leitor_perfil->permissions()->attach($equipegestao_show);
		







		// adicione as permissões para o acesso das equipes (por distrito)
		//por padrão somente gerente e administrador tem acesso a todos distritos
		// os demais operadores precisarão ser configurados
		$distritos = Distrito::all();
		foreach ($distritos as $distrito) {
			$administrador->distritos()->attach($distrito);
        	$gerente->distritos()->attach($distrito);
		}


		


		echo "usuário Administrador: adm@mail.br senha:123456  \n";		
		echo "usuário Gerente: gerente@mail.br senha:123456  \n";		
		echo "usuário Operacional: operador@mail.br senha:123456  \n";		
		echo "usuário Somente Leitura: leitura@mail.br senha:123456  \n";
    }
}
