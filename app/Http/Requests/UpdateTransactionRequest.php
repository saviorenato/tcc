<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
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
            'type' => 'required',
            'ticker' => 'required',
            'date' => 'required',
            'amount' => 'required',
            'quantity' => 'required',
        ];
    }

    public function messages(): array
    {
        return[
            'type.required' => 'Campo Tipo é obrigatório!',
            'ticker.required' => 'Campo Ticker é obrigatório!',
            'date.required' => 'Campo Data é obrigatório!',
            'amount.required' => 'Campo Valor é obrigatório!',
            'quantity.required' => 'Campo Quantidade é obrigatório!',
        ];
    }
}
