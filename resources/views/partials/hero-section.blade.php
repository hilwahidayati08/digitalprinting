<!-- Optional Hero Section for Homepage -->
@if(request()->routeIs('home'))
    <section class="relative overflow-hidden bg-gradient-primary text-white min-h-[85vh] md:min-h-[75vh] flex items-center">
        <!-- Animated Background -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-grid-pattern bg-grid-sm"></div>
        </div>
        
        <!-- CMYK Dots Animation -->
        <div class="absolute top-10 left-10 w-3 h-3 bg-printing-cyan rounded-full animate-bounce"></div>
        <div class="absolute top-20 right-20 w-4 h-4 bg-printing-magenta rounded-full animate-pulse animation-delay-300"></div>
        <div class="absolute bottom-20 left-1/4 w-3.5 h-3.5 bg-printing-yellow rounded-full animate-bounce animation-delay-500"></div>
        <div class="absolute bottom-10 right-1/3 w-2.5 h-2.5 bg-printing-black rounded-full animate-pulse animation-delay-700"></div>

        <div class="container mx-auto px-4 py-12 md:py-20 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Badge -->
                <div class="inline-flex items-center px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full mb-4 md:mb-6 animate-fade-in text-sm">
                    <span class="font-medium">{{$hero->label}}</span>
                </div>
                
                <!-- Main Heading -->
                <h1 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold mb-4 md:mb-6 animate-fade-in-up leading-tight">
                    <span class="block">{{$hero->headline}}</span>
                </h1>
                
                <!-- Description -->
                <div class="mb-8 md:mb-10 animate-fade-in-up animation-delay-200">
                    <p class="text-lg md:text-xl text-white/60 text-center mx-auto max-w-2xl leading-relaxed">
                        {{ Str::limit($hero->subheadline, 150) }}
                    </p>
                </div>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center mb-12 md:mb-16 animate-fade-in-up animation-delay-400">
                    <a href="{{ route('products.index') }}" 
                       class="px-6 md:px-8 py-3 md:py-4 bg-white text-primary-600 font-bold rounded-xl hover:bg-neutral-100 transition-all duration-300 shadow-dp-lg hover:shadow-dp-xl hover:scale-105 flex items-center justify-center space-x-2 group">
                        <span>Lihat Produk</span>
                        <svg class="w-4 h-4 md:w-5 md:h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    <a href="https://wa.me/6285810761209?text=Halo%20Admin,%20saya%20ingin%20konsultasi%20gratis%20tentang%20layanan%20digital%20printing.%0A%0ANama:%0AProduk%20yang%20dibutuhkan:%0AJumlah:%0AUkuran:%0ATerima%20kasih."
                        target="_blank"
                        class="px-6 md:px-8 py-3 md:py-4 bg-white/20 backdrop-blur-sm text-white font-bold rounded-xl hover:bg-white/30 transition-all duration-300 border border-white/30 hover:border-white/50 group">
                        <span class="flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span>Konsultasi Gratis</span>
                        </span>
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 max-w-3xl mx-auto animate-fade-in-up animation-delay-600">
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold mb-1">10K+</div>
                        <div class="text-white/60 text-xs md:text-sm">Proyek Selesai</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold mb-1">500+</div>
                        <div class="text-white/60 text-xs md:text-sm">Klien Puas</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold mb-1">24/7</div>
                        <div class="text-white/60 text-xs md:text-sm">Dukungan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold mb-1">1K+</div>
                        <div class="text-white/60 text-xs md:text-sm">Produk Tersedia</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 animate-bounce-slow">
            <a href="#" class="text-white/60 hover:text-white transition-colors">
                <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </a>
        </div>
    </section>
@endif