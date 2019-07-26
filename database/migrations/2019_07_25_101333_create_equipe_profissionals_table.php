<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipeProfissionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipe_profissionals', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descricao')->nullable();
            $table->integer('cargo_id')->unsigned();
            $table->integer('equipe_id')->unsigned();
            $table->integer('profissional_id')->unsigned()->nullable(); // chave fraca
            # fk
            $table->foreign('cargo_id')->references('id')->on('cargos')->onDelete('cascade');
            $table->foreign('equipe_id')->references('id')->on('equipes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipe_profissionals', function (Blueprint $table) {
            $table->dropForeign('equipe_profissionals_cargo_id_foreign');
            $table->dropForeign('equipe_profissionals_equipe_id_foreign');
        });
        Schema::dropIfExists('equipe_profissionals');
    }
}
