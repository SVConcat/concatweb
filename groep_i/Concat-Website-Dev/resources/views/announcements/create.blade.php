<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-5xl mt-5 mb-5">
        <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1">
            Announcement aanmaken
        </h1>

        <form method="POST" action="{{ route('announcements.store') }}" class="mt-4 space-y-4">
            @csrf

            <div>
                <label for="titel" class="block text-l font-bold">Titel*</label>
                <input type="text" name="titel" id="titel" value="{{ old('titel') }}"
                       placeholder="Titel van het event"
                       class="w-full p-2 {{ $errors->has('titel') ? 'bg-red-100 border-red-500' : 'bg-purple-100 border-purple-300' }} text-purple-700 rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                @error('titel')
                <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="inhoud" class="block text-l font-bold">Inhoud*</label>
                <textarea name="inhoud" id="inhoud" rows="5"
                          placeholder="Beschrijving van de announcement"
                          class="w-full p-2 {{ $errors->has('inhoud') ? 'bg-red-100 border-red-500' : 'bg-purple-100 border-purple-300' }} text-purple-700 rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">{{ old('inhoud') }}</textarea>
                @error('inhoud')
                <p class="text-red-600 text-sm mt-1 font-bold">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                <button type="submit" name="action" value="publish"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                    Publiceren
                </button>
                <button type="submit" name="action" value="draft"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                    Opslaan als concept
                </button>
            </div>
        </form>
    </div>
</x-layout>
