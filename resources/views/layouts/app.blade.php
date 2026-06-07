<!DOCTYPE html>
<html lang="id" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'POS Rumah Cake suprezz')</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#d2a689',
                            100: '#f4d3bf',
                            500: '#D9703E',
                            600: '#C1542A',
                            700: '#A24423',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        :root {
            --brand-primary: #D9703E;
            --brand-primary-dark: #C1542A;
            --brand-soft: #FFAA64;
            --bg-app: #F8F9FA;
            --bg-card: #FFFFFF;
            --bg-panel: #F4F5F7;
            --bg-input: #FAFAFA;
            --text-primary: #3F2B25;
            --text-secondary: #6B4F3F;
            --text-white: #FFFFFF;
            --text-muted: #6B4F3F;
            --text-muted-dark: #D8B298;
            --border-light: #E2E8F0;
            --border-soft: #F0F2F5;
            --star-active: #FFA800;
            --star-inactive: #E2E8F0;
        }

        .overlay-panel {
            background-color: rgba(59, 42, 34, 0.6);
        }

        .card-base {
            background-color: var(--bg-card);
            border-color: var(--border-light);
        }

        .card-header {
            background-color: var(--bg-panel);
            border-color: var(--border-light);
        }

        .title-primary,
        .text-primary {
            color: var(--text-primary);
        }

        .text-secondary,
        .text-muted {
            color: var(--text-secondary);
        }

        .text-accent {
            color: var(--brand-primary);
        }

        .btn-primary {
            background-color: var(--brand-primary);
            color: var(--text-white);
        }

        .btn-primary:hover,
        .btn-primary-hover:hover {
            background-color: var(--brand-primary-dark);
        }

        .btn-soft {
            background-color: var(--brand-soft);
            color: var(--text-primary);
        }

        .input-surface {
            background-color: var(--bg-input);
            border-color: var(--border-light);
            color: var(--text-primary);
        }

        .border-light {
            border-color: var(--border-light) !important;
        }

        .bg-brand-primary {
            background-color: var(--brand-primary) !important;
        }

        .bg-brand-primary-dark {
            background-color: var(--brand-primary-dark) !important;
        }

        .bg-brand-soft {
            background-color: var(--brand-soft) !important;
        }

        .text-brand-white {
            color: var(--text-white) !important;
        }

        .dark .card-base {
            background-color: var(--bg-card);
            border-color: var(--border-light);
        }

        .dark .card-header {
            background-color: var(--bg-panel);
            border-color: var(--border-light);
        }

        .dark .title-primary {
            color: var(--text-white);
        }

        .dark .text-muted {
            color: var(--text-muted-dark);
        }

        body {
            background-color: var(--bg-app);
            color: var(--text-primary);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }
        .surface-card {
            background-color: var(--bg-card); /* cards white for contrast */
        }
        .surface-panel {
            background-color: var(--bg-panel); /* subtle panel surface */
        }
        .text-secondary {
            color: var(--text-secondary); /* warm taupe for secondary text */
        }
        .text-muted-blue {
            color: #A39288;
        }
        .accent-bg {
            background-color: #D9703E !important; /* keep warm orange accent */
        }
        .accent-hover:hover {
            background-color: #C1542A !important;
        }
        .accent-ring:focus {
            box-shadow: 0 0 0 3px rgba(217, 112, 62, 0.25);
        }
        .bg-red-600 { background-color: #D9703E !important; }
        .hover\:bg-red-700:hover { background-color: #C1542A !important; }
        .text-red-600 { color: #D9703E !important; }
        .dark .text-red-400 { color: #C1542A !important; }
        .text-red-500 { color: #C1542A !important; }
        .bg-red-100 { background-color: #EECFBC !important; }
        .bg-red-50 { background-color: #F4E3D9 !important; }
        .text-red-700 { color: #A24423 !important; }
        .border-red-200 { border-color: #CD9A82 !important; }
        .dark .text-red-300 { color: #C1542A !important; }
        .hover\:text-red-500:hover { color: #C1542A !important; }
        .focus\:ring-red-500:focus { box-shadow: 0 0 0 3px rgba(217, 112, 62, 0.25); }
        .from-red-600 { --tw-gradient-from: #D9703E !important; }
        .to-red-700 { --tw-gradient-to: #A24423 !important; }
        .hover\:from-red-700:hover { --tw-gradient-from: #C1542A !important; }
        .hover\:to-red-800:hover { --tw-gradient-to: #A24423 !important; }

        /* Dark mode warm bakery palette (lightened for better contrast) */
        .dark body {
            background-color: #3F2A20; /* warmer brown dark background */
            color: #F4E3D9;
        }
        .dark .bg-[#EAD9CE] { background-color: #4A352D !important; }
        .dark .bg-[#F3E3D7] { background-color: #3F2A20 !important; }
        .dark .bg-[#F4E3D9] { background-color: #3F2A20 !important; }
        .dark .bg-[#ECDCCB] { background-color: #4A352D !important; }
        .dark .bg-[#D9B89F] { background-color: #4A352D !important; }
        .dark .bg-[#D0B09A] { background-color: #4A352D !important; }
        .dark .text-gray-900 { color: #d97338 !important; }
        .dark .text-gray-500 { color: #ce6828 !important; }
        .dark .text-gray-400 { color: #cd782e !important; }
        .dark .text-gray-300 { color: #c56022 !important; }
        .dark .bg-gray-50 { background-color: #3B2A22 !important; }
        .dark .bg-gray-700 { background-color: #403029 !important; }
        .dark .bg-gray-800 { background-color: #3B2A22 !important; }
        .dark .border-gray-300 { border-color: #6B4F3F !important; }
        .dark .border-gray-600 { border-color: #4A352D !important; }
        .dark .hover\:bg-gray-50:hover { background-color: #5C3C2E !important; }
        .dark .dark\:bg-gray-700 { background-color: #403029 !important; }
        .dark .dark\:bg-gray-800 { background-color: #43352D !important; }
        .dark .dark\:text-gray-300 { color: #ba6028 !important; }
        .dark .dark\:text-gray-400 { color: #c66715 !important; }
        /* Card & price enhancements */
        .card-strong { box-shadow: 0 8px 20px rgba(45,30,20,0.08); border-radius: 14px; }
        .menu-price { font-size: 1.25rem; font-weight: 800; color: #D9703E; }
        /* Cart FAB style */
        .cart-fab-btn { background: linear-gradient(180deg,#D9703E,#C1542A); box-shadow: 0 8px 18px rgba(193,84,46,0.18); }
        .cart-fab-badge { background: #FFF; color: #D9703E; }
        .bg-red-900\/20 { background-color: rgba(169, 54, 30, 0.2) !important; }
        .dark .bg-red-900\/30 { background-color: rgba(193, 84, 42, 0.3) !important; }
        .text-gray-900 { color: #2C1A11 !important; }
        .text-gray-700 { color: #7A6A61 !important; }
        .bg-gray-50 { background-color: #EAD9CE !important; }
        .bg-white { background-color: #F4E3D9 !important; }
        .bg-gray-100 { background-color: #E5D2C5 !important; }
        .border-gray-200 { border-color: #D8C3B7 !important; }
        .border-gray-300 { border-color: #C7B8AA !important; }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen text-[#2C1A11] transition-colors duration-200">
    @yield('content')

    <script>
        // Init dark mode before page render to prevent flash
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @stack('scripts')
</body>
</html>
