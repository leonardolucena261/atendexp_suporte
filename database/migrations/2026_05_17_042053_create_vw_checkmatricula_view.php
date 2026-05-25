<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW vw_checkmatricula AS
            SELECT 
                ta.cod_turma_aluno,
                ta.cod_aluno,
                ta.data_matricula,
                ta.situacao AS situacao_matricula,
                ta.autenticacao,
                t.cod_turma,
                t.nome_turma,
                t.turno,
                t.dias_de_aula,
                t.data_inicio AS data_inicio_turma,
                t.data_termino AS data_termino_turma,
                t.hora_inicio,
                t.hora_termino,
                t.situacao AS situacao_turma,
                m.cod_modulo,
                m.nome_modulo,
                c.cod_curso,
                c.nome_curso,
                pl.cod_periodo_letivo,
                pl.periodo AS nome_periodo_letivo,
                co.cod_coordenacao,
                co.nome_coordenacao,
                co.nome_responsavel
            FROM turma_aluno ta
            INNER JOIN turma t ON ta.cod_turma = t.cod_turma
            INNER JOIN modulo m ON t.cod_modulo = m.cod_modulo
            INNER JOIN curso c ON m.cod_curso = c.cod_curso
            INNER JOIN periodo_letivo pl ON t.cod_periodo_letivo = pl.cod_periodo_letivo
            INNER JOIN coordenacao co ON c.cod_coordenacao = co.cod_coordenacao;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_checkmatricula;");
    }
};
