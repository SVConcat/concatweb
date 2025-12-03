<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-5xl mt-5 mb-5">
        <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1" alt="Formulier voor het toevoegen van een event">
            Evenement toevoegen
        </h1>

        <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data" class="mt-4 space-y-4" onsubmit="return validateForm()">
            @csrf

            <div>
                <label for="titel" class="block text-l font-bold">Titel*</label>
                <input type="text" name="titel" id="titel" placeholder="Titel van het event"
                       value="{{ old('titel') }}"
                       class="w-full p-2 {{ $errors->has('titel') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                @error('titel')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="categorie" class="block text-l font-bold">Categorie*</label>
                <select name="categorie" id="categorie"
                        class="w-full p-2 {{ $errors->has('categorie') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                    <option value="">-- Selecteer een categorie --</option>
                    <option value="blokborrel" {{ old('categorie') == 'blokborrel' ? 'selected' : '' }}>Blokborrel</option>
                    <option value="education" {{ old('categorie') == 'education' ? 'selected' : '' }}>Education</option>
                </select>
                @error('categorie')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="datum" class="block text-l font-bold">Datum*</label>
                    <input type="date" name="datum" id="datum"
                           value="{{ old('datum') }}"
                           class="w-full p-2 {{ $errors->has('datum') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                    @error('datum')
                    <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="einddatum" class="block text-l font-bold">Einddatum*</label>
                    <input type="date" name="einddatum" id="einddatum"
                           value="{{ old('einddatum') }}"
                           class="w-full p-2 {{ $errors->has('einddatum') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                    @error('einddatum')
                    <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="starttijd" class="block text-l font-bold">Starttijd*</label>
                    <input type="time" name="starttijd" id="starttijd"
                           value="{{ old('starttijd') }}"
                           class="w-full p-2 {{ $errors->has('starttijd') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                    @error('starttijd')
                    <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="eindtijd" class="block text-l font-bold">Eindtijd*</label>
                    <input type="time" name="eindtijd" id="eindtijd"
                           value="{{ old('eindtijd') }}"
                           class="w-full p-2 {{ $errors->has('eindtijd') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                    @error('eindtijd')
                    <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <label for="beschrijving" class="block text-l font-bold">Beschrijving*</label>
                <textarea name="beschrijving" id="beschrijving" placeholder="Beschrijving van het event"
                          class="w-full p-2 {{ $errors->has('beschrijving') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">{{ old('beschrijving') }}</textarea>
                @error('beschrijving')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="locatie" class="block text-l font-bold">Locatie*</label>
                <input type="text" name="locatie" id="locatie" placeholder="Locatie van het event"
                       value="{{ old('locatie') }}"
                       class="w-full p-2 {{ $errors->has('locatie') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                @error('locatie')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="afbeelding" class="block text-l font-bold">Afbeelding</label>
                <input type="file" name="afbeelding" id="afbeelding" accept="image/*"
                       class="w-full p-2 bg-purple-100 text-purple-700 rounded-lg outline-none border border-purple-300 focus:ring-2 focus:ring-purple-500">
                @error('afbeelding')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="aantal_beschikbare_plekken" class="block text-l font-bold">Aantal plekken</label>
                <input type="number" name="aantal_beschikbare_plekken" id="aantal_beschikbare_plekken" placeholder="0" min="0"
                       value="{{ old('aantal_beschikbare_plekken') }}"
                       class="w-full p-2 {{ $errors->has('aantal_beschikbare_plekken') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                @error('aantal_beschikbare_plekken')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="betaal_link" class="block text-l font-bold">Betaal link</label>
                <input type="text" name="betaal_link" id="betaal_link" placeholder="Betaal link van het event"
                       value="{{ old('betaal_link') }}"
                       class="w-full p-2 {{ $errors->has('betaal_link') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                @error('betaal_link')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <input type="submit" value="Toevoegen"
                   class="w-full bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition font-semibold cursor-pointer" alt="Klik om het event toe te voegen">
        </form>


    </div>

    <script>
        function validateForm() {
            const startDate = document.getElementById('datum').value;
            const endDate = document.getElementById('einddatum').value;
            const startTime = document.getElementById('starttijd').value;
            const endTime = document.getElementById('eindtijd').value;

            if (new Date(startDate) > new Date(endDate)) {
                alert('De einddatum moet gelijk of later zijn dan de begindatum.');
                return false;
            }

            if (startDate === endDate && startTime >= endTime && endTime !== '') {
                alert('De eindtijd moet later zijn dan de begintijd.');
                return false;
            }

            return true;
        }
    </script>
</x-layout>
