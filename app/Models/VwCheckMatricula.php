<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VwCheckMatricula extends Model
{
    /**
     * O nome da view associada ao model.
     *
     * @var string
     */
    protected $table = 'vw_checkmatricula';

    /**
     * Define a chave primária da view. 
     * Views não possuem chave primária real, mas o Eloquent precisa de uma para métodos como find().
     *
     * @var string
     */
    protected $primaryKey = 'cod_turma_aluno';

    /**
     * Indica se o ID é auto-incrementável.
     * Como é uma view, definimos como falso.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indica se o modelo deve gerenciar os campos created_at e updated_at.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Os atributos que podem ser consultados e convertidos em tipos específicos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data_matricula' => 'date',
        'data_inicio_turma' => 'date',
        'data_termino_turma' => 'date',
        'cod_turma_aluno' => 'integer',
        'cod_aluno' => 'integer',
        'cod_turma' => 'integer',
        'cod_modulo' => 'integer',
        'cod_curso' => 'integer',
        'cod_periodo_letivo' => 'integer',
        'cod_coordenacao' => 'integer',
    ];

    /**
     * Bloqueia qualquer tentativa de salvar/inserir dados através deste Model.
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            return false;
        });

        static::deleting(function ($model) {
            return false;
        });
    }
}
