<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titel' => 'required|string|max:255',
            'inhoud' => 'required|string|max:1500',
        ];
    }

    public function messages(): array
    {
        return [
            'titel.required' => 'De titel is verplicht.',
            'titel.string' => 'De titel moet een geldige tekst zijn.',
            'titel.max' => 'De titel mag niet langer zijn dan 255 tekens.',

            'inhoud.required' => 'De inhoud is verplicht.',
            'inhoud.string' => 'De inhoud moet een geldige tekst zijn.',
            'inhoud.max' => 'De inhoud mag niet langer zijn dan 1500 tekens.',
        ];
    }
}
