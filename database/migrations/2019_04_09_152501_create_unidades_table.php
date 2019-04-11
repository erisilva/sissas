<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->string('porte', 10);
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
            $table->integer('distrito_id')->unsigned();
            $table->timestamps();

            $table->foreign('distrito_id')->references('id')->on('distritos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unidades', function (Blueprint $table) {
            $table->dropForeign('unidades_distrito_id_foreign');
        });

        Schema::dropIfExists('unidades');
    }
}
