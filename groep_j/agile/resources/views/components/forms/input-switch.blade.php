@props(["name","checked" => false,"disabled" => false, "label" => ''])

<div class="form-group flex items-center my-2">
    <input type="checkbox" name="{{$name}}" id="{{$label}}" @if($checked) checked @endif @if($disabled) disabled @endif class="form-checkbox h-5 w-5 text-blue-600">
    <label for="{{$label}}" class="ms-3">{{ ucfirst($label) }}</label>
</div>
