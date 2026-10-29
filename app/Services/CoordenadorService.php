<?php

namespace App\Services;

use App\Models\Curso;
use App\Models\CursoCoordenador;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CoordenadorService
{
    /**
     * Escala um coordenador para um curso.
     * Encerra automaticamente o mandato ativo anterior.
     */
    public function escalar(Curso $curso, User $user, Carbon $inicio, ?string $obs = null): CursoCoordenador
    {
        return DB::transaction(function () use ($curso, $user, $inicio, $obs) {
            // lockForUpdate = trava a linha p/ evitar corrida entre 2 requisições simultâneas
            $mandatoAtivo = CursoCoordenador::where('curso_id', $curso->cod_curso)
                ->whereNull('data_fim')
                ->lockForUpdate()
                ->first();

            if ($mandatoAtivo && $mandatoAtivo->user_id === $user->id) {
                throw ValidationException::withMessages([
                    'user_id' => 'Este usuário já é o coordenador atual do curso.',
                ]);
            }

            if ($mandatoAtivo) {
                // Encerra o anterior no dia anterior ao novo início
                $mandatoAtivo->update(['data_fim' => $inicio->copy()->subDay()]);
            }

            // Garante que o usuário tenha UUID (necessário p/ o acesso via WhatsApp)
            if (! $user->uuid) {
                $user->forceFill(['uuid' => (string) Str::uuid()])->save();
            }

            return CursoCoordenador::create([
                'curso_id'    => $curso->cod_curso,
                'user_id'     => $user->id,
                'data_inicio' => $inicio,
                'observacao'  => $obs,
            ]);
        });
    }

    /** Encerra um mandato manualmente (ex.: coordenador saiu antes do previsto) */
    public function encerrar(CursoCoordenador $mandato, Carbon $fim): void
    {
        if ($fim->lt($mandato->data_inicio)) {
            throw ValidationException::withMessages([
                'data_fim' => 'A data de fim não pode ser anterior à data de início.',
            ]);
        }

        $mandato->update(['data_fim' => $fim]);
    }
}
