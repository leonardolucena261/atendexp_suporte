<?php

namespace App\Notifications;

use App\Broadcasting\WhatsappChannel;
use App\Models\Curso;
use App\Models\CursoCoordenador;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class ConviteCoordenador extends Notification implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Curso $curso,
        public CursoCoordenador $mandato,
    ) {}

    public function via(object $notifiable): array
    {
        return [WhatsappChannel::class];
    }

    public function toWhatsapp(object $notifiable): string
    {
        $link = url('/coordenador/acesso/'.$notifiable->uuid);

        return "🎓 Olá, {$notifiable->name}!\n\n"
            ."Você foi escalado(a) como coordenador(a) do curso {$this->curso->nome_curso}, "
            ."a partir de ".$this->mandato->data_inicio->format('d/m/Y').".\n\n"
            ."Seu identificador de acesso ao Workspace do Coordenador:\n"
            ."🔑 {$notifiable->uuid}\n\n"
            ."Acesse: {$link}\n\n"
            ."Sua senha de acesso é a mesma da sua conta no Atende XP.";
    }
}