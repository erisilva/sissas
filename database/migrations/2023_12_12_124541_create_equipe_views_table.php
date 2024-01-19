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
                        profissionals.cns,
                        profissionals.cpf,
                        profissionals.flexibilizacao,
                        profissionals.admissao,
                        profissionals.tel,
                        profissionals.cel,
                        profissionals.email,
                        profissionals.cep,
                        profissionals.logradouro,
                        profissionals.bairro,
                        profissionals.numero,
                        profissionals.complemento,
                        profissionals.cidade,
                        profissionals.uf,
                        profissionals.registroClasse,
                        profissionals.ufOrgaoEmissor,
                        cargos.nome as cargo,
                        cargos.cbo,
                        vinculos.nome as vinculo,
                        vinculo_tipos.nome as tipo_de_vinculo,
                        equipes.descricao as equipe,
                        equipes.numero as equipe_numero,
                        equipe_tipos.nome as equipe_tipo,
                        equipes.ine,
                        equipes.cnes,
                        equipes.minima as equipe_minima,
                        unidades.nome as unidade,
                        unidades.porte as unidade_porte,
                        distritos.nome as distrito,
                        profissionals.id as profissional_id,
                        cargos.id as cargo_equipe_id,
                        profissionals.cargo_id as cargo_profissional_id,
                        vinculos.id as vinculo_id,
                        vinculo_tipos.id as vinculo_tipo_id,
                        equipe_profissionals.equipe_id as equipe_id,
                        unidades.id as unidade_id,
                        distritos.id as distrito_id,
                        equipe_tipos.id as equipe_tipo_id
                    from equipe_profissionals
                    left join profissionals on (profissionals.id = equipe_profissionals.profissional_id)
                    left join vinculos on (profissionals.vinculo_id = vinculos.id)
                    left join vinculo_tipos on (profissionals.vinculo_id = vinculo_tipos.id)
                    inner join equipes on (equipes.id = equipe_profissionals.equipe_id)
                        inner join unidades on (unidades.id = equipes.unidade_id)
                        inner join equipe_tipos on (equipe_tipos.id = equipes.equipe_tipo_id)
                            inner join distritos on (unidades.distrito_id = distritos.id)
                    inner join cargos on (equipe_profissionals.cargo_id = cargos.id)
                    order by distritos.nome asc, unidades.nome asc, equipes.descricao asc, cargos.nome asc;
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
