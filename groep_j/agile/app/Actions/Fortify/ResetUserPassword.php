<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and reset the user's forgotten password.
     *
     * @param  array<string, string>  $input
     */
    public function reset(User $user, array $input): void
    {
        Validator::make($input, [
            'password' => [
                $this->passwordRules(),
                function ($attribute, $value, $fail) use ($user) {
                    if (Hash::check($value, $user->password)) {
                        $fail('Het nieuwe wachtwoord mag niet hetzelfde zijn als het huidige wachtwoord.');
                    }
                },
            ],
        ], [
            'password.required' => 'Een nieuw wachtwoord is verplicht.',
            'password.confirmed' => 'Het wachtwoord en de bevestiging komen niet overeen.',
            'password.min' => 'Het wachtwoord moet minimaal 8 tekens bevatten.',
        ])->validate();

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
