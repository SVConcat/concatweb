<?php

namespace App\Http\Requests;

use App\Enums\EventCategoryEnum;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'max:65535',
            'price' => 'numeric|max:2147483647|nullable|min:0',
            'capacity' => 'numeric|max:2147483647|nullable|min:0',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category' => 'required|string|in:'.implode(',', EventCategoryEnum::toArray()),
            'payment_link' => 'nullable|url|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'weeztix_event_id' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'De titel dient verplicht in te worden gevuld',
            'title.max' => 'De titel mag niet langer zijn dan 255 karakters',
            'description.required' => 'De beschrijving dient verplicht in te worden gevuld',
            'description.max' => 'De beschrijving mag niet langer zijn dan 65535 karakters',
            'price.numeric' => 'De prijs dient een nummer te zijn',
            'price.max' => 'De prijs mag niet groter zijn dan 2147483647',
            'capacity.numeric' => 'De capaciteit dient een nummer te zijn',
            'capacity.max' => 'De capaciteit mag niet groter zijn dan 2147483647',
            'capacity.min' => 'De capaciteit dient minimaal 0 te zijn',
            'banner.image' => 'Het bestand dient een afbeelding te zijn',
            'banner.mimes' => 'De afbeelding dient een bestand te zijn van het type: jpeg, png, jpg, gif, svg',
            'banner.max' => 'De afbeelding mag niet groter zijn dan 2048 kilobytes',
            'payment_link.max' => 'De betaallink mag niet langer zijn dan 255 karakters',
            'payment_link.url' => 'De betaallink dient een URL te zijn',
            'category.required' => 'Een categorie is verplicht',
            'category.in' => 'De geselecteerde categorie is ongeldig',
            'location.max' => 'De locatie mag niet langer zijn dan 255 karakters',
            'start_date.required' => 'De startdatum dient verplicht in te worden gevuld',
            'start_date.date' => 'De startdatum dient een datum te zijn',
            'end_date.date' => 'De einddatum dient een datum te zijn',
            'end_date.after_or_equal' => 'De einddatum dient na of gelijk te zijn aan de startdatum',
        ];
    }
}
