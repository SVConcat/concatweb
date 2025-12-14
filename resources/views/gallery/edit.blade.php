<x-layout>
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-lg mt-8">
        <h1 class="text-2xl font-bold mb-6 border-b-4 border-purple-500 pb-1">Foto bewerken</h1>

        <form method="POST" action="{{ route('gallery.update', $gallery) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label class="block mb-2">Titel*</label>
            <input type="text" name="title" value="{{ old('title', $gallery->title) }}"
                   class="w-full mb-4 p-2 border rounded">
            @error('title')
            <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
            @enderror

            <label class="block mb-2">Datum*</label>
            <input type="date" name="date" value="{{ old('date', $gallery->date) }}"
                   class="w-full mb-4 p-2 border rounded">
            @error('date')
            <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
            @enderror

            <label class="block mb-2">Categorie*</label>
            <select name="type" class="w-full mb-4 p-2 border rounded">
                <option value="blokborrel" {{ old('type', $gallery->type) === 'blokborrel' ? 'selected' : '' }}>Blokborrel</option>
                <option value="education" {{ old('type', $gallery->type) === 'education' ? 'selected' : '' }}>Education</option>
            </select>
            @error('type')
            <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
            @enderror

            <label class="block mb-2 font-bold">Evenementen</label>
            <div class="border rounded p-2 mb-4 max-h-60 overflow-y-auto">
                @foreach($evenementen as $evenement)
                    <label class="flex items-center mb-1">
                        <input
                            type="checkbox"
                            name="evenementen[]"
                            value="{{ $evenement->id }}"
                            {{ in_array($evenement->id, old('evenementen', $gallery->evenementen->pluck('id')->toArray())) ? 'checked' : '' }}
                            class="mr-2"
                        >
                        <span>{{ $evenement->titel }}</span>
                    </label>
                @endforeach
            </div>
            @error('evenementen')
            <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
            @enderror

            <label class="block mb-2">Afbeelding</label>
            <input type="file" name="image" id="image" accept="image/*" class="mb-4">
            @error('image')
            <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
            @enderror

            @if($gallery->src)
                <div class="mb-4">
                    <img src="{{ $gallery->image_url }}"
                         alt="Huidige afbeelding"
                         class="w-48 rounded border">
                </div>
            @endif

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Opslaan</button>
        </form>
    </div>
</x-layout>
