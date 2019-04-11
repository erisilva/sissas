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
		// para distritos
		$unidade_index = Permission::where('name', '=', 'unidade.index')->get()->first(); 
		$unidade_create = Permission::where('name', '=', 'unidade.create')->get()->first();
		$unidade_edit = Permission::where('name', '=', 'unidade.edit')->get()->first();  
		$unidade_delete = Permission::where('name', '=', 'unidade.delete')->get()->first();
		$unidade_show = Permission::where('name', '=', 'unidade.show')->get()->first();  
		$unidade_export = Permission::where('name', '=', 'unidade.export')->get()->first();
		// para cargos
		$cargo_index = Permission::where('name', '=', 'cargo.index')->get()->first(); 
		$cargo_create = Permission::where('name', '=', 'cargo.create')->get()->first();
		$cargo_edit = Permission::where('name', '=', 'cargo.edit')->get()->first();  
		$cargo_delete = Permission::where('name', '=', 'cargo.delete')->get()->first();
		$cargo_show = Permission::where('name', '=', 'cargo.show')->get()->first();  
		$cargo_export = Permission::where('name', '=', 'cargo.export')->get()->first();



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
		# cargos
		$administrador_perfil->permissions()->attach($cargo_index);
		$administrador_perfil->permissions()->attach($cargo_create);
		$administrador_perfil->permissions()->attach($cargo_edit);
		$administrador_perfil->permissions()->attach($cargo_delete);
		$administrador_perfil->permissions()->attach($cargo_show);
		$administrador_perfil->permissions()->attach($cargo_export);



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
		# cargos
		$gerente_perfil->permissions()->attach($cargo_index);
		$gerente_perfil->permissions()->attach($cargo_create);
		$gerente_perfil->permissions()->attach($cargo_edit);
		$gerente_perfil->permissions()->attach($cargo_show);
		$gerente_perfil->permissions()->attach($cargo_export);


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
		# cargos
		$operador_perfil->permissions()->attach($cargo_index);
		$operador_perfil->permissions()->attach($cargo_show);
		$operador_perfil->permissions()->attach($cargo_export);




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
