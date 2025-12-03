<x-layout>
    <div class="w-full max-w-5xl mx-auto my-6 lg:my-12 shadow-xl rounded-lg overflow-hidden bg-white border-2">
        <!-- Header met titel -->
        <div class="bg-gradient-to-r from-blue-400 to-purple-500 p-6 sm:h-44 flex items-center justify-center">
            <h1 class="text-white text-3xl font-bold text-center">Evenement bewerken</h1>
        </div>

        <div class="p-6 md:p-10">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-4" role="alert">
                    <p class="font-bold">Succes!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('events.update', $event->id) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Titel -->
                <div>
                    <label for="titel" class="block font-bold text-lg mb-1">Titel*</label>
                    <input type="text" name="titel" id="titel" value="{{ old('titel', $event->titel) }}"
                           class="w-full p-3 bg-purple-100 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                           required aria-required="true" aria-label="Titel van het evenement">
                    @error('titel') <p class="text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Categorie -->
                <div>
                    <label for="categorie" class="block font-bold text-lg mb-1">Categorie*</label>
                    <select name="categorie" id="categorie"
                            class="w-full p-3 bg-purple-100 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                            aria-label="Categorie van het evenement" required>
                        <option value="blokborrel" {{ $event->categorie === 'blokborrel' ? 'selected' : '' }}>Blokborrel</option>
                        <option value="education" {{ $event->categorie === 'education' ? 'selected' : '' }}>Education</option>
                    </select>
                    @error('categorie') <p class="text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Datum -->
                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label for="datum" class="block font-bold text-lg mb-1">Startdatum*</label>
                        <input type="date" name="datum" id="datum" value="{{ old('datum', $event->datum) }}"
                               class="w-full p-3 bg-purple-100 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                               required aria-required="true">
                        @error('datum') <p class="text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="einddatum" class="block font-bold text-lg mb-1">Einddatum*</label>
                        <input type="date" name="einddatum" id="einddatum" value="{{ old('einddatum', $event->einddatum) }}"
                               class="w-full p-3 bg-purple-100 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                               required aria-required="true">
                        @error('einddatum') <p class="text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Tijd -->
                <div class="grid sm:grid-cols-2 gap-6">
                    <div>
                        <label for="starttijd" class="block font-bold text-lg mb-1">Starttijd*</label>
                        <input type="time" name="starttijd" id="starttijd" value="{{ old('starttijd', \Carbon\Carbon::createFromFormat('H:i:s', $event->starttijd)->format('H:i')) }}"
                               class="w-full p-3 bg-purple-100 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                               required>
                        @error('starttijd') <p class="text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="eindtijd" class="block font-bold text-lg mb-1">Eindtijd*</label>
                        <input type="time" name="eindtijd" id="eindtijd" value="{{ old('eindtijd', \Carbon\Carbon::createFromFormat('H:i:s', $event->eindtijd)->format('H:i')) }}"
                               class="w-full p-3 bg-purple-100 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                               required>
                        @error('eindtijd') <p class="text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Locatie -->
                <div>
                    <label for="locatie" class="block font-bold text-lg mb-1">Locatie*</label>
                    <input type="text" name="locatie" id="locatie" value="{{ old('locatie', $event->locatie) }}"
                           class="w-full p-3 bg-purple-100 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                           required aria-label="Locatie van het evenement">
                    @error('locatie') <p class="text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Beschrijving -->
                <div>
                    <label for="beschrijving" class="block font-bold text-lg mb-1">Beschrijving*</label>
                    <textarea name="beschrijving" id="beschrijving" rows="6"
                              class="w-full p-3 bg-purple-100 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                              required aria-label="Beschrijving van het evenement">{{ old('beschrijving', $event->beschrijving) }}</textarea>
                    @error('beschrijving') <p class="text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Aantal plekken -->
                <div>
                    <label for="aantal_beschikbare_plekken" class="block font-bold text-lg mb-1">Aantal beschikbare plekken</label>
                    <input type="number" name="aantal_beschikbare_plekken" id="aantal_beschikbare_plekken"
                           value="{{ old('aantal_beschikbare_plekken', $event->aantal_beschikbare_plekken) }}"
                           class="w-full p-3 bg-purple-100 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                           min="0" aria-label="Aantal beschikbare plekken">
                    @error('aantal_beschikbare_plekken') <p class="text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Betaallink -->
                <div>
                    <label for="betaal_link" class="block font-bold text-lg mb-1">Betaallink</label>
                    <input type="url" name="betaal_link" id="betaal_link" value="{{ old('betaal_link', $event->betaal_link) }}"
                           class="w-full p-3 bg-purple-100 border border-purple-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                           aria-label="Betaallink voor het evenement">
                    @error('betaal_link') <p class="text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Afbeelding -->
                <div>
                    <label for="afbeelding" class="block font-bold text-lg mb-1">Afbeelding (optioneel)</label>
                    <input type="file" name="afbeelding" id="afbeelding"
                           class="w-full text-sm bg-purple-100 border border-purple-300 rounded-lg file:py-2 file:px-4 file:bg-purple-700 file:text-white file:rounded file:cursor-pointer"
                           aria-label="Upload een afbeelding">
                    @error('afbeelding') <p class="text-red-600 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit"
                            class="w-full bg-[#3129FF] hover:bg-[#E39FF6] text-white font-semibold py-3 px-6 rounded-lg transition text-lg">
                        Evenement opslaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
