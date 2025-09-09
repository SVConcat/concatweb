<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-5xl mt-5 mb-5">
        <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1">
            Nieuwsbrief toevoegen
        </h1>

        <form method="POST" action="{{ route('newsletters.store') }}" enctype="multipart/form-data"
            class="mt-4 space-y-6">
            @csrf

            <div>
                <label for="titel" class="block font-bold">Algemene titel nieuwsbrief*</label>
                <input type="text" name="titel" id="titel" value="{{ old('titel') }}"
                    class="w-full p-2 rounded-lg border border-purple-300 bg-purple-100 text-purple-700">
                @error('titel')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="publicatiedatum" class="block font-bold">Publicatiedatum*</label>
                <input type="date" name="publicatiedatum" id="publicatiedatum" value="{{ old('publicatiedatum') }}"
                    class="w-full p-2 rounded-lg border border-purple-300 bg-purple-100 text-purple-700">
                @error('publicatiedatum')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <h2 class="text-xl font-semibold">Nieuwsblokjes</h2>
            <div id="event-blocks">
                <div class="event-block border p-4 mb-4 rounded-xl bg-purple-50">
                    <label>Titel*</label>
                    <input type="text" name="events[0][titel]" class="w-full mb-2">
                    @error('events.0.titel')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror

                    <label>Datum</label>
                    <input type="date" name="events[0][datum]" class="w-full mb-2">

                    <label>Tijd</label>
                    <input type="text" name="events[0][tijd]" class="w-full mb-2">

                    <label>Locatie</label>
                    <input type="text" name="events[0][locatie]" class="w-full mb-2">

                    <label>Inhoud*</label>
                    <textarea name="events[0][inhoud]" class="w-full mb-2" rows="4"></textarea>
                    @error('events.0.inhoud')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror

                    <label>Afbeelding</label>
                    <input type="file" name="event_images[0]" accept="image/*" class="w-full mb-2">
                </div>
            </div>

            <button type="button" onclick="addEventBlock()" class="bg-blue-500 text-white px-4 py-2 rounded">
                + Blok toevoegen
            </button>

            <input type="submit" value="Nieuwsbrief genereren"
                class="w-full bg-orange-500 text-white p-3 rounded-lg hover:bg-orange-600 transition font-semibold cursor-pointer">
        </form>
    </div>

    <script>
        let eventCount = 1;
        function addEventBlock() {
            const container = document.getElementById('event-blocks');
            const block = document.createElement('div');
            block.classList.add('event-block', 'border', 'p-4', 'mb-4', 'rounded-xl', 'bg-purple-50');
            block.innerHTML = `
                <label>Titel*</label>
                <input type="text" name="events[${eventCount}][titel]" class="w-full mb-2">

                <label>Datum*</label>
                <input type="date" name="events[${eventCount}][datum]" class="w-full mb-2">

                <label>Tijd</label>
                <input type="text" name="events[${eventCount}][tijd]" class="w-full mb-2">

                <label>Locatie</label>
                <input type="text" name="events[${eventCount}][locatie]" class="w-full mb-2">

                <label>Inhoud*</label>
                <textarea name="events[${eventCount}][inhoud]" class="w-full mb-2" rows="4"></textarea>

                <label>Afbeelding</label>
                <input type="file" name="event_images[${eventCount}]" accept="image/*" class="w-full mb-2">
            `;
            container.appendChild(block);
            eventCount++;
        }
    </script>
</x-layout>
