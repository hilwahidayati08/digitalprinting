<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Digital Printing')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS via CDN (SEMENTARA untuk testing) -->
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
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
    </style>
    
    @stack('styles')
</head>
<body class="font-sans bg-gray-50 text-gray-800 min-h-screen">
    <!-- Mobile Menu Button -->
    <button id="mobile-menu-button" class="md:hidden fixed top-4 left-4 z-50 p-2 bg-primary-600 text-white rounded-lg shadow-lg">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <!-- Main Layout -->
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @include('partials.admin.sidebar')
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col md:ml-0 w-full">
            <!-- Header -->
            @include('partials.admin.header')
            
            <!-- Main Content Area -->
            <main class="flex-1 p-4 md:p-6 bg-gray-50">
                <!-- Breadcrumb & Page Title -->
                
                <!-- Flash Messages -->
                <div class="mb-6">
                    @if(session('success'))
                        <div class="p-4 bg-green-50 border border-green-200 rounded-xl mb-4 animate-fade-in">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                                <p class="text-green-800 font-medium">{{ session('success') }}</p>
                                <button class="ml-auto text-green-600" onclick="this.parentElement.parentElement.remove()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Main Content -->
                <div class="animate-fade-in">
                    @yield('content')
                </div>

                @stack('pagination')
            </main>
            
            <!-- Footer -->
            @include('partials.admin.footer')
        </div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden"></div>

    <!-- JavaScript -->
    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const sidebar = document.getElementById('sidebar');
            const mobileOverlay = document.getElementById('mobile-menu-overlay');
            
            if (mobileMenuButton && sidebar && mobileOverlay) {
                mobileMenuButton.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                    mobileOverlay.classList.toggle('hidden');
                });
                
                mobileOverlay.addEventListener('click', function() {
                    sidebar.classList.add('-translate-x-full');
                    mobileOverlay.classList.add('hidden');
                });
            }
            
            // Auto-hide success messages after 5 seconds
            setTimeout(() => {
                document.querySelectorAll('.bg-green-50').forEach(el => {
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 300);
                });
            }, 5000);
        });
        
        // Common functions
        function confirmDelete(message = 'Yakin menghapus data ini?') {
            return confirm(message);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @stack('scripts')
</body>
</html>