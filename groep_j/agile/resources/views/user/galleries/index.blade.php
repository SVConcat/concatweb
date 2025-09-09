@extends("layouts.default")

@section("title", "Events")

@section("content")
    <section class="section">
        <div class="image-container">
            @if($gallery->hasPhotos())
                @foreach($gallery->gallery as $image)
                    <button type="button" class="image" data-bs-toggle="modal" data-bs-target="#exampleModal{{$loop->index}}">
                        <img src="{{ asset($gallery->getGalleryImagePath($image['path'] ?? $image)) }}" class="gallery-image">
                    </button>
                @endforeach
            @endif
        </div>
    </section>

    @if($gallery->hasPhotos())
        @foreach($gallery->gallery as $image)
            <x-gallerymodal :id="$loop->index" :gallery="$gallery" :image="$image"/>
        @endforeach
    @endif
@stop
