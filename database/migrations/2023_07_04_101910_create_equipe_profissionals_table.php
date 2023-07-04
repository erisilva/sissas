<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipe_profissionals', function (Blueprint $table) {
            $table->id();

            $table->text('descricao')->nullable();
            $table->bigInteger('profissional_id')->unsigned()->nullable(); // chave fraca
            # fk
            $table->foreignId('cargo_id')->constrained()->restrictOnDelete()->cascadeOnUpdate(); 
            $table->foreignId('equipe_id')->constrained()->restrictOnDelete()->cascadeOnUpdate(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipe_profissionals', function (Blueprint $table) {
            $table->dropForeign(['cargo_id']);
            $table->dropForeign(['equipe_id']);
        });

        Schema::dropIfExists('equipe_profissionals');        
    }
};
