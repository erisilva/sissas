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
        Schema::create('capacitacaos', function (Blueprint $table) {
            $table->id();
            $table->date('inicio');
            $table->date('fim');

            $table->text('observacao')->nullable();
            $table->string('cargaHoraria')->nullable();

            $table->foreignId('capacitacao_tipo_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('profissional_id')->constrained()->restrictOnDelete()->cascadeOnUpdate(); 
            $table->foreignId('user_id')->constrained()->restrictOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('capacitacaos', function (Blueprint $table) {
            $table->dropForeign(['capacitacao_tipo_id']);
            $table->dropForeign(['profissional_id']);
            $table->dropForeign(['user_id']);
        });
        
        Schema::dropIfExists('capacitacaos');
    }
};
