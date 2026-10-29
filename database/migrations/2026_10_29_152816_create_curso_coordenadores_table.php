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
        Schema::create('curso_coordenadores', function (Blueprint $table) {
            $table->id();
            $table->Integer('curso_id'); // ⚠️ deve ter o MESMO tipo de curso.cod_curso
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();   // NULL = mandato atual
            $table->string('observacao')->nullable();
            $table->timestamps();

            $table->foreign('curso_id')
                ->references('cod_curso')->on('curso')
                ->cascadeOnDelete();

            $table->index(['curso_id', 'data_fim']); // acelera a busca do coordenador ativo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curso_coordenadores');
    }
};
