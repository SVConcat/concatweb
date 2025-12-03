<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-5xl mt-5 mb-5">
        <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1">
            Sponsor bewerken
        </h1>
        <form method="POST" action="{{ route('sponsors.update', $sponsor) }}" enctype="multipart/form-data" class="mt-4 space-y-4" onsubmit="return validateForm()">
            @csrf
            @method('PATCH')

            {{-- Name field --}}
            <div>
                <x-form-label for="name">Naam*:</x-form-label>
                <x-form-input type="text" name="name" id="name" placeholder="Naam van de sponsor" value="{{ old('name', $sponsor->name) }}" required aria-required="true"/>
                <x-form-error name="name"/>
            </div>

            {{-- Description field --}}
            <div>
                <x-form-label for="description">Beschrijving*:</x-form-label>
                <x-form-textarea name="description" id="description" placeholder="Beschrijving van de sponsor" rows="20" required aria-required="true">{{ old('description', $sponsor->description) }}</x-form-textarea>
                <x-form-error name="description"/>
            </div>

            {{-- URL field --}}
            <div>
                <x-form-label for="url">URL:</x-form-label>
                <x-form-input type="url" name="url" id="url" placeholder="https://voorbeeld.com" value="{{ old('url', $sponsor->url) }}"/>
                <x-form-error name="url"/>
            </div>

            {{-- Logo upload field --}}
            <div>
                <x-form-label for="logo">Logo:</x-form-label>
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $sponsor->image_path) }}" alt="Huidig logo van {{ $sponsor->name }}" class="h-24 object-contain">
                    <p class="text-sm text-gray-500">Huidige logo</p>
                </div>
                <x-form-input type="file" name="logo" id="logo"/>
                <p class="text-sm text-gray-500 mt-1">Laat leeg om het huidige logo te behouden</p>
                <x-form-error name="logo"/>
            </div>

            {{-- Hide checkbox --}}
            <div>
                <x-form-label for="hide">Verbergen:</x-form-label>
                <div class="flex items-center gap-2 bg-purple-100 border border-purple-300 p-3 rounded-lg mt-2">
                    <input type="checkbox" name="hide" id="hide" class="h-5 w-5 accent-purple-500" {{ old('hide', $sponsor->trashed()) ? 'checked' : '' }}/>
                    <span class="text-purple-700">Verbergen</span>
                </div>
            </div>

            <x-form-button type="submit" class="w-full">Opslaan</x-form-button>
        </form>
    </div>
</x-layout>
