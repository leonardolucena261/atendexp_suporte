<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class InvalidarCarteirinhaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Altere para a sua lógica de permissão/autenticação da secretaria
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'motivo_invalidacao' => 'required|string|min:5|max:500',
        ];
    }

    public function messages()
    {
        return [
            'motivo_invalidacao.required' => 'O motivo da invalidação é obrigatório para auditoria.',
            'motivo_invalidacao.min' => 'O motivo deve ter pelo menos 5 caracteres. Seja detalhado.',
        ];
    }
}
