<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Senha extends Model
{
    use HasFactory;

    /**
     * Nome da tabela associada ao model.
     * 
     * @var string
     */
    protected $table = 'senha';

    /**
     * A chave primária da tabela.
     * No diagrama, é o campo cod_senha.
     * 
     * @var string
     */
    protected $primaryKey = 'cod_senha';

    /**
     * Como a chave não segue o padrão 'id', desativamos o auto-incremento 
     * caso ele seja gerenciado manualmente, ou mantemos true se for serial.
     * Geralmente, para campos cod_*, mantemos true.
     * 
     * @var bool
     */
    public $incrementing = true;

    /**
     * O diagrama não mostra campos de timestamp (created_at/updated_at).
     * Se eles não existirem na sua tabela, deixe como false.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atributos que podem ser preenchidos em massa (Mass Assignment).
     * 
     * @var array
     */
    protected $fillable = [
        'cod_turma',
        'numero_senha',
        'autenticacao',
        'validade',
        'situacao',
    ];

    /**
     * Conversão de tipos (Casting).
     * O campo 'validade' possui um ícone de relógio, indicando datetime/timestamp.
     * 
     * @var array
     */
    protected $casts = [
        'validade' => 'datetime',
        'cod_turma' => 'integer',
        'cod_senha' => 'integer',
    ];

    /**
     * Relacionamento: Uma Senha pertence a uma Turma.
     * Mapeia a ligação cod_turma -> cod_turma no diagrama.
     * 
     * @return BelongsTo
     */
    /*public function turma(): BelongsTo
    {
        return $this->belongsTo(Turma::class, 'cod_turma', 'cod_turma');
    }*/
}
