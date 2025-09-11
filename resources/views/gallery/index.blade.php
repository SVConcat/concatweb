<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <title>SV Concat - Galerij</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>
    <x-layout>
        <div class="w-full">
            <div class="max-w-7xl mx-auto px-6 bg-gray-50 p-6 rounded-xl shadow-lg w-full my-5">
                <!-- Gecentreerde titel -->
                <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1 text-center w-full mb-5">
                    Galerij
                </h1>

                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="flex justify-end mb-4">
                            <a href="{{ route('gallery.create') }}"
                                class="inline-flex items-center bg-green-500 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-green-600 transition"
                                aria-label="Nieuwe foto toevoegen">
                                <i class="fa-solid fa-plus mr-2" aria-hidden="true"></i>Foto toevoegen
                            </a>
                        </div>
                    @endif
                @endauth

                <!-- Sorteerknop links / Filter -->
                <form method="GET" id="filterForm" class="mb-6">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Filter op:</label>
                    <select id="type" name="type"
                        class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                        aria-labelledby="galery-title" onchange="document.getElementById('filterForm').submit()">
                        <option value="" {{ request('type') == '' ? 'selected' : '' }}>Alle</option>
                        <option value="blokborrel" {{ request('type') == 'blokborrel' ? 'selected' : '' }}>Blokborrel</option>
                        <option value="education" {{ request('type') == 'education' ? 'selected' : '' }}>Education</option>
                    </select>
                </form>

                <!-- De foto-grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6" role="list">
                    @foreach($photos as $photo)
                        <div role="listitem" class="bg-white rounded-xl shadow-md p-4 cursor-pointer flex flex-col" tabindex="0"
                            aria-label="Bekijk foto {{ $photo['title'] }} van {{ $photo['date'] }}"
                            onclick="openModal('{{ e($photo['title']) }}', '{{ e($photo['date']) }}', '{{ e($photo['src']) }}')"
                            onkeypress="if(event.key === 'Enter' || event.key === ' ') openModal('{{ e($photo['title']) }}', '{{ e($photo['date']) }}', '{{ e($photo['src']) }}')">

                            <img src="{{ $photo['src'] }}" alt="Foto"
                                class="h-40 w-full object-contain bg-gray-100 rounded-lg mb-2" />

                            @auth
                                @if(auth()->user()->isAdmin())
                                    <div class="flex flex-col items-end mt-auto space-y-2">
                                        <a href="{{ route('gallery.edit', $photo['id']) }}"
                                            class="bg-blue-500 text-white py-1 px-3 rounded-md text-sm hover:bg-blue-600 transition"
                                            onclick="event.stopPropagation();" aria-label="Bewerk foto {{ $photo['title'] }}">
                                            <i class="fa-solid fa-pencil mr-1"></i> Bewerken
                                        </a>

                                        <form action="{{ route('gallery.destroy', $photo['id']) }}" method="POST"
                                            onsubmit="return confirm('Weet je zeker dat je deze foto wilt verwijderen?')"
                                            class="inline-block" onkeydown="event.stopPropagation();">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 text-white py-1 px-3 rounded-md text-sm hover:bg-red-600 transition"
                                                aria-label="Verwijder foto {{ $photo['title'] }}">
                                                <i class="fa-solid fa-trash mr-1"></i> Verwijderen
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-layout>

    <!-- Modal - buiten de layout component -->
    <div id="photoModal" role="dialog" aria-modal="true" aria-labelledby="eventName" aria-describedby="eventDate" onclick="handleBackdropClick(event)" class="gallery-modal" aria-hidden="true">

        <div class="gallery-modal-content">
            <button class="gallery-modal-close" onclick="closeModal()" aria-label="Sluit modal">×</button>
            <img src="" id="modalPhoto" alt="" class="gallery-modal-image" />
            <div class="gallery-modal-info">
                <span id="eventName">Evenement naam</span>
                <span id="eventDate">Datum</span>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('photoModal');
        const focusableSelectors = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
        let lastFocusedElement = null;

        function openModal(name, date, src) {
            lastFocusedElement = document.activeElement;

            document.getElementById('eventName').innerText = name;
            document.getElementById('eventDate').innerText = date;
            const modalImg = document.getElementById('modalPhoto');
            modalImg.src = src;
            modalImg.alt = `Foto van ${name} op ${date}`;

            modal.setAttribute('aria-hidden', 'false');

            // Eerst de modal display maken zonder animatie class
            modal.style.display = 'flex';
            modal.style.opacity = '1';
            modal.style.backdropFilter = 'blur(6px)';

            document.body.classList.add('modal-open');

            // Kleine vertraging om de browser de kans te geven de initiële state te renderen
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    modal.classList.add('gallery-modal-active');
                });
            });

            setTimeout(() => {
                modal.querySelector('button').focus();
            }, 500);
        }

        function closeModal() {
            modal.classList.add('gallery-modal-closing');

            setTimeout(() => {
                modal.setAttribute('aria-hidden', 'true');
                modal.classList.remove('gallery-modal-active', 'gallery-modal-closing');

                // Reset de inline styles
                modal.style.display = '';
                modal.style.opacity = '';
                modal.style.backdropFilter = '';

                document.body.classList.remove('modal-open');

                if (lastFocusedElement) {
                    lastFocusedElement.focus();
                }
            }, 300);
        }

        function handleBackdropClick(event) {
            if (event.target === event.currentTarget) {
                closeModal();
            }
        }

        // Escape key sluit modal
        window.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && modal.classList.contains('gallery-modal-active')) {
                closeModal();
            }
        });

        document.querySelectorAll('#filterForm select').forEach(select => {
            select.addEventListener('change', () => {
                document.getElementById('filterForm').submit();
            });
        });
    </script>
</body>
</html>
