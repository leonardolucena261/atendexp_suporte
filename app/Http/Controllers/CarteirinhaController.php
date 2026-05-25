<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvalidarCarteirinhaRequest;
use App\Models\Aluno;
use App\Models\Carteirinha;
use Illuminate\Http\Request;

class CarteirinhaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
    }

    /**
     * Exibe o "App" da carteirinha digital via QR Code
     */
    public function index(string $uuid)
    {
        
        // 1. Busca a carteirinha pelo número impresso/QR Code
        $carteirinha = Carteirinha::where('uuid', $uuid)->firstOrFail();
        
        // 2. BLOQUEIO DE SEGURANÇA: Carteirinha Invalidada
        if ($carteirinha->situacao === 'INVALIDADA') {
            abort(403, 'Esta carteirinha foi invalidada. Procure a secretaria de cursos com seu documento de identificação oficial para solicitar uma nova carteirinha.');
        }

        // 3. Se for ATIVA, busca os dados do aluno usando o cod_aluno da carteirinha
        $aluno = Aluno::findOrFail($carteirinha->cod_aluno);
        
        // 4. Busca o histórico 
        $historico = \App\Models\VwCheckMatricula::where('cod_aluno', $carteirinha->cod_aluno)
                                          ->orderByDesc('nome_periodo_letivo')
                                          ->get();

        // Passa a variável $carteirinha também, pois vamos precisar do número lá no JS
        return view('carteirinha.index', compact('aluno', 'historico', 'carteirinha'));
    }

    /**
     * Gera/Renova o token via AJAX
     */
    public function gerarToken(string $uuid)
    {
        $carteirinha = Carteirinha::where('uuid', $uuid)->firstOrFail();

        // SEGURANÇA EM DOBRA: Impede que um AJAX force a geração se estiver invalidada
        abort_if($carteirinha->situacao === 'INVALIDADA', 403, 'Operação negada para carteirinhas invalidadas.');

        try {
            // Chama a lógica perfeita que criamos no Model
            $carteirinha->renovarTokenSeVencido();
            $carteirinha->save();

            return response()->json([
                'token_acesso' => $carteirinha->token_acesso,
                'token_expiracao' => $carteirinha->token_expiracao
            ]);

        } catch (\Exception $e) {
            // Se cair aqui por causa da nossa regra de "ainda é válido"...
            if (str_contains($e->getMessage(), 'ainda é válido')) {
                // ...retorna o token ATUAL com sucesso, sem gerar um novo!
                return response()->json([
                    'token_acesso' => $carteirinha->token_acesso,
                    'token_expiracao' => $carteirinha->token_expiracao,
                    'status' => 'atual', // Indica que está apenas MOSTRANDO o existente
                    'message' => 'Seu token atual ainda é válido. Exibindo o código abaixo.'
                ]);
            }

            // Se for qualquer outro erro real do banco/sistema, ai sim retorna erro
            return response()->json(['message' => $e->getMessage()], 403); 
        }
    }


    /**
     * Invalida uma carteirinha ativa
     */
    public function invalidar(InvalidarCarteirinhaRequest $request, int $id)
    {
        try {
            $carteirinha = Carteirinha::findOrFail($id);

            // Chama a regra de negócio que protege contra dupla invalidação e preenche os logs
            $carteirinha->invalidar($request->motivo_invalidacao);
            $carteirinha->save(); // Salva as alterações no banco

            return back()->with('sucesso', 'Carteirinha invalidada com sucesso e registro de auditoria salvo.');

        } catch (\Exception $e) {
            // Captura tanto o erro de "já invalidada" quanto o "não encontrado"
            return back()->with('erro', $e->getMessage());
        }
    }

    /**
     * @warning VULNERABILIDADE DE BYPASS LÓGICO - SINCRONIZAÇÃO DE ESTADO
     * 
     * O mecanismo de autenticação via token possui uma janela de vulnerabilidade caso a validação
     * seja feita apenas de forma temporal. 
     * 
     * Cenário de ataque/falha: Se a secretaria invalidar uma carteirinha (situacao = 'INVALIDADA') 
     * hoje, mas o campo `token_expiracao` ainda estiver no futuro (dentro dos 5 dias), o sistema 
     * permitiria o acesso não autorizado e a alteração de dados (Upsert) apenas verificando a data.
     * 
     * MITIGAÇÃO OBRIGATÓRIA (Checagem Dupla de Domínio):
     * A camada de entrada NÃO pode confiar apenas no `token_expiracao`. É estritamente obrigatório
     * verificar a integridade do estado da carteirinha (`situacao === 'ATIVA'`) EM CONJUNTO com 
     * a validade temporal do token antes de liberar qualquer operação no banco de dados.
     */
    public function acessarPorToken(Request $request)
    {
        $request->validate(['token' => 'required|string|size:6']);

        $carteirinha = Carteirinha::where('token_acesso', $request->token)->first();

        if (! $carteirinha) {
            return abort(404, 'Token não encontrado.');
        }

        // A CHECAGEM DUPLA DE SEGURANÇA:
        if ($carteirinha->situacao === 'INVALIDADA') {
            return abort(403, 'Esta carteirinha foi invalidada pela escola. Acesso bloqueado.');
        }

        if ($carteirinha->token_expiracao->isPast()) {
            return abort(403, 'Este token expirou. Solicite um novo na secretaria.');
        }

        // Se chegou aqui, pode abrir o formulário!
        return view('formulario-aluno', ['cod_aluno' => $carteirinha->cod_aluno]);
    }

     // NOVO MÉTODO PARA O COMPROVANTE
     public function comprovante(string $uuid, int $cod_turma_aluno)
     {
         // A mesma validação de segurança (se a carteirinha for inválida, não exibe comprovante)
         $carteirinha = Carteirinha::where('uuid', $uuid)->firstOrFail();
         abort_if($carteirinha->situacao === 'INVALIDADA', 403, 'Acesso negado.');
 
         // Busca os dados dessa matrícula específica na view
         $matricula = \Illuminate\Support\Facades\DB::table('vw_checkmatricula')
             ->where('cod_turma_aluno', $cod_turma_aluno)
             ->where('cod_aluno', $carteirinha->cod_aluno) // Garante que é do aluno da carteirinha
             ->firstOrFail();
 
         $aluno = Aluno::findOrFail($carteirinha->cod_aluno);
 
         // Retorne a view do comprovante (você criará essa view depois)
         return view('carteirinha.comprovante', compact('matricula', 'aluno', 'uuid'));
     }
}
