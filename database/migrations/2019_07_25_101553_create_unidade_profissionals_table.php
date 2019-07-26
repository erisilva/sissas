<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadeProfissionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidade_profissionals', function (Blueprint $table) {
            $table->increments('id');
            $table->text('descricao')->nullable();
            $table->integer('unidade_id')->unsigned();
            $table->integer('profissional_id')->unsigned();
            $table->timestamps();
            # fk
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');
            $table->foreign('profissional_id')->references('id')->on('profissionals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unidade_profissionals', function (Blueprint $table) {
            $table->dropForeign('unidade_profissionals_unidade_id_foreign');
            $table->dropForeign('unidade_profissionals_profissional_id_foreign');
        });
        Schema::dropIfExists('unidade_profissionals');
    }
}
