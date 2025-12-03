<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-5xl mt-5 mb-5">
        <h1 aria-label="Bewerk bestuurslid {{ $boardMember->name}}" class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1">
            Bestuurslid bewerken
        </h1>

        @if(session('success'))
        <div aria-label="Succesmelding" aria-live="polite" class="w-full flex justify-center">
            <div class="max-w-md p-4 mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('board-members.update', $boardMember->id) }}" enctype="multipart/form-data" class="mt-4 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-l font-bold">Naam*</label>
                <input type="text" name="name" id="name" value="{{ old('name', $boardMember->name) }}"
                       class="w-full p-2 {{ $errors->has('name') ? 'bg-red-100 text-red-700 border-red-300' : 'bg-purple-100 text-purple-700 border-purple-300' }} rounded-lg border outline-none focus:ring-2 focus:ring-purple-500"
                       aria-label="Voer de volledige naam in van het bestuurslid">
                       
                @error('name')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="role" class="block text-l font-bold">Rol*</label>
                <input type="text" name="role" id="role" value="{{ old('role', $boardMember->role) }}"
                       class="w-full p-2 {{ $errors->has('role') ? 'bg-red-100 text-red-700 border-red-300' : 'bg-purple-100 text-purple-700 border-purple-300' }} rounded-lg border outline-none focus:ring-2 focus:ring-purple-500"
                       aria-label="Voer de functie in van het bestuurslid">
                @error('role')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="photo" class="block text-l font-bold">Foto</label>
                <input type="file" name="photo" id="photo" accept="image/*"
                       class="w-full p-2 {{ $errors->has('photo') ? 'bg-red-100 text-red-700 border-red-300' : 'bg-purple-100 text-purple-700 border-purple-300' }} rounded-lg border outline-none focus:ring-2 focus:ring-purple-500"
                       aria-label="Upload een profielfoto voor dit bestuurslid">
                @if ($boardMember->photo)
                    <img src="{{ asset($boardMember->photo) }}" alt="Huidige profielfoto van {{ $boardMember->name }}" class="mt-2 w-32 h-32 object-cover rounded">
                @endif
                @error('photo')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="bio" class="block text-l font-bold">Bio*</label>
                <textarea name="bio" id="bio" rows="6"
                          class="w-full p-2 {{ $errors->has('bio') ? 'bg-red-100 text-red-700 border-red-300' : 'bg-purple-100 text-purple-700 border-purple-300' }} rounded-lg border outline-none focus:ring-2 focus:ring-purple-500"
                          aria-label="Voer een biografie in voor dit bestuurslid">{{ old('bio', $boardMember->bio) }}</textarea>
                @error('bio')
                <div class="text-red-500 text-l mt-1 font-bold">{{ $message }}</div>
                @enderror
            </div>

           <input type="submit" value="Opslaan"
                   class="w-full bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition font-semibold cursor-pointer mt-4"
                   aria-label="Klik om de wijzigingen op te slaan">
        </form>
    </div>
</x-layout>