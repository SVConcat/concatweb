<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titel' => 'required|string|max:255',
            'categorie' => 'required|in:blokborrel,education',
            'datum' => 'required|date',
            'einddatum' => 'required|date',
            'starttijd' => 'required|date_format:H:i',
            'eindtijd' => 'required|date_format:H:i',
            'beschrijving' => 'required|string|min:10|max:1500',
            'locatie' => 'required|string|max:255',
            'aantal_beschikbare_plekken' => 'nullable|integer|max:999',
            'betaal_link' => 'nullable|url|max:1500',
            'afbeelding' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'titel.required' => 'De titel van het evenement is verplicht.',
            'titel.string' => 'De titel van het evenement moet een tekst zijn.',
            'titel.max' => 'De titel van het evenement mag niet meer dan 255 karakters bevatten.',

            'categorie.required' => 'De categorie van het evenement is verplicht.',
            'categorie.in' => 'De geselecteerde categorie is ongeldig. Geldige opties zijn: blokborrel, education.',

            'datum.required' => 'De datum van het evenement is verplicht.',
            'datum.date' => 'De datum van het evenement moet een geldige datum zijn.',

            'starttijd.required' => 'De starttijd van het evenement is verplicht.',
            'starttijd.date_format' => 'De starttijd van het evenement moet in het formaat HH:MM zijn.',

            'eindtijd.required' => 'De eindtijd van het evenement is verplicht.',
            'eindtijd.date_format' => 'De eindtijd van het evenement moet in het formaat HH:MM zijn.',

            'beschrijving.required' => 'De beschrijving van het evenement is verplicht.',
            'beschrijving.string' => 'De beschrijving van het evenement moet een tekst zijn.',
            'beschrijving.min' => 'De beschrijving van het evenement moet minstens 10 karakters bevatten.',
            'beschrijving.max' => 'De beschrijving van het evenement mag niet meer dan 1500 karakters bevatten.',

            'locatie.required' => 'De locatie van het evenement is verplicht.',
            'locatie.string' => 'De locatie van het evenement moet een tekst zijn.',
            'locatie.max' => 'De locatie van het evenement mag niet meer dan 255 karakters bevatten.',

            'aantal_beschikbare_plekken.nullable' => 'Het aantal beschikbare plekken is optioneel.',
            'aantal_beschikbare_plekken.integer' => 'Het aantal beschikbare plekken moet een geheel getal zijn.',
            'aantal_beschikbare_plekken.max' => 'Het aantal beschikbare plekken mag niet meer dan 999 zijn.',

            'betaal_link.nullable' => 'De betaal link is optioneel.',
            'betaal_link.url' => 'De betaal link moet een geldige URL zijn.',
            'betaal_link.max' => 'De betaal link mag niet meer dan 1500 karakters bevatten.',

            'afbeelding.nullable' => 'Afbeelding is optioneel.',
            'afbeelding.image' => 'De afbeelding moet een geldig afbeeldingsbestand zijn.',
            'afbeelding.mimes' => 'De afbeelding moet een bestand zijn van het type: jpeg, png, jpg, gif.',
            'afbeelding.max' => 'De afbeelding mag niet groter zijn dan 2MB.'
        ];
    }
}
