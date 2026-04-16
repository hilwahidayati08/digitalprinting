<section class="py-12 md:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 md:px-8 lg:px-12">
        <div class="text-center mb-10 md:mb-12">
            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white rounded-full shadow-lg border border-neutral-100 mb-6">
                <span class="flex w-2.5 h-2.5 bg-blue-600 rounded-full animate-pulse"></span>
                <span class="text-xs sm:text-sm font-bold tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-800 uppercase">LAYANAN UNGGULAN</span>
            </span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-neutral-800 mb-4 leading-tight">Solusi Printing <span class="text-blue-600">Lengkap</span> untuk Semua Kebutuhan</h2>
            <p class="text-neutral-600 text-sm sm:text-base max-w-2xl mx-auto px-4">Dari desain hingga finishing, kami menyediakan layanan lengkap dengan kualitas terbaik</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 md:gap-6">
            @forelse($services as $service)
                <div class="bg-white rounded-xl p-5 md:p-6 shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 group text-center sm:text-left">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-600 transition-colors duration-300 mx-auto sm:mx-0">
                        @if($service->icon && file_exists(public_path('storage/services/' . $service->icon)))
                            <img src="{{ asset('storage/services/' . $service->icon) }}" class="w-6 h-6 object-contain" alt="{{ $service->service_name }}">
                        @else
                            <svg class="w-6 h-6 text-blue-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        @endif
                    </div>
                    <h3 class="text-base md:text-lg font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">{{ $service->service_name }}</h3>
                    <p class="text-gray-500 text-xs sm:text-sm leading-relaxed">{{ Str::limit($service->description, 100) }}</p>
                </div>
            @empty
                <div class="col-span-4 text-center py-12"><p class="text-gray-500">Belum ada layanan yang tersedia.</p></div>
            @endforelse
        </div>
    </div>
</section>