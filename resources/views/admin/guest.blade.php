<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@600;700;800&family=JetBrains+Mono&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <title>@yield('title', 'PrintPro - Digital Printing & Ecommerce')</title>
    <meta name="description" content="@yield('description', 'Solusi digital printing profesional dengan teknologi terkini. Company profile & ecommerce printing terpercaya.')">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'PrintPro - Digital Printing & Ecommerce')">
    <meta property="og:description" content="@yield('description', 'Solusi digital printing profesional dengan teknologi terkini.')">
    <meta property="og:image" content="@yield('og-image', asset('images/og-image.jpg'))">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'PrintPro - Digital Printing & Ecommerce')">
    <meta name="twitter:description" content="@yield('description', 'Solusi digital printing profesional dengan teknologi terkini.')">
    <meta name="twitter:image" content="@yield('og-image', asset('images/og-image.jpg'))">

    <style>
        /* Mencegah overflow horizontal */
        html, body {
            overflow-x: hidden !important;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        /* Animasi dasar untuk fade-in-up */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }
        [data-animate] {
            will-change: transform, opacity;
        }
    </style>
    @stack('head')
</head>
<body class="font-sans bg-gray-50 text-gray-800 antialiased">

    <!-- Loading Screen (opsional, bisa dihapus) -->
    <div id="loading" class="fixed inset-0 bg-white z-[9999] flex items-center justify-center transition-opacity duration-400">
        <div class="w-12 h-12 border-4 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
    </div>

    @include('partials.guest-navbar')

    <main id="main-content" class="flex-grow">
        <div class="min-h-screen">
            @yield('content')
        </div>
    </main>

    @include('partials.guest-footer')

    <!-- WhatsApp Floating Button -->
    <a href="https://api.whatsapp.com/send?phone={{ $settings->whatsapp_number ?? '6285810761209' }}&text=Halo%20PrintPro"
       target="_blank" rel="noopener noreferrer"
       class="fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:shadow-xl hover:bg-blue-700 transition-all duration-300 z-50 group"
       aria-label="Chat via WhatsApp">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.95.57 3.85 1.65 5.48L2 22l4.8-1.57c1.6.98 3.45 1.53 5.34 1.53 5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2z"/>
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m7-7v18" />
        </svg>
    </button>

    <script>
        // Loading screen
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

        // Back to top
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
            let scrollTimeout;
            window.addEventListener('scroll', function() {
                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(toggleBackToTop, 50);
            });
            backToTop.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        // Intersection Observer untuk animasi
        const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');
                    entry.target.classList.remove('opacity-0');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-animate]').forEach(el => {
                el.classList.add('opacity-0');
                observer.observe(el);
            });
        });

        // Cart counter (contoh)
        document.addEventListener('DOMContentLoaded', function() {
            const cartCount = document.getElementById('cart-count');
            function loadCart() {
                try {
                    const cartItems = JSON.parse(localStorage.getItem('printpro_cart')) || [];
                    const totalItems = cartItems.reduce((sum, item) => sum + (item.quantity || 0), 0);
                    if (cartCount) {
                        cartCount.textContent = totalItems;
                        if (totalItems === 0) cartCount.classList.add('hidden');
                        else cartCount.classList.remove('hidden');
                    }
                } catch (e) {
                    console.error('Cart error:', e);
                    localStorage.removeItem('printpro_cart');
                    if (cartCount) cartCount.classList.add('hidden');
                }
            }
            loadCart();
        });
    </script>

    @stack('scripts')
</body>
</html>