@props([
  "name",
  "required" => false,
  "value" => "",
  "title" => "",
  "class" => "",
  "label" => "",
  "multiple" => false,
  "gallery" => null,
])

<div class="mb-4">
  <label class="block text-gray-700 text-sm font-bold mb-1" for="{{ $name }}">
    {{ \Illuminate\Support\Str::of($label)->kebab()->replace("-", " ")->ucfirst() }}
    @if ($required)
      <span class="">*</span>
    @endif
  </label>
    @if ($value && $value !== "assets/images/logo-black.svg")
        <div class="mb-2">
            <a href="{{ asset($value) }}" target="_blank" class="file">
                {{ str_replace(config('app.url').'/storage/', '',$value) ?: 'Bekijk bestand' }}
            </a>
        </div>
    @endif

    @if ($multiple && $gallery->hasPhotos())
        <div class="mb-2 flex flex-wrap gap-2">
            @foreach ($gallery->gallery as $image)
                <a href="{{ asset($gallery->getGalleryImagePath($image)) }}" target="_blank" class="file">{{ $image ?: 'Bekijk bestand' }}</a>
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </div>
    @endif

  <input
    type="file"
    name="{{ $name }}{{ $multiple ? '[]' : '' }}"
    class="border border-gray-400 bg-white rounded-md w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-500 {{ $class }}"
    {{ $multiple ? "multiple" : "" }}
  />
    @error($name)
    <span class="text-xs italic text-red-500">{{ $message }}</span>
    @enderror

    @if ($multiple)
        @error($name . '.*')
        <span class="text-xs italic text-red-500">{{ $message }}</span>
        @enderror
    @endif
</div>
