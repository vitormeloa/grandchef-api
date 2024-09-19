<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'status' => 'sometimes|in:open,approved,completed,canceled',
            'products' => 'sometimes|array',
            'products.*.product_id' => 'sometimes|exists:products,id',
            'products.*.quantity' => 'sometimes|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'O status deve ser um dos seguintes: open, approved, completed, canceled.',
            'products.array' => 'Os produtos devem estar no formato de uma lista.',
            'products.*.product_id.exists' => 'O produto fornecido não existe.',
            'products.*.quantity.integer' => 'A quantidade do produto deve ser um número inteiro.',
            'products.*.quantity.min' => 'A quantidade do produto deve ser pelo menos 1.',
        ];
    }
}
