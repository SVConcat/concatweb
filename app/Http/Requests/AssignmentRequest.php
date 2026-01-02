<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|min:10|max:1500',
            'company_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'De titel is verplicht.',
            'title.string' => 'De titel moet een tekst zijn.',
            'title.max' => 'De titel mag niet langer zijn dan 255 tekens.',

            'short_description.required' => 'De korte omschrijving is verplicht.',
            'short_description.string' => 'De korte omschrijving moet een tekst zijn.',
            'short_description.min' => 'De korte omschrijving moet minimaal 10 tekens lang zijn.',
            'short_description.max' => 'De korte omschrijving mag niet langer zijn dan 1500 tekens.',

            'company_name.required' => 'De bedrijfsnaam is verplicht.',
            'company_name.string' => 'De bedrijfsnaam moet een tekst zijn.',
            'company_name.max' => 'De bedrijfsnaam mag niet langer zijn dan 255 tekens.',

            'email.email' => 'Het e-mailadres moet een geldig e-mailadres zijn.',
            'email.string' => 'Het e-mailadres moet een tekst zijn.',
            'email.max' => 'Het e-mailadres mag niet langer zijn dan 255 tekens.',

            'phone_number.string' => 'Het telefoonnummer moet een tekst zijn.',
            'phone_number.max' => 'Het telefoonnummer mag niet langer zijn dan 255 tekens.',
        ];
    }
}
