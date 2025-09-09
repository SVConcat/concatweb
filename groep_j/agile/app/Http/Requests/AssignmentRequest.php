<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'description' => 'required|max:65535',
            'reward' => 'numeric|nullable|max:21474836.47|min:0',
            'url' => 'required|url|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'De titel dient verplicht in te worden gevuld',
            'title.max' => 'De titel mag niet langer zijn dan 255 karakters',
            'company.required' => 'Het bedrijf dient verplicht in te worden gevuld',
            'company.max' => 'Het bedrijf mag niet langer zijn dan 255 karakters',
            'description.required' => 'De beschrijving dient verplicht in te worden gevuld',
            'description.max' => 'De beschrijving mag niet langer zijn dan 65535 karakters',
            'reward.decimal' => 'De beloning dient een decimaal getal te zijn',
            'reward.max' => 'De beloning mag niet groter zijn dan 21474836.47',
            'reward.min' => 'De beloning dient minimaal 0 te zijn',
            'url.required' => 'Een URL is verplicht',
            'url.url' => 'De URL is ongeldig',
            'url.max' => 'De URL mag niet langer zijn dan 255 karakters',
            'contact_email.required' => 'Een contact e-mailadres is verplicht',
            'contact_email.email' => 'Het contact e-mailadres is ongeldig',
            'contact_email.max' => 'Het contact e-mailadres mag niet langer zijn dan 255 karakters',
            'contact_phone.required' => 'Een contact telefoonnummer is verplicht',
            'contact_phone.string' => 'Het contact telefoonnummer is ongeldig',
            'contact_phone.max' => 'Het contact telefoonnummer mag niet langer zijn dan 20 karakters',
        ];
    }
}
