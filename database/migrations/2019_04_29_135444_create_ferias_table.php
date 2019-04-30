<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ferias', function (Blueprint $table) {
            $table->increments('id');

            $table->date('inicio');
            $table->date('fim');

            $table->text('justificativa')->nullable();
            $table->text('observacao')->nullable();

            $table->integer('ferias_tipo_id')->unsigned();
            $table->integer('profissional_id')->unsigned();
            $table->integer('user_id')->unsigned();


            $table->timestamps();

            // FK
            $table->foreign('ferias_tipo_id')->references('id')->on('ferias_tipos')->onDelete('cascade');
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
        Schema::table('ferias', function (Blueprint $table) {
            $table->dropForeign('ferias_ferias_tipo_id_foreign');
            $table->dropForeign('ferias_profissional_id_foreign');
            $table->dropForeign('ferias_user_id_foreign');
        });

        Schema::dropIfExists('ferias');
    }
}
