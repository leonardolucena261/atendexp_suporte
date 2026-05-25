<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

use Illuminate\Support\Str;
use function Illuminate\Support\now;

class Carteirinha extends Model
{
    protected $table = 'carteirinhas';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'cod_aluno', 
        'numero_carteirinha', 
        'data_emissao', 
        'data_validade',
        'situacao', 
        'motivo_invalidacao', 
        'invalidada_em',
        'token_acesso', 
        'token_expiracao',
    ];

    protected $casts = [
        'data_emissao' => 'date',
        'data_validade' => 'date',
        'invalidada_em' => 'datetime',
    ];

    /**
     * EVENTO AUTOMÁTICO: Roda apenas na criação original da carteirinha.
     */
    protected static function booted()
    {
        static::creating(function ($carteirinha) {
            // Gera o UUID automaticamente se não existir
            if (empty($carteirinha->uuid)) {
                $carteirinha->uuid = (string) Str::uuid();
            }
            
            // Se por acaso não foi gerado antes, gera na criação
            if (empty($carteirinha->token_acesso)) {
                $carteirinha->gerarTokenSeguro();
            }
        });
    }

    /**
     * AÇÃO MANUAL: Chamado pelo Controller quando a secretaria pede um novo token.
     * Força a renovação, MAS SOMENTE SE o atual já estiver vencido.
     */
    public function renovarTokenSeVencido(): self
    {
        // Regra: Verifica se já tem token E se a expiração ainda é no futuro
        if (!empty($this->token_acesso) && Carbon::parse($this->token_expiracao)->isFuture()) {
            throw new Exception('Este token ainda é válido. Não é possível gerar um novo até que ele vença.');
        }

        // Se chegou aqui, ou está vencido, ou é nulo. Pode gerar!
        $this->gerarTokenSeguro();
        
        return $this;
    }

    /**
     * MÉTODO INTERNO: Faz o trabalho sujo de gerar o hash e salvar a data.
     */
    private function gerarTokenSeguro(int $tamanho = 6): void
    {
        $alfabeto = '2345679ACDEFGHJKMNPQRTVWXYZ';
        $tamanhoAlfabeto = strlen($alfabeto) - 1;

        do {
            $token = '';
            for ($i = 0; $i < $tamanho; $i++) {
                $token .= $alfabeto[random_int(0, $tamanhoAlfabeto)];
            }
        } while (self::where('token_acesso', $token)->exists());

        // Atualiza os atributos deste objeto
        $this->token_acesso = $token;
        $this->token_expiracao = now()->addDays(5);
    }

    /**
     * AÇÃO MANUAL: Invalida a carteirinha de forma segura e auditável.
     */
    public function invalidar(string $motivo): self
    {
        // 1. Proteção: Não permite invalidar algo que já está invalidado (evita sobrescrever log antigo)
        if ($this->situacao === 'INVALIDADA') {
            throw new Exception('Esta carteirinha já encontra-se invalidada.');
        }

        // 2. Aplica as regras de invalidação
        $this->situacao = 'INVALIDADA';
        $this->motivo_invalidacao = $motivo;
        $this->invalidada_em = now();

        return $this;
    }

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'cod_aluno', 'cod_aluno');
    }
}
