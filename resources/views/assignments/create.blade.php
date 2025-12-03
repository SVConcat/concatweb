<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-2xl mt-5 mb-5">
        <h1 class="text-2xl font-bold border-b-4 border-purple-500 pb-1 mb-6 text-center">
            Nieuwe Opdracht Toevoegen
        </h1>

        <form method="POST" action="{{ route('assignments.store') }}" class="space-y-6">
            @csrf

            <div>
                <x-form-label for="title">Titel*</x-form-label>
                <x-form-input type="text" name="title" id="title" placeholder="Titel van de opdracht" value="{{ old('title') }}" aria-required="true"/>
                <x-form-error name="title"/>
            </div>

            <div>
                <x-form-label for="company_name">Bedrijfsnaam*</x-form-label>
                <x-form-input type="text" name="company_name" id="company_name" placeholder="Naam van het bedrijf" value="{{ old('company_name') }}" aria-required="true"/>
                <x-form-error name="company_name"/>
            </div>

            <div>
                <x-form-label for="short_description">Korte Omschrijving*</x-form-label>
                <x-form-textarea name="short_description" id="short_description" placeholder="Korte omschrijving van de opdracht" rows="5" aria-required="true">{{ old('short_description') }}</x-form-textarea>
                <x-form-error name="short_description"/>
            </div>

            <div>
                <x-form-label for="email">E-mailadres (optioneel)</x-form-label>
                <x-form-input name="email" id="email" placeholder="contact@bedrijf.nl" value="{{ old('email') }}"/>
                <x-form-error name="email"/>
            </div>

            <div>
                <x-form-label for="phone_number">Telefoonnummer (optioneel)</x-form-label>
                <x-form-input type="text" name="phone_number" id="phone_number" placeholder="06-12345678" value="{{ old('phone_number') }}"/>
                <x-form-error name="phone_number"/>
            </div>

            <div class="pt-2">
                <x-form-button type="submit" class="w-full">Opdracht Toevoegen</x-form-button>
            </div>
        </form>
    </div>
</x-layout>
