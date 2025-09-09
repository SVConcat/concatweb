<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BoardMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255|string',
            'role' => 'required|max:255|string',
            'description' => 'nullable|max:65535|',
            'image' => 'image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'De naam is verplicht.',
            'role.required' => 'De rol is verplicht.',
            'description.max' => 'De beschrijving mag niet langer zijn dan 65535 tekens.',
            'image.image' => 'Het gekozen bestand moet een afbeelding zijn.',
            'image.mimes' => 'Alleen jpeg, jpg, png, svg en webp bestanden zijn toegestaan.',
            'image.max' => 'De afbeelding mag niet groter zijn dan 2MB.',
        ];
    }
}
