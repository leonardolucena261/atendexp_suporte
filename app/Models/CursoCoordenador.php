<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CursoCoordenador extends Model
{
    protected $table = 'curso_coordenadores';

    protected $fillable = ['curso_id', 'user_id', 'data_inicio', 'data_fim', 'observacao'];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim'    => 'date',
    ];

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'curso_id', 'cod_curso');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAtivo($query)
    {
        return $query->whereNull('data_fim');
    }
}
