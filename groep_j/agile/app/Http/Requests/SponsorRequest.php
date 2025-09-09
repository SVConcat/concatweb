<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SponsorRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:65535',
            'image' => ['image', 'mimes:jpeg,jpg,png,gif,svg', 'max:2048', Rule::requiredIf(function () {
                return $this->request->get('image') === null && DB::table('sponsors')->where('id', $this->route('id'))->value('image') === null;
            })],
            'active' => 'required',
            'url' => 'required|url|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => "Naam is verplicht",
            'name.string' => "Naam moet een string zijn",
            'name.max' => "Naam mag niet groter zijn dan 255 karakters",
            'description.string' => "Beschrijving moet een string zijn",
            'description.max' => "Beschrijving mag niet groter zijn dan 65535 karakters",
            'image.image' => "Afbeelding moet een afbeelding zijn",
            'image.mimes' => "Afbeelding moet een bestand zijn van type: jpeg, png, jpg, gif, svg",
            'image.max' => "Afbeelding mag niet groter zijn dan 2048 kilobytes",
            'active.required' => 'Status is verplicht',
            'image.required' => "Afbeelding is verplicht",
            'url.required' => "URL is verplicht",
            'url.url' => "URL moet een geldige URL zijn",
            'url.max' => "URL mag niet groter zijn dan 255 karakters",
        ];
    }
}
