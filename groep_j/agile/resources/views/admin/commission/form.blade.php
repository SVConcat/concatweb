@extends('admin.index')

@section("title", isset($commission) ? 'Bewerk commissie' : 'Voeg commissie toe')

@section("content")
    <div class="container">
        @if(isset($commission))
            <form method="POST" action="{{ route('admin.commission.update', ['id' => $commission->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                @else
                    <form method="POST" action="{{ route('admin.commission.store') }}" enctype="multipart/form-data">
                        @csrf
                        @endif

                        <x-forms.input-field type="text" name="name" label="Naam" required value="{{ old('name', $commission->name ?? '') }}"/>
                        <x-forms.input-textarea name="description" label="Omschrijving" required>{{ old('description', $commission->description ?? '') }}</x-forms.input-textarea>

                        <button type="submit" class="button right">{{ isset($commission) ? 'Bewerk commissie' : 'Voeg commissie toe' }}</button>
                    </form>

                    @if(isset($commission))
                        <x-actions.crud-delete
                            :item="$commission"
                            route="admin.commission.delete"
                            title="Commissie verwijderen"
                            message="Weet je zeker dat je deze commissie wilt verwijderen?"
                        />
                    @endif
    </div>
@stop
