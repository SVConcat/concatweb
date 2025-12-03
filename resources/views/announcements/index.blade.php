<x-layout>
    <div class="container max-w-4xl mx-auto px-4 py-8 bg-white rounded-lg shadow-xl mt-5">
        <div class="flex flex-col mb-8">
            <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1 text-center w-full">
                Aankondigingen
            </h1>

            @auth
                @if(auth()->user()->isAdmin())
                    <div class="flex justify-end my-4">
                        <a href="{{ route('announcements.create') }}"
                           class="inline-flex items-center bg-green-500 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-green-600 transition">
                           <i class="fa-solid fa-plus mr-2" aria-hidden="true"></i> Nieuwe aankondiging maken</a>
                    </div>
                @endif
            @endauth
        </div>

        <div id="announcements-container">
            {{-- Zichtbare announcements --}}
            @if(count($groupedVisible) > 0)
                @include('announcements.partials.list', [
                    'groupedAnnouncements' => $groupedVisible,
                    'showAdminControls' => $showAdminControls
                ])
            @else
                <div class="text-center p-8 bg-gray-50 rounded-lg">
                    <p class="text-gray-500 italic">Er zijn momenteel geen aankondigingen</p>
                </div>
            @endif

            {{-- Niet-zichtbare voor admins --}}
            @auth
                @if(auth()->user()->isAdmin() && count($groupedNonVisible) > 0)
                    <div class="mt-8 pt-6 border-t-2 border-gray-200">
                        <h2 class="text-xl font-bold mb-4 text-gray-500">Niet-zichtbare aankondigingen</h2>
                        @include('announcements.partials.list', [
                            'groupedAnnouncements' => $groupedNonVisible,
                            'showAdminControls' => true
                        ])
                    </div>
                @endif
            @endauth
        </div>
    </div>
</x-layout>
