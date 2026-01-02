<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class NewsletterCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titel' => 'required|string|max:255|unique:newsletters,titel',
            'publicatiedatum' => 'required|date',
            'events' => 'required|array|min:1',
            'events.*.titel' => 'required|string|max:255',
            'events.*.datum' => 'nullable|date',
            'events.*.tijd' => 'nullable|string',
            'events.*.locatie' => 'nullable|string|max:255',
            'events.*.inhoud' => 'required|string|min:10|max:1500',
            'event_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'titel.required' => 'De titel van de nieuwsbrief is verplicht.',
            'titel.string' => 'De titel van de nieuwsbrief moet een tekst zijn.',
            'titel.max' => 'De titel van de nieuwsbrief mag niet meer dan 255 karakters bevatten.',
            'titel.unique' => 'Er bestaat al een nieuwsbrief met deze titel.',

            'publicatiedatum.required' => 'De publicatiedatum van de nieuwsbrief is verplicht.',
            'publicatiedatum.date' => 'De publicatiedatum van de nieuwsbrief moet een geldige datum zijn.',

            'events.required' => 'Er moet ten minste één evenement worden toegevoegd aan de nieuwsbrief.',
            'events.array' => 'De evenementen moeten in een lijst worden aangeleverd.',
            'events.min' => 'Er moet ten minste één evenement worden toegevoegd aan de nieuwsbrief.',

            'events.*.titel.required' => 'De titel van elk evenement is verplicht.',
            'events.*.titel.string' => 'De titel van elk evenement moet een tekst zijn.',
            'events.*.titel.max' => 'De titel van elk evenement mag niet meer dan 255 karakters bevatten.',

            'events.*.datum.nullable' => 'De datum van elk evenement is optioneel.',
            'events.*.datum.date' => 'De datum van elk evenement moet een geldige datum zijn.',

            'events.*.tijd.string' => 'De tijd van elk evenement moet een tekst zijn.',

            'events.*.locatie.string' => 'De locatie van elk evenement moet een tekst zijn.',
            'events.*.locatie.max' => 'De locatie van elk evenement mag niet meer dan 255 karakters bevatten.',

            'events.*.inhoud.required' => 'De inhoud van elk evenement is verplicht.',
            'events.*.inhoud.string' => 'De inhoud van elk evenement moet een tekst zijn.',
            'events.*.inhoud.min' => 'De inhoud van elk evenement moet minstens 10 karakters bevatten.',
            'events.*.inhoud.max' => 'De inhoud van elk evenement mag niet meer dan 1500 karakters bevatten.',

            'event_images.*.nullable' => 'Afbeeldingen zijn optioneel.',
            'event_images.*.image' => 'Alle geüploade bestanden moeten afbeeldingen zijn.',
            'event_images.*.mimes' => 'Alle geüploade afbeeldingen moeten in het formaat jpeg, png, jpg of gif zijn.',
            'event_images.*.max' => 'Elke afbeelding mag maximaal 2 MB zijn.',
        ];
    }
}
