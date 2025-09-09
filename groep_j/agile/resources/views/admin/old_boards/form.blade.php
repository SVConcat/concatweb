@extends('admin.index')

@section("title", isset($oldBoard) ? 'Bewerk oud bestuur' : 'Voeg oud bestuur toe')

@section("content")
    <div class="container">
        @if(isset($oldBoard))
            <form method="POST" action="{{ route('admin.old_boards.update', ['id' => $oldBoard->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                @else
                    <form method="POST" action="{{ route('admin.old_boards.store') }}" enctype="multipart/form-data">
                        @csrf
                        @endif

                        <x-forms.input-field type="text" name="names" label="Namen" required value="{{ old('names', $oldBoard->names ?? '') }}"/>
                        <x-forms.input-field type="text" name="term" label="Termijn (bijv. 2024/2025)" required value="{{ old('term', $oldBoard->term ?? '') }}"/>
                        <x-forms.input-file name="image" label="Groepsfoto" value="{{ $oldBoard->image_url ?? '' }}"/>

                        <button type="submit" class="button right">{{ isset($oldBoard) ? 'Bewerk oud bestuur' : 'Voeg oud bestuur toe' }}</button>
                    </form>

                    @if(isset($oldBoard))
                        <x-actions.crud-delete
                            :item="$oldBoard"
                            route="admin.old_boards.delete"
                            title="Oud bestuur verwijderen"
                            message="Weet je zeker dat je dit oud bestuur wilt verwijderen?"
                        />
                    @endif


    </div>
@stop
