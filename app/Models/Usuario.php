<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table      = 'usuario';
    protected $primaryKey = 'cod_usuario';
    public $timestamps    = false;

    protected $fillable = ['nome_usuario', 'senha', 'nome_completo', 'perfil', 'situacao'];

    
}
