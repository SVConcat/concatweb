<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-5xl mb-5">
        <h1 class="text-2xl font-bold border-b-4 border-yellow-500 inline-block pb-1">
            Announcement bewerken
        </h1>

        <form method="POST" action="{{ route('announcements.update', $announcement->id) }}" class="mt-4 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="titel" class="block text-lg font-bold">*Titel:</label>
                <input type="text" name="titel" id="titel" value="{{ old('titel', $announcement->titel) }}" required
                       class="w-full p-2 {{ $errors->has('titel') ? 'bg-red-100 border-red-500' : 'bg-yellow-50 border-yellow-200' }} text-yellow-700 rounded-lg border focus:ring-2 focus:ring-yellow-500">
                @error('titel')
                <div class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="inhoud" class="block text-lg font-bold">*Inhoud:</label>
                <textarea name="inhoud" id="inhoud" rows="5" required
                          class="w-full p-2 {{ $errors->has('inhoud') ? 'bg-red-100 border-red-500' : 'bg-yellow-50 border-yellow-200' }} text-yellow-700 rounded-lg border focus:ring-2 focus:ring-yellow-500">{{ old('inhoud', $announcement->inhoud) }}</textarea>
                @error('inhoud')
                <div class="text-red-500 text-sm mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-end space-x-4">
                @if ($announcement->isVisible)
                    {{-- Show "Bijwerken" button if the announcement is already published --}}
                    <x-form-button type="submit" name="action" value="update">
                        Bijwerken
                    </x-form-button>
                @else

                <x-form-button type="submit" name="action" value="save">
                    Opslaan
                </x-form-button>
                    <button type="submit" name="action" value="publish"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold transition">
                        Publiceer
                    </button>
                @endif

            </div>
        </form>
    </div>
</x-layout>
