@extends('admin.index')

@section("title", isset($assignment) ? $assignment->title : 'Create Assignment')

@section("content")
    <div class="container">
        <form method="POST" action="{{ isset($assignment) ? route('admin.assignment.update', ['id' => $assignment->id]) : route('admin.assignment.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($assignment))
                @method('PUT')
            @endif

            <x-forms.input-field type="text" name="title" label="Titel" :required="true" value="{{ old('title', $assignment->title ?? '') }}" />
            <x-forms.input-field type="text" name="company" label="Bedrijf" :required="true" value="{{ old('company', $assignment->company ?? '') }}" />
            <x-forms.input-textarea name="description" label="Omschrijving" :required="true">{{ old('description', $assignment->description ?? '') }}</x-forms.input-textarea>
            <x-forms.input-field type="number" name="reward" label="Beloning" step="any" value="{{ old('reward', $assignment->reward ?? '') }}" />
            <x-forms.input-field type="url" name="url" label="URL" :required="true" value="{{ old('url', $assignment->url ?? '') }}" />
            <x-forms.input-field type="email" name="contact_email" label="Contact Email" :required="true" value="{{ old('contact_email', $assignment->contact_email ?? '') }}" />
            <x-forms.input-field type="text" name="contact_phone" label="Contact Telefoonnummer" :required="true" value="{{ old('contact_phone', $assignment->contact_phone ?? '') }}" />
            <x-forms.input-switch name="active" label="Actief" :checked="old('active', $assignment->active ?? false)" />

            <button type="submit" class="button right">{{ isset($assignment) ? 'Update opdracht' : 'Opdracht creëren ' }}</button>
        </form>

        @if(isset($assignment))
            <x-actions.crud-delete :item="$assignment" route="admin.assignment.delete" title="Opdracht verwijderen" message="Weet je zeker dat je deze opdracht wilt verwijderen?" />
        @endif
    </div>
@endsection
