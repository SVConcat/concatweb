@extends('admin.index')

@section("title", $event->title ?? 'Event')

@section("content")
    <div class="container">
        <form method="POST" action="{{ isset($event) ? route('admin.event.update', ['id' => $event->id]) : route('admin.event.store')}}" enctype="multipart/form-data">
            @csrf
            @if(isset($event))
                @method('PUT')
            @endif
            <x-forms.input-field type="text" name="title" label="Titel" :required="true" value="{{ old('title', $event->title ?? '')}}"/>
            <x-forms.input-textarea name="description" label="Beschrijving" :class="'max-h-[300px]'">{{ old('description',$event->description ?? '')}}</x-forms.input-textarea>
            <x-forms.input-field step="any" type="number" name="price" label="Prijs" value="{{ old('price',$event->price ?? '' )}}"/>
            <x-forms.input-field type="number" name="capacity" label="Aantal plaatsen" value="{{ old('capacity',$event->capacity ?? '' )}}"/>
            <x-forms.input-file name="banner" :title="($event->title ?? '')" label="Afbeelding" value="{{ $event->banner_url ?? '' }}"/>
            <x-forms.input-select name="category" :required="true" label="Categorie" :enum="$categories" value="{{old('category', $event->category->value ?? '')}}"/>
            <x-forms.input-field type="url" name="payment_link" label="Betaal link" value="{{old('payment_link',$event->payment_link ?? '')}}"/>
            <x-forms.input-switch name="is_open" label="Inschrijven mogelijk?" :checked="old('is_open', $event->is_open ?? false)"/>
            <x-forms.input-field name="location" label="Locatie" value="{{old('location',$event->location ?? '')}}"/>
            <x-forms.input-field type="datetime-local" name="start_date" :required="true" label="Datum / Start datum" value="{{ old('start_date', isset($event) ? $event->getFormattedDateForInput($event->start_date) : '' ) }}"/>
            <x-forms.input-field type="datetime-local" name="end_date" label="Eind datum" value="{{ old('end_date', isset($event) ? $event->getFormattedDateForInput($event->end_date) : '' )}}"/>
            <x-forms.input-select name="weeztix_event_id" label="Weeztix evenement" :list="$weeztixEvents" value="{{ old('weeztix_event_id', $event->weeztix_event_id ?? '') }}"/>

            @if($sponsors->count() > 0)
                <h2 class="mt-4">Sponsoren</h2>
                @foreach($sponsors as $sponsor)
                    <x-forms.input-checkbox name="sponsors[]" :value="$sponsor->id" :label="$sponsor->name" :checked="isset($event) && $event->sponsors->contains($sponsor->id)"/>
                @endforeach
            @endif
            <x-discord-modal />
            @if(!isset($event) || $event->status->name !== 'ARCHIVED')
                <button id="openModalButton" type="button" class="button right hidden" data-modal-id="dateModal">{{ isset($event) ? 'Evenement updaten' : 'Evenement toevoegen' }}</button>
            @endif
            <button id="submitButton" type="submit" class="button right" data-state="{{$event->status->name ?? ''}}">{{ isset($event) ? 'Evenement updaten' : 'Evenement toevoegen' }}</button>
            <x-modal id="dateModal" title="Datum formatting" message="Ingevoerde datum ligt vóór de huidige datum. Klopt dit?" />
        </form>
        @if(isset($event))
            <x-actions.crud-delete :item="$event" route="admin.event.delete" title="Evenement verwijderen" message="Weet je zeker dat je deze wilt verwijderen?" />
        @endif

        @if(isset($event) && $event->status->name === 'ARCHIVED')
            <x-forms.input-dropzone attribute="gallery" :model="$event" id="eventGallery" label="Gallerij"/>
        @endif
    </div>
@stop
