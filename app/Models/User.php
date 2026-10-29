<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'email', 'password', 'whatsapp', 'uuid'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* ========== Módulo Coordenador ========== */

    /** Todos os mandatos (histórico) deste usuário */
    public function mandatos(): HasMany
    {
        return $this->hasMany(CursoCoordenador::class);
    }

    /** Cursos que este usuário coordena/coordenou */
    public function cursosCoordenados(): BelongsToMany
    {
        return $this->belongsToMany(Curso::class, 'curso_coordenadores', 'user_id', 'curso_id')
                    ->withPivot(['data_inicio', 'data_fim'])
                    ->withTimestamps();
    }

    /** O usuário tem mandato em aberto? (usado pelo middleware do workspace) */
    public function ehCoordenadorAtivo(): bool
    {
        return $this->mandatos()->whereNull('data_fim')->exists();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'coordenador' => $this->ehCoordenadorAtivo(), // mandato ativo = acesso
            default       => true, // painéis futuros (admin) ajustamos depois
        };
    }
}
