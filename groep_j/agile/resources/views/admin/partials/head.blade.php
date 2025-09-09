<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="robots" content="follow, index" />
    <meta name="description" content="Beheeromgeving van de admin." />

    <!-- SEO & Social -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Admin Dashboard" />
    <meta property="og:locale" content="nl_NL" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="Adminomgeving" />
    <meta property="og:title" content="Admin Dashboard" />
    <meta property="og:url" content="{{ url()->current() }}" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.0/min/dropzone.min.css"> <!-- todo download instead of cdn (dropzone) -->

    <!-- Vendor Styles -->
    <link href="{{ asset('assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />

    <!-- App Styles -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/admin.css') }}" rel="stylesheet" />
    @stack('styles')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</head>
