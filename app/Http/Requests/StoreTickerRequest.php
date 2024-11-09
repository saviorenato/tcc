<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTickerRequest extends FormRequest
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
            'ticker' => 'required',
            'name' => 'required',
            'cnpj' => 'required',
        ];
    }

    public function messages(): array
    {
        return[
            'ticker.required' => 'Campo Ticker é obrigatório!',
            'name.required' => 'Campo Nome é obrigatório!',
            'cnpj.required' => 'Campo CNPJ é obrigatório!',
        ];
    }
}
