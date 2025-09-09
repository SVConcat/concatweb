@props(['label' => '', 'placeholder' => 'Zoeken...', 'params' => [], 'class' => ''])

<form method="GET" action="{{ route(Route::currentRouteName()) }}" class="searchbar">
    @foreach($params as $name)
        @if($name === 'search')
            @continue
        @endif
        <input type="hidden" name="{{ $name }}" value="{{ request($name) }}">
    @endforeach
    <x-forms.input-field label="{{$label}}" type="search" name="search" placeholder="{{$placeholder}}" value="{{ request('search') }}" class="{{$class}}"/>
</form>
