<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coordenacao extends Model
{
    protected $table = 'coordenacao';
    protected $primaryKey = 'cod_coordenacao';
    public $timestamps = false;

    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class, 'cod_coordenacao', 'cod_coordenacao');
    }
}
