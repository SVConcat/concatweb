@extends("layouts.default")

@section("title", "Events")

@section("content")
    <div class="section">
        <div class="container has-sidebar">
            <div class="items-wrapper">
                <div class="items">
                    @foreach($events as $event)
                        <x-item :item="$event" alt="{{$event->banner ? 'Poster voor '.$event->title : ''}}" route="user.event.show"/>
                    @endforeach
                </div>
                <div class="pagination">
                    {{ $events->links() }}
                </div>
            </div>
            <div class="sidebar">
                <h2 class="has-background">Filters</h2>
                <x-filters.dropdown :onchange="'this.form.submit()'" label="Status" default="Alle statussen" name="status" enum="{{\App\Enums\ActiveTypeEnum::class}}" value="{{ request('status') }}" :params="$bindings"/>
                <x-filters.dropdown :onchange="'this.form.submit()'" label="Categorie" default="Alle categorieën" name="category" enum="{{\App\Enums\EventCategoryEnum::class}}" value="{{ request('category') }}" :params="$bindings"/>
                <a class="button item-button" href="{{ route('user.calender.index') }}">Kalender</a>
            </div>
        </div>
    </div>
@stop
