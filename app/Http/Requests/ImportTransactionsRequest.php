<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportTransactionsRequest extends FormRequest
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
            'file' => 'required|file|mimes:xlsx,xls',
        ];
    }

    public function messages(): array
    {
        return[
            'file.required' => 'Um arquivo é necessário!',
            'file.file' => 'O arquivo deve ser um arquivo (xlsx ou xls).',
            'file.mimes' => 'O arquivo deve ser um arquivo (xlsx ou xls).',
        ];
    }
}
