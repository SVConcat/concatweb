@extends("admin.index")

@section("title", "Galleries")

@section("content")
    <div class="container">
        <x-forms.input-dropzone attribute="gallery"
                                :model="$gallery"
                                id="homeGallery"
                                label="Gallerij pagina"
                                :metadatas="[
                                                ['type' => 'text', 'name' => 'event_name', 'label' => 'Evenement'],
                                                ['type' => 'date', 'name' => 'event_date', 'label' => 'Datum']
                                            ]"
        />
    </div>
@stop
