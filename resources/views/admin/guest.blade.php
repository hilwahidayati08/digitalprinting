<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Page Title -->
    <title>@yield('title', 'PrintPro - Digital Printing & Ecommerce')</title>

    <!-- Meta Description -->
    <meta name="description" content="@yield('description', 'Solusi digital printing profesional dengan teknologi terkini. Company profile & ecommerce printing terpercaya.')">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'PrintPro - Digital Printing & Ecommerce')">
    <meta property="og:description" content="@yield('description', 'Solusi digital printing profesional dengan teknologi terkini.')">
    <meta property="og:image" content="@yield('og-image', asset('images/og-image.jpg'))">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'PrintPro - Digital Printing & Ecommerce')">
    <meta property="twitter:description" content="@yield('description', 'Solusi digital printing profesional dengan teknologi terkini.')">
    <meta property="twitter:image" content="@yield('og-image', asset('images/og-image.jpg'))">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    /* Memaksa elemen tidak keluar jalur */
    html, body {
        position: relative;
        overflow-x: hidden !important;
        width: 100%;
        margin: 0;
        padding: 0;
    }
    
    /* Menghapus potensi margin negatif dari baris Tailwind yang bocor */
    .container {
        overflow: hidden;
    }

    /* Mencegah animasi fade-in mendorong lebar layar */
    [data-animate] {
        will-change: transform, opacity;
    }
</style>
    @stack('head')
</head>

<body class="font-sans bg-gray-50 text-gray-800 antialiased">
    <!-- Loading Animation -->
    <div id="loading"
        class="fixed inset-0 bg-white z-[9999] flex items-center justify-center transition-opacity duration-500">
        <div class="text-center">
            <!-- Modern Loading Animation -->
            <div class="relative w-20 h-20 mx-auto mb-6">
                <div class="absolute inset-0 border-4 border-blue-200 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-blue-600 rounded-full border-t-transparent animate-spin"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                </div>
            </div>
            <p class="text-base font-medium text-gray-700">Memuat PrintPro...</p>
            <p class="text-sm text-gray-400 mt-1">Solusi Digital Printing Profesional</p>
        </div>
    </div>

    <!-- Skip to Content -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md z-[1000] shadow-sm">
        Lewati ke konten
    </a>

    <!-- Navigation -->
    @include('partials.guest-navbar')

    <!-- Main Content -->
    <main id="main-content" class="flex-grow">
        <div class="min-h-screen">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    @include('partials.guest-footer')

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/6285810761209?text=Halo%20PrintPro" 
       target="_blank"
       class="fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:shadow-xl hover:bg-blue-700 transition-all duration-300 z-50 group"
       aria-label="Chat via WhatsApp">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.95.57 3.85 1.65 5.48L2 22l4.8-1.57c1.6.98 3.45 1.53 5.34 1.53 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2zm5.67 14.14c-.29.82-1.46 1.5-2.39 1.59-.64.06-1.44.11-2.55-.19-1.39-.38-2.73-1.21-3.89-2.21-1.12-.96-2.01-2.14-2.56-3.24-.36-.71-.57-1.37-.62-1.96-.05-.58.1-1.13.38-1.58.29-.46.7-.8 1.15-.97.27-.1.52-.15.75-.15.21 0 .4.02.57.09.16.07.3.24.4.51.2.48.55 1.28.6 1.37.05.1.09.22.02.35-.06.13-.12.23-.22.36-.1.12-.2.24-.29.36-.1.12-.2.24-.09.44.1.2.45.74.97 1.2.67.6 1.24.87 1.42.96.18.09.3.08.41-.02.1-.1.44-.51.56-.68.12-.17.24-.14.4-.08.16.06.98.46 1.15.54.17.08.28.12.33.19.06.07.06.42-.23.97-.29.55-1.08 1.07-1.5 1.17-.31.07-.67.11-1.03-.07-.3-.15-1.21-.46-2.26-1.32-.88-.72-1.48-1.55-1.66-1.86-.17-.31-.19-.56-.13-.75.05-.17.12-.27.19-.36.07-.09.15-.19.22-.3.07-.11.1-.19.07-.3-.03-.11-.05-.2-.09-.3-.04-.1-.24-.58-.33-.8-.09-.22-.18-.18-.24-.18h-.2c-.07 0-.18.02-.28.13-.1.11-.39.38-.39.94 0 .56.41 1.1.47 1.17.06.07.8 1.22 1.94 1.71.27.12.48.19.65.24.27.08.52.07.73.02.23-.06.69-.28.79-.56.1-.28.1-.52.07-.58-.03-.06-.14-.09-.29-.16z"/>
        </svg>
        <span class="absolute right-full mr-3 top-1/2 -translate-y-1/2 bg-gray-900 text-white text-sm px-3 py-1.5 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap pointer-events-none">
            Chat WhatsApp
        </span>
    </a>

    <!-- Back to Top -->
    <button id="back-to-top"
        class="fixed bottom-6 left-6 bg-white text-blue-600 p-3 rounded-full shadow-md hover:shadow-lg transition-all duration-300 opacity-0 invisible hover:bg-blue-50 border border-gray-200 z-50"
        aria-label="Kembali ke atas">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <!-- Scripts -->
    <script>
        // Hide loading screen
// Ganti SEMUA script loading dengan ini:
document.addEventListener('DOMContentLoaded', function() {
    const loading = document.getElementById('loading');
    if (loading) {
        loading.classList.add('opacity-0');
        setTimeout(() => loading.style.display = 'none', 400);
    }
});

setTimeout(function() {
    const loading = document.getElementById('loading');
    if (loading) loading.style.display = 'none';
}, 2000);
        // Back to top button with debounce
        document.addEventListener('DOMContentLoaded', function() {
            const backToTop = document.getElementById('back-to-top');
            
            function toggleBackToTop() {
                if (window.pageYOffset > 300) {
                    backToTop.classList.remove('opacity-0', 'invisible');
                    backToTop.classList.add('opacity-100', 'visible');
                } else {
                    backToTop.classList.remove('opacity-100', 'visible');
                    backToTop.classList.add('opacity-0', 'invisible');
                }
            }

            // Debounce scroll event for better performance
            let scrollTimeout;
            window.addEventListener('scroll', function() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(toggleBackToTop, 50);
            });

            backToTop.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });

        // Intersection Observer for animations (modern version)
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                    entry.target.classList.remove('opacity-0');
                    observer.unobserve(entry.target); // Stop observing once animated
                }
            });
        }, observerOptions);

        // Observe elements with data-animate attribute
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-animate]').forEach(el => {
                el.classList.add('opacity-0');
                observer.observe(el);
            });
        });

        // Shopping cart functionality with error handling
        document.addEventListener('DOMContentLoaded', function() {
            const cartCount = document.getElementById('cart-count');
            
            function loadCart() {
                try {
                    const cartItems = JSON.parse(localStorage.getItem('printpro_cart')) || [];
                    const totalItems = cartItems.reduce((sum, item) => sum + (item.quantity || 0), 0);
                    
                    if (cartCount) {
                        cartCount.textContent = totalItems;
                        if (totalItems === 0) {
                            cartCount.classList.add('hidden');
                        } else {
                            cartCount.classList.remove('hidden');
                        }
                    }
                } catch (e) {
                    console.error('Failed to load cart:', e);
                    localStorage.removeItem('printpro_cart'); // Reset corrupted data
                    if (cartCount) {
                        cartCount.classList.add('hidden');
                    }
                }
            }

            loadCart();
        });
    </script>

    @stack('scripts')
</body>
</html>