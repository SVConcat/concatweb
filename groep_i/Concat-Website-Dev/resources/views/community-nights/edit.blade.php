<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-5xl mt-5 mb-5">
        <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1" alt="Formulier voor het bewerken van een event">
            Community avond bewerken
        </h1>

        @if(session('success'))
        <div class="w-full flex justify-center">
            <div class="max-w-md p-4 mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('community-nights.update', $communityNight->id) }}" enctype="multipart/form-data" class="mt-4 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-l font-bold">Titel*</label>
                <input type="text" name="title" id="title" placeholder="Titel van het event" aria-label="Communityavond title bewerken"
                       value="{{ old('title', $communityNight->title) }}"
                       class="w-full p-2 {{ $errors->has('title') ? 'bg-red-100 text-red-700 border-red-300' : 'bg-purple-100 text-purple-700 border-purple-300' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                @error('title')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-l font-bold">Afbeelding</label>
                <input type="file" name="image" id="image" aria-label="Communityavond afbeelding bewerken"
                       class="w-full p-2 {{ $errors->has('image') ? 'bg-red-100 text-red-700 border-red-300' : 'bg-purple-100 text-purple-700 border-purple-300' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                @error('image')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-l font-bold">Beschrijving*</label>
                <textarea name="description" id="description" rows="5" aria-label="Communityavond beschrijving bewerken"
                          class="w-full p-2 {{ $errors->has('description') ? 'bg-red-100 text-red-700 border-red-300' : 'bg-purple-100 text-purple-700 border-purple-300' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">{{ old('description', $communityNight->description) }}</textarea>
                @error('description')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="start_time" class="block text-l font-bold">Starttijd*</label>
                    <input type="datetime-local" name="start_time" id="start_time" aria-label="Communityavond starttijd bewerken"
                           value="{{ old('start_time', \Carbon\Carbon::parse($communityNight->start_time)->format('Y-m-d\TH:i')) }}"
                           class="w-full p-2 {{ $errors->has('start_time') ? 'bg-red-100 text-red-700 border-red-300' : 'bg-purple-100 text-purple-700 border-purple-300' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                    @error('start_time')
                    <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="end_time" class="block text-l font-bold">Eindtijd*</label>
                    <input type="datetime-local" name="end_time" id="end_time" aria-label="Communityavond eindtijd bewerken"
                           value="{{ old('end_time', \Carbon\Carbon::parse($communityNight->end_time)->format('Y-m-d\TH:i')) }}"
                           class="w-full p-2 {{ $errors->has('end_time') ? 'bg-red-100 text-red-700 border-red-300' : 'bg-purple-100 text-purple-700 border-purple-300' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                    @error('end_time')
                    <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div>
                <label for="location" class="block text-l font-bold">Locatie*</label>
                <input type="text" name="location" id="location" placeholder="Locatie van het event" aria-label="Communityavond locatie bewerken"
                       value="{{ old('location', $communityNight->location) }}"
                       class="w-full p-2 {{ $errors->has('location') ? 'bg-red-100 text-red-700 border-red-300' : 'bg-purple-100 text-purple-700 border-purple-300' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                @error('location')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="link" class="block text-l font-bold">Event Link</label>
                <input type="url" name="link" id="link" placeholder="Link naar het event" aria-label="Communityavond link bewerken"
                       value="{{ old('link', $communityNight->link) }}"
                       class="w-full p-2 {{ $errors->has('link') ? 'bg-red-100 text-red-700 border-red-300' : 'bg-purple-100 text-purple-700 border-purple-300' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                @error('link')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="capacity" class="block text-l font-bold">Capaciteit</label>
                <input type="number" name="capacity" id="capacity" placeholder="0" min="0" aria-label="Communityavond capaciteit bewerken"
                       value="{{ old('capacity', $communityNight->capacity) }}"
                       class="w-full p-2 {{ $errors->has('capacity') ? 'bg-red-100 text-red-700 border-red-300' : 'bg-purple-100 text-purple-700 border-purple-300' }} rounded-lg outline-none border focus:ring-2 focus:ring-purple-500">
                @error('capacity')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <input type="submit" value="Opslaan"
                   class="w-full bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition font-semibold cursor-pointer mt-4">
        </form>
    </div>
</x-layout>
