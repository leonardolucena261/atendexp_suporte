<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        session()->forget("login");
        return view("senha.login");
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'nome_usuario' => 'required|string',
            'senha'        => 'required|string',
        ]);
        
        $usuario = Usuario::where('nome_usuario', $credentials['nome_usuario'])
                        ->where('senha', $credentials['senha'])
                        ->where('situacao', 'ATIVO')
                        ->first();

        if ($usuario) {
            session(['login' => $usuario]);
            return redirect()->intended('/senha');
        }

        return back()->withErrors([
            'nome_usuario' => 'Credenciais invalidas ou usuario inativo.',
        ])->onlyInput('nome_usuario');
    }
}
