<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descricao');
            $table->integer('numero')->unsigned();
            $table->string('cnes');
            $table->string('ine');
            $table->enum('minima', ['s', 'n']);
            $table->timestamps();

            //fk
            $table->integer('unidade_id')->unsigned()->index();

            // fks
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('equipes', function (Blueprint $table) {
            $table->dropForeign('equipes_unidade_id_foreign');
        });

        Schema::dropIfExists('equipes');
    }
}
