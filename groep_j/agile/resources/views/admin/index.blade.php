<!DOCTYPE html>
<html
    class="h-full"
    data-theme="true"
    data-theme-mode="light"
    dir="ltr"
    lang="en"
>
@php
    if (strpos(Route::current()->getName(), '.') !== false) {
        $parts = explode('.', Route::current()->getName());
        $className = $parts[0]; // admin.events.index -> admin
    } else {
        $className = Route::current()->getName();
    }
@endphp

@include("admin.partials.head")

<body
    class="{{ $className }} antialiased flex h-full text-base text-gray-700
        [--tw-page-bg:var(--tw-coal-300)]
        [--tw-content-bg:var(--tw-light)]
        [--tw-content-bg-dark:var(--tw-coal-500)]
        [--tw-content-scrollbar-color:#e8e8e8]
        [--tw-header-height:60px]
        [--tw-sidebar-width:270px]
        bg-[--tw-page-bg] lg:overflow-hidden"
>
<!-- Theme Mode -->
<script>
    const defaultThemeMode = 'light';
    let themeMode;

    if (document.documentElement) {
        themeMode = localStorage.getItem('theme') ||
            document.documentElement.getAttribute('data-theme-mode') ||
            defaultThemeMode;

        if (themeMode === 'system') {
            themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }

        document.documentElement.classList.add(themeMode);
    }
</script>
<!-- End Theme Mode -->

<div class="flex grow">
    <!-- Header (Mobile) -->
    <header
        class="flex lg:hidden items-center fixed z-10 top-0 start-0 end-0 shrink-0 bg-[--tw-page-bg] h-[--tw-header-height]"
        id="header"
    >
        <div class="container-fixed flex items-center justify-between flex-wrap gap-3">
            <button
                class="btn btn-icon btn-light btn-clear btn-sm -me-2"
                data-drawer-toggle="#sidebar"
            >
                <i class="ki-filled ki-menu"></i>
            </button>
        </div>
    </header>
    <!-- End Header -->

    <!-- Wrapper -->
    <div class="flex flex-col lg:flex-row grow pt-[--tw-header-height] lg:pt-0">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')
        <!-- End Sidebar -->

        <!-- Main -->
        <div
            class="flex flex-col grow lg:rounded-l-xl bg-[--tw-content-bg] dark:bg-[--tw-content-bg-dark] border border-gray-300 dark:border-gray-200 lg:ms-[--tw-sidebar-width]"
        >
            <div
                class="flex flex-col grow lg:scrollable-y-auto lg:[scrollbar-width:auto] lg:light:[--tw-scrollbar-thumb-color:var(--tw-content-scrollbar-color)] pt-5"
                id="scrollable_content"
            >
                <main class="grow" role="content">
                    @yield("content")
                </main>
                @include("admin.partials.scripts")
            </div>
        </div>
        <!-- End Main -->
    </div>
    <!-- End Wrapper -->
</div>
</body>
</html>
