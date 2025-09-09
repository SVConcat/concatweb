<div class="flex-col fixed top-0 bottom-0 z-20 hidden lg:flex items-stretch shrink-0 w-[--tw-sidebar-width] dark" id="sidebar">
    <!-- Sidebar Header with Logo -->
    <div class="flex flex-col items-center py-5 space-y-2">
        <a href="/" class="flex flex-col items-center">
            <img src="{{ asset('assets/images/logo-white.png') }}" alt="Home" class="w-8 h-auto">
            <span class="text-sm text-white font-medium">{{ config('app.url') }}</span>
        </a>
    </div>

    <!-- Sidebar Menu -->
    <div class="flex items-stretch grow shrink-0 justify-center my-5" id="sidebar_menu">
        <div class="scrollable-y-auto grow [--tw-scrollbar-thumb-color:var(--tw-gray-300)]" data-scrollable="true">
            <div class="mb-5">
                <div class="menu flex flex-col w-full gap-1.5 px-3.5" id="sidebar_primary_menu">
                    @foreach([
                        ['route' => 'admin.events.index', 'label' => 'Evenementen / Community'],
                        ['route' => 'admin.announcements.index', 'label' => 'Nieuws'],
                        ['route' => 'admin.sponsors.index', 'label' => 'Sponsoren'],
                        ['route' => 'admin.statues.index', 'label' => 'Statuten'],
                        ['route' => 'admin.board.index', 'label' => 'Bestuur leden'],
                        ['route' => 'admin.old_boards.index', 'label' => 'Oude besturen'],
                        ['route' => 'admin.commission.index', 'label' => 'Commissies'],
                        ['route' => 'admin.gallery.index', 'label' => 'Gallerij'],
                        ['route' => 'admin.assignments.index', 'label' => 'Prikbord'],
                        ['route' => 'admin.weeztix.index', 'label' => 'Weeztix'],
                        ['route' => 'admin.newsletter.index', 'label' => 'Nieuwsbrief']
                    ] as $item)
                        <div class="menu-item">
                            <a class="no-line menu-link gap-2.5 py-2 px-2.5 rounded-md menu-item-active:bg-gray-100 menu-link-hover:bg-gray-100 !menu-item-here:bg-transparent"
                               href="{{ route($item['route']) }}">
                                <span class="menu-icon items-start text-lg text-gray-600 menu-item-active:text-gray-900">
                                    <i class="ki-filled ki-home-3"></i>
                                </span>
                                <span class="menu-title text-sm text-gray-800 font-medium menu-item-here:text-gray-900">
                                    {{ $item['label'] }}
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Logout Button -->
            <div class="mt-auto p-3">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-auto flex items-center justify-center gap-2 py-1 px-3 text-xs font-medium text-white bg-red-600 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 transition-all">
                        <i class="ki-filled ki-logout"></i>
                        Uitloggen
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
