<!-- Service Highlights Section -->
<section class="py-16 bg-gradient-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-2 bg-primary-50 text-primary-600 rounded-full text-sm font-medium mb-4">
                ✨ Layanan Unggulan
            </span>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-neutral-800 mb-4">
                Solusi Printing <span class="text-primary-600">Lengkap</span> untuk Semua Kebutuhan
            </h2>
            <p class="text-neutral-600 max-w-2xl mx-auto">
                Dari desain hingga finishing, kami menyediakan layanan lengkap dengan kualitas terbaik
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($services as $service)
                @if($service->is_active)
<div class="flex flex-col bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] transition-all duration-300 group hover:-translate-y-2 border border-slate-50 overflow-hidden">                    
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-slate-50 rounded-full group-hover:bg-blue-50 transition-colors duration-500"></div>

                    <div class="relative w-16 h-16 mb-8">
                        <div class="absolute inset-0 bg-gradient-to-br {{ $service->gradient_class ?? 'from-blue-500 to-indigo-600' }} rounded-2xl rotate-6 group-hover:rotate-12 transition-transform duration-500 opacity-20"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-br {{ $service->gradient_class ?? 'from-blue-500 to-indigo-600' }} rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 group-hover:scale-110 transition-transform duration-500">
                            @if($service->icon)
                                <img src="{{ asset('storage/services/'.$service->icon) }}" class="w-8 h-8 object-contain filter brightness-0 invert">
                            @else
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            @endif
                        </div>
                    </div>

                    <div class="relative flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-blue-600 transition-colors">
                            {{ $service->service_name }}
                        </h3>
                        
                        <div class="overflow-hidden">
                            <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-3 min-h-[4.5rem] break-words">
                                {{ $service->description }}
                            </p>
                        </div>
                        
                        <div class="mt-auto">
                            <a href="#" class="inline-flex items-center gap-2 text-blue-600 font-bold text-sm hover:gap-3 transition-all duration-300">
                                <span>Selengkapnya</span>
                                <div class="w-8 h-[2px] bg-blue-100 group-hover:w-12 group-hover:bg-blue-600 transition-all duration-300"></div>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>