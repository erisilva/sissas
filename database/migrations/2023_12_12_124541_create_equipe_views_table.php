<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement($this->dropView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function createView(): string
    {
        return <<<EOD
                  CREATE VIEW equipe_views AS
                    select 
                        equipe_profissionals.id,
                        profissionals.nome,
                        profissionals.matricula,
                        profissionals.cpf,
                        profissionals.cns,
                        profissionals.email,
                        profissionals.tel,
                        profissionals.cel,
                        profissionals.cep,
                        profissionals.logradouro,
                        profissionals.bairro,
                        profissionals.numero,
                        profissionals.complemento,
                        profissionals.cidade,
                        profissionals.uf,
                        cargo_profissional.nome as cargo_profissional,
                        vinculos.nome as vinculo,
                        vinculo_tipos.nome as tipo_de_vinculo,
                        carga_horarias.nome as carga_horaria,
                        profissionals.flexibilizacao,
                        profissionals.admissao,	
                        profissionals.registroClasse,
                        profissionals.ufOrgaoEmissor,
                        orgao_emissors.nome as orgao_emissor,
                        equipe_cargos.nome as cargo,
                        equipes.descricao as equipe,
                        equipes.numero as equipe_numero,
                        equipes.cnes,
                        equipes.ine,
                        equipes.minima,
                        equipe_tipos.nome as equipe_tipo,
                        unidades.nome as unidade,
                        unidades.porte as unidade_porte,
                        distritos.nome as distrito,
                        profissionals.id as profissional_id,
                        equipe_cargos.id as cargo_id,
                        profissionals.cargo_id as cargo_profissional_id,
                        carga_horarias.id as carga_horaria_id,
                        vinculos.id as vinculo_id,
                        vinculo_tipos.id as vinculo_tipo_id,
                        equipe_profissionals.equipe_id as equipe_id,
                        unidades.id as unidade_id,
                        distritos.id as distrito_id,
                        equipe_tipos.id as equipe_tipo_id
                        from equipe_profissionals
                        left join profissionals on (profissionals.id = equipe_profissionals.profissional_id)
                            left join vinculos on (profissionals.vinculo_id = vinculos.id)
                            left join vinculo_tipos on (profissionals.vinculo_tipo_id = vinculo_tipos.id)
                            left join carga_horarias on (carga_horarias.id = profissionals.carga_horaria_id)
                            left join cargos cargo_profissional on (cargo_profissional.id = profissionals.cargo_id)
                            left join orgao_emissors on (orgao_emissors.id = profissionals.orgao_emissor_id)
                        inner join equipes on (equipes.id = equipe_profissionals.equipe_id)
                            inner join unidades on (unidades.id = equipes.unidade_id)
                            inner join equipe_tipos on (equipe_tipos.id = equipes.equipe_tipo_id)
                                inner join distritos on (unidades.distrito_id = distritos.id)
                        inner join cargos equipe_cargos on (equipe_profissionals.cargo_id = equipe_cargos.id)	 
                    order by distritos.nome asc, unidades.nome asc, equipes.descricao asc, equipe_cargos.nome asc;
                EOD;
    }
   
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    private function dropView(): string
    {
        return <<<EOD

            DROP VIEW IF EXISTS `equipe_views`;
            EOD;
    }    
};
