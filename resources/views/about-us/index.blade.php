<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-5xl mt-5 mb-5 mx-auto">
        {{-- Over Concat sectie --}}
        <section class="mb-12" role="region" aria-labelledby="over-concat-title">
            <h1 id="over-concat-title" class="text-3xl font-bold text-center text-purple-700 mb-4">Over Concat</h1>
            <p class="italic text-gray-800 text-center max-w-3xl mx-auto mb-6">
                concat [kon-ket] (verb) <br>
                “Concatenatie is een standaardoperatie in programmeertalen om twee objecten aan elkaar te verbinden.”<br>
                Wanneer gebruikt na het woord <strong>studievereniging</strong> {Studievereniging Concat} worden studenten met elkaar, bedrijven en docenten verbonden.
            </p>

            <div class="text-gray-700 space-y-4 max-w-3xl mx-auto">
                <p><strong>Voorbeeldzinnen:</strong></p>
                <ol class="list-decimal list-inside space-y-2">
                    <li>“Ik ben een informaticastudent, zit op school en ben op zoek naar gezelligheid, dus dan ga ik naar studievereniging Concat.”</li>
                    <li>Een bedrijf heeft een tekort aan informaticastudenten, als oplossing benaderen ze studievereniging Concat.</li>
                    <li>
                        <code class="bg-gray-100 px-2 py-1 rounded text-sm font-mono" aria-label="SQL query voorbeeld">
                            SELECT CONCAT(SO, BIM) AS Gezelligheid FROM Avans;
                        </code>
                    </li>
                </ol>

                <p>
                    Studievereniging Concat heeft twee hoofddoelen: studenten verbinden en een extensie zijn van de opleiding.
                    Studenten verbinden met elkaar, docenten en het bedrijfsleven. Op deze manier willen wij studenten helpen om een gezellige studietijd te hebben
                    en na de studietijd helemaal voorbereid te zijn voor het bedrijfsleven.
                </p>
            </div>
        </section>

        {{-- Titel Huidig Bestuur --}}
        <h2 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1 text-center w-full mb-8">
            Huidig Bestuur
        </h2>

        {{-- Bestuursleden cards --}}
<div class="grid sm:grid-cols-2 gap-8" role="list">
    @foreach ($currentBoard as $member)
        <div role="listitem" class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden p-5 flex flex-col space-y-4 min-h-[400px]" tabindex="0">
            {{-- Header met naam, rol en foto naast elkaar --}}
            <div class="flex justify-between items-start space-x-4">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-800">{{ $member['name'] }}</h3>
                    <p class="text-purple-700 font-semibold">{{ $member['role'] }}</p>
                </div>
                <img
                    src="{{ Storage::url($member['photo']) }}"
                    alt="Foto van {{ $member['name'] }}"
                    class="w-64 h-64 object-cover rounded-lg shadow"
                >
            </div>
            {{-- Volledige bio --}}
            <p class="text-gray-700 whitespace-pre-line flex-grow">
                {{ $member['bio'] }}
            </p>

           @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('board-members.edit', $member->id) }}"
                    class="bg-[#3129FF] rounded-lg text-white py-1 px-2 hover:bg-[#E39FF6] transition text-sm inline-flex items-center max-w-[90px] truncate"
                    aria-label="Bewerk Knop">
                    <i class="fa-solid fa-pencil mr-1"></i>Bewerken
                    </a>
                @endif
            @endauth

        </div>
    @endforeach
</div>

        {{-- Titel Vorige Besturen --}}
        <h2 class="text-xl font-bold border-b-4 border-purple-500 inline-block mt-10 pb-1 text-center w-full mb-8">
            Vorige Besturen
        </h2>

        {{-- Horizontale tijdlijn --}}
        <div class="relative" role="region" aria-labelledby="tijdlijn-title">
            <h3 id="tijdlijn-title" class="sr-only">Vorige besturen tijdlijn</h3>
            <div class="flex items-center justify-between mb-4">
                <button
                    onclick="scrollTimeline(-300)"
                    class="px-3 py-1 bg-purple-500 text-white rounded hover:bg-purple-600"
                    aria-label="Scroll naar links op de tijdlijn"
                ><i class="fa-solid fa-arrow-left"></i></button>
                <button
                    onclick="scrollTimeline(300)"
                    class="px-3 py-1 bg-purple-500 text-white rounded hover:bg-purple-600"
                    aria-label="Scroll naar rechts op de tijdlijn"
                ><i class="fa-solid fa-arrow-right"></i></button>
            </div>

            <div id="timeline" class="flex space-x-6 overflow-x-auto pb-4 scroll-smooth" role="list">
                @foreach ($previousBoards as $board)
                    <div role="listitem" class="min-w-[400px] min-h-[300px] bg-white border border-purple-200 p-4 rounded-lg shadow-sm" tabindex="0">


                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-lg font-bold text-purple-700 m-0">
                                {{ $board['from'] }} - {{ $board['to'] }}
                            </h4>

                            @auth
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('previous-boards.edit', $board['id']) }}"
                                class="bg-[#3129FF] rounded-lg text-white py-1 px-2 hover:bg-[#E39FF6] transition text-sm inline-flex items-center max-w-[90px] truncate"
                                aria-label="Bewerk bestuur {{ $board['from'] }} - {{ $board['to'] }}">
                                    <i class="fa-solid fa-pencil mr-1"></i>Bewerken
                                </a>
                                @endif
                            @endauth

                        </div>


                        @if (!empty($board['photo']))
                            <img src="{{ Storage::url($board['photo']) }}" alt="Groepsfoto van bestuur uit {{ $board['from'] }} - {{ $board['to'] }}" class="w-full h-46 object-cover rounded mt-2 mb-3">
                        @endif

                        <p class="text-gray-700 text-sm whitespace-pre-line">
                            <br>{{ $board['members'] }}
                        </p>

                    </div>
                @endforeach
            </div>
        </div>

        {{-- Bestuurslid worden --}}
        <div class="mt-10 bg-purple-50 p-6 rounded-lg shadow-inner" role="region" aria-labelledby="bestuur-worden-title">
            <h3 id="bestuur-worden-title" class="text-xl font-bold text-purple-700 mb-2">Bestuurslid worden?</h3>
            <p class="text-gray-700 mb-4">
                Lijkt het jou leuk om deel uit te maken van het bestuur van SV Concat?
                <a href="mailto:info@svconcat.nl" class="text-purple-600 hover:underline" aria-label="Stuur een e-mail naar SV Concat">Stuur ons een mail</a> of
                <a href="https://discord.com/invite/AMYt823VPJ" target="_blank" class="text-blue-600 hover:underline" aria-label="Open Discord link naar SV Concat">stuur een bericht via Discord</a>,
                of spreek iemand van het bestuur aan. Nieuwe ideeën en energie zijn altijd welkom!
            </p>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        function toggleBio(index, button) {
            const bioShort = document.querySelector(`#bio-${index} .bio-short`);
            const bioFull = document.querySelector(`#bio-${index} .bio-full`);

            const isHidden = bioFull.classList.contains('hidden');

            bioFull.classList.toggle('hidden', !isHidden);
            bioShort.classList.toggle('hidden', isHidden);
            button.textContent = isHidden ? 'Lees minder' : 'Lees meer';
            button.setAttribute('aria-expanded', isHidden.toString());
        }

        function scrollTimeline(offset) {
            const timeline = document.getElementById('timeline');
            timeline.scrollBy({ left: offset, behavior: 'smooth' });
        }
    </script>
</x-layout>
