<x-layout>
    <div class="flex justify-center items-center px-4 py-32">
        <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl text-center">

            <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-2 mb-6">
                Verifieer je e-mailadres
            </h1>

            @if (session('message'))
                <div class="p-4 mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg text-left" role="alert">
                    <p class="font-medium">{{ session('message') }}</p>
                </div>
            @endif

            <p class="text-gray-700 text-lg mb-4">
                Bedankt voor je registratie! We hebben een verificatielink naar je e-mailadres gestuurd.
            </p>
            <p class="text-gray-600 mb-8">
                Klik op de link in de e-mail om je account te activeren.
            </p>

            <div class="mt-4 pt-4 border-t border-gray-200">
                <p class="text-gray-600 mb-4">Geen e-mail ontvangen?</p>

                <form method="POST" action="{{ route('verification.send') }}" class="inline" class="inline" aria-label="Formulier voor opnieuw verzenden verificatie-e-mail">
                    @csrf
                    <button type="submit" class="bg-purple-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-purple-700 transition duration-300" aria-label="Verstuur de verificatie-e-mail opnieuw">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Stuur opnieuw
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-layout>
