<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'products.required' => 'É necessário fornecer uma lista de produtos.',
            'products.array' => 'Os produtos devem estar no formato de uma lista.',
            'products.*.product_id.required' => 'O ID do produto é obrigatório.',
            'products.*.product_id.exists' => 'O produto fornecido não existe.',
            'products.*.quantity.required' => 'A quantidade do produto é obrigatória.',
            'products.*.quantity.integer' => 'A quantidade do produto deve ser um número inteiro.',
            'products.*.quantity.min' => 'A quantidade do produto deve ser pelo menos 1.',
        ];
    }
}
