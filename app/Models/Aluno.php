<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    
    /**
     * A tabela associada ao model.
     */
    protected $table = 'aluno';

    /**
     * A chave primária da tabela.
     */
    protected $primaryKey = 'cod_aluno';

    /**
     * Indica se a chave primária é auto-incrementada.
     * (Mantenha true se for INT AUTO_INCREMENT, mude para false se for string como 'ALU001')
     */
    public $incrementing = true;

    /**
     * Indica se o model deve gerenciar automaticamente created_at e updated_at.
     * Desativado porque sistemas legados geralmente não usam esses campos.
     */
    public $timestamps = false;

    /**
     * Os atributos que são atribuíveis em massa.
     * ATENÇÃO: Ajuste os nomes das colunas abaixo conforme estão exatamente no seu banco (ex: 'nome' ou 'nome_aluno')
     */
    protected $fillable = [
        'cod_bairro',
        'cod_escola',
        'cod_escolaridade',
        'nome_aluno',
        'data_nascimento',
        'data_cadastro',
        'data_atualizado',
        'nome_pai',
        'nome_mae',
        'sexo',
        'rg',
        'cpf',
        'telefone_residencial',
        'telefone_celular',
        'email',
        'tipo_sanguineo',
        'estado_civil',
        'serie_escolar',
        'turno_escolar',
        'manequim',
        'numero_calcado',
        'endereco',
        'numero_endereco',
        'possui_alergia',
        'qual_alergia',
        'portador_pne',
        'qual_pne',
        'medicao_controlada',
        'qual_medicao',
        'possui_bolsa_familia',
        'numero_bolsa_familia',
        'numero_cnis',
        'renda_familiar',
        'ex_aluno',
        'seduc',
        'qual_curso_fez',
        'obs',
        'nome_civil',
        'responsavel_rg',
        'responsavel_cpf',
    ];

    // ==========================================
    // RELACIONAMENTOS (Conforme o diagrama ER)
    // ==========================================


     // ==========================================
    // RELACIONAMENTOS COM CARTEIRINHA (NOVOS)
    // ==========================================

    /**
     * Pega TODAS as carteirinhas do aluno (Ativas e Invalidadas).
     * Usado no histórico da View.
     */
    public function carteirinhas()
    {
        return $this->hasMany(Carteirinha::class, 'cod_aluno', 'cod_aluno');
    }

    /**
     * Pega apenas a carteirinha que está ATIVA no momento.
     * Usado para exibir o botão "Ver" e "Invalidar" na View.
     */
    public function carteirinhaAtiva()
    {
        return $this->hasOne(Carteirinha::class, 'cod_aluno', 'cod_aluno')->where('situacao', 'ATIVA');
    }
}
