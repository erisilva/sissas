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
        Schema::create('profissionals', function (Blueprint $table) {
            $table->id();

            $table->string('nome');
            $table->string('matricula');
            $table->string('cns')->nullable(); // cartão nacional saúde
            $table->string('cpf');
            $table->string('flexibilizacao'); // extensão, redução, nenhum

            $table->date('admissao');
            $table->text('observacao')->nullable();

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
            
            $table->string('registroClasse')->nullable();
            $table->string('ufOrgaoEmissor', '2')->nullable();

            // fks
            $table->foreignId('cargo_id')->constrained()->cascadeOnUpdate()->restrictOnDelete(); 
            $table->foreignId('carga_horaria_id')->constrained()->cascadeOnUpdate()->restrictOnDelete(); 
            $table->foreignId('vinculo_id')->constrained()->cascadeOnUpdate()->restrictOnDelete(); 
            $table->foreignId('vinculo_tipo_id')->constrained()->cascadeOnUpdate()->restrictOnDelete(); 
            $table->foreignId('orgao_emissor_id')->constrained()->cascadeOnUpdate()->restrictOnDelete(); 


            $table->softDeletes();            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profissionals', function (Blueprint $table) {
            $table->dropForeign(['cargo_id']);
            $table->dropForeign(['carga_horaria_id']);
            $table->dropForeign(['vinculo_id']);
            $table->dropForeign(['vinculo_tipo_id']);
            $table->dropForeign(['orgao_emissor_id']);
        });
        
        Schema::dropIfExists('profissionals');
    }
};
