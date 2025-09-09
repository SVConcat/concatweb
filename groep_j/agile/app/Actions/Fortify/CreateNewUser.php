<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $messages = [
            'name.required' => 'De naam is verplicht.',
            'name.string' => 'De naam moet een geldige tekst zijn.',
            'name.max' => 'De naam mag maximaal 255 tekens bevatten.',

            'major.required' => 'De major is verplicht.',
            'major.string' => 'De major moet een geldige tekst zijn.',
            'major.in' => 'De major moet ofwel "SO" of "BI" zijn.',

            'email.required' => 'Het e-mailadres is verplicht.',
            'email.string' => 'Het e-mailadres moet een geldige tekst zijn.',
            'email.email' => 'Voer een geldig e-mailadres in.',
            'email.max' => 'Het e-mailadres mag maximaal 255 tekens bevatten.',
            'email.unique' => 'Dit e-mailadres is al in gebruik.',
            'email.regex' => 'Dit e-mailadres heeft een ongeldig formaat',

            'phone.required' => 'Het telefoonnummer is verplicht.',
            'phone.string' => 'Het telefoonnummer moet een geldige tekst zijn.',
            'phone.min' => 'Het telefoonnummer moet minimaal 10 tekens bevatten.',
            'phone.max' => 'Het telefoonnummer mag maximaal 20 tekens bevatten.',

            'password.required' => 'Het wachtwoord is verplicht.',
            'password.min' => 'Het wachtwoord moet minimaal 8 tekens lang zijn.',
            'password.confirmed' => 'Het wachtwoord en de bevestiging komen niet overeen.'
        ];

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'major' => ['required', 'string', 'in:SO,BI'],
            'email' => [
                'required',
                'string',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'max:255',
                Rule::unique(User::class),
            ],
            'phone' => ['required', 'string', 'min:10', 'max:20'],
            'password' => $this->passwordRules(),
        ], $messages)->validate();

        return User::create([
            'name' => $input['name'],
            'major' => $input['major'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
