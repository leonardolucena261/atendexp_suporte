<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Carteirinha;
use App\Models\Senha;
use App\Models\TurmaAluno;
use App\Models\VwCheckMatricula;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MatriculaController extends Controller
{
    /**
     * Realiza a matrícula do aluno na turma usando o token de acesso.
     * A ideia eh que seja um JsonResponse como retorno
     * @return mixed
     */
    public function matricular(string $token)
    {
        try {
            // 1. VERIFICAÇÃO DE SESSÃO
            $vaga = session('vaga');

            // Converte array para objeto se necessário (evita erro de propriedade)
            if (is_array($vaga)) {
                $vaga = (object) $vaga;
            }

            if (! $vaga) {
                throw new Exception('Sua sessão expirou. Por favor, escaneie o QR Code ou insira o token novamente para escolher a turma.');
            }

            // 2. BUSCA E VALIDAÇÃO DO TOKEN (Checagem dupla)
            $carteirinha = Carteirinha::where('token_acesso', $token)->firstOrFail();

            if ($carteirinha->situacao === 'INVALIDADA') {
                throw new Exception('Carteirinha invalidada. Procure a secretaria.');
            }
            if ($carteirinha->token_expiracao && Carbon::parse($carteirinha->token_expiracao)->isPast()) {
                throw new Exception('Este token expirou. Gere um novo token no seu aplicativo de carteirinha.');
            }

            // 3. BUSCA OS DADOS DO ALUNO
            $aluno = Aluno::findOrFail($carteirinha->cod_aluno);

            if (! $aluno->data_nascimento) {
                throw new Exception('Data de nascimento não cadastrada. Procure a secretaria.');
            }

            // 4. CÁLCULO E VALIDAÇÃO CRÍTICA DE IDADE
            $idadeAluno = Carbon::parse($aluno->data_nascimento)->age;
            $idadeMinima = $vaga->idade_minima ?? 0;
            $idadeMaxima = $vaga->idade_maxima ?? 999;

            if ($idadeAluno < $idadeMinima || $idadeAluno > $idadeMaxima) {
                $faixa = "{$idadeMinima} a {$idadeMaxima} anos";
                throw new Exception("Idade inadequada. O aluno tem {$idadeAluno} anos, mas esta turma exige faixa etária de {$faixa}.");
            }

            // =============================================================
            // 5. NOVA REGRA: VALIDAÇÃO DE DUPLA COORDENAÇÃO NO PERÍODO
            // =============================================================
            $temConflito = VwCheckMatricula::where('cod_aluno', $aluno->cod_aluno)
                ->where('cod_periodo_letivo', $vaga->cod_periodo_letivo)
                ->where('cod_coordenacao', $vaga->cod_coordenacao)
                // Ignora matrículas transferidas
                ->where('situacao_matricula', '!=', 'Transferido')
                // IMPORTANTE: Exclui a PRÓPRIA turma da busca (caso seja um refresh/F5)
                ->where('cod_turma', '!=', $vaga->cod_turma)
                ->exists();

            if ($temConflito) {
                throw new Exception('Este aluno já possui uma matrícula ativa nesta mesma coordenação para o período letivo selecionado.');
            }

            // =============================================================
            // 5.1. NOVA REGRA: PREVENIR DUPLO CONSUMO DE SENHA NA MESMA MATRÍCULA
            // =============================================================
            $matriculaExistente = TurmaAluno::where('cod_turma', $vaga->cod_turma)
                ->where('cod_aluno', $aluno->cod_aluno)
                ->first();

            if ($matriculaExistente) {
                // A matrícula já existe para este aluno nesta turma

                if ($matriculaExistente->autenticacao === $vaga->autenticacao) {
                    // ✅ MESMA autenticação: é apenas um retry/F5, permitir sem consumir senha novamente
                    // Limpar sessão para evitar reutilização indevida
                    session()->forget('vaga');

                    return response()->json([
                        'sucesso' => true,
                        'message' => 'Matrícula já realizada anteriormente.',
                        'autenticacao' => $matriculaExistente->aut2013enticacao,
                        'redirect_url' => route('carteirinha.app', $carteirinha->uuid),
                        'retry' => true, // Flag opcional para frontend saber que foi um retry
                    ]);
                } else {
                    // ❌ Autenticação DIFERENTE: alguém tentando usar outra senha para mesma matrícula
                    /*
                    \Log::warning('Tentativa de uso de senha secundária para matrícula existente', [
                        'cod_aluno' => $aluno->cod_aluno,
                        'cod_turma' => $vaga->cod_turma,
                        'autenticacao_existente' => $matriculaExistente->autenticacao,
                        'autenticacao_tentativa' => $vaga->autenticacao,
                    ]);
                    */

                    throw new Exception('Esta matrícula já foi realizada com outro token. Use o aplicativo para acompanhar.');
                }
            }

            // =============================================================

            // 6. PREPARAÇÃO DOS DADOS PARA SALVAR

            $dadosMatricula = [
                'cod_turma' => $vaga->cod_turma,
                'cod_aluno' => $aluno->cod_aluno,
                'situacao' => 'Matriculado',
                'autenticacao' => $vaga->autenticacao,
                'data_matricula' => Carbon::now()->toDateString(),
            ];

            // =============================================================
            // 7. NOVA REGRA: VALIDAÇÃO DA SITUAÇÃO DA SENHA
            // =============================================================
            if (empty($vaga->situacao_senha) || $vaga->situacao_senha !== 'DISPONIVEL') {
                // Log opcional para auditoria
                /*
                \Log::warning('Tentativa de matrícula com senha indisponível', [
                    'autenticacao' => $vaga->autenticacao,
                    'situacao_senha' => $vaga->situacao_senha,
                    'cod_aluno' => $aluno->cod_aluno,
                ]);
                */

                throw new Exception('Esta vaga não está mais disponível. A senha foi utilizada ou expirou.');
            }

            // 8. UPSERT (INSERT OU UPDATE DE SEGURANÇA)
            $matricula = TurmaAluno::updateOrCreate(
                [
                    'cod_turma' => $vaga->cod_turma,
                    'cod_aluno' => $aluno->cod_aluno,
                ],
                $dadosMatricula
            );

            // =============================================================
            // 9. NOVA REGRA: INVALIDAR A SENHA APÓS MATRÍCULA COM SUCESSO
            // =============================================================
            $senhaAtualizada = Senha::where('autenticacao', $vaga->autenticacao)
                ->where('situacao', 'disponivel') // Garante que só atualiza se ainda estiver disponível
                ->update([
                    'situacao' => 'UTILIZADA',
                    // Opcional: registrar quando foi utilizada
                    // 'data_utilizacao' => Carbon::now(),
                ]);

            // Se nenhuma linha foi afetada, algo inesperado aconteceu
            /*
            if ($senhaAtualizada === 0) {

                \Log::error('Falha ao invalidar senha após matrícula', [
                    'autenticacao' => $vaga->autenticacao,
                    'matricula_id' => $matricula->cod_turma ?? null,
                ]);

                // Não lançamos exceção aqui para não reverter a matrícula,
                // mas registramos para auditoria. Ajuste conforme sua política.
            }
            */

            // =============================================================

            // 10. LIMPAR SESSÃO PARA EVITAR REUTILIZAÇÃO
            session()->forget('vaga');

            return response()->json([
                'sucesso' => true,
                'message' => 'Matrícula realizada com sucesso!',
                'autenticacao' => $matricula->autenticacao,
                'redirect_url' => route('carteirinha.app', $carteirinha->uuid),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'sucesso' => false,
                'message' => $e->getMessage(),
            ], 403);
        }
    }
}
