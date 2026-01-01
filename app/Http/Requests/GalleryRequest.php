<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:blokborrel,education',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'evenementen' => 'nullable|array',
            'evenementen.*' => 'exists:events,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'De titel is verplicht.',
            'title.string' => 'De titel moet een tekst zijn.',
            'title.max' => 'De titel mag niet meer dan 255 karakters bevatten.',

            'date.required' => 'De datum is verplicht.',
            'date.date' => 'De datum moet een geldige datum zijn.',

            'type.required' => 'Het type evenement is verplicht.',
            'type.in' => 'De geselecteerde categorie is ongeldig. Geldige opties zijn: blokborrel, education.',

            'images.required' => 'Er moet minimaal één afbeelding worden geüpload.',
            'images.array' => 'De afbeeldingen moeten in een array worden aangeleverd.',

            'images.*.image' => 'Alle bestanden moeten geldige afbeeldingen zijn.',
            'images.*.mimes' => 'Afbeeldingen moeten een van de volgende formaten hebben: jpeg, png, jpg, gif.',
            'images.*.max' => 'Elke afbeelding mag niet groter zijn dan 2MB.',

            'evenementen.nullable' => 'De evenementen zijn optioneel.',
            'evenementen.array' => 'De evenementen moeten in een array worden aangeleverd.',

            'evenementen.*.exists' => 'Een van de geselecteerde evenementen bestaat niet in de database.',
        ];
    }
}
