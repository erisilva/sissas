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
        Schema::create('equipes', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->integer('numero')->unsigned();
            $table->string('cnes')->nullable();
            $table->string('ine')->nullable();
            $table->enum('minima', ['s', 'n'])->default('n');
            $table->enum('tipo', ['s', 'a'])->default('s');
            $table->foreignId('unidade_id')->constrained()->restrictOnDelete()->cascadeOnUpdate(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipes', function (Blueprint $table) {
            $table->dropForeign(['unidade_id']);
        });
        
        Schema::dropIfExists('equipes');
    }
};
