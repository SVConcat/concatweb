<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <title>{{ config('app.name') }}</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @stack('styles')
    @stack('scripts')
</head>

<body>
    <!-- Desktop Navigation -->
    <div id="desktop-nav" class="sticky hidden lg:flex justify-center top-4 gap-10 z-10 text-white opacity-0 -translate-y-6 transition duration-500">
        <nav class="flex items-center px-6 py-2 w-fit rounded-3xl bg-[var(--blue)] shadow-2xl">
            <a href="{{ route('home') }}">
                <img src="https://svconcat.nl/media/assets/logo-white.svg" alt="Concat's logo" class="me-8 size-10">
            </a>
            <ul id="nav-links" class="flex items-center space-x-10 font-bold">
                <x-nav-link href="{{ route('events.index') }}">Evenementen</x-nav-link>
                <x-nav-link href="{{ route('community-nights.index') }}">Community Avonden</x-nav-link>
                <x-nav-link href="{{ route('gallery.index') }}"><i class="text-3xl fa-solid fa-image"></i></x-nav-link>
                <x-nav-link href="{{ route('sponsors.index') }}"><i class="text-3xl fa-solid fa-handshake"></i></x-nav-link>
                <x-nav-link href="{{ route('newsletters.index') }}"><i class="text-3xl fa-solid fa-envelope"></i></x-nav-link>
                <x-nav-link href="{{ route('assignments.index') }}"><i class="text-3xl fa-solid fa-briefcase"></i></x-nav-link>
                <x-nav-link href="{{ route('about-us.index') }}"><i class="text-3xl fa-solid fa-users"></i></x-nav-link>
                <x-nav-link href="{{ route('account.show') }}"><i class="text-3xl fa-solid fa-user"></i></x-nav-link>

                <a href="https://sv-concat.myspreadshop.nl/"><i class="text-3xl fa-solid fa-cart-shopping"></i></a>

                @guest
                    <x-nav-link href="{{ route('login') }}"><i class="text-3xl fa-solid fa-right-to-bracket"></i></x-nav-link>
                @endguest

                @auth
                    @if(Auth::user()->isAdmin())
                        <x-nav-link href="{{ route('roosters.index') }}"><i class="text-3xl fa-solid fa-calendar-days"></i></x-nav-link>
                    @endif
                @endauth

                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @method('POST')
                        @csrf
                        <button type="submit" class="x-nav-link">
                            <i class="text-3xl fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                @endauth
            </ul>
        </nav>
        <aside class="flex items-center px-4 py-2 w-fit rounded-3xl bg-[var(--blue)] shadow-2xl">
            <a href="{{ route('announcements.index') }}">
                <i class="text-3xl fa-solid fa-bell"></i>
            </a>
        </aside>
    </div>

    <!-- Mobile Navigation -->
    <div id="mobile-nav" class="sticky lg:hidden flex justify-between z-30 top-2 px-2 text-white opacity-0 -translate-y-6 transition duration-500">
        <button type="button" id="menu-open" class="flex items-center px-4 py-2 w-fit rounded-md bg-[var(--blue)] shadow-2xl">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
        <a href="{{ route('announcements.index') }}" class="flex items-center px-4 py-2 w-fit rounded-md bg-[var(--blue)] shadow-2xl">
            <i class="fa-solid fa-bell text-xl"></i>
        </a>
    </div>

    <!-- Sidebar -->
    <div id="mobile-sidebar" class="fixed flex-col justify-between items-start lg:hidden p-4 z-50 w-64 h-screen bg-[var(--blue)] text-white transform -translate-x-full transition duration-300">
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('home') }}">
                <img src="https://svconcat.nl/media/assets/logo-white.svg" alt="Concat's logo" class="me-8 size-10">
            </a>
            <button type="button" id="menu-close" class="p-4">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>
        <ul class="flex flex-col space-y-4 font-bold">
            <x-nav-link href="{{ route('events.index') }}">Evenementen</x-nav-link>
            <x-nav-link href="{{ route('community-nights.index') }}">Community Avonden</x-nav-link>
            <x-nav-link href="{{ route('gallery.index') }}">Galerij</x-nav-link>
            <x-nav-link href="{{ route('sponsors.index') }}">Sponsoren</x-nav-link>
            <x-nav-link href="{{ route('newsletters.index') }}">Nieuwsbrief</x-nav-link>
            <x-nav-link href="{{ route('assignments.index') }}">Opdrachten</x-nav-link>
            <x-nav-link href="{{ route('about-us.index') }}">Over ons</x-nav-link>
            <x-nav-link href="{{ route('account.show') }}">Account</x-nav-link>

            <a href="https://sv-concat.myspreadshop.nl/">Webshop</a>

            @guest
                <x-nav-link href="{{ route('login') }}">Inloggen</x-nav-link>
            @endguest

            @auth
                @if(Auth::user()->isAdmin())
                    <x-nav-link href="{{ route('roosters.index') }}">Roosters</x-nav-link>
                @endif
            @endauth

            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @method('POST')
                    @csrf
                    <button type="submit" class="x-nav-link">
                        Uitloggen
                    </button>
                </form>
            @endauth
        </ul>
    </div>

    <div id="mobile-overlay" class="fixed hidden lg:hidden z-40 inset-0 bg-black bg-opacity-30 backdrop-blur-sm"></div>

    <!-- Main Content -->
    <div id="page-content" class="flex justify-center items-center z-0 p-6 lg:mt-200 opacity-0 translate-y-4 transition-all duration-700 ease-out">
        {{ $slot }}
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-4 pb-3 text-center mt-auto">
        <div class="container mx-auto px-4">
            <!-- Flex container for responsiveness -->
            <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
                <!-- Social Media Links -->
                <div class="flex space-x-6">
                    <a href="https://www.instagram.com/svconcat" target="_blank" aria-label="Instagram"
                       class="hover:text-gray-400">
                        <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M7.75 2A5.75 5.75 0 002 7.75v8.5A5.75 5.75 0 007.75 22h8.5A5.75 5.75 0 0022 16.25v-8.5A5.75 5.75 0 0016.25 2h-8.5zM12 5.5a6.5 6.5 0 110 13 6.5 6.5 0 010-13zm0 10.5a4 4 0 100-8 4 4 0 000 8zm5-10.2a1.2 1.2 0 112.4 0 1.2 1.2 0 01-2.4 0z"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/company/sv-concat" target="_blank" aria-label="LinkedIn"
                       class="hover:text-gray-400">
                        <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M20.5 3h-17A1.5 1.5 0 002 4.5v15A1.5 1.5 0 003.5 21h17a1.5 1.5 0 001.5-1.5v-15A1.5 1.5 0 0020.5 3zM8 18H5V9h3v9zM6.5 7.5A1.5 1.5 0 116.5 4a1.5 1.5 0 010 3.5zM19 18h-3v-4.5c0-1.1 0-2.5-1.5-2.5S13 12.4 13 13.5V18h-3V9h3v1.2c.5-.8 1.4-1.2 2.5-1.2 2.5 0 3.5 1.6 3.5 4V18z"/>
                        </svg>
                    </a>
                    <a href="https://discord.gg/AMYt823VPJ" target="_blank" aria-label="Discord"
                       class="hover:text-gray-400">
                        <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M20.317 4.369a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.078.037c-.212.375-.455.864-.623 1.25a18.858 18.858 0 00-5.654 0c-.17-.396-.417-.875-.63-1.25a.077.077 0 00-.078-.037 19.736 19.736 0 00-4.885 1.515.07.07 0 00-.032.027C1.07 9.042-.3 13.561.022 18.032a.08.08 0 00.031.056 19.856 19.856 0 005.993 3.036.077.077 0 00.084-.028c.462-.631.873-1.295 1.226-1.98a.076.076 0 00-.041-.104 13.277 13.277 0 01-1.885-.902.077.077 0 01-.008-.127c.126-.094.251-.193.371-.296a.074.074 0 01.077-.01c3.967 1.813 8.27 1.813 12.206 0a.075.075 0 01.078.009c.12.103.245.202.372.297a.077.077 0 01-.007.126 13.207 13.207 0 01-1.886.902.076.076 0 00-.04.105c.354.685.765 1.35 1.226 1.98a.077.077 0 00.084.028 19.841 19.841 0 005.994-3.036.077.077 0 00.031-.056c.423-6.002-1.047-10.52-4.69-13.636a.062.062 0 00-.031-.027zM8.02 15.674c-1.182 0-2.157-1.086-2.157-2.418 0-1.331.946-2.418 2.157-2.418 1.224 0 2.158 1.099 2.157 2.418 0 1.332-.946 2.418-2.157 2.418zm7.962 0c-1.182 0-2.157-1.086-2.157-2.418 0-1.331.946-2.418 2.157-2.418 1.224 0 2.158 1.099 2.157 2.418 0 1.332-.946 2.418-2.157 2.418z"/>
                        </svg>
                    </a>
                </div>

                <!-- Privacy & Contact Links -->
                <div class="text-sm flex flex-col md:flex-row md:space-x-6">
                    <a href="/privacyverklaring" class="hover:text-gray-400">Privacyverklaring</a>
                    <span class="hidden md:inline">|</span>
                    <a href="mailto:info@svconcat.nl" class="hover:text-gray-400">info@svconcat.nl</a>
                    <span class="hidden md:inline">|</span>
                    <a href="{{ asset('storage/pdfs/statutensvconcat.pdf') }}" class="hover:text-gray-400">Regels en
                        statuten</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
