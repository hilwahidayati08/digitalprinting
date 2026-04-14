<section class="relative min-h-[85vh] flex items-center bg-neutral-900 overflow-hidden">

    {{-- Background Image --}}
    <div class="absolute inset-0 z-0">
        <img src="{{ $hero->photo ? asset('storage/heros/' . $hero->photo) : asset('images/no-image.png') }}"
             alt="Hero Background"
             class="w-full h-full object-cover object-center opacity-40">
    </div>

    {{-- CMYK Dots --}}
    <div class="absolute top-10 left-10 w-3 h-3 bg-cyan-400 rounded-full animate-bounce opacity-60"></div>
    <div class="absolute top-20 right-20 w-4 h-4 bg-pink-500 rounded-full animate-pulse opacity-60"></div>
    <div class="absolute bottom-20 left-1/4 w-3.5 h-3.5 bg-yellow-400 rounded-full animate-bounce opacity-60" style="animation-delay:.3s"></div>
    <div class="absolute bottom-10 right-1/3 w-2.5 h-2.5 bg-neutral-400 rounded-full animate-pulse opacity-60" style="animation-delay:.5s"></div>

    {{-- Decorative line kiri --}}
    <div class="absolute left-8 top-1/2 -translate-y-1/2 hidden lg:flex flex-col items-center gap-3 z-10">
        <div class="w-px h-20 bg-gradient-to-b from-transparent via-white/30 to-white/10"></div>
        <div class="w-1.5 h-1.5 rounded-full bg-white/40"></div>
        <div class="w-1.5 h-1.5 rounded-full bg-white/25"></div>
        <div class="w-1.5 h-1.5 rounded-full bg-white/15"></div>
        <div class="w-px h-20 bg-gradient-to-b from-white/10 via-white/30 to-transparent"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-5 sm:px-6 md:px-8 lg:px-12 py-12 sm:py-16 md:py-20 w-full">
        <div class="max-w-2xl mx-auto lg:mx-0 text-center lg:text-left">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full mb-6 border border-white/20">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span class="text-xs sm:text-sm font-medium tracking-wide text-white/90">
                    {{ $hero->label ?? 'Digital Printing Terpercaya' }}
                </span>
            </div>

            {{-- Heading --}}
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black mb-4 sm:mb-6 leading-[1.2] sm:leading-[1.1] tracking-tight">
                <span class="block text-white drop-shadow-lg">{{ $hero->headline ?? 'Solusi Cetak Profesional' }}</span>
                <span class="text-blue-400">Berkualitas Tinggi</span>
            </h1>

            {{-- Divider --}}
            <div class="flex items-center justify-center lg:justify-start gap-3 mb-6">
                <div class="h-px w-12 bg-blue-400"></div>
                <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                <div class="h-px w-6 bg-white/30"></div>
            </div>

            {{-- Description --}}
            <p class="text-white/75 text-sm sm:text-base md:text-lg mb-8 sm:mb-10 leading-relaxed max-w-xl mx-auto lg:mx-0">
                {{ Str::limit($hero->subheadline ?? 'Kami menyediakan layanan digital printing terbaik untuk kebutuhan bisnis dan personal Anda.', 150) }}
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center lg:justify-start">
                <a href="{{ route('products') }}"
                   class="group inline-flex items-center justify-center gap-2 px-6 sm:px-7 py-3 bg-white text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105 text-sm md:text-base">
                    <span>Lihat Produk</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
                <a href="https://wa.me/6285810761209?text=Halo%20Admin,%20saya%20ingin%20konsultasi%20gratis%20tentang%20layanan%20digital%20printing.%0A%0ANama:%0AProduk%20yang%20dibutuhkan:%0AJumlah:%0AUkuran:%0ATerima%20kasih."
                   target="_blank"
                   class="inline-flex items-center justify-center gap-2 px-6 sm:px-7 py-3 bg-transparent text-white font-bold rounded-xl border border-white/40 hover:bg-white/10 hover:border-white/60 transition-all duration-300 backdrop-blur-sm text-sm md:text-base">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span>Konsultasi Gratis</span>
                </a>
            </div>

        </div>
    </div>
</section>
