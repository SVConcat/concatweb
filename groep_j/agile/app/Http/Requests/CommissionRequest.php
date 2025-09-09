<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255|string',
            'description' => 'required|max:65535'

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'De naam is verplicht.',
            'description.required' => 'De omschrijving is verplicht.',
            'description.max' => 'De beschrijving mag niet langer zijn dan 65535 tekens.'

        ];
    }
}
