<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class SponsorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Naam is verplicht.',
            'name.string' => 'Naam moet een string zijn.',
            'name.max' => 'Naam mag niet langer zijn dan 255 tekens.',

            'logo.image' => 'Logo moet een afbeelding zijn.',
            'logo.mimes' => 'Logo moet een van de volgende formaten hebben: jpeg, png, jpg, gif.',
            'logo.max' => 'Logo mag niet groter zijn dan 2MB.',
        ];
    }
}
