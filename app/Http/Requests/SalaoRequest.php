<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'unidade_id' => 'required|integer',
            'nome' => 'required|string|max:255',
            'ativo' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'unidade_id.required' => 'O campo unidade é obrigatório.',
            'nome.required' => 'O nome do salão é obrigatório.',
            'ativo.required' => 'O status do salão é obrigatório.',
            // 'nome.max' => 'O nome do salão não pode ter mais que 255 caracteres.',
        ];
    }
}
