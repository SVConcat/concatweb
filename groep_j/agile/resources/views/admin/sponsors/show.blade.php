@extends('admin.index')

@section("title", $sponsor->name ?? 'Sponsor')

@section("content")
    <div class="container">
        <form method="POST" action="{{ isset($sponsor) ? route('admin.sponsor.update', ['id' => $sponsor->id]) : route('admin.sponsor.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($sponsor))
                @method('PUT')
            @endif
            <x-forms.input-field type="text" name="name" label="Naam" :required="true" value="{{ old('name', $sponsor->name ?? '') }}"/>
            <x-forms.input-textarea name="description" label="Beschrijving" :class="'min-h-[100px] max-h-[300px]'">{{ old('description', $sponsor->description ?? '') }}</x-forms.input-textarea>
            <x-forms.input-file name="image" :required="true" label="Afbeelding" :title="($sponsor->name ?? '')" value="{{ $sponsor->image_url ?? '' }}"/>
            <x-forms.input-select name="active" :required="true" label="Status" :list="$types" value="{{ old('active', $sponsor->active ?? '') }}"/>
            <x-forms.input-field type="url" name="url" label="Url" :required="true" value="{{ old('url', $sponsor->url ?? '') }}"/>

            @if($events->count() > 0)
                <h2 class="mt-4">Events</h2>
                @foreach($events as $event)
                    <x-forms.input-checkbox name="events[]" :value="$event->id" :label="$event->title" :checked="isset($sponsor) && $sponsor->events->contains($event->id)"/>
                @endforeach
            @endif
            <button type="submit" class="button right">{{ isset($sponsor) ? 'Sponsor updaten' : 'Sponsor toevoegen' }}</button>
        </form>
        @if(isset($sponsor))
            <x-actions.crud-delete :item="$sponsor" route="admin.sponsor.delete" title="Sponsor verwijderen" message="Weet je zeker dat je deze wilt verwijderen?" />
        @endif
    </div>
@stop
