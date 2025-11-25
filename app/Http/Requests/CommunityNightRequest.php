<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommunityNightRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'required|string|min:10|max:1500',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'location' => 'required|string|max:255',
            'link' => 'nullable|url|max:1500',
            'capacity' => 'nullable|integer|min:0|max:999',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Titel is verplicht.',
            'title.string' => 'Titel moet een tekst zijn.',
            'title.max' => 'Titel mag niet meer dan 255 karakters bevatten.',

            'description.required' => 'Beschrijving is verplicht.',
            'description.string' => 'Beschrijving moet een tekst zijn.',
            'description.min' => 'Beschrijving moet minstens 10 karakters bevatten.',
            'description.max' => 'Beschrijving mag niet meer dan 1500 karakters bevatten.',

            'start_time.required' => 'Starttijd is verplicht.',
            'start_time.date' => 'Starttijd moet een geldige datum zijn.',

            'end_time.required' => 'Eindtijd is verplicht.',
            'end_time.date' => 'Eindtijd moet een geldige datum zijn.',
            'end_time.after_or_equal' => 'Eindtijd moet op of na de starttijd zijn.',

            'location.required' => 'Locatie is verplicht.',
            'location.string' => 'Locatie moet een tekst zijn.',
            'location.max' => 'Locatie mag niet meer dan 255 karakters bevatten.',

            'link.nullable' => 'Link is optioneel.',
            'link.url' => 'Link moet een geldige URL zijn.',
            'link.max' => 'Link mag niet meer dan 1500 karakters bevatten.',

            'capacity.nullable' => 'Capaciteit is optioneel.',
            'capacity.integer' => 'Capaciteit moet een geheel getal zijn.',
            'capacity.min' => 'Capaciteit mag niet minder dan 0 zijn.',
            'capacity.max' => 'Capaciteit mag niet meer dan 100 zijn.',

            'image.nullable' => 'Afbeelding is optioneel.',
            'image.image' => 'De afbeelding moet een geldig afbeeldingsbestand zijn.',
            'image.mimes' => 'De afbeelding moet van het type jpeg, png, jpg of webp zijn.',
            'image.max' => 'De afbeelding mag niet groter zijn dan 2 MB.'
        ];
    }
}
