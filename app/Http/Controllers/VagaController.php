<?php

namespace App\Http\Controllers;

use App\Models\Vw_turmas_modulo_periodo_porsenha;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VagaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        dd($request);
        return view('vaga');
    }

    public function index()
    {
        return view('vaga.find');
    }

    public function validaMatricula()
    {
        $raw = session('vaga');
        if ($raw === null) {
            return redirect()->route('vaga.find')
                ->with('error', 'Nenhuma vaga na sessão. Acesse pelo token e confirme o check-in antes da matrícula.');
        }

        $vaga = $raw instanceof Vw_turmas_modulo_periodo_porsenha
            ? $raw
            : new Vw_turmas_modulo_periodo_porsenha((array) $raw);

        $cursoCheckin = $this->formatCursoForCheckin($vaga);
        if (($cursoCheckin['situacaoSenha'] ?? '') !== 'DISPONIVEL') {
            return redirect()->route('vaga.find')
                ->with('error', 'Este token não está disponível para matrícula (já utilizado ou inválido).');
        }

        return view('vaga.validamatricula', [
            'vaga' => $vaga,
            'cursoCheckin' => $cursoCheckin,
        ]);
    }

    /**
     * Check-in a partir da sessão (ex.: após recarregar a página).
     */
    public function checkin()
    {
        $raw = session('vaga');
        if ($raw === null) {
            return redirect()->route('vaga.find')
                ->with('error', 'Não foi possível encontrar a vaga. Informe o token válido.');
        }

        $vaga = $raw instanceof Vw_turmas_modulo_periodo_porsenha
            ? $raw
            : new Vw_turmas_modulo_periodo_porsenha((array) $raw);

        return view('vaga.checkin', [
            'vaga' => $vaga,
            'cursoCheckin' => $this->formatCursoForCheckin($vaga),
        ]);
    }

    public function getVaga(string $token)
    {
        $token = trim(rawurldecode($token));
        $needle = mb_strtolower($token, 'UTF-8');

        $vaga = Vw_turmas_modulo_periodo_porsenha::query()
            ->whereRaw('LOWER(TRIM(autenticacao)) = ?', [$needle])
            ->first();

        if (! $vaga) {
            return redirect()->route('vaga.find')->with('error', 'Vaga não encontrada');
        }

        session(['vaga' => $vaga]);

        return view('vaga.checkin', [
            'vaga' => $vaga,
            'cursoCheckin' => $this->formatCursoForCheckin($vaga),
        ]);
    }

    /**
     * Converte o registro da view em payload para o renderizador JS de checkin.blade.php.
     * Usa vários nomes de coluna possíveis para compatibilidade com o banco.
     */
    private function formatCursoForCheckin(Vw_turmas_modulo_periodo_porsenha $vaga): array
    {
        $a = $vaga->getAttributes();

        $get = function (string ...$keys) use ($a) {
            foreach ($keys as $key) {
                if (array_key_exists($key, $a) && $a[$key] !== null && $a[$key] !== '') {
                    return $a[$key];
                }
            }

            return null;
        };

        $inicioVal = $get(
            'turma_data_inicio',
            'data_inicio',
            'dt_inicio',
            'inicio',
            'data_matricula',
            'data_inicio_curso'
        );
        $inicio = '—';
        if ($inicioVal !== null) {
            if ($inicioVal instanceof DateTimeInterface) {
                $inicio = Carbon::instance($inicioVal)->format('d/m/Y');
            } else {
                try {
                    $inicio = Carbon::parse((string) $inicioVal)->format('d/m/Y');
                } catch (\Throwable) {
                    $inicio = (string) $inicioVal;
                }
            }
        }

        $hi = $this->formatHora($get(
            'turma_hora_inicio',
            'horario_inicio',
            'hora_inicio',
            'hr_inicio',
            'hr_ini',
            'hor_inicio'
        ));
        $hf = $this->formatHora($get(
            'turma_hora_termino',
            'horario_fim',
            'hora_fim',
            'hr_fim',
            'hor_fim'
        ));

        if ($hi === null) {
            $hi = '08:00';
        }
        if ($hf === null) {
            $hf = '12:00';
        }

        $diasSemana = $this->normalizarDiasSemana($get('dias_de_aula', 'dias_semana', 'dias_aula', 'dias'));

        $codigo = $get('autenticacao', 'codigo', 'token') ?? (string) ($vaga->getKey() ?? '');

        $situacaoNorm = strtoupper(trim((string) ($get('situacao_senha') ?? '')));
        if ($situacaoNorm === '') {
            $situacaoNorm = 'DISPONIVEL';
        }

        $vagaDoTokenDisponivel = ($situacaoNorm === 'DISPONIVEL');

        $faixaEtaria = (string) ($get('nome_faixa_etaria') ?? '—');
        $faixaStrParaIdade = ($faixaEtaria !== '' && $faixaEtaria !== '—') ? $faixaEtaria : null;
        $faixaIdades = $this->extrairIdadesDaStringFaixa($faixaStrParaIdade);
        $idadeMinDb = $get('idade_minima', 'idade_min', 'nr_idade_minima');
        $idadeMaxDb = $get('idade_maxima', 'idade_max', 'nr_idade_maxima');
        $idadeMinima = $idadeMinDb !== null ? (int) $idadeMinDb : ($faixaIdades !== null ? $faixaIdades['min'] : null);
        $idadeMaxima = $idadeMaxDb !== null ? (int) $idadeMaxDb : ($faixaIdades !== null ? $faixaIdades['max'] : null);

        return [
            'codigo' => (string) $codigo,
            'nome' => (string) ($get('nome_curso', 'curso', 'dsc_curso', 'nome_turma', 'turma', 'nome') ?? '—'),
            'modulo' => (string) ($get('modulo', 'nome_modulo', 'dsc_modulo', 'modulo_nome') ?? '—'),
            'vagas' => $vagaDoTokenDisponivel ? 1 : 0,
            'total' => 1,
            'turno' => (string) ($get('turno', 'dsc_turno', 'periodo', 'desc_turno') ?? '—'),
            'faixaEtaria' => $faixaEtaria !== '' ? $faixaEtaria : '—',
            'idadeMinima' => $idadeMinima,
            'idadeMaxima' => $idadeMaxima,
            'situacaoSenha' => $situacaoNorm,
            'inicio' => $inicio,
            'horarioInicio' => $hi,
            'horarioFim' => $hf,
            'diasSemana' => $diasSemana,
        ];
    }

    /**
     * Extrai idade mínima e máxima de textos como "18 a 29 anos", "18-29", "de 18 a 29".
     *
     * @return array{min: int, max: int}|null
     */
    private function extrairIdadesDaStringFaixa(?string $texto): ?array
    {
        if ($texto === null || trim($texto) === '') {
            return null;
        }

        $t = trim($texto);
        $patterns = [
            '/(\d+)\s*(?:a|à|ate|até)\s*(\d+)/iu',
            '/(\d+)\s*[-–]\s*(\d+)/u',
            '/de\s*(\d+)\s*(?:a|à|ate|até)\s*(\d+)/iu',
            '/entre\s*(\d+)\s*e\s*(\d+)/iu',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $t, $m)) {
                $a = (int) $m[1];
                $b = (int) $m[2];

                return ['min' => min($a, $b), 'max' => max($a, $b)];
            }
        }

        if (preg_match('/^(\d+)\s*anos?$/iu', $t, $m)) {
            $n = (int) $m[1];

            return ['min' => $n, 'max' => $n];
        }

        return null;
    }

    private function formatHora(mixed $val): ?string
    {
        if ($val === null || $val === '') {
            return null;
        }
        if ($val instanceof DateTimeInterface) {
            return Carbon::instance($val)->format('H:i');
        }
        $s = (string) $val;
        if (preg_match('/(\d{1,2}):(\d{2})/', $s, $m)) {
            return sprintf('%02d:%02d', (int) $m[1], (int) $m[2]);
        }

        try {
            return Carbon::parse($s)->format('H:i');
        } catch (\Throwable) {
            return $s;
        }
    }

    private function normalizarDiasSemana(mixed $raw): array
    {
        if ($raw === null || $raw === '') {
            return [];
        }
        if (is_array($raw)) {
            $out = [];
            foreach ($raw as $item) {
                $t = $this->tokenDiaSemana((string) $item);
                if ($t !== null) {
                    $out[] = $t;
                }
            }

            return array_values(array_unique($out));
        }
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $this->normalizarDiasSemana($decoded);
            }

            $fromLista = $this->parseDiasDeAulaString($raw);
            if (count($fromLista) > 0) {
                return $fromLista;
            }

            return $this->diasSemanaDoTextoLivre($raw);
        }

        return [];
    }

    /**
     * Interpreta dias_de_aula: um ou mais dias separados por vírgula, "/" ou " e "
     * (ex.: SEGUNDA, TERÇA/QUINTA, TERÇA E QUINTA, SEGUNDA/TERÇA E QUINTA).
     */
    private function parseDiasDeAulaString(string $raw): array
    {
        $s = trim($raw);
        if ($s === '') {
            return [];
        }

        $s = preg_replace('/\s+e\s+/iu', ',', $s);
        $s = preg_replace('/\s*\/\s*/u', ',', $s);
        $parts = preg_split('/\s*,\s*/u', $s, -1, PREG_SPLIT_NO_EMPTY);

        $out = [];
        foreach ($parts as $part) {
            $key = $this->mapearNomeDiaPortuguesParaChave(trim($part));
            if ($key !== null) {
                $out[] = $key;
            }
        }

        return array_values(array_unique($out));
    }

    /**
     * Mapeia um fragmento (ex.: "SEGUNDA-FEIRA", "terça") para chave JS seg|ter|...
     */
    private function mapearNomeDiaPortuguesParaChave(string $parte): ?string
    {
        if ($parte === '') {
            return null;
        }

        $p = mb_strtolower(trim(Str::ascii($parte)));
        $p = preg_replace('/\s*-\s*feira\s*/u', ' ', $p);
        $p = preg_replace('/\s+/u', ' ', $p);

        // Ordem: nomes completos para evitar ambiguidade (ex.: quinta vs quarta).
        $porNome = [
            ['seg', 'segunda'],
            ['ter', 'terca'],
            ['qua', 'quarta'],
            ['qui', 'quinta'],
            ['sex', 'sexta'],
            ['sab', 'sabado'],
            ['dom', 'domingo'],
        ];

        foreach ($porNome as [$key, $needle]) {
            if (str_contains($p, $needle)) {
                return $key;
            }
        }

        // Abreviações comuns: 2ª, 2a, 3a...
        if (preg_match('/\b2a\b|\b2\s*ª/u', $parte)) {
            return 'seg';
        }
        if (preg_match('/\b3a\b|\b3\s*ª/u', $parte)) {
            return 'ter';
        }
        if (preg_match('/\b4a\b|\b4\s*ª/u', $parte)) {
            return 'qua';
        }
        if (preg_match('/\b5a\b|\b5\s*ª/u', $parte)) {
            return 'qui';
        }
        if (preg_match('/\b6a\b|\b6\s*ª/u', $parte)) {
            return 'sex';
        }

        return null;
    }

    /**
     * Varre um texto único procurando nomes de dias (fallback quando não há separadores).
     */
    private function diasSemanaDoTextoLivre(string $raw): array
    {
        $p = mb_strtolower(trim(Str::ascii($raw)));
        $porNome = [
            ['seg', 'segunda'],
            ['ter', 'terca'],
            ['qua', 'quarta'],
            ['qui', 'quinta'],
            ['sex', 'sexta'],
            ['sab', 'sabado'],
            ['dom', 'domingo'],
        ];
        $out = [];
        foreach ($porNome as [$key, $needle]) {
            if (str_contains($p, $needle)) {
                $out[] = $key;
            }
        }

        return array_values(array_unique($out));
    }

    private function tokenDiaSemana(string $fragment): ?string
    {
        $f = mb_strtolower(trim($fragment));
        $candidates = [
            'dom' => ['dom', 'domingo'],
            'seg' => ['seg', 'segunda', '2ª', '2a'],
            'ter' => ['ter', 'terca', 'terça', '3ª', '3a'],
            'qua' => ['qua', 'quarta', '4ª', '4a'],
            'qui' => ['qui', 'quinta', '5ª', '5a'],
            'sex' => ['sex', 'sexta', '6ª', '6a'],
            'sab' => ['sab', 'sáb', 'sabado', 'sábado'],
        ];
        foreach ($candidates as $key => $needles) {
            foreach ($needles as $n) {
                if (str_contains($f, $n) || $f === $key) {
                    return $key;
                }
            }
        }

        return null;
    }
}
