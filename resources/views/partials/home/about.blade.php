<section id="tentang-kami"
    class="relative overflow-hidden bg-gradient-to-br from-sky-50 via-white to-indigo-50/40 py-12 md:py-20">
    <div class="max-w-6xl mx-auto px-5 md:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <!-- Kiri: Teks -->
            <div class="text-center lg:text-left order-2 lg:order-1">
                <div class="flex justify-center lg:justify-start mb-6">
                    <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white rounded-full shadow-lg border border-neutral-100">
                        <span class="flex w-2.5 h-2.5 bg-primary-600 rounded-full animate-pulse"></span>
                        <span class="text-xs sm:text-sm font-bold tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-600 uppercase">
                            {{ $about->label ?? 'Tentang Kami' }}
                        </span>
                    </span>
                </div>
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-4 text-neutral-900 leading-tight">
                    {{ $about->headline ?? 'Digital Printing Terpercaya' }}
                </h2>
                <p class="text-neutral-600 text-sm sm:text-base md:text-lg leading-relaxed px-4 lg:px-0">
                    {{ $about->subheadline ?? 'Kami melayani ribuan klien dengan hasil cetak berkualitas tinggi, teknologi modern, dan tim profesional berpengalaman.' }}
                </p>
            </div>

            <!-- Kanan: Gambar + Floating Cards -->
            <div class="relative mx-auto w-full max-w-sm lg:max-w-md order-1 lg:order-2">
                <div class="rounded-2xl overflow-hidden shadow-xl bg-white">
                    <img src="{{ $about->photo ? asset('storage/heros/' . $about->photo) : 'https://placehold.co/600x450/2563eb/white?text=Printing' }}"
                        alt="{{ $about->label ?? 'Tentang Kami' }}" class="w-full h-auto object-cover aspect-[4/3]" loading="lazy">
                </div>
                <!-- Card Kualitas -->
                <div class="absolute -top-3 -right-3 bg-white/90 backdrop-blur-sm rounded-xl p-2 shadow-md flex items-center gap-2 animate-float">
                    <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold">Kualitas Terbaik</p>
                        <p class="text-[9px] text-gray-500">Garansi hasil</p>
                    </div>
                </div>
                <!-- Card Cepat -->
                <div class="absolute -bottom-3 -left-3 bg-white/90 backdrop-blur-sm rounded-xl p-2 shadow-md flex items-center gap-2 animate-float-delay">
                    <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold">Cepat Sampai</p>
                        <p class="text-[9px] text-gray-500">Tepat waktu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0px); }
    }
    @keyframes float-delay {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0px); }
    }
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    .animate-float-delay {
        animation: float-delay 3.5s ease-in-out infinite;
    }
    @media (max-width: 640px) {
        .animate-float, .animate-float-delay {
            animation-duration: 2.5s;
        }
    }
</style>
