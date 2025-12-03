<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-5xl mt-5 mb-5">
        <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1 text-center w-full">
            Sponsoren
        </h1>

        @auth
            @if(auth()->user()->isAdmin())
                <div class="flex justify-end my-4" >
                    <a href="{{ route('sponsors.create') }}"
                       class="inline-flex items-center bg-green-500 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-green-600 transition"
                       aria-label="Nieuwe sponsor toevoegen"><i class="fa-solid fa-plus mr-2" aria-hidden="true"></i>Sponsor toevoegen</a>
                </div>
            @endif
        @endauth

        <div class="flex flex-col flex-wrap my-4">
            <div class="grid md:grid-cols-2 gap-8 lg:gap-6 mx-auto">
                @foreach($sponsors as $sponsor)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                        <a href="{{ $sponsor->url }}" aria-label="Bezoek website van {{ $sponsor->name }}" target="_blank" rel="noopener noreferrer">
                            @if(isset($sponsor->image_path))
                                <img src="{{ asset('storage/' . $sponsor->image_path) }}" alt="{{ $sponsor->name }}" class="h-44 p-8 w-full object-contain">
                            @else
                            <div class="p-5 sm:h-44 flex items-center justify-center bg-gradient-to-r from-blue-400 to-purple-500" aria-hidden="true">
                                <h1 class="text-white text-3xl font-bold">{{ $sponsor->name ?? 'Sponsor' }}</h1>
                            </div>
                            @endif
                        </a>

                        @auth
                            @if(auth()->user()->isAdmin())
                                <div class="flex justify-end mt-4 mr-4">
                                    <a href="{{ route('sponsors.edit', $sponsor) }}"
                                       class="bg-blue-500 text-white py-1 px-3 rounded-md text-sm mr-2 hover:bg-blue-600 transition"
                                       aria-label="Bewerk sponsor {{ $sponsor->name }}">
                                        <i class="fa-solid fa-pencil mr-1" aria-hidden="true"></i> Bewerken
                                    </a>

                                    <form method="POST" action="{{ route('sponsors.destroy', $sponsor) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 text-white py-1 px-3 rounded-md text-sm hover:bg-red-600 transition"
                                                onclick="return confirm('Weet je zeker dat je deze sponsor wilt verwijderen?')"
                                                aria-label="Verwijder sponsor {{ $sponsor->name }}">
                                            <i class="fa-solid fa-trash mr-1" aria-hidden="true"></i> Verwijderen
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth

                        <div class="p-5">
                            @if(isset($sponsor->image_path))
                                <a href="{{ route('sponsors.show', $sponsor) }}" aria-label="Details bekijken van sponsor {{ $sponsor->name }}">
                                    <h5 class="text-2xl font-bold tracking-tight text-gray-900 mb-4">{{ $sponsor->name }}</h5>
                                </a>
                            @endif


                            <div class="mb-4 grow text-gray-700 relative overflow-hidden">
                                <p class="mb-3 font-normal text-gray-700 ">{!! $sponsor->formattedDescription !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if(Auth::check() && Auth::user()->isAdmin())
            <h2 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1 mt-8 text-center w-full">
                Inactieve Sponsoren
            </h2>
            @if($inactiveSponsors->isEmpty())
                <p class="text-gray-500 text-center mt-4 italic">Er zijn momenteel geen inactieve sponsoren.</p>
            @endif
            <div class="flex flex-col flex-wrap my-8">
                <div class="grid md:grid-cols-2 gap-8 lg:gap-6 mx-auto">
                    @foreach($inactiveSponsors as $inactiveSponsor)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                            <a href="{{ $inactiveSponsor->url }}" aria-label="Bezoek website van {{ $inactiveSponsor->name }}" target="_blank" rel="noopener noreferrer">
                                @if(isset($inactiveSponsor->image_path))
                                    <img src="{{ asset('storage/' . $inactiveSponsor->image_path) }}" alt="{{ $inactiveSponsor->name }}" class="h-44 p-8 w-full object-contain grayscale">
                                @else
                                    <div class="p-5 sm:h-44 flex items-center justify-center bg-gradient-to-r from-blue-400 to-purple-500" aria-hidden="true">
                                        <h1 class="text-white text-3xl font-bold">{{ $inactiveSponsor->name ?? 'Sponsor' }}</h1>
                                    </div>
                                @endif
                            </a>

                            @auth
                                @if(auth()->user()->isAdmin())
                                    <div class="flex justify-end mt-4 mr-4">
                                        <a href="{{ route('sponsors.edit-hidden', $inactiveSponsor) }}"
                                           class="bg-blue-500 text-white py-1 px-3 rounded-md text-sm mr-2 hover:bg-blue-600 transition"
                                           aria-label="Bewerk sponsor {{ $inactiveSponsor->name }}">
                                            <i class="fa-solid fa-pencil mr-1" aria-hidden="true"></i> Bewerken
                                        </a>

                                        <form method="POST" action="{{ route('sponsors.force-delete', $inactiveSponsor->id) }}" class="inline">
                                            @csrf
                                            @method('POST')
                                            <button type="submit"
                                                    class="bg-red-500 text-white py-1 px-3 rounded-md text-sm hover:bg-red-600 transition"
                                                    onclick="return confirm('Weet je zeker dat je deze sponsor wilt verwijderen?')"
                                                    aria-label="Verwijder sponsor {{ $inactiveSponsor->name }}">
                                                <i class="fa-solid fa-trash mr-1" aria-hidden="true"></i> Verwijderen
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth

                            <div class="p-5">
                                @if(isset($inactiveSponsor->image_path))
                                    <a href="{{ route('sponsors.show', $inactiveSponsor) }}" aria-label="Details bekijken van sponsor {{ $inactiveSponsor->name }}">
                                        <h5 class="text-2xl font-bold tracking-tight text-gray-900 mb-4">{{ $inactiveSponsor->name }}</h5>
                                    </a>
                                @endif


                                <div class="mb-4 grow text-gray-700 relative overflow-hidden">
                                    <p class="mb-3 font-normal text-gray-700 ">{!! $inactiveSponsor->formattedDescription !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layout>
