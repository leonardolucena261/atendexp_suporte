<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PwaController extends Controller
{
    public function manifest()
    {
        $manifest = [
            "name" => "Cidade do Saber - Carteirinha Digital",
            "short_name" => "C. Saber",
            "description" => "Sua carteirinha e dados acadêmicos em um aplicativo.",
            
            // ATENÇÃO: Mantemos genérico. O UUID entra na URL ao escanear o QR, 
            // mas o manifest em si não pode ser dinâmico por causa do Cache do Navegador.
            "start_url" => url('/app'),
            "scope" => "/app",
            
            "display" => "standalone",
            "background_color" => "#1E293B",
            "theme_color" => "#1E293B",
            "orientation" => "portrait",
            
            // A MÁGICA ACONTECE AQUI: O asset() garante que os ícones sempre apontem 
            // para /img/icon-192.png com o caminho absoluto correto do servidor
            "icons" => [
                [
                    "src" => asset('img/icon-192.png'),
                    "type" => "image/png",
                    "sizes" => "192x192",
                    "purpose" => "any maskable" // Recomendado para ícones de PWA modernos
                ],
                [
                    "src" => asset('img/icon-512.png'),
                    "type" => "image/png",
                    "sizes" => "512x512",
                    "purpose" => "any maskable"
                ]
            ]
        ];

        // Retorna o JSON com o Content-Type correto para o navegador reconhecer como PWA
        return Response::json($manifest)
            ->header('Content-Type', 'application/manifest+json')
            ->header('Cache-Control', 'public, max-age=86400'); // Cache de 24h para o manifest
    }
}
