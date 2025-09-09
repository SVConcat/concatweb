@props([
  "name",
  "required" => false,
  "value" => "",
  "class" => "",
  "type" => "text",
  "label" => "",
  "placeholder" => "",
  "step" => ""
])

<div class="mb-4">
  <label class="block text-gray-700 text-sm font-bold mb-1 {{$label ? '' : 'hidden'}}" for="{{ $name }}">

    {{ ucfirst($label) }}
    @if ($required)
      <span class="">*</span>
    @endif
  </label>
  <input
    type="{{ $type }}"
    @if($type === 'number')step="{{ $step }}" @endif
    name="{{ $name }}"
    value="{{ $value }}"
    placeholder="{{ $placeholder }}"
    class="border border-gray-400 bg-white rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-500 {{ $class }}"
    {{ $required ? "required" : "" }}
  />
  @error($name)
    <span class="text-xs italic">{{ $message }}</span>
  @enderror
</div>
