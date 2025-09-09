<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatueRequest extends FormRequest
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
            'filepath' => 'required|mimes:pdf|max:2048|file'
        ];
    }



    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'filepath.required' => 'Bestand is verplicht',
            'filepath.mimes' => 'Bestand moet van het type PDF zijn',
            'filepath.max' => 'Bestand mag niet groter zijn dan 2048 kilobytes',
            'filepath.file' => 'Bestand moet een valide bestand zijn',
        ];
    }
}
