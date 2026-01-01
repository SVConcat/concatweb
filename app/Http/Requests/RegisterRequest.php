<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Naam is verplicht.',
            'name.string' => 'Naam moet een tekst zijn.',
            'name.max' => 'Naam mag niet langer zijn dan 150 tekens.',

            'email.required' => 'Email is verplicht.',
            'email.email' => 'Email moet een geldig e-mailadres zijn.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',

            'password.required' => 'Wachtwoord is verplicht.',
            'password.string' => 'Wachtwoord moet een tekst zijn.',
            'password.min' => 'Wachtwoord moet minimaal 8 tekens lang zijn.',
            'password.confirmed' => 'Wachtwoord bevestiging komt niet overeen.',
        ];
    }
}
