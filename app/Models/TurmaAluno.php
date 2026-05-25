<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TurmaAluno extends Model
{
    /**
     * Indica ao Laravel que a tabela NÃO possui as colunas created_at e updated_at.
     * Se não colocar isso, o Laravel vai dar erro de coluna desconhecida ao salvar.
     */
    public $timestamps = false;

    /**
     * Nome explícito da tabela (Boa prática, embora o Laravel pluralize 'TurmaAluno' corretamente).
     */
    protected $table = 'turma_aluno';

    /**
     * Define a chave primária customizada.
     */
    protected $primaryKey = 'cod_turma_aluno';

    /**
     * Indica que a chave primária é um número inteiro auto-incrementável.
     */
    protected $keyType = 'int';
    public $incrementing = true;

    /**
     * Campos permitidos para atribuição em massa (Mass Assignment).
     * Evita que usuários maliciosos enviem dados que não deveriam ser salvos.
     */
    protected $fillable = [
        'cod_turma',
        'cod_aluno',
        'situacao',
        'autenticacao',
        'data_matricula',
    ];

    /**
     * Conversão automática de tipos (Casts).
     * Garante que a data_matricula seja retornada sempre como um objeto Carbon,
     * permitindo usar formatadores como $matricula->data_matricula->format('d/m/Y').
     */
    protected $casts = [
        'data_matricula' => 'date',
    ];

    // =============================================================
    // RELACIONAMENTOS (Recomendado para o futuro)
    // =============================================================

    /**
     * Uma matrícula (turma_aluno) pertence a UM Aluno.
     */
    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'cod_aluno', 'cod_aluno');
    }

    /**
     * Uma matrícula (turma_aluno) pertence a UMA Turma.
     */
    /*public function turma()
    {
        return $this->belongsTo(Turma::class, 'cod_turma', 'cod_turma');
    }*/
}
