<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class RegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'event_id' => ['required', 'exists:events,id'],
            'naam' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('registrations', 'email')->where(fn($query) => $query->where('event_id', $this->input('event_id'))),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.required' => 'Het evenement is verplicht.',
            'event_id.exists' => 'Het geselecteerde evenement bestaat niet.',

            'naam.required' => 'Je naam is verplicht.',
            'naam.string' => 'Je naam moet een tekst zijn.',
            'naam.max' => 'Je naam mag niet meer dan 255 karakters bevatten.',

            'email.required' => 'Je e-mailadres is verplicht.',
            'email.email' => 'Je e-mailadres moet een geldig e-mailadres zijn.',
            'email.max' => 'Je e-mailadres mag niet meer dan 255 karakters bevatten.',
            'email.unique' => 'Je bent al ingeschreven voor dit evenement met dit e-mailadres.',
        ];
    }
}
