<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0.01',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.exists' => 'A categoria selecionada não existe.',
            'name.string' => 'O nome do produto deve ser um texto.',
            'name.max' => 'O nome do produto não pode exceder 255 caracteres.',
            'price.numeric' => 'O preço do produto deve ser numérico.',
        ];
    }
}
