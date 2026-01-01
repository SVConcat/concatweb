<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoosterRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ical_url' => 'required|url|unique:roosters,ical_url',
            'klas' => 'required|integer|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'ical_url.required' => 'De iCal URL is verplicht.',
            'ical_url.url' => 'De iCal URL moet een geldige URL zijn.',
            'ical_url.unique' => 'Deze iCal URL is al toegevoegd.',

            'klas.required' => 'De klas is verplicht.',
            'klas.integer' => 'De klas moet een geheel getal zijn.',
            'klas.max' => 'De klas mag niet groter zijn dan 255.',
        ];
    }
}
