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
            CREATE OR REPLACE ALGORITHM = UNDEFINED VIEW vw_turmas_modulo_periodo_porsenha AS
            SELECT
                t.cod_turma AS cod_turma,
                t.cod_periodo_letivo AS cod_periodo_letivo,
                t.cod_modulo AS cod_modulo,
                t.cod_local AS cod_local,
                t.cod_professor AS cod_professor,
                t.nome_turma AS nome_turma,
                t.data_inicio AS turma_data_inicio,
                t.data_termino AS turma_data_termino,
                t.hora_inicio AS turma_hora_inicio,
                t.hora_termino AS turma_hora_termino,
                t.faixa_etaria_inicial AS faixa_etaria_inicial,
                t.faixa_etaria_final AS faixa_etaria_final,
                t.turno AS turno,
                t.nome_faixa_etaria AS nome_faixa_etaria,
                t.dias_de_aula AS dias_de_aula,
                t.qtd_aluno AS qtd_aluno,
                t.idade_minima AS idade_minima,
                t.idade_maxima AS idade_maxima,
                t.situacao AS situacao_turma,
                m.nome_modulo AS nome_modulo,
                m.situacao_modulo AS situacao_modulo,
                m.conteudo AS conteudo,
                pl.periodo AS periodo,
                pl.data_inicio AS periodo_data_inicio,
                pl.data_termino AS periodo_data_termino,
                pl.metas_educacao AS metas_educacao,
                pl.metas_cultura AS metas_cultura,
                pl.metas_esporte AS metas_esporte,
                s.cod_senha AS cod_senha,
                s.numero_senha AS numero_senha,
                s.autenticacao AS autenticacao,
                s.validade AS validade,
                s.situacao AS situacao_senha,
                c.cod_curso AS cod_curso,
                c.cod_coordenacao AS cod_coordenacao,
                c.nome_curso AS nome_curso,
                c.informacoes_curso AS informacoes_curso,
                c.ementa AS ementa,
                c.objetivo AS objetivo,
                c.conteudo_programatico AS conteudo_programatico,
                c.metodologia AS metodologia,
                c.recursos_utilizados AS recursos_utilizados,
                c.sistematica_avaliacao AS sistematica_avaliacao,
                c.referencias AS referencias,
                la.nome_local AS nome_local
            FROM turma t
            JOIN modulo m ON t.cod_modulo = m.cod_modulo
            JOIN curso c ON c.cod_curso = m.cod_curso
            JOIN periodo_letivo pl ON t.cod_periodo_letivo = pl.cod_periodo_letivo
            JOIN senha s ON t.cod_turma = s.cod_turma
            JOIN local_aula la ON la.cod_local = t.cod_local;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_turmas_modulo_periodo_porsenha;");
    }
};
