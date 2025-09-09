<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-5xl mt-5 mb-5">

        @if(session('success'))
            <div class="w-full flex justify-center">
                <div class="max-w-md p-4 mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-lg">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1 text-center w-full">
            Community Avonden
        </h1>

        @auth
            @if(auth()->user()->role === 'admin')
                <div class="flex justify-end my-4">
                    <a href="{{ url('/community-nights/create') }}"
                       class="inline-flex items-center bg-green-500 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-green-600 transition"
                       aria-label="Nieuw community-avond toevoegen">
                        <i class="fa-solid fa-plus mr-2" aria-hidden="true"></i> Community Avond toevoegen
                    </a>
                </div>
            @endif
        @endauth

        <div class="flex flex-col flex-wrap my-4">
            <div class="grid sm:grid-cols-2 gap-8 lg:gap-6 mx-auto">
                @foreach($communityNights as $communityNight)
                    <div>
                        <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden flex flex-col h-full">
                            <a href="{{ route('community-nights.show', $communityNight) }}" class="block w-full aspect-square relative overflow-hidden">
                                @if(isset($communityNight->image))
                                    <img src="{{ asset('storage/' . $communityNight->image) }}"
                                         alt="{{ $communityNight->title }}"
                                         class="aspect-square object-cover w-full h-full">
                                @else
                                    <div
                                        class="p-5 flex items-center justify-center bg-gradient-to-r from-blue-400 to-purple-500 w-full h-full">
                                        <h1 class="text-white text-3xl font-bold text-center w-full break-words">{{ $communityNight->title ?? 'Community Night' }}</h1>
                                    </div>
                                @endif
                            </a>


                            @auth
                                @if(auth()->user()->role === 'admin')
                                    <div class="flex justify-end mb-4 gap-2 pt-2 pr-2">
                                        <a href="{{ route('community-nights.edit', $communityNight->id) }}"
                                           class="bg-[#3129FF] rounded-lg text-white py-1.5 px-3 hover:bg-[#E39FF6] transition text-sm">
                                            <i class="fa-solid fa-pencil mr-1" aria-hidden="true"></i>
                                            Bewerken
                                        </a>
                                        <form action="{{ route('community-nights.destroy', $communityNight->id) }}"
                                              method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    dusk="delete-communityNight-{{ $communityNight->id }}"
                                                    onclick="return confirm('Weet je zeker dat je deze Community Night wilt verwijderen?');"
                                                    class="bg-red-500 text-white py-1.5 px-3 rounded-lg hover:bg-red-600 transition text-sm">
                                                <i class="fa-solid fa-trash mr-1" aria-hidden="true"></i>
                                                Verwijderen
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth

                            <div class="p-5 flex flex-col flex-grow">
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
                                        <span class="text-md font-bold">{{ $communityNight->location ?? 'Locatie TBD' }}</span>
                                    </div>
                                @endif

                                <div class="flex flex-col justify-between max-h-40 mt-auto">
                                    <div class="mb-4 grow text-gray-700 relative overflow-hidden">
                                        <p class="mb-3 font-normal text-gray-700 ">{{ $communityNight->description }}</p>
                                        <div class="absolute bottom-0 left-0 w-full h-1/2 bg-gradient-to-b from-transparent to-white"></div>
                                    </div>

                                    <div>
                                        <a href="{{ route('community-nights.show', $communityNight) }}"
                                           class="inline-flex items-center text-sm text-center bg-[#3129FF] text-white py-2 px-4 rounded-lg hover:bg-[#E39FF6] transition font-semibold">
                                            Lees meer...
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="pagination-container" class="mt-6 text-center">
                {{ $communityNights->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-layout>

