<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-5xl mt-5 mb-5 mx-auto">
        <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1">
            Nieuwsbrief bewerken
        </h1>

        <form method="POST" action="{{ route('newsletters.update', $newsletter) }}" enctype="multipart/form-data"
            class="mt-4 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="titel" class="block font-bold">Titel*</label>
                <input type="text" name="titel" id="titel" value="{{ old('titel', $newsletter->titel) }}"
                    class="w-full p-2 bg-purple-100 border-purple-300 text-purple-700 rounded-lg border">
                @error('titel')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="publicatiedatum" class="block font-bold">Publicatiedatum*</label>
                <input type="date" name="publicatiedatum" id="publicatiedatum"
                    value="{{ old('publicatiedatum', $newsletter->publicatiedatum->format('Y-m-d')) }}"
                    class="w-full p-2 bg-purple-100 border-purple-300 text-purple-700 rounded-lg border">
                @error('publicatiedatum')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <h2 class="text-xl font-semibold">Nieuwsblokjes</h2>
            <div id="event-blocks">
                @foreach ($events as $index => $event)
                    <div class="event-block border p-4 mb-4 rounded-xl bg-purple-50">
                        <label>Titel*</label>
                        <input type="text" name="events[{{ $index }}][titel]"
                            value="{{ old("events.$index.titel", $event['titel']) }}" class="w-full mb-2">
                            @error("events.$index.titel")
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror

                        <label>Datum</label>
                        <input type="date" name="events[{{ $index }}][datum]"
                            value="{{ old("events.$index.datum", $event['datum']) }}" class="w-full mb-2">

                        <label>Tijd</label>
                        <input type="text" name="events[{{ $index }}][tijd]"
                            value="{{ old("events.$index.tijd", $event['tijd'] ?? '') }}" class="w-full mb-2">

                        <label>Locatie</label>
                        <input type="text" name="events[{{ $index }}][locatie]"
                            value="{{ old("events.$index.locatie", $event['locatie'] ?? '') }}" class="w-full mb-2">

                        <label>Inhoud*</label>
                        <textarea name="events[{{ $index }}][inhoud]" rows="4"
                            class="w-full mb-2">{{ old("events.$index.inhoud", $event['inhoud']) }}</textarea>
                        @error("events.$index.inhoud")
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror

                        <label>Afbeelding</label>
                        <input type="file" name="event_images[{{ $index }}]" accept="image/*" class="w-full mb-2">

                        @if (!empty($newsletter->images[$index]))
                            <img src="{{ asset($newsletter->images[$index]) }}" alt="Event afbeelding"
                                class="w-full max-w-xs rounded shadow border mt-2">
                        @endif
                    </div>
                @endforeach
            </div>

            <button type="button" onclick="addEventBlock()" class="bg-blue-500 text-white px-4 py-2 rounded">
                + Blok toevoegen
            </button>

            <input type="submit" value="Wijzigingen opslaan"
                class="w-full bg-orange-500 text-white p-3 rounded-lg hover:bg-orange-600 transition font-semibold cursor-pointer">
        </form>
    </div>

    <script>
        let eventCount = {{ count($events) }};
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