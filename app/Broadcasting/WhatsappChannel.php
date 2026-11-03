<?php

namespace App\Broadcasting;

use App\Services\WhatsAppService;
use Illuminate\Notifications\Notification;

class WhatsappChannel
{
    public function __construct(private WhatsAppService $whatsapp) {}

    public function send(object $notifiable, Notification $notification): void
    {
        $numero = $notifiable->whatsapp ?? null;

        if (! $numero) {
            logger()->warning('[WhatsApp] usuário {id} sem telefone cadastrado', ['id' => $notifiable->id]);
            return;
        }

        $this->whatsapp->sendText($numero, $notification->toWhatsapp($notifiable));
    }
}
