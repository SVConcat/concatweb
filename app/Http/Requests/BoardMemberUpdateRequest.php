<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BoardMemberUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'required|string|min:10',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Naam is verplicht.',
            'name.string' => 'Naam moet een tekst zijn.',
            'name.max' => 'Naam mag niet langer zijn dan 255 tekens.',

            'role.required' => 'Rol is verplicht.',
            'role.string' => 'Rol moet een tekst zijn.',
            'role.max' => 'Rol mag niet langer zijn dan 255 tekens.',

            'bio.required' => 'Bio is verplicht.',
            'bio.string' => 'Bio moet een tekst zijn.',
            'bio.min' => 'Bio moet minimaal 10 tekens bevatten.',

            'photo.nullable' => 'Afbeelding is optioneel.',
            'photo.image' => 'De afbeelding moet een geldig afbeeldingsbestand zijn.',
            'photo.mimes' => 'De afbeelding moet van het type jpeg, png, jpg of webp zijn.',
            'photo.max' => 'De afbeelding mag niet groter zijn dan 2 MB.'
        ];
    }

    protected function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator): void
    {
        $this->session()->put('errors',$validator->errors()->toArray());

        Log::warning('Validatiefouten in BoardMemberUpdateRequest', [
            'errors' => $validator->errors()->toArray(),
        ]);

        parent::failedValidation($validator); // laat Laravel de standaard redirect doen
    }


}
