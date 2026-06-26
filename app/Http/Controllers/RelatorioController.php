<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function matriculas(Request $request)
    {
        if (!session('login')) {
            return view('senha.login');
        }

        $cursos = DB::table('vw_relatorio_matriculas')
            ->select('nome_curso')
            ->distinct()
            ->orderBy('nome_curso')
            ->pluck('nome_curso', 'nome_curso');

        // Opções de filtro para os selects
        $coordenacoes = DB::table('coordenacao')
            ->orderBy('nome_coordenacao')
            ->pluck('nome_coordenacao', 'nome_coordenacao');

        $periodos = DB::table('periodo_letivo')
            ->orderByDesc('periodo')
            ->pluck('periodo', 'cod_periodo_letivo');

        // ★ Código do período mais recente (primeiro da lista ordenada)
        $periodoPadrao = $periodos->keys()->first();

        // Query base
        $query = DB::table('vw_relatorio_matriculas');

        // ── Filtros ──

        // 1. Busca textual (curso ou turma)
        if ($request->filled('busca')) {
            $termo = $request->input('busca');
            $query->where(function ($q) use ($termo) {
                $q->where('nome_curso', 'like', "%{$termo}%")
                  ->orWhere('cod_turma', 'like', "%{$termo}%");
            });
        }

        // 2. Coordenação
        if ($request->filled('coordenacao') && $request->input('coordenacao') !== 'todos') {
            $query->where('coordenacao', $request->input('coordenacao'));
        }

        // 3. Período letivo
        if ($request->has('periodo_letivo')) {
            // O usuário enviou o campo (mesmo que seja "todos")
            if ($request->input('periodo_letivo') !== 'todos') {
                $query->where('cod_periodo_letivo', $request->input('periodo_letivo'));
            }
            // Se for "todos", não aplica filtro → mostra todos
        } else {
            // Nenhum período no request → aplica o padrão (último)
            if ($periodoPadrao) {
                $query->where('cod_periodo_letivo', $periodoPadrao);
            }
        }

        // 4. Faixa etária (busca por sobreposição)
        if ($request->filled('faixa_etaria') && $request->input('faixa_etaria') !== 'todos') {
            $faixa = $request->input('faixa_etaria');
            switch ($faixa) {
                case 'ate17':    $query->where('idade_maxima', '<=', 17); break;
                case '18a29':    $query->where('idade_minima', '<=', 29)->where('idade_maxima', '>=', 18); break;
                case '30a44':    $query->where('idade_minima', '<=', 44)->where('idade_maxima', '>=', 30); break;
                case '45a59':    $query->where('idade_minima', '<=', 59)->where('idade_maxima', '>=', 45); break;
                case '60plus':   $query->where('idade_minima', '>=', 60); break;
            }
        }

        // 5. Curso
        if ($request->filled('curso') && $request->input('curso') !== 'todos') {
            $query->where('nome_curso', $request->input('curso'));
        }

        // 6. Alerta de saúde
        if ($request->filled('saude') && $request->input('saude') !== 'todos') {
            if ($request->input('saude') === 'com') {
                $query->where('qtd_alerta_saude', '>', 0);
            } else {
                $query->where('qtd_alerta_saude', 0);
            }
        }

        // 7. PCD
        if ($request->filled('pcd') && $request->input('pcd') !== 'todos') {
            if ($request->input('pcd') === 'com') {
                $query->where('qtd_pcd', '>', 0);
            } else {
                $query->where('qtd_pcd', 0);
            }
        }

        // 8. Tem vaga
        if ($request->filled('tem_vaga') && $request->input('tem_vaga') !== 'todos') {
            if ($request->input('tem_vaga') === 'sim') {
                $query->where('sobra_vagas', '>', 0);
            } else {
                $query->where('sobra_vagas', '<=', 0);
            }
        }

        $sortBy = $request->input('sort_by', 'coordenacao');
        $sortDir = $request->input('sort_dir', 'asc');
        $allowedSorts = [
           'coordenacao','cod_turma','nome_curso','periodo_letivo',
           'turno','hora_inicio','dias_de_aula','faixa_etaria',
           'oferta_vagas','matriculados','sobra_vagas','indice_ocupacao',
           'qtd_pcd','media_idade','qtd_mulheres','qtd_homens','qtd_alerta_saude'
        ];
        if (!in_array($sortBy, $allowedSorts)) { $sortBy = 'coordenacao'; }
        if (!in_array($sortDir, ['asc','desc'])) { $sortDir = 'asc'; }
        $query->orderBy($sortBy, $sortDir);
       
        $dados = $query->get();

        // Resumo (cards)
        $resumo = [
            'total_turmas'       => $dados->count(),
            'total_matriculados' => $dados->sum('matriculados'),
            'total_vagas'        => $dados->sum('oferta_vagas'),
            'total_sobras'       => $dados->sum('sobra_vagas'),
            'ocupacao_media'     => round($dados->avg('indice_ocupacao') ?? 0, 1),
            'total_pcd'          => $dados->sum('qtd_pcd'),
            'total_alertas'      => $dados->sum('qtd_alerta_saude'),
            'total_mulheres'     => $dados->sum('qtd_mulheres'),
            'total_homens'       => $dados->sum('qtd_homens'),
        ];

        // Totais (rodapé da tabela)
        $totais = [
            'matriculados'     => $dados->sum('matriculados'),
            'oferta_vagas'     => $dados->sum('oferta_vagas'),
            'sobra_vagas'      => $dados->sum('sobra_vagas'),
            'qtd_pcd'          => $dados->sum('qtd_pcd'),
            'qtd_alerta_saude' => $dados->sum('qtd_alerta_saude'),
            'qtd_mulheres'     => $dados->sum('qtd_mulheres'),
            'qtd_homens'       => $dados->sum('qtd_homens'),
            'media_idade'      => round($dados->avg('media_idade') ?? 0, 1),
            'indice_ocupacao'  => round($dados->avg('indice_ocupacao') ?? 0, 1),
        ];

        // Filtros ativos (para repopular o form)
        $filtros = $request->only([
            'busca', 'coordenacao', 'periodo_letivo',
            'faixa_etaria', 'curso', 'saude', 'pcd', 'tem_vaga',
            'sort_by', 'sort_dir'
        ]);

        // ★ Injeta o período padrão nos filtros para o select ficar correto
        if (!$request->has('periodo_letivo') && $periodoPadrao) {
            $filtros['periodo_letivo'] = $periodoPadrao;
        }

        return view('relatorio.matriculas', compact(
            'dados', 'resumo', 'totais', 'coordenacoes', 'periodos', 'cursos', 'filtros'
        ));
        
    }

    /**
     * Exporta os dados filtrados para CSV (abre no Excel).
     */
    public function exportExcel(Request $request)
    {
        if (!session('login')) {
            abort(403);
        }

         // ★ Mesma lógica de período padrão
         $periodoPadrao = DB::table('periodo_letivo')
         ->orderByDesc('periodo')
         ->pluck('periodo', 'cod_periodo_letivo')
         ->keys()->first();

        // Reaplica os mesmos filtros
        $query = DB::table('vw_relatorio_matriculas');

        if ($request->filled('busca')) {
            $termo = $request->input('busca');
            $query->where(function ($q) use ($termo) {
                $q->where('nome_curso', 'like', "%{$termo}%")
                  ->orWhere('cod_turma', 'like', "%{$termo}%");
            });
        }
        if ($request->filled('coordenacao') && $request->input('coordenacao') !== 'todos') {
            $query->where('coordenacao', $request->input('coordenacao'));
        }
         // ★ Período padrão também no export
         if ($request->has('periodo_letivo')) {
            if ($request->input('periodo_letivo') !== 'todos') {
                $query->where('cod_periodo_letivo', $request->input('periodo_letivo'));
            }
        } else {
            if ($periodoPadrao) {
                $query->where('cod_periodo_letivo', $periodoPadrao);
            }
        }

        if ($request->filled('faixa_etaria') && $request->input('faixa_etaria') !== 'todos') {
            $faixa = $request->input('faixa_etaria');
            switch ($faixa) {
                case 'ate17':    $query->where('idade_maxima', '<=', 17); break;
                case '18a29':    $query->where('idade_minima', '<=', 29)->where('idade_maxima', '>=', 18); break;
                case '30a44':    $query->where('idade_minima', '<=', 44)->where('idade_maxima', '>=', 30); break;
                case '45a59':    $query->where('idade_minima', '<=', 59)->where('idade_maxima', '>=', 45); break;
                case '60plus':   $query->where('idade_minima', '>=', 60); break;
            }
        }
        
        if ($request->filled('saude') && $request->input('saude') !== 'todos') {
            $request->input('saude') === 'com'
                ? $query->where('qtd_alerta_saude', '>', 0)
                : $query->where('qtd_alerta_saude', 0);
        }
        if ($request->filled('pcd') && $request->input('pcd') !== 'todos') {
            $request->input('pcd') === 'com'
                ? $query->where('qtd_pcd', '>', 0)
                : $query->where('qtd_pcd', 0);
        }
        if ($request->filled('tem_vaga') && $request->input('tem_vaga') !== 'todos') {
            $request->input('tem_vaga') === 'sim'
                ? $query->where('sobra_vagas', '>', 0)
                : $query->where('sobra_vagas', '<=', 0);
        }

        $dados = $query->orderBy('coordenacao')->orderBy('nome_curso')->orderBy('cod_turma')->get();

        // Monta CSV com BOM UTF-8
        $cabecalhos = [
            'Coordenação', 'Turma', 'Curso', 'Período Letivo',
            'Horário', 'Dias', 'Faixa Etária',
            'Vagas Ofertadas', 'Matriculados', 'Sobra',
            'Ocupação (%)', 'PCD', 'Taxa PCD (%)',
            'Idade Média', 'Mulheres', 'Homens', 'Alertas Saúde'
        ];

        $linhas = [];
        $linhas[] = implode("\t", $cabecalhos);

        foreach ($dados as $r) {
            $linhas[] = implode("\t", [
                $r->coordenacao,
                $r->cod_turma,
                $r->nome_curso,
                $r->periodo_letivo,
                substr($r->hora_inicio ?? '00:00', 0, 5) . ' - ' . substr($r->hora_termino ?? '00:00', 0, 5),
                $r->dias_de_aula,
                $r->faixa_etaria,
                $r->oferta_vagas,
                $r->matriculados,
                $r->sobra_vagas,
                $r->indice_ocupacao,
                $r->qtd_pcd,
                $r->taxa_pcd,
                $r->media_idade,
                $r->qtd_mulheres,
                $r->qtd_homens,
                $r->qtd_alerta_saude,
            ]);
        }

        $csv = "\xEF\xBB\xBF" . implode("\n", $linhas);
        $filename = 'relatorio_matriculas_' . date('Y-m-d_His') . '.csv';

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}