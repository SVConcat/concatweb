@props(['item', 'id' => 'gallerySwiper'])

@if($item instanceof \Illuminate\Database\Eloquent\Model && $item->hasPhotos())
    <div class="swiper-container" id="{{ $id }}">
        <div class="swiper-wrapper">
            @foreach($item->gallery as $image)
                <div class="swiper-slide">
                    <img src="{{ asset($item->getGalleryImagePath($image)) }}" alt="">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
@elseif($item instanceof \Illuminate\Database\Eloquent\Collection && $item->isNotEmpty())
    <div class="swiper-container" id="{{ $id }}">
        <div class="swiper-wrapper">
            @foreach($item as $subItem)
                <div class="swiper-slide">

                    <img src="{{ asset($subItem->image_url) }}" alt="">
                    @if($subItem->term)
                        <h3>{{$subItem->term}}</h3>
                        <h3>{{$subItem->names}}</h3>
                    @endif

                </div>

            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
@endif
