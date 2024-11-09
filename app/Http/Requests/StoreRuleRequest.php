<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRuleRequest extends FormRequest
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
            'name' => 'required',
            'aliquot' => 'required',
            'amount' => 'required',
        ];
    }

    public function messages(): array
    {
        return[
            'name.required' => 'Campo Nome é obrigatório!',
            'aliquot.required' => 'Campo Aliquta é obrigatório!',
            'amount.required' => 'Campo Valor é obrigatório!',
        ];
    }
}
