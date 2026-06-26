<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_relatorio_matriculas");

        DB::statement("
            CREATE VIEW vw_relatorio_matriculas AS
            SELECT
                co.nome_coordenacao AS coordenacao,

                t.cod_turma,
                c.nome_curso,
                pl.cod_periodo_letivo,
                pl.periodo AS periodo_letivo,

                t.hora_inicio,
                t.hora_termino,
                t.dias_de_aula,
                t.turno,
                t.idade_minima,
                t.idade_maxima,
                CONCAT(t.idade_minima, ' a ', t.idade_maxima, ' anos') AS faixa_etaria,

                t.qtd_aluno AS oferta_vagas,

                COUNT(CASE WHEN ta.situacao = 'Matriculado' THEN ta.cod_aluno END) AS matriculados,
                (t.qtd_aluno - COUNT(CASE WHEN ta.situacao = 'Matriculado' THEN ta.cod_aluno END)) AS sobra_vagas,
                ROUND(
                    (COUNT(CASE WHEN ta.situacao = 'Matriculado' THEN ta.cod_aluno END) / NULLIF(t.qtd_aluno, 0)) * 100,
                    1
                ) AS indice_ocupacao,

                SUM(CASE WHEN ta.situacao = 'Matriculado' AND a.portador_pne IN ('Sim','S') THEN 1 ELSE 0 END) AS qtd_pcd,
                ROUND(
                    (SUM(CASE WHEN ta.situacao = 'Matriculado' AND a.portador_pne IN ('Sim','S') THEN 1 ELSE 0 END)
                    / NULLIF(COUNT(CASE WHEN ta.situacao = 'Matriculado' THEN ta.cod_aluno END), 0)) * 100,
                    1
                ) AS taxa_pcd,

                ROUND(
                    AVG(CASE WHEN ta.situacao = 'Matriculado' THEN TIMESTAMPDIFF(YEAR, a.data_nascimento, CURDATE()) END),
                    1
                ) AS media_idade,

                SUM(CASE WHEN ta.situacao = 'Matriculado' AND a.sexo = 'Feminino' THEN 1 ELSE 0 END) AS qtd_mulheres,
                SUM(CASE WHEN ta.situacao = 'Matriculado' AND a.sexo = 'Masculino' THEN 1 ELSE 0 END) AS qtd_homens,

                SUM(CASE
                    WHEN ta.situacao = 'Matriculado'
                         AND (a.possui_alergia = 'SIM' OR a.medicao_controlada = 'SIM')
                    THEN 1 ELSE 0
                END) AS qtd_alerta_saude,

                COUNT(ta.cod_aluno) AS total_inscritos

            FROM turma_aluno ta
            INNER JOIN turma t  ON ta.cod_turma  = t.cod_turma
            INNER JOIN aluno a  ON ta.cod_aluno  = a.cod_aluno
            INNER JOIN modulo m ON m.cod_modulo  = t.cod_modulo
            INNER JOIN curso c  ON c.cod_curso   = m.cod_curso
            INNER JOIN coordenacao co ON co.cod_coordenacao = c.cod_coordenacao
            LEFT  JOIN periodo_letivo pl ON pl.cod_periodo_letivo = t.cod_periodo_letivo
            GROUP BY
                co.nome_coordenacao,
                t.cod_turma, t.qtd_aluno, c.nome_curso,
                pl.cod_periodo_letivo, pl.periodo,
                t.hora_inicio, t.hora_termino, t.dias_de_aula,
                t.idade_minima, t.idade_maxima
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_relatorio_matriculas");
    }
};
