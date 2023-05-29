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
        Schema::create('distrito_user', function (Blueprint $table) {
            $table->foreignId('distrito_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->index(['distrito_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distrito_user', function (Blueprint $table) {
            Schema::table('distrito_user', function (Blueprint $table) {
                $table->dropForeign(['distrito_id']);
                $table->dropForeign(['user_id']);
            });
    
            Schema::dropIfExists('distrito_user');
        });
    }
};
