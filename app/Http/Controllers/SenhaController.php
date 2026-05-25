<?php

namespace App\Http\Controllers;

use App\Models\Senha;
use App\Models\Vw_turmas_modulo_periodo_porsenha;
use Illuminate\Http\Request;

class SenhaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        if(session('login')) {
            return view('senha.senha');
        } else {
            return view('senha.login');
        }
    }
    public function index()
    {
        if(session('login')) {
            return view('senha.senha');
        } else {
            return view('senha.login');
        }
    }
    public function list(Request $request)
    {
        if(!session('login')) {
            return view('senha.login');
        }

        // ==========================================
        // NOVA REGRA: Verificação de Perfil (LGPD/Segurança)
        // ==========================================
        $perfil = strtoupper(trim(session('login')['perfil'] ?? ''));
        
        if (!in_array($perfil, ['ADMINISTRADOR DO SISTEMA', 'GERENCIA'])) {
            // Retorna erro 403 (Forbidden) se não for Admin ou Gerência
            abort(403, 'Acesso não autorizado. Somente perfis de Administrador ou Gerência podem emitir senhas.');
        }
        // ==========================================

        $validated = $request->validate([
            'cod_turma' => 'required|string|max:5'
        ]);
        
        $codigo_turma = $request->input('cod_turma');

        $senhas = Vw_turmas_modulo_periodo_porsenha::where('cod_turma', $request->input('cod_turma'))
                       ->where('situacao_senha', "DISPONIVEL")
                       ->where(function ($query) {
                        $query->whereNull('validade')
                              ->orWhere('validade', '>=', now());
                    })
                       ->get();

        return view("senha.imprimir", compact("senhas", "codigo_turma"));
    }
}
