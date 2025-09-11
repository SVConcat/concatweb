<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <title>{{ $event->titel }}</title>
</head>

<x-layout>
    <div class="lg:my-12 w-full max-w-5xl border-2 mx-auto shadow-xl rounded-lg overflow-hidden bg-white" role="main">

        <!-- Header met afbeelding of titel -->
        <div class="relative bg-gray-200 overflow-hidden">
            @if(isset($event->afbeelding))
                <div class="lg:h-64">
                    <img src="{{ Storage::url($event->afbeelding) }}" alt="Afbeelding van evenement: {{ $event->titel }}" class="w-full h-full object-cover" />
                </div>
            @else
                <div class="p-6 sm:h-44 flex items-center justify-center bg-gradient-to-r from-blue-400 to-purple-500">
                    <h1 class="text-white text-3xl font-bold" id="eventTitle">{{ $event->titel ?? 'Community Night' }}</h1>
                </div>
            @endif
        </div>

        <!-- Hoofdinhoud van het evenement -->
        <div class="p-6 md:p-14 ">
            <div class="flex flex-col lg:flex-row gap-8">

                <div class="flex-1" aria-labelledby="eventTitle">
                    @if(session('success'))
                        <div class="bg-green-500 text-white p-3 rounded-md mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-red-500 text-white p-3 rounded-md mb-4" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>
                                        @if($error == 'The email has already been taken.')
                                            Het e-mailadres is al geregistreerd.
                                        @else
                                            {{ $error }}
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-8">
                        @if(isset($event->titel))
                            <h2 class="text-2xl font-bold text-gray-800 mb-5">{{ $event->titel }}</h2>
                        @endif

                        <!-- Categorie -->
                        @if(isset($event->categorie))
                            <div class="flex items-center text-gray-500 mb-4">
                                <i class="flex-shrink-0 fa-solid fa-tag text-3xl" alt="Events categorie" aria-hidden="true"></i>
                                <span class="text-lg font-bold ml-2">{{ $event->categorie }}</span>
                            </div>
                        @endif

                        <!-- Datum & Tijd -->
                        <div class="flex items-center text-gray-500 mb-4">
                            <i class="fa-solid fa-calendar text-3xl flex-shrink-0" aria-hidden="true"></i>
                            <span class="text-lg font-bold ml-2">
                                Datum start: {{ \Carbon\Carbon::parse($event->datum)->format('d-m-Y') ?? 'Datum onbekend' }},
                                {{ \Carbon\Carbon::parse($event->starttijd)->format('H:i') ?? 'Tijd onbekend' }} <br>
                                Datum einde: {{ \Carbon\Carbon::parse($event->einddatum)->format('d-m-Y') ?? 'Einddatum onbekend' }},
                                {{ \Carbon\Carbon::parse($event->eindtijd)->format('H:i') ?? 'Eindtijd onbekend' }}
                            </span>
                        </div>

                        <!-- Locatie -->
                        <div class="flex items-center text-gray-500 mb-4">
                            <i class="fa-solid fa-location-dot text-3xl flex-shrink-0" aria-hidden="true"></i>
                            <span class="text-lg font-bold ml-2">Locatie: {{ $event->locatie ?? 'Locatie onbekend' }}</span>
                        </div>

                        <hr class="my-1 border-2 border-gray-400 rounded">

                        <!-- Beschrijving -->
                        <div>
                            <p>{!! $event->beschrijving ?? 'Geen beschrijving beschikbaar.' !!}</p>
                        </div>
                    </div>

                    <!-- Laatst Bijgewerkt Informatie -->
                    <div class="sm:text-right sm:text-lg text-md text-gray-500 mb-4" aria-label="Laatst bijgewerkt informatie">
                        @if($event->updated_at != $event->created_at)
                            <span>Laatst bijgewerkt op: </span>
                            <time datetime="{{ $event->updated_at }}">{{ \Carbon\Carbon::parse($event->updated_at)->format('d-m-Y H:i') }}</time>
                        @else
                            <span>Gemaakt op: </span>
                            <time datetime="{{ $event->created_at }}">{{ \Carbon\Carbon::parse($event->created_at)->format('d-m-Y H:i') }}</time>
                        @endif
                    </div>

                    <!-- Aantal plekken en ingeschreven -->
                    <div class="flex items-center text-gray-500 mb-4" aria-label="Informatie over beschikbare en ingeschreven plekken">
                        <i class="fa-solid fa-users text-3xl flex-shrink-0" aria-hidden="true"></i>
                        <div class="ml-2">
                            @if(auth()->user() && auth()->user()->isAdmin())
                                <div class="text-lg font-bold">
                                    Inschrijvingen:
                                    @if($availableSpots > 0)
                                        {{ $registeredCount }} / {{ $availableSpots }}
                                    @else
                                        Geen plaatsen beschikbaar
                                    @endif
                                </div>
                            @else
                                <div class="text-lg font-bold">
                                    Totaal aantal plekken:
                                    @if($availableSpots > 0)
                                        {{ $availableSpots }} plekken
                                    @else
                                        Geen plaatsen beschikbaar
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Button om formulier te openen -->
                    <!-- <button id="openFormButton" class="bg-blue-500 text-white py-3 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full mb-6" alt="Inschrijven voor event">
                        Inschrijven
                    </button> -->


                    <!-- Conditionele Inschrijfknop (alleen op verificatie) -->

                    @if (Auth::check() && !Auth::user()->hasVerifiedEmail())
                        <a href="{{ route('verification.notice') }}" 
                        title="Je moet je e-mailadres verifiëren om je te kunnen inschrijven."
                        class="block text-center bg-yellow-500 text-white py-3 px-6 rounded-lg hover:bg-yellow-600 w-full mb-6">
                            Verifieer je e-mail om in te schrijven
                        </a>
                    @else
                        <button id="openFormButton" class="bg-blue-500 text-white py-3 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full mb-6" alt="Inschrijven voor event">
                            Inschrijven
                        </button>
                    @endif

                    <!-- Link 'Zet in agenda' -->
                    <div class="text-center -mb-7">
                        <a href="{{ route('events.ics', $event->id) }}"
                            class="text-sm text-purple-600 hover:underline font-medium transition duration-200"
                            aria-label="Download evenement {{ $event->titel }} en voeg het toe aan je agenda">
                            Zet in agenda <i class="fa-solid fa-calendar" aria-hidden="true"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Popup -->
    <div id="popupModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96 relative">
            <button id="closePopup" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" aria-label="Sluiten inschrijf popup">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
            <h3 id="modalTitle" class="text-xl font-bold mb-6 text-gray-800">Inschrijven</h3>
            <form action="{{ route('registration') }}" method="POST">
                @csrf
                <input type="hidden" name="event_id" value="{{ $event->id }}">

                @auth
                    <input type="hidden" name="naam" value="{{ auth()->user()->name }}">
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                    <p class="text-gray-700 mb-4">
                        Je bent ingelogd als <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})
                    </p>
                @else
                    <div class="mb-6">
                        <label for="naam" class="block text-gray-700">Naam:</label>
                        <input type="text" id="naam" name="naam" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-gray-700">E-mail:</label>
                        <input type="email" id="email" name="email" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                @endauth

                <button type="submit" class="bg-blue-500 text-white py-3 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full">
                    Inschrijven
                </button>
            </form>
        </div>
    </div>

    <script>
        const openFormButton = document.getElementById('openFormButton');
        const popupModal = document.getElementById('popupModal');
        const closePopup = document.getElementById('closePopup');

        openFormButton.addEventListener('click', function() {
            popupModal.classList.remove('hidden');
            popupModal.setAttribute('aria-hidden', 'false');
            openFormButton.setAttribute('aria-expanded', 'true');
            // Focus op eerste invoerveld of close knop
            const firstInput = popupModal.querySelector('input, button, textarea, select');
            if (firstInput) {
                firstInput.focus();
            }
        });

        closePopup.addEventListener('click', function() {
            popupModal.classList.add('hidden');
            popupModal.setAttribute('aria-hidden', 'true');
            openFormButton.setAttribute('aria-expanded', 'false');
            openFormButton.focus();
        });

        window.addEventListener('click', function(event) {
            if (event.target === popupModal) {
                popupModal.classList.add('hidden');
                popupModal.setAttribute('aria-hidden', 'true');
                openFormButton.setAttribute('aria-expanded', 'false');
                openFormButton.focus();
            }
        });

        // Optioneel: sluit modal met Esc-toets
        window.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !popupModal.classList.contains('hidden')) {
                popupModal.classList.add('hidden');
                popupModal.setAttribute('aria-hidden', 'true');
                openFormButton.setAttribute('aria-expanded', 'false');
                openFormButton.focus();
            }
        });
    </script>
</x-layout>
