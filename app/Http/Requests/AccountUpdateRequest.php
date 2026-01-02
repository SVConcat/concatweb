<?php

namespace App\Http\Requests;

use App\Rules\MatchesCurrentPassword;
use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = auth()->user();

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => ['nullable', 'required_with:password', new MatchesCurrentPassword],
            'password' => 'nullable|confirmed|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Naam is verplicht.',
            'name.string' => 'Naam moet een tekenreeks zijn.',
            'name.max' => 'Naam mag niet langer zijn dan 255 tekens.',

            'email.required' => 'E-mailadres is verplicht.',
            'email.email' => 'Voer een geldig e-mailadres in.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',

            'current_password.required_with' => 'Uw huidige wachtwoord is vereist om het nieuwe wachtwoord te wijzigen.',

            'password.confirmed' => 'De wachtwoorden komen niet overeen.',
            'password.min' => 'Het wachtwoord moet minimaal 8 tekens bevatten.',
        ];
    }
}
