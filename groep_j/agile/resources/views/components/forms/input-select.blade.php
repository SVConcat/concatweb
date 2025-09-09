@props([
  "name",
  "required" => false,
  "list" => [],
  "enum" => null,
  "value" => "",
  "class" => "",
  "label" => "",
  "default" => "",
  'onchange' => ''
])

<div class="mb-4">
  <label class="block text-gray-700 text-sm font-bold mb-1 {{$label ? '' : 'hidden'}}" for="{{ $name }}">
      {{ ucfirst($label) }}
  @if ($required)
      <span class="">*</span>
    @endif
  </label>

    <div class="relative">
        <select
            onchange="{{ $onchange }}"
            name="{{ $name }}"
            id="{{ $name }}"
            class="border border-gray-400 bg-white rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-500 appearance-none pr-8 {{ $class }}"
            {{ $required ? "required" : "" }}
        >
            <option value="">{{ $default != '' ? $default : 'Selecteer een '.strtolower($label) }}</option>
            @if ($enum)
                @foreach ($enum::cases() as $item)
                    <option
                        value="{{ strtoupper($item->value) }}"
                        {{ $item->value == $value ? "selected" : "" }}
                    >
                        {{ __($item->value) }}
                    </option>
                @endforeach
            @else
                @foreach ($list as $key => $item)
                    <option value="{{ $key }}" {{ $key == $value ? "selected" : "" }}>
                        {{ ucfirst(strtolower(__($item))) }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>
  @error($name)
    <span class="text-xs italic">{{ $message }}</span>
  @enderror
</div>
