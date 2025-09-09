@props(['item', 'alt' =>'', 'route'])
<div class="comiboard">
    <div class="block text-block">
        <div class="image-inline">
            <img src="{{ asset($item->image_url)}}" alt="{{$alt}}" @if(!$item->image_url) class="no-image" @endif>
        </div>
        <div class="item-header">
            <h3 class="has-background">{{$item->name}}</h3>
            <h6>{{$item->role}}</h6>
        </div>
        <div class="item-body">
            <p>
                {{$item->description}}
            </p>
        </div>
    </div>
</div>

