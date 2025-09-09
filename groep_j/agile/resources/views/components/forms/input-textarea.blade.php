@props([
  "name",
  "required" => false,
  "class" => "",
  "label" => "",
])

<div class="mb-4">
  <label class="block text-gray-700 text-sm font-bold mb-1" for="{{ $name }}">
      {{ ucfirst($label) }}
  @if ($required)
      <span class="">*</span>
    @endif
  </label>
  <textarea
    name="{{ $name }}"
    id="{{ $name }}"
    class="border border-gray-400 bg-white rounded-md w-full h-32 py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-500 resize-none {{ $class }}"
    {{ $required ? "required" : "" }}
  >{{ $slot }}</textarea>
  @error($name)
    <span class="text-xs italic">{{ $message }}</span>
  @enderror
</div>
