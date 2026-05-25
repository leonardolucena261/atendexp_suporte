<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vw_turmas_modulo_periodo_porsenha extends Model
{
    // 1. Define o nome da View que criamos no MySQL
    protected $table = 'vw_turmas_modulo_periodo_porsenha';

    // 2. Define a chave primária (Views não têm PK real, mas o Eloquent precisa de uma)
    protected $primaryKey = 'cod_turma';

    // 3. Como é uma View, a chave não é auto-incremental por si só
    public $incrementing = false;

    // 4. Se a sua View não incluiu as colunas created_at e updated_at
    public $timestamps = false;

    // Adicione isso aqui:
    protected $fillable = [
        'cod_turma',
        // adicione outros campos que você também quer permitir aqui...
    ];

    /**
     * Opcional: Impedir que alguém tente salvar dados através desta View
     * já que Views com múltiplos JOINs geralmente não permitem escrita direta.
     */
    public function save(array $options = [])
    {
        throw new \Exception("Esta é uma View de leitura e não permite gravação direta.");
    }
}
