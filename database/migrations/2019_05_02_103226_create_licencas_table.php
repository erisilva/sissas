<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicencasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licencas', function (Blueprint $table) {
            $table->increments('id');

            $table->date('inicio');
            $table->date('fim');

            $table->text('observacao')->nullable();

            $table->integer('licenca_tipo_id')->unsigned();
            $table->integer('profissional_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->timestamps();

            // FK
            $table->foreign('licenca_tipo_id')->references('id')->on('licenca_tipos')->onDelete('cascade');
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
        Schema::table('licencas', function (Blueprint $table) {
            $table->dropForeign('licencas_licenca_tipo_id_foreign');
            $table->dropForeign('licencas_profissional_id_foreign');
            $table->dropForeign('licencas_user_id_foreign');
        });

        Schema::dropIfExists('licencas');
    }
}
