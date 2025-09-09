<x-layout>
    <div class="lg:my-12 w-full max-w-3xl lg:max-w-screen-2xl flex flex-row flex-wrap lg:flex-nowrap gap-6 ">
        <div class="flex flex-col gap-6 justify-start w-full lg:w-3/4">

            <!-- Carrousel -->
            <div class="lg:col-span-2">
                <div class="swiper-container relative h-96 rounded-xl overflow-hidden shadow-lg">
                    <div class="swiper-wrapper">
                        @foreach($photos as $photo)
                            <div class="swiper-slide relative">
                                <img src="{{ $photo['src'] }}" alt="{{ $photo['title'] }}"
                                     class="w-full h-full object-cover">
                                <div
                                    class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-6">
                                    <h3 class="text-xl font-bold text-white">{{ $photo['title'] }}</h3>
                                    <p class="text-gray-200 text-sm">{{ $photo['date'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Navigation buttons -->
                    <div class="swiper-button-next text-white"></div>
                    <div class="swiper-button-prev text-white"></div>
                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="flex flex-col gap-6 lg:flex-row">
                {{-- Events Section Wrapper --}}
                <div class="w-full lg:max-w-6/12 flex flex-col h-full">
                    <h1 class="text-2xl font-bold mb-2 text-left">Eerstvolgend evenement</h1>
                    <hr class="border-b-4 border-purple-500 mb-4">


                    <div class="grid gap-8 lg:gap-6 flex-grow">
                        <div
                            class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                            <a href="{{ route('events.show', $event->id) }}"
                               class="block w-full aspect-square relative overflow-hidden"
                               aria-label="Details bekijken van {{ $event->titel }}">
                                @if(isset($event->afbeelding))
                                    <img src="{{ asset('storage/' . $event->afbeelding) }}"
                                         alt="Afbeelding van {{ $event->titel }}. Datum: {{ \Carbon\Carbon::parse($event->start_datum)->format('d-m-Y') }} tot {{ \Carbon\Carbon::parse($event->einddatum)->format('d-m-Y') }} in {{ $event->locatie }}"
                                         class="w-full object-cover">
                                @else
                                    <div
                                        class="p-5 flex h-full w-full items-center justify-center bg-gradient-to-r from-blue-400 to-purple-500"
                                        aria-hidden="true">
                                        <h1 class="text-white text-3xl font-bold text-center w-full break-words">{{ $event->titel }}</h1>
                                    </div>
                                @endif
                            </a>

                            <div class="p-5 flex flex-col flex-grow">
                                {{-- Titel --}}
                                {{-- Categorie --}}
                                @if(isset($event->categorie))
                                    <div>
                                        <span
                                            class="inline-block mb-2 bg-purple-100 text-purple-700 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full">
                                            {{ ucfirst($event->categorie) }}
                                        </span>
                                    </div>
                                @endif

                                {{-- Datum & tijd --}}
                                @if(isset($event->start_datum) && isset($event->einddatum))
                                    <div class="flex items-center text-gray-500 mb-4">
                                        <i class="flex flex-shrink-0 fa-solid fa-calendar fa-fw text-3xl"
                                           aria-hidden="true"></i>
                                        <span class="text-lg font-bold ml-2">
                                                {{ \Carbon\Carbon::parse($event->start_datum)->format('d-m-Y') }} {{ \Carbon\Carbon::parse($event->starttijd)->format('H:i') }},
                                                {{ \Carbon\Carbon::parse($event->einddatum)->format('d-m-Y') }} {{ \Carbon\Carbon::parse($event->eindtijd)->format('H:i') }}
                                    </span>
                                    </div>
                                @endif

                                {{-- Locatie --}}
                                @if(isset($event->locatie))
                                    <div class="flex items-center text-gray-500 mb-4">
                                        <i class="flex flex-shrink-0 fa-solid fa-location-dot fa-fw text-3xl"
                                           aria-hidden="true"></i>
                                        <span class="text-md font-bold ml-2">{{ $event->locatie }}</span>
                                    </div>
                                @endif

                                {{-- Beschrijving --}}
                                <div class="mb-4 grow text-gray-700 relative overflow-hidden max-h-32">
                                    <p class="mb-3 font-normal text-gray-700">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($event->beschrijving), 150, '...') }}
                                    </p>
                                    <div
                                        class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-b from-transparent to-white"
                                        aria-hidden="true"></div>
                                </div>

                                <div class="mt-auto">
                                    <div class="flex items-center text-gray-500 mb-4">
                                        <i class="flex-shrink-0 fa-solid fa-users text-3xl"
                                           alt="Aantal inschrijvingen evenement" aria-hidden="true"></i>
                                        <div class="ml-2">
                                            <!-- Totaal aantal plekken -->
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

                                    {{-- Lees meer knop --}}
                                    <a href="{{ route('events.show', $event->id) }}"
                                       class="inline-flex items-center text-sm text-center bg-[#3129FF] text-white py-2 px-4 rounded-lg hover:bg-[#E39FF6] transition font-semibold"
                                       aria-label="Lees meer over {{ $event->titel }}. Datum van {{ \Carbon\Carbon::parse($event->start_datum)->format('d-m-Y') }} tot {{ \Carbon\Carbon::parse($event->einddatum)->format('d-m-Y') }} in {{ $event->locatie }}">
                                        Lees meer...
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Community Night Section Wrapper --}}
                <div class="w-full lg:max-w-6/12 flex flex-col h-full">
                    <h1 class="text-2xl font-bold mb-2 text-left">Eerstvolgende community-avond</h1>
                    <hr class="border-b-4 border-purple-500 mb-4">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                        <a href="{{ route('community-nights.show', $communityNight) }}">
                            {{-- Temporarily disabled, breaks at times for unknown reasons --}}
                            @if(isset($communityNight->image))
                                <img src="{{ asset('storage/' . $communityNight->image) }}"
                                     alt="{{ $communityNight->title }}" class="aspect-square object-cover w-full">
                            @else
                                <div
                                    class="p-5 sm:h-44 flex items-center justify-center bg-gradient-to-r from-blue-400 to-purple-500">
                                    <h1 class="text-white text-3xl font-bold text-center w-full break-words">{{ $communityNight->title ?? 'Community Night' }}</h1>
                                </div>
                            @endif
                        </a>

                        <div class="p-5 flex flex-col flex-grow">
                            {{-- Temporarily disabled, breaks at times for unknown reasons --}}
                            @if(isset($communityNight->image))
                                <a href="{{ route('community-nights.show', $communityNight) }}">
                                    <h5 class="text-2xl font-bold tracking-tight text-gray-900 mb-4">{{ $communityNight->title }}</h5>
                                </a>
                            @endif

                            @if(isset($communityNight->date))
                                <div class="flex items-center text-gray-500 mb-4">
                                    <i class="flex flex-shrink-0 fa-solid fa-calendar fa-fw text-3xl"></i>
                                    <span class="text-lg font-bold">{{ $communityNight->date }}, {{ $communityNight->start_time }} - {{ $communityNight->end_time }}</span>
                                </div>
                            @endif

                            @if(isset($communityNight->location))
                                <div class="flex items-center text-gray-500 mb-4">
                                    <i class="flex flex-shrink-0 fa-solid fa-location-dot fa-fw text-3xl"></i>
                                    <span
                                        class="text-md font-bold">{{ $communityNight->location ?? 'Locatie TBD' }}</span>
                                </div>
                            @endif

                            <div class="mt-auto"> {{-- Pushes button to bottom --}}
                                <div class="mb-4 grow text-gray-700 relative overflow-hidden">
                                    <p class="mb-3 font-normal text-gray-700 ">{{ $communityNight->description }}</p>
                                    <div
                                        class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-b from-transparent to-white"></div>
                                </div>

                                <a href="{{ route('community-nights.show', $communityNight) }}"
                                   class="inline-flex items-center text-sm text-center bg-[#3129FF] text-white py-2 px-4 rounded-lg hover:bg-[#E39FF6] transition font-semibold">
                                    Lees meer...
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="w-full lg:w-1/4">
            <!-- Announcements -->
            <div class="bg-white p-6 rounded-xl shadow-lg h-fit lg:sticky lg:top-4">
                <h2 class="text-2xl font-bold border-b-4 border-yellow-500 inline-block pb-1 mb-4">
                    Aankondigingen
                </h2>

                <div class="relative">
                    <!-- Container met vaste hoogte en scroll -->
                    {{-- TODO: Hoogte moet dynamisch worden gemaakt --}}
                    <div id="announcements-scroll-container" class="space-y-4 max-h-[1112px] overflow-y-auto pb-4">
                        @if(count($groupedAnnouncements) > 0)
                            @include('announcements.partials.list', ['groupedAnnouncements' => $groupedAnnouncements])
                        @else
                            <div class="text-center p-8 bg-gray-50 rounded-lg">
                                <p class="text-gray-500 italic">Er zijn momenteel geen aankondigingen</p>
                            </div>
                        @endif
                    </div>

                    <!-- Gradient overlay voor scroll indicatie -->
                    <div
                        class="pointer-events-none absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white to-transparent"></div>


                </div>
            </div>
        </div>

        @push('scripts')
            <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
            <script>
                function expandAnnouncements() {
                    const container = document.getElementById('announcements-scroll-container');
                    const button = document.getElementById('load-more-button');

                    // Verhoog de maximale hoogte of verwijder deze volledig
                    if (container.classList.contains('max-h-[600px]')) {
                        container.classList.remove('max-h-[600px]');
                        button.textContent = 'Minder tonen';
                    } else {
                        container.classList.add('max-h-[600px]');
                        button.textContent = 'Meer laden';
                    }
                }

                document.addEventListener('DOMContentLoaded', function () {
                    new Swiper('.swiper-container', {
                        loop: true,
                        autoplay: {
                            delay: 5000,
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                    });
                });
            </script>
        @endpush
    </div>
</x-layout>
