<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class PreCadastroController extends Controller
{
    public function index()
    {
        $jaVerificado = session('precadastro_verificado', false);

        if (! $jaVerificado) {
            // Gera token único para esta tentativa de verificação
            $token = bin2hex(random_bytes(16));
            session(['precadastro_token' => $token]);
        }

        return view('vaga.precadastro', [
            'jaVerificado' => $jaVerificado,
            'tokenVerificacao' => $jaVerificado ? null : session('precadastro_token'),
        ]);
    }

    /**
     * Valida a verificação humana (pressionar e segurar)
     */
    public function verificarHumano(Request $request)
    {
        // Se já verificado na sessão, libera direto
        if (session('precadastro_verificado')) {
            return response()->json(['sucesso' => true]);
        }

        $tokenEsperado = session('precadastro_token');
        $tokenRecebido = $request->input('token');
        $duracao = (int) $request->input('duracao');

        // Token inválido ou ausente
        if (! $tokenEsperado || ! $tokenRecebido || ! hash_equals($tokenEsperado, $tokenRecebido)) {
            return response()->json(['sucesso' => false, 'mensagem' => 'Token inválido. Recarregue a página.'], 403);
        }

        // Tempo de interação fora do range humano (1.5s a 12s)
        if ($duracao < 1500 || $duracao > 12000) {
            return response()->json(['sucesso' => false, 'mensagem' => 'Tempo de interação suspeito. Tente novamente.'], 403);
        }

        // Invalida o token (impede replay)
        session()->forget('precadastro_token');

        // Marca como verificado
        session(['precadastro_verificado' => true]);

        return response()->json(['sucesso' => true]);
    }

    /**
     * Cadastra o pré-candidato
     */
    public function store(Request $request)
    {
        // ── Bloqueio 1: verificação humana ──
        if (! session('precadastro_verificado')) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'Verificação humana necessária. Recarregue a página.',
            ], 403);
        }

        // ── Bloqueio 2: honeypot ──
        if ($request->filled('website_url')) {
            // Bot detectado — responde "sucesso" silenciosamente para não alertar
            return response()->json(['sucesso' => true, 'mensagem' => 'Registrado.']);
        }

        // ── Bloqueio 3: rate limiting (3 tentativas/minuto por IP) ──
        $rateKey = 'precadastro:'.$request->ip();

        if (RateLimiter::tooManyAttempts($rateKey, 3)) {
            $segundos = RateLimiter::availableIn($rateKey);

            return response()->json([
                'sucesso' => false,
                'mensagem' => "Muitas tentativas. Aguarde {$segundos} segundos.",
            ], 429);
        }
        RateLimiter::hit($rateKey, 60);

        // ── Calcula a Idade ──
        $dataNascimento = Carbon::parse($request->data_nascimento);
        $idade = $dataNascimento->diffInYears(Carbon::now());
        $isMenor = $idade < 18;

        // ── Validação dos dados ──
        $regras = [
            'nome_aluno'        => 'required|string|max:50',
            'nome_mae'          => 'required|string|max:50', // NOVA REGRA: Obrigatório para todos
            'cpf'               => 'required|string|max:20',
            'data_nascimento'   => 'required|date|before:today',
            'sexo'              => 'required|in:Masculino,Feminino',
            'telefone_celular'  => 'required|string|max:20',
            'email'             => 'nullable|email|max:50',
        ];

        $mensagens = [
            'nome_aluno.required'       => 'O nome é obrigatório.',
            'nome_mae.required'         => 'O nome da mãe é obrigatório.', // NOVA REGRA
            'nome_aluno.max'            => 'O nome deve ter no máximo 50 caracteres.',
            'cpf.required'              => 'O CPF é obrigatório.',
            'cpf.unique'                => 'Já existe um pré-cadastro com este CPF.',
            'data_nascimento.required'  => 'A data de nascimento é obrigatória.',
            'data_nascimento.before'    => 'A data de nascimento deve ser anterior a hoje.',
            'sexo.required'             => 'Selecione o sexo.',
            'sexo.in'                   => 'Valor inválido para o campo sexo.',
            'telefone_celular.required' => 'O telefone celular é obrigatório.',
            'email.email'               => 'Informe um e-mail válido.',
        ];

        // ── Regras Específicas para Menor de Idade (LGPD / ECA) ──
        if ($isMenor) {
            $regras['nome_responsavel'] = 'required|string|max:50';
            $regras['cpf_responsavel'] = 'required|string|max:20';
            $regras['grau_parentesco'] = 'required|in:Mãe,Pai,Tutor(a) Legal,Avó(o),Outro';
            $regras['termo_responsavel'] = 'required|accepted'; // Verifica se o checkbox estava marcado

            $mensagens['nome_responsavel.required'] = 'O nome do responsável é obrigatório.';
            $mensagens['cpf_responsavel.required'] = 'O CPF do responsável é obrigatório.';
            $mensagens['grau_parentesco.required'] = 'Selecione o grau de parentesco.';
            $mensagens['termo_responsavel.required'] = 'Você deve aceitar o termo de responsabilidade.';
            $mensagens['termo_responsavel.accepted'] = 'Você deve aceitar o termo de responsabilidade.';
        }

        $request->validate($regras, $mensagens);

        // Sanitização
        $cpfLimpo = preg_replace('/\D/', '', $request->cpf);
        $telLimpo = preg_replace('/\D/', '', $request->telefone_celular);

        // Validação algorítmica do CPF
        if (! $this->validarCPF($cpfLimpo)) {
            return response()->json([
                'sucesso' => false,
                'mensagem' => 'O CPF informado é inválido.',
                'errors' => ['cpf' => ['O CPF informado é inválido.']],
            ], 422);
        }

         // Formata nomes para comparação (Remove acentos, upper, trim)
         $nomeAlunoFormatado = mb_strtoupper(trim(preg_replace('/[^\p{L}\s]/u', '', $request->nome_aluno)), 'UTF-8');
         $nomeMaeFormatado   = mb_strtoupper(trim(preg_replace('/[^\p{L}\s]/u', '', $request->nome_mae)), 'UTF-8');
 
        // ╔══════════════════════════════════════════════════════╗
        // ║ NOVA REGRA: DEDUPLICAÇÃO INTELIGENTE (CPF ou Tríade) ║
        // ╚══════════════════════════════════════════════════════╝
        
        $alunoExistente = Aluno::where('cpf', $request->cpf)
        ->orWhere(function($query) use ($nomeAlunoFormatado, $request, $nomeMaeFormatado) {
            $query->whereRaw('UPPER(TRIM(nome_aluno)) = ?', [$nomeAlunoFormatado])
                  ->where('data_nascimento', $request->data_nascimento)
                  ->whereRaw('UPPER(TRIM(nome_mae)) = ?', [$nomeMaeFormatado]);
        })->first();

        if ($alunoExistente) {
            return response()->json([
                'sucesso'  => false,
                'duplicado' => true, // Bandeira especial para o JS identificar
                'aluno' => [
                    'nome_aluno' => $alunoExistente->nome_aluno,
                    'cpf'        => $alunoExistente->cpf
                ]
            ]);
        }

        // ── Dados Base do Aluno ──
        $dadosAluno = [
            'nome_aluno'        => mb_strtoupper(trim($request->nome_aluno), 'UTF-8'),
            'nome_mae'          => $nomeMaeFormatado, // Sempre salva o nome da mãe real aqui
            // 'cpf'              => $cpfLimpo,
            'cpf'               => $request->cpf,
            'data_nascimento'   => $request->data_nascimento,
            'sexo'              => $request->sexo,
            // 'telefone_celular' => $telLimpo,
            'telefone_celular'  => $request->telefone_celular,
            'email'             => $request->email ? strtolower(trim($request->email)) : null,
            'data_cadastro'     => now(),
            'data_atualizado'   => now(),
        ];

        // ── Dados do Responsável (Se Menor) ──
        if ($isMenor) {
            $cpfRespLimpo = preg_replace('/\D/', '', $request->cpf_responsavel);

            if (! $this->validarCPF($cpfRespLimpo)) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'O CPF do responsável é inválido.',
                    'errors' => ['cpf_responsavel' => ['O CPF do responsável é inválido.']],
                ], 422);
            }

            // ── NOVA REGRA: CPF do responsável não pode ser igual ao do candidato ──
            if ($cpfLimpo === $cpfRespLimpo) {
                return response()->json([
                    'sucesso' => false,
                    'mensagem' => 'O CPF do responsável não pode ser igual ao do candidato.',
                    'errors' => ['cpf_responsavel' => ['O CPF do responsável não pode ser igual ao do candidato.']],
                ], 422);
            }

            // Mapeando para as colunas já existentes na sua tabela
            $grau = $request->grau_parentesco;
            $nomeRespFormatado = mb_strtoupper(trim($request->nome_responsavel), 'UTF-8');

            // 1. Roteia o nome para a coluna correta
            if ($grau === 'Pai') {
                $dadosAluno['nome_pai'] = $nomeRespFormatado;
            } elseif ($grau === 'Mãe') {
                // Se quem assinou foi a mãe, garantimos que o nome_pai não fica sujo
                // (O nome_mae já foi preenchido acima pelo campo principal)
            } else {
                // Tutor, Avó, Outro -> Não misturamos com nome_pai ou nome_mae. 
                // Vai direto para as observações para a secretaria saber quem assinou.
                $dadosAluno['obs'] = "Pré-cadastro web: Termo LGPD/ECA assinalado por {$grau} (CPF: {$cpfRespLimpo}).";
            }

            // 2. Salva o CPF de quem assinou o termo
            $dadosAluno['responsavel_cpf'] = $cpfRespLimpo;

        }

        Aluno::create($dadosAluno);

        // Invalida verificação — próximo cadastro exige nova verificação
        session()->forget('precadastro_verificado');

        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Pré-cadastro realizado com sucesso!',
        ]);
    }

    private function validarCPF(string $cpf): bool
    {
        if (strlen($cpf) !== 11) {
            return false;
        }
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += (int) $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ((int) $cpf[$c] !== $d) {
                return false;
            }
        }

        return true;
    }
}
