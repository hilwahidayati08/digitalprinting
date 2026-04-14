<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Digital Printing')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#1e40af',
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#1e40af',
                            600: '#1d4ed8',
                            700: '#1e3a8a',
                            800: '#1e3a8a',
                            900: '#172554',
                            950: '#0f172a',
                        },
                        secondary: {
                            DEFAULT: '#0891b2',
                            50: '#ecfeff',
                            100: '#cffafe',
                            200: '#a5f3fc',
                            300: '#67e8f9',
                            400: '#22d3ee',
                            500: '#0891b2',
                            600: '#0e7490',
                            700: '#155e75',
                            800: '#164e63',
                            900: '#083344',
                        },
                        accent: {
                            DEFAULT: '#c026d3',
                            50: '#fdf4ff',
                            100: '#fae8ff',
                            200: '#f5d0fe',
                            300: '#f0abfc',
                            400: '#e879f9',
                            500: '#c026d3',
                            600: '#a21caf',
                            700: '#86198f',
                            800: '#701a75',
                            900: '#4a044e',
                        },
                        printing: {
                            cyan: '#00aeef',
                            magenta: '#ec008c',
                            yellow: '#fff200',
                            black: '#231f20',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                        heading: ['Montserrat', 'Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'card': '0 4px 14px 0 rgba(30, 64, 175, 0.08)',
                        'card-hover': '0 8px 25px 0 rgba(30, 64, 175, 0.15)',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        /* Flash Alert */
        .flash-alert {
            position: relative;
            overflow: hidden;
            animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .flash-alert.dismissing {
            animation: slideUp 0.3s ease-in forwards;
        }

        .flash-progress {
            transition: width linear;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 1;
                transform: translateY(0);
                max-height: 100px;
            }

            to {
                opacity: 0;
                transform: translateY(-16px);
                max-height: 0;
                padding: 0;
                margin: 0;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Overlay untuk mobile sidebar */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            transition: opacity 0.3s ease;
        }

        /* Prevent body scroll when sidebar open on mobile */
        body.sidebar-open {
            overflow: hidden;
        }

        [x-cloak] {
            display: none !important;
        }

        @media (max-width: 768px) {
            .sidebar-overlay {
                backdrop-filter: blur(2px);
            }
        }

        /* --- Kunci: Layout satu halaman dengan scroll internal --- */
        /* html dan body diatur menjadi full height dengan overflow hidden */
        html,
        body {
            height: 100%;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }

        /* Container utama flex dengan height penuh, tidak overflow */
        .app-container {
            height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* Sidebar memiliki overflow auto untuk scroll internal */
        #sidebar {
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
        }

        /* Area konten utama: flex column dengan height penuh */
        .main-content-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            height: 100%;
        }

        /* Area main yang bisa di-scroll (termasuk footer di dalamnya) */
        .main-scrollable {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Konten dalam scrollable area */
        .scrollable-content {
            padding: 1rem;
        }

        @media (min-width: 768px) {
            .scrollable-content {
                padding: 1.5rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body x-data="{ sidebarOpen: false }" :class="{ 'sidebar-open': sidebarOpen }" class="font-sans bg-gray-50 text-gray-800">

    {{-- Container utama dengan height penuh dan overflow hidden --}}
    <div class="app-container">

        {{-- OVERLAY untuk mobile --}}
        <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false" class="sidebar-overlay md:hidden"
            style="display: none;"></div>

        {{-- Include Sidebar (sudah dimodifikasi untuk scroll internal) --}}
        @include('partials.admin.sidebar')

        {{-- Main Content Area dengan scroll internal (termasuk footer) --}}
        <div class="main-content-area">

            {{-- Header (static, tidak ikut scroll) --}}
            @include('partials.admin.header')

            {{-- Area scrollable yang berisi konten + footer --}}
            <main class="main-scrollable bg-gray-50 flex flex-col">
<div class="scrollable-content flex-1">
                    {{-- Flash Messages --}}
                    <div id="flash-container" class="mb-4 space-y-3">
                        @if (session('success'))
                            <div
                                class="flash-alert flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl shadow-sm">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-emerald-500 text-white rounded-full flex items-center justify-center shadow-sm">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                                <p class="text-sm font-semibold flex-1">{{ session('success') }}</p>
                                <button onclick="dismissAlert(this.parentElement)"
                                    class="text-emerald-400 hover:text-emerald-600 transition-colors ml-auto">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                                <div class="flash-progress absolute bottom-0 left-0 h-0.5 bg-emerald-400 rounded-full"
                                    style="width: 100%"></div>
                            </div>
                        @endif

                        @if (session('error'))
                            <div
                                class="flash-alert flex items-center gap-3 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl shadow-sm">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center shadow-sm">
                                    <i class="fas fa-times text-xs"></i>
                                </div>
                                <p class="text-sm font-semibold flex-1">{{ session('error') }}</p>
                                <button onclick="dismissAlert(this.parentElement)"
                                    class="text-red-400 hover:text-red-600 transition-colors ml-auto">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                                <div class="flash-progress absolute bottom-0 left-0 h-0.5 bg-red-400 rounded-full"
                                    style="width: 100%"></div>
                            </div>
                        @endif

                        @if (session('warning'))
                            <div
                                class="flash-alert flex items-center gap-3 p-4 bg-amber-50 border border-amber-100 text-amber-700 rounded-2xl shadow-sm">
                                <div
                                    class="flex-shrink-0 w-8 h-8 bg-amber-500 text-white rounded-full flex items-center justify-center shadow-sm">
                                    <i class="fas fa-exclamation text-xs"></i>
                                </div>
                                <p class="text-sm font-semibold flex-1">{{ session('warning') }}</p>
                                <button onclick="dismissAlert(this.parentElement)"
                                    class="text-amber-400 hover:text-amber-600 transition-colors ml-auto">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                                <div class="flash-progress absolute bottom-0 left-0 h-0.5 bg-amber-400 rounded-full"
                                    style="width: 100%"></div>
                            </div>
                        @endif
                    </div>

                    {{-- Page Content --}}
                    <div class="animate-fade-in">
                        @yield('content')
                    </div>
                </div>
                @stack('pagination')

                {{-- Include Footer - SEKARANG IKUT TER-SCROLL --}}
                @include('partials.admin.footer')


            </main>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Auto-hide success messages after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.bg-green-50, .bg-red-50').forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 300);
            });
        }, 5000);

        // Common functions
        function confirmDelete(message = 'Yakin menghapus data ini?') {
            return confirm(message);
        }

        // Optional: Fix untuk memastikan sidebar scroll bekerja dengan baik
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.style.overflowY = 'auto';
            }
        });
    </script>
    <script>
        function dismissAlert(el) {
            el.classList.add('dismissing');
            setTimeout(() => el.remove(), 300);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const DURATION = 4000; // 4 detik

            document.querySelectorAll('.flash-alert').forEach(alert => {
                const bar = alert.querySelector('.flash-progress');

                // Jalankan progress bar
                if (bar) {
                    bar.style.transition = `width ${DURATION}ms linear`;
                    setTimeout(() => bar.style.width = '0%', 50);
                }

                // Auto dismiss
                setTimeout(() => dismissAlert(alert), DURATION);
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
