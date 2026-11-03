<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

final class WhatsAppService
{
    /** Envia texto para um número. Retorna true se despachou com sucesso. */
    public function sendText(string $numero, string $mensagem): bool
    {
        $numero = $this->normalizarNumero($numero);

        // Modo seco: registra a mensagem e "envia" com sucesso.
        if (! config('whatsapp.enabled')) {
            Log::info('[WhatsApp dry-run] para {numero}: {mensagem}', [
                'numero' => $numero, 'mensagem' => $mensagem,
            ]);
            return true;
        }

        try {
            $resposta = Http::withHeaders(['apikey' => (string) config('whatsapp.api_key')])
                ->timeout(10)
                ->connectTimeout(5)
                ->post(rtrim((string) config('whatsapp.base_url'), '/')
                    .'/message/sendText/'.config('whatsapp.instance'), [
                    'number' => $numero,
                    'text'   => $mensagem,
                ]);

            if ($resposta->failed()) {
                Log::error('[WhatsApp] falha no envio', [
                    'status' => $resposta->status(), 'body' => $resposta->body(),
                ]);
                return false;
            }

            return true;
        } catch (Throwable $e) {
            Log::error('[WhatsApp] exceção no envio: '.$e->getMessage());
            return false;
        }
    }

    /** Normaliza para E.164 com DDI 55 (Brasil) quando ausente. */
    private function normalizarNumero(string $numero): string
    {
        $digitos = preg_replace('/\D/', '', $numero);

        return str_starts_with($digitos, '55') || strlen($digitos) > 11
            ? $digitos
            : '55'.$digitos;
    }
}