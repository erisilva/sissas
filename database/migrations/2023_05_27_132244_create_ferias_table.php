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
        Schema::create('ferias', function (Blueprint $table) {
            $table->id();
            $table->date('inicio');
            $table->date('fim');

            $table->text('justificativa')->nullable();
            $table->text('observacao')->nullable();

            $table->foreignId('ferias_tipo_id')->constrained()->cascadeOnUpdate()->restrictOnDelete(); 
            $table->foreignId('profissional_id')->constrained()->cascadeOnUpdate()->restrictOnDelete(); 
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->restrictOnDelete(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ferias', function (Blueprint $table) {
            $table->dropForeign(['ferias_tipo_id']);
            $table->dropForeign(['profissional_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('ferias');
    }
};
