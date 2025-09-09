@props([
  "name",
  "list" => [],
  "enum" => null,
  "label" => "",
  "default" => "",
  "params" => [],
  "class" => "",
])

<form method="GET" action="{{ route(Route::currentRouteName()) }}" class="dropdown">
    @foreach($params as $paramMame)
        @if($paramMame === $name)
            @continue
        @endif
            <input type="hidden" name="{{ $paramMame }}" value="{{ request($paramMame) }}">
    @endforeach
    <x-forms.input-select :onchange="'this.form.submit()'" label="{{$label}}" default="{{$default}}" name="{{$name}}" :list="$list" enum="{{$enum}}" value="{{ request($name) }}" class="{{$class}}"/>
</form>
