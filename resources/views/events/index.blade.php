<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-5xl mt-5 mb-5">
        <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1 text-center w-full mb-5">
            Evenementen
        </h1>
        <!-- Link 'Download als ICS' -->
        <div class="text-center -mt-5 mb-2">
            <a href="{{ route('events.download-ics') }}"
            class="text-base text-purple-600 hover:underline font-semibold transition duration-200"
            aria-label="Download alle evenementen als ICS bestand en voeg toe aan je agenda">
            Download als ICS <i class="fa-solid fa-calendar-arrow-down" aria-hidden="true"></i>
            </a>
        </div>



        @auth
            @if(auth()->user()->role === 'admin')
                <div class="flex justify-end my-4" >
                    <a href="{{ url('/events/create') }}"
                       class="inline-flex items-center bg-green-500 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-green-600 transition"
                       aria-label="Nieuw event toevoegen">
                        <i class="fa-solid fa-plus mr-2" aria-hidden="true"></i> Evenement toevoegen
                    </a>
                </div>
            @endif

        @endauth
        {{-- Dropdown for filtering and showing user's events --}}
        <form method="GET" action="{{ url('/events/index') }}" class="mb-6 flex flex-col sm:flex-row items-center gap-4 justify-center">
            <div>
                <label for="categorie" class="text-sm font-semibold text-gray-700">Filter op categorie:</label>
                <select name="categorie" id="categorie"
                        onchange="this.form.submit()"
                        class="p-2 bg-purple-100 text-purple-700 rounded-lg outline-none border border-purple-300 focus:ring-2 focus:ring-purple-500"
                        aria-label="Filter events op categorie">
                    <option value="all" {{ $categorieFilter === 'all' ? 'selected' : '' }}>Alle categorieën</option>
                    <option value="blokborrel" {{ $categorieFilter === 'blokborrel' ? 'selected' : '' }}>Blokborrel</option>
                    <option value="education" {{ $categorieFilter === 'education' ? 'selected' : '' }}>Education</option>

                </select>
            </div>
            @auth
                <div>
                    <select name="myevents" id="myevents"
                            onchange="this.form.submit()"
                            class="p-2 bg-purple-100 text-purple-700 rounded-lg outline-none border border-purple-300 focus:ring-2 focus:ring-purple-500"
                            aria-label="Filter op mijn events">
                        <option value="0" {{ !$onlyMyEvents ? 'selected' : '' }}>Alles</option>
                        <option value="1" {{ $onlyMyEvents ? 'selected' : '' }}>Ingeschreven </option>

                    </select>
                </div>
            @endauth

            {{-- Afgelopen events knop --}}
            <div>
                <a href="{{ url('/events/index') . '?afgelopen=true&categorie=' . $categorieFilter }}"
                   class="inline-flex items-center bg-purple-100 text-gray-800 font-semibold py-2 px-4 rounded border-pink-300 hover:bg-[#E39FF6] transition"
                   aria-label="Bekijk afgelopen events">
                    <i class="fa-solid fa-clock-rotate-left mr-2" aria-hidden="true"></i> Afgelopen evenementen
                </a>
            </div>
        </form>

        {{-- Eventslijst --}}
        <div class="flex flex-col flex-wrap my-4">

            <div class="grid sm:grid-cols-2 gap-8 lg:gap-6 mx-auto">
                @foreach($events as $event)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                        <a href="{{ route('events.show', $event->id) }}"
                           class="block w-full aspect-square relative overflow-hidden"
                           aria-label="Details bekijken van {{ $event->titel }}">
                            @if(isset($event->afbeelding))
                                <img src="{{ asset('storage/' . $event->afbeelding) }}"
                                     alt="Afbeelding van {{ $event->titel }}. Datum: {{ \Carbon\Carbon::parse($event->start_datum)->format('d-m-Y') }} tot {{ \Carbon\Carbon::parse($event->einddatum)->format('d-m-Y') }} in {{ $event->locatie }}"
                                     class="aspect-square object-cover w-full h-full">
                            @else
                                <div class="p-5 flex items-center justify-center bg-gradient-to-r from-blue-400 to-purple-500 w-full h-full" aria-hidden="true">
                                    <h1 class="text-white text-3xl font-bold text-center w-full break-words">{{ $event->titel }}</h1>
                                </div>
                            @endif
                        </a>

                        <div class="p-5">
                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <div class="flex justify-end mb-4 gap-2 pt-2 pr-2">
                                        <a href="{{ route('events.edit', $event->id) }}"
                                        class="bg-[#3129FF] rounded-lg text-white py-1.5 px-3 hover:bg-[#E39FF6] transition text-sm">
                                            <i class="fa-solid fa-pencil mr-1" aria-hidden="true"></i>
                                            Bewerken
                                        </a>
                                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('Weet je zeker dat je dit evenement wilt verwijderen?');"
                                                    class="bg-red-500 text-white py-1.5 px-3 rounded-lg hover:bg-red-600 transition text-sm">
                                                <i class="fa-solid fa-trash mr-1" aria-hidden="true"></i>
                                                Verwijderen
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth

                            {{-- Categorie --}}
                            @if(isset($event->categorie))
                                <span class="inline-block mb-2 bg-purple-100 text-purple-700 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">
                                    {{ ucfirst($event->categorie) }}
                                </span>
                            @endif

                            {{-- Registration Status --}}
                            @auth
                                @if($event->isUserRegistered(auth()->id()))
                                    <span class="inline-block mb-2 bg-green-100 text-green-700 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">
                                        Ingeschreven
                                    </span>
                                @else
                                    <span class="inline-block mb-2 bg-red-100 text-red-700 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">
                                        Niet ingeschreven
                                    </span>
                                @endif
                            @endauth

                            @if(isset($event->datum))
                                <div class="flex items-center text-gray-500 mb-4 mt-3">
                                    <i class="flex flex-shrink-0 fa-solid fa-calendar fa-fw text-3xl"></i>
                                    <span class="text-lg font-bold">{{ $event->datum }}, {{ $event->starttijd }} - {{ $event->eindtijd }}</span>
                                </div>
                            @endif

                            {{-- Locatie --}}
                            @if(isset($event->locatie))
                                <div class="flex items-center text-gray-500 mb-4">
                                    <i class="flex flex-shrink-0 fa-solid fa-location-dot fa-fw text-3xl" aria-hidden="true"></i>
                                    <span class="text-md font-bold ml-2">{{ $event->locatie }}</span>
                                </div>
                            @endif

                            {{-- Beschrijving --}}
                            <div class="mb-4 grow text-gray-700 relative overflow-hidden max-h-32">
                                <p class="mb-3 font-normal text-gray-700">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($event->beschrijving), 150, '...') }}
                                </p>
                                <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-b from-transparent to-white" aria-hidden="true"></div>
                            </div>

                            {{-- Lees meer knop --}}
                            <a href="{{ route('events.show', $event->id) }}"
                               class="inline-flex items-center text-sm text-center bg-[#3129FF] text-white py-2 px-4 rounded-lg hover:bg-[#E39FF6] transition font-semibold"
                               aria-label="Lees meer over {{ $event->titel }}. Datum van {{ \Carbon\Carbon::parse($event->start_datum)->format('d-m-Y') }} tot {{ \Carbon\Carbon::parse($event->einddatum)->format('d-m-Y') }} in {{ $event->locatie }}">
                                Lees meer...
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Paginatie --}}
            <div id="pagination-container" class="mt-6 text-center" role="navigation" aria-label="Paginanavigatie">
                {{ $events->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-layout>
