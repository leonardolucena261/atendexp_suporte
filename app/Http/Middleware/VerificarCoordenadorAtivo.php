<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarCoordenadorAtivo
{
    /**
     * Handle an incoming request.
     * Guarda de acesso: só deixa passar quem tem mandato ativo
     * (uma linha em curso_coordenadores com data_fim = NULL).
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // 1) Visitante (não autenticado): deixa seguir.
        //    Exigir login é papel do middleware Authenticate do painel,
        //    que redireciona o convidado para /coordenador/login.
        if ($user === null) {
            return $next($request);
        }

        // 2) Autenticado SEM mandato ativo: bloqueia.
        if (! $user->ehCoordenadorAtivo()) {
            abort(403, 'Acesso restrito a coordenadores com mandato ativo.');
        }

        return $next($request);
    }
}
