<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is verplicht.',
            'email.email' => 'Email moet een geldig e-mailadres zijn.',
            'email.max' => 'Email mag niet langer zijn dan 255 tekens.',

            'password.required' => 'Wachtwoord is verplicht.',
            'password.string' => 'Wachtwoord moet een tekst zijn.',
        ];
    }
}
