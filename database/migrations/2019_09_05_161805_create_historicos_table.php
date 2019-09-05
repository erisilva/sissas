<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historicos', function (Blueprint $table) {
            $table->increments('id');
            $table->text('observacao')->nullable();
            // FK
            $table->integer('historico_tipo_id')->unsigned();
            $table->integer('profissional_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('historico_tipo_id')->references('id')->on('historico_tipos')->onDelete('cascade');
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
        Schema::table('historicos', function (Blueprint $table) {
            $table->dropForeign('historicos_historico_tipo_id_foreign');
            $table->dropForeign('historicos_profissional_id_foreign');
            $table->dropForeign('historicos_user_id_foreign');
        });

        Schema::dropIfExists('historicos');
    }
}
