<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE curso_coordenadores
            ADD COLUMN ativo TINYINT(1)
                GENERATED ALWAYS AS (IF(data_fim IS NULL, 1, NULL)) STORED,
            ADD UNIQUE KEY uk_curso_coordenador_ativo (curso_id, ativo)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE curso_coordenadores
            DROP KEY uk_curso_coordenador_ativo,
            DROP COLUMN ativo
        ");
    }
};
