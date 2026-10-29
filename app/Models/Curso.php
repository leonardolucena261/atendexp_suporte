<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Curso extends Model
{
    // ⚠️ Sua tabela foge do padrão do Laravel (singular + PK custom),
    // então os 3 itens abaixo são OBRIGATÓRIOS:
    protected $table = 'curso';            // Laravel procuraria "cursos"
    protected $primaryKey = 'cod_curso';   // Laravel usaria "id"
    public $timestamps = false;            // a tabela não tem created_at/updated_at

    protected $fillable = [
        'nome_curso',
        'informacoes_curso',
        'ementa',
        'objetivo',
        'conteudo_programatico',
        'metodologia',
        'recursos_utilizados',
        'sistematica_avaliacao',
        'referencias',
        'cod_coordenacao',
    ];

    /* ========== Módulo Coordenador ========== */

    /** Histórico completo de mandatos do curso */
    public function coordenadores(): HasMany
    {
        return $this->hasMany(CursoCoordenador::class, 'curso_id', 'cod_curso');
    }

    /** Coordenador atual (data_fim = NULL) */
    public function coordenadorAtivo(): HasOne
    {
        return $this->hasOne(CursoCoordenador::class, 'curso_id', 'cod_curso')
                    ->whereNull('data_fim')
                    ->latest('data_inicio');
    }
}
