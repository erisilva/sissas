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
        Schema::create('historicos', function (Blueprint $table) {
            $table->id();

            // FK
            $table->foreignId('historico_tipo_id')->constrained()->restrictOnDelete()->cascadeOnUpdate(); 
            $table->foreignId('profissional_id')->constrained()->restrictOnDelete()->cascadeOnUpdate(); 
            $table->foreignId('user_id')->constrained()->restrictOnDelete()->cascadeOnUpdate(); 

            // FK - chaves fracas
            $table->bigInteger('unidade_id')->unsigned()->nullable();
            $table->bigInteger('equipe_id')->unsigned()->nullable();

            $table->text('changes')->nullable();
            $table->text('observacao')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historicos', function (Blueprint $table) {
            $table->dropForeign(['historico_tipo_id']);
            $table->dropForeign(['profissional_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('historicos');
    }
};
