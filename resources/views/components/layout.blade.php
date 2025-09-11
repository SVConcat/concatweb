<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <title>SV Concat</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    {{-- @vite(['resources/img/logo-white.png']) --}}

</head>

<body>

    @if (request()->is('/'))
        <div class="text-center p-6 lg:py-16"> {{-- Adjust padding as needed --}}
            <h2 class="text-3xl font-light text-gray-700"> {{-- Adjust styling as needed --}}
                Welkom bij
            </h2>
            <h1 class="text-5xl font-bold text-blue-600 mt-2"> {{-- Adjust styling as needed --}}
                Studievereniging Concat
            </h1>
            {{-- You can add more introductory text or elements here --}}
        </div>
    @endif

    <div class="nav-container px-6">
        <!-- Desktop Navigation -->
        <nav id="main-nav" class="opacity-0 -translate-y-6 transition-all duration-700 ease-out">
            <a href="/" class="flex items-center mr-2">
                <img src="https://svconcat.nl/media/assets/logo-white.svg" alt="Concat Logo" class="h-10 w-auto">
            </a>
            <div class="flex horizontal spaced centered">
                <div class="flex" id="menu-links">
                    <x-nav-link href="/events/index">Evenementen</x-nav-link>
                    <x-nav-link href="/community-nights">Community Avonden</x-nav-link>
                    <x-nav-link href="/gallery"><i class="text-xl fa-solid fa-image"></i></x-nav-link>
                    <x-nav-link href="{{ route('sponsors.index')  }}"><i
                            class="text-xl fa-solid fa-handshake"></i></x-nav-link>
                    <x-nav-link href="/newsletters"><i class="text-xl fa-solid fa-envelope"></i></x-nav-link>
                    <x-nav-link href="{{ route('assignments.index') }}"><i
                            class="text-xl fa-solid fa-briefcase"></i></x-nav-link>
                    <x-nav-link href="/about-us"><i class="text-xl fa-solid fa-users"></i></x-nav-link>
                    <x-nav-link href="/account"><i class="text-xl fa-solid fa-user"></i></x-nav-link>

                    <a href="https://sv-concat.myspreadshop.nl/" redirect="https://sv-concat.myspreadshop.nl/"><i
                            class="text-xl fa-solid fa-cart-shopping"></i></a>

                    @guest
                        <!-- <x-nav-link href="/register">Registreren</x-nav-link> -->
                        <x-nav-link href="/login"><i class="text-2xl fa-solid fa-right-to-bracket"></i></x-nav-link>
                    @endguest

                    @auth
                        @if(Auth::user()->isAdmin())
                            <x-nav-link href="/roosters"><i class="text-xl fa-solid fa-calendar-days"></i></x-nav-link>
                        @endif
                    @endauth

                    @auth
                        <form action="{{ route('logout') }}" method="POST" style="display:flex;">
                            @csrf
                            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="x-nav-link">
                                <i class="text-2xl fa-solid fa-right-from-bracket"></i>
                            </a>
                        </form>
                    @endauth

                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobile-menu">
            <div id="menu-links-mobile">
                <button class="close-btn">✕</button>
                <a href="/" class="flex items-center mr-2">
                    <img src="https://svconcat.nl/media/assets/logo-white.svg" alt="Concat Logo" class="h-10 w-auto">
                </a>
                <x-nav-link href="/events/index">Evenementen</x-nav-link>
                <x-nav-link href="/community-nights">Community Avonden</x-nav-link>

                <x-nav-link href="/gallery">
                    <i class="text-xl fa-solid fa-image"></i>
                    <span class="ml-2">Galerij</span>
                </x-nav-link>

                <x-nav-link href="{{ route('sponsors.index')  }}">
                    <i class="text-xl fa-solid fa-handshake"></i>
                    <span class="ml-2">Sponsoren</span>
                </x-nav-link>

                <x-nav-link href="/newsletters">
                    <i class="text-xl fa-solid fa-envelope"></i>
                    <span class="ml-2">Nieuwsbrief</span>
                </x-nav-link>

                <x-nav-link href="{{ route('assignments.index') }}">
                    <i class="text-xl fa-solid fa-briefcase"></i>
                    <span class="ml-2">Opdrachten</span>
                </x-nav-link>

                <x-nav-link href="/about-us">
                    <i class="text-xl fa-solid fa-users"></i>
                    <span class="ml-2">About Us</span>
                </x-nav-link>

                <x-nav-link href="/account">
                    <i class="text-xl fa-solid fa-user"></i>
                    <span class="ml-2">Account</span>
                </x-nav-link>

                @guest
                    <x-nav-link href="/login">
                        <i class="text-xl fa-solid fa-right-to-bracket"></i>
                        <span class="ml-2">Inloggen</span>
                    </x-nav-link>
                @endguest
                @auth
                    @if(Auth::user()->isAdmin())
                        <x-nav-link href="/roosters"><i class="text-xl fa-solid fa-calendar-days"></i></x-nav-link>
                    @endif
                @endauth

                @auth
                    <form action="{{ route('logout') }}" method="POST" style="display:flex;">
                        @csrf
                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="x-nav-link">
                            Uitloggen
                        </a>
                    </form>
                @endauth
            </div>
        </div>
        <div class="overlay"></div>
        <a href="{{ route('announcements.index') }}" id="bell-icon"
            class="absolute right-[2%] z-50 flex items-center justify-center h-16 w-16 bg-white rounded-full shadow-md hover:shadow-lg transition-all hover:scale-105"
            title="Bekijk aankondigingen" aria-label="Aankondigingen">
            <i class="fa-solid fa-bell text-gray-700 text-xl"></i>
            <!-- Notificatie indicator
        <span class="absolute -top-1 -right-1 bg-red-500 text-xs text-white rounded-full px-2 py-1"></span>-->
        </a>

        <button id="nav-button" class="hamburger"></button>
    </div>

    <!-- Nieuwe bel-icoon knop -->



    <div id="page-content"
        class="flex justify-center items-center p-6 lg:mt-200 opacity-0 translate-y-4 transition-all duration-700 ease-out">
        {{ $slot }}
    </div>

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
                                d="M7.75 2A5.75 5.75 0 002 7.75v8.5A5.75 5.75 0 007.75 22h8.5A5.75 5.75 0 0022 16.25v-8.5A5.75 5.75 0 0016.25 2h-8.5zM12 5.5a6.5 6.5 0 110 13 6.5 6.5 0 010-13zm0 10.5a4 4 0 100-8 4 4 0 000 8zm5-10.2a1.2 1.2 0 112.4 0 1.2 1.2 0 01-2.4 0z" />
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/company/sv-concat" target="_blank" aria-label="LinkedIn"
                        class="hover:text-gray-400">
                        <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M20.5 3h-17A1.5 1.5 0 002 4.5v15A1.5 1.5 0 003.5 21h17a1.5 1.5 0 001.5-1.5v-15A1.5 1.5 0 0020.5 3zM8 18H5V9h3v9zM6.5 7.5A1.5 1.5 0 116.5 4a1.5 1.5 0 010 3.5zM19 18h-3v-4.5c0-1.1 0-2.5-1.5-2.5S13 12.4 13 13.5V18h-3V9h3v1.2c.5-.8 1.4-1.2 2.5-1.2 2.5 0 3.5 1.6 3.5 4V18z" />
                        </svg>
                    </a>
                    <a href="https://discord.gg/AMYt823VPJ" target="_blank" aria-label="Discord"
                        class="hover:text-gray-400">
                        <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path
                                d="M20.317 4.369a19.791 19.791 0 00-4.885-1.515.074.074 0 00-.078.037c-.212.375-.455.864-.623 1.25a18.858 18.858 0 00-5.654 0c-.17-.396-.417-.875-.63-1.25a.077.077 0 00-.078-.037 19.736 19.736 0 00-4.885 1.515.07.07 0 00-.032.027C1.07 9.042-.3 13.561.022 18.032a.08.08 0 00.031.056 19.856 19.856 0 005.993 3.036.077.077 0 00.084-.028c.462-.631.873-1.295 1.226-1.98a.076.076 0 00-.041-.104 13.277 13.277 0 01-1.885-.902.077.077 0 01-.008-.127c.126-.094.251-.193.371-.296a.074.074 0 01.077-.01c3.967 1.813 8.27 1.813 12.206 0a.075.075 0 01.078.009c.12.103.245.202.372.297a.077.077 0 01-.007.126 13.207 13.207 0 01-1.886.902.076.076 0 00-.04.105c.354.685.765 1.35 1.226 1.98a.077.077 0 00.084.028 19.841 19.841 0 005.994-3.036.077.077 0 00.031-.056c.423-6.002-1.047-10.52-4.69-13.636a.062.062 0 00-.031-.027zM8.02 15.674c-1.182 0-2.157-1.086-2.157-2.418 0-1.331.946-2.418 2.157-2.418 1.224 0 2.158 1.099 2.157 2.418 0 1.332-.946 2.418-2.157 2.418zm7.962 0c-1.182 0-2.157-1.086-2.157-2.418 0-1.331.946-2.418 2.157-2.418 1.224 0 2.158 1.099 2.157 2.418 0 1.332-.946 2.418-2.157 2.418z" />
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
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const content = document.getElementById('page-content');
            if (content) {
                requestAnimationFrame(() => {
                    content.classList.remove('opacity-0', 'translate-y-4');
                    content.classList.add('opacity-100', 'translate-y-0');
                });
            }
        });

        window.addEventListener('DOMContentLoaded', () => {
            const nav = document.getElementById('main-nav');
            const content = document.getElementById('page-content');

            requestAnimationFrame(() => {
                if (nav) {
                    nav.classList.remove('opacity-0', '-translate-y-6');
                    nav.classList.add('opacity-100', 'translate-y-0');
                }

                if (content) {
                    content.classList.remove('opacity-0', 'translate-y-4');
                    content.classList.add('opacity-100', 'translate-y-0');
                }
            });
        });
    </script>
</body>

</html>
