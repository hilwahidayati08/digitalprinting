<footer class="bg-[#080f1e] text-white border-t border-white/5">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Top accent line --}}
    <div class="h-0.5 w-full bg-gradient-to-r from-transparent via-blue-600 to-transparent opacity-60"></div>

    <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12 pt-20 pb-10">

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 mb-16">

            {{-- Col 1: Brand (Logo Dinamis) --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="flex items-center gap-3">
                    {{-- Container Logo --}}
        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 overflow-hidden bg-slate-100 shadow-[0_0_15px_rgba(37,99,235,0.5)] border border-white/20">
            <img src="{{ asset('storage/logo-cetakkilat2.png') }}" 
                 alt="CetakKilat Logo" 
                 class="w-full h-full object-contain p-1.5">
        </div>
                    <div>
                        <p class="font-black text-xl leading-none tracking-tight">{{ $settings->site_name ?? 'CetakKilat' }}</p>
                        <p class="text-[9px] text-blue-400 uppercase tracking-[0.2em] font-bold mt-1">Digital Printing</p>
                    </div>
                </div>

                <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                    {{ $settings->description ?? 'Solusi digital printing profesional dengan teknologi terkini.' }}
                </p>

                {{-- Status Operasional Minimalis --}}
                <div class="flex items-center gap-3 py-2 border-l-2 border-blue-600/30 pl-4">
                    @php
                        $now = \Carbon\Carbon::now('Asia/Jakarta');
                        $open = \Carbon\Carbon::createFromTimeString($settings->time_open ?? '08:00', 'Asia/Jakarta');
                        $close = \Carbon\Carbon::createFromTimeString($settings->time_close ?? '17:00', 'Asia/Jakarta');
                        $isOpen = $now->between($open, $close) && $now->dayOfWeek !== 0;
                    @endphp
                    <span class="w-2 h-2 rounded-full {{ $isOpen ? 'bg-emerald-400 animate-pulse' : 'bg-red-400' }}"></span>
                    <p class="text-xs text-gray-400 font-medium">
                        <span class="{{ $isOpen ? 'text-emerald-400' : 'text-red-400' }} font-bold uppercase tracking-wider mr-2">
                            {{ $isOpen ? 'Buka' : 'Tutup' }}
                        </span>
                        {{ $settings->time_open ?? '08:00' }} – {{ $settings->time_close ?? '17:00' }} WIB
                    </p>
                </div>
            </div>

            {{-- Col 2: Navigasi --}}
            <div class="lg:col-span-2 lg:col-start-6">
                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-white mb-8">Navigasi</p>
                <ul class="space-y-4 text-sm text-gray-500">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a></li>
                    <li><a href="{{ route('products') }}" class="hover:text-white transition-colors">Produk</a></li>
                    <li><a href="{{ route('portofolio.index') }}" class="hover:text-white transition-colors">Portofolio</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Kontak</a></li>
                </ul>
            </div>

            {{-- Col 3: Hubungi Kami --}}
            <div class="lg:col-span-4 lg:col-start-9 space-y-6">
                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-white mb-8">Hubungi Kami</p>
                
                <div class="space-y-4 text-xs text-gray-400">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-gray-600 mt-1"></i>
                        <p>{{ $settings->address ?? 'Jl. Gandaria V No.11E, Jakarta Selatan' }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fab fa-whatsapp text-gray-600"></i>
                        <a href="https://wa.me/{{ $settings->whatsapp ?? '6285810761209' }}" class="hover:text-white">+{{ $settings->whatsapp ?? '6285810761209' }}</a>
                    </div>
                </div>

                {{-- Sosial Media Minimalis --}}
                <div class="flex gap-4 pt-4 border-t border-white/5">
                    <a href="{{ $settings->facebook_url ?? '#' }}" class="text-gray-600 hover:text-blue-500 transition-colors"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ $settings->instagram_url ?? '#' }}" class="text-gray-600 hover:text-pink-500 transition-colors"><i class="fab fa-instagram"></i></a>
                    <a href="{{ $settings->tiktok_url ?? '#' }}" class="text-gray-600 hover:text-white transition-colors"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="pt-8 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-gray-600 text-[10px] uppercase tracking-widest">
                &copy; {{ date('Y') }} <span class="text-blue-500 font-bold">{{ $settings->site_name ?? 'CetakKilat' }}</span>
            </p>
            <div class="flex gap-6 text-[9px] font-bold uppercase tracking-widest text-gray-600">
                <a href="#" class="hover:text-gray-300 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-gray-300 transition-colors">Terms of Service</a>
            </div>
        </div>

    </div>
</footer>