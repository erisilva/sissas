<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfissionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profissionals', function (Blueprint $table) {
            $table->increments('id');

            $table->string('nome');
            $table->string('matricula');
            $table->string('cns')->nullable(); // cartão nacional saúde
            $table->string('cpf');
            $table->string('flexibilizacao'); // extensão, redução, nenhum

            $table->date('admissao');
            $table->text('observacao')->nullable();

            $table->string('tel')->nullable();
            $table->string('cel')->nullable();
            $table->string('email')->nullable();
            $table->string('cep')->nullable();
            $table->string('logradouro')->nullable();
            $table->string('bairro')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            
            $table->string('registroClasse')->nullable();
            $table->string('ufOrgaoEmissor', '2')->nullable();

            // fks
            $table->integer('cargo_id')->unsigned();
            $table->integer('carga_horaria_id')->unsigned();
            $table->integer('vinculo_id')->unsigned();
            $table->integer('vinculo_tipo_id')->unsigned();
            $table->integer('orgao_emissor_id')->unsigned();

            $table->softDeletes();
            $table->timestamps();

            // fks
            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade');
            $table->foreign('carga_horaria_id')->references('id')->on('carga_horarias')->onDelete('cascade');
            $table->foreign('vinculo_id')->references('id')->on('vinculos')->onDelete('cascade');
            $table->foreign('vinculo_tipo_id')->references('id')->on('vinculo_tipos')->onDelete('cascade');
            $table->foreign('orgao_emissor_id')->references('id')->on('orgao_emissors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profissionals', function (Blueprint $table) {
            $table->dropForeign('profissionals_cargo_id_foreign');
            $table->dropForeign('profissionals_carga_horaria_id_foreign');
            $table->dropForeign('profissionals_vinculo_id_foreign');
            $table->dropForeign('profissionals_vinculo_tipo_id_foreign');
            $table->dropForeign('profissionals_orgao_emissor_id_foreign');
        });

        Schema::dropIfExists('profissionals');
    }
}
