<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carteirinhas', function (Blueprint $table) {
            $table->id();
            
            // unsignedInteger é a melhor prática para Foreign Keys no Laravel
            $table->integer('cod_aluno');
            
            $table->string('numero_carteirinha', 50)->unique();
            $table->date('data_emissao');
            $table->date('data_validade');
            
            // --- NOVOS CAMPOS DO TOKEN ---
            // Tamanho 6, único no sistema inteiro
            $table->string('token_acesso', 6)->unique();
            
            // Timestamp para controlar a expiração de 5 dias
            $table->timestamp('token_expiracao')->nullable();
            // ------------------------------

            // Controle de validade (Só uma ativa por aluno por vez)
            $table->enum('situacao', ['ATIVA', 'INVALIDADA'])->default('ATIVA');
            
            // Log de invalidação
            $table->text('motivo_invalidacao')->nullable();
            $table->timestamp('invalidada_em')->nullable();
            
            $table->timestamps();

            $table->foreign('cod_aluno')->references('cod_aluno')->on('aluno')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carteirinhas');
    }
};