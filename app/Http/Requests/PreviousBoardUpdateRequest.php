<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreviousBoardUpdateRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'FromYear' => 'required|date',
            'ToYear' => 'required|date|after_or_equal:FromYear',
            'members' => 'required|string|min:5|max:200',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'FromYear.required' => 'Begin datum is verplicht.',
            'FromYear.date' => 'Begin datum moet een geldige datum zijn.',

            'ToYear.required' => 'Eind datum is verplicht.',
            'ToYear.date' => 'Eind datum moet een geldige datum zijn.',
            'ToYear.after_or_equal' => 'Einddatum moet op of na de begindatum zijn.',

            'members.required' => 'Ledenbeschrijving is verplicht.',
            'members.string' => 'Leden beschrijving moet een tekst zijn.',
            'members.min' => 'Ledenbeschrijving moet minstens 5 karakters bevatten.',
            'members.max' => 'Ledenbeschrijving mag niet meer dan 200 karakters bevatten.',

            'photo.nullable' => 'Afbeelding is optioneel.',
            'photo.image' => 'De afbeelding moet een geldig afbeeldingsbestand zijn.',
            'photo.mimes' => 'De afbeelding moet van het type jpeg, png, jpg of webp zijn.',
            'photo.max' => 'De afbeelding mag niet groter zijn dan 2 MB.'
        ];
    }
}
