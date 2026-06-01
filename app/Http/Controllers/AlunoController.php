<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use App\Models\Carteirinha;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AlunoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if(!session('login')) {
            return view('senha.login');
        } 
    }

    public function index(Request $request)
    {
        if(!session('login')) {
            return view('senha.login');
        } 

        $query = Aluno::query();
        // Se houver busca (ex: pelo nome ou CPF)
        if ($request->filled('busca')) {
            $termo = $request->get('busca');
            $query = Aluno::where('nome_aluno', 'like', "%{$termo}%")
                ->orWhere('cpf', 'like', "%{$termo}%");
        }

        // OBRIGATÓRIO: Carrega as carteirinhas junto com os alunos
        // Isso evita que o Laravel faça uma consulta no banco para CADA linha da tela
        $alunos = $query->with(['carteirinhaAtiva', 'carteirinhas'])
        ->orderBy('nome_aluno', 'asc')
        ->paginate(15);

        // Se houver resultado, pega o primeiro. Se não, cria um "Aluno Oco" genérico
        $aluno = $alunos->first() ?? (object)[
            'carteirinhas' => collect(), // Retorna coleção vazia ao invés de null
            'nome_aluno' => '',
            'cpf' => '',
            'rg' => '',
            'data_nascimento' => null,
            'situacao' => null,
        ];

        return view('aluno.list', compact('alunos','aluno'));
            
    }
   
        /**
     * Gera (se necessário) e exibe a carteirinha do aluno para impressão.
     * Se receber um ID, busca a específica. Se não receber ID, verifica/cria uma ativa.
     */
    public function carteirinha(int $cod_aluno, $id = null) : View
    {
        if(!session('login')) {
            return view('senha.login');
        } 
        // 1. Busca o aluno (Falha automaticamente se não existir)
        $aluno = Aluno::findOrFail($cod_aluno);

        if ($id) {
            // Cenário A: O ID foi informado. Buscar a carteirinha específica (Ex: histórico)
            $carteira = Carteirinha::where('id', $id)
                        ->where('cod_aluno', $cod_aluno)
                        ->firstOrFail(); // Falha se o ID não pertencer a este aluno
        } else {
            // Cenário B: Nenhum ID. Verifica se tem ativa. Se não, cria uma nova.
            if (!$aluno->carteirinhaAtiva) {
                
                // Busca o maior ID global existente na tabela inteira
                $ultimoId = Carteirinha::max('id') ?? 0;
                
                $novoNumero = 'CAR-' . str_pad($ultimoId + 1, 6, '0', STR_PAD_LEFT);

                Carteirinha::create([
                    'cod_aluno'          => $aluno->cod_aluno,
                    'numero_carteirinha' => $novoNumero,
                    'data_emissao'       => Carbon::now()->toDateString(),
                    'data_validade'      => Carbon::now()->addYear()->toDateString(),
                    'situacao'           => 'ATIVA'
                ]);

                $aluno->load('carteirinhaAtiva');
            }
            
            $carteira = $aluno->carteirinhaAtiva;
        }

        return view('aluno.carteirinha', [
            'carteirinha'  => $carteira, // A que vai ser impressa
            'aluno'        => $aluno,
            'historico'    => $aluno->carteirinhas()->orderByDesc('created_at')->get() // Todas as carteiras (para o painel lateral)
        ]);
    }

    /**
     * Exibe a página informativa sobre o processo de pré-cadastro.
     */
    public function informePrecadastro()
    {
        if (!session('login')) {
            return view('senha.login');
        }

        return view('aluno.informeprecadastro');
    }

}
