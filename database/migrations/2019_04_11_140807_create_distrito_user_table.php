<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistritoUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distrito_user', function (Blueprint $table) {
          $table->integer('user_id')->unsigned();
          $table->integer('distrito_id')->unsigned();
          $table->index(['user_id', 'distrito_id']); 
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('distrito_user', function (Blueprint $table) {
            $table->dropForeign('distrito_user_distrito_id_foreign');
            $table->dropForeign('distrito_user_user_id_foreign');
        });
        Schema::dropIfExists('distrito_user');
    }
}
