<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, string>  $input
     */
    public function update(User $user, array $input): void
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
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => ['required', 'string', 'min:10', 'max:20'],
        ], $messages)->validate();

        $input['newsletter_subscription'] = array_key_exists('newsletter_subscription', $input);
        $input['announcement_subscription'] = array_key_exists('announcement_subscription', $input);

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'major' => $input['major'],
                'email' => $input['email'],
                'phone' => $input['phone'],

                'newsletter_subscription' => $input['newsletter_subscription'],
                'announcement_subscription' => $input['announcement_subscription'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'major' => $input['major'],
            'phone' => $input['phone'],
            'new_email' => $input['email'],
            'newsletter_subscription' => $input['newsletter_subscription'],
            'announcement_subscription' => $input['announcement_subscription'],
        ])->save();

        $tempUser = clone $user;
        $tempUser->email = $user->new_email;

        $tempUser->sendEmailVerificationNotification();
    }
}
