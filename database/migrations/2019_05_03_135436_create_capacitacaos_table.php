<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCapacitacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capacitacaos', function (Blueprint $table) {
            $table->increments('id');

            $table->date('inicio');
            $table->date('fim');

            $table->text('observacao')->nullable();
            $table->string('cargaHoraria')->nullable();

            $table->integer('capacitacao_tipo_id')->unsigned();
            $table->integer('profissional_id')->unsigned();
            $table->integer('user_id')->unsigned();


            $table->timestamps();

            // FK
            $table->foreign('capacitacao_tipo_id')->references('id')->on('capacitacao_tipos')->onDelete('cascade');
            $table->foreign('profissional_id')->references('id')->on('profissionals')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('capacitacaos', function (Blueprint $table) {
            $table->dropForeign('capacitacaos_capacitacao_tipo_id_foreign');
            $table->dropForeign('capacitacaos_profissional_id_foreign');
            $table->dropForeign('capacitacaos_user_id_foreign');
        });

        Schema::dropIfExists('capacitacaos');
    }
}
