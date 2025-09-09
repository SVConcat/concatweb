@props(['item', 'alt' => '', 'route' => null, 'word_count' => 20])
<div class="item">
    @if(!Request::is('assignments') && (isset($item->category) && $item->category->value !== \App\Enums\EventCategoryEnum::COMMUNITY->value) && ($item->hasAttribute('banner') || $item->hasAttribute('image')))
        <div class="block image-block">
            <img src="{{ asset($item->banner_url) }}" alt="{{ $alt }}" @if(!$item->banner) class="no-image" @endif>
        </div>
    @endif
    <div class="block text-block">
        <div class="item-header">
            <h3 class="has-background">{{ $item->title }}</h3>
            <h6>{{ $item->category ? __($item->category->value) : '' }}</h6>
            @if(isset($item->location) && $item->location)
                <h6 class="detailed">{{ $item->location}}</h6>
            @endif
        </div>
        <div class="item-body">
            @if($item->reward)
                <p>
                    <strong>{{ __('Beloning') }}:</strong>
                    €{{ $item->reward }}
                </p>
            @endif
            <p>
                {!! Str::of(strip_tags($item->description))->words($word_count, '...') !!}
            </p>

        </div>

        <div class="item-footer">
            @if($route)
                <a href="{{ route($route, [$item->id]) }}" class="button item-button" aria-label="Lees meer over {{ $item->title }}">Lees verder</a>
            @endif
        </div>
    </div>
</div>
