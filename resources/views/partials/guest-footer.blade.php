<footer class="bg-[#080f1e] text-white border-t border-white/5">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Top accent line --}}
    <div class="h-0.5 w-full bg-gradient-to-r from-transparent via-blue-600 to-transparent opacity-60"></div>

    <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12 pt-20 pb-10">

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 mb-16">

            {{-- Col 1: Brand --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-print text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="font-black text-xl leading-none tracking-tight">{{ $settings->site_name ?? 'PrintPro' }}</p>
                        <p class="text-[10px] text-blue-400 uppercase tracking-[0.2em] font-bold mt-1">Digital Printing</p>
                    </div>
                </div>

                {{-- Tagline --}}
                <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                    {{ $settings->description ?? 'Solusi digital printing profesional dengan teknologi terkini untuk kebutuhan bisnis dan personal Anda.' }}
                </p>

                {{-- Jam Operasional --}}
                <div class="rounded-xl border border-white/10 bg-white/[0.03] p-4 space-y-3">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fas fa-clock text-blue-400 text-xs"></i>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500">Jam Operasional</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 text-xs">Senin – Sabtu</span>
                        <span class="text-white font-bold text-xs tabular-nums">
                            {{ $settings->time_open ?? '08:00' }} – {{ $settings->time_close ?? '17:00' }} WIB
                        </span>
                    </div>
                    <div class="pt-1 border-t border-white/5 flex items-center gap-2">
                        @php
                            $now = \Carbon\Carbon::now('Asia/Jakarta');
                            $open = \Carbon\Carbon::createFromTimeString($settings->time_open ?? '08:00', 'Asia/Jakarta');
                            $close = \Carbon\Carbon::createFromTimeString($settings->time_close ?? '17:00', 'Asia/Jakarta');
                            $isOpen = $now->between($open, $close) && $now->dayOfWeek !== 0;
                        @endphp
                        <span class="w-1.5 h-1.5 rounded-full {{ $isOpen ? 'bg-emerald-400' : 'bg-red-400' }} {{ $isOpen ? 'animate-pulse' : '' }}"></span>
                        <span class="text-[11px] font-bold {{ $isOpen ? 'text-emerald-400' : 'text-red-400' }}">
                            {{ $isOpen ? 'Buka Sekarang' : 'Tutup Sekarang' }}
                        </span>
                    </div>
                </div>

                {{-- Sosial Media --}}
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-600 mb-4">Ikuti Kami</p>
                    <div class="flex gap-2.5">
                        <a href="{{ $settings->facebook_url ?? '#' }}"
                            class="w-9 h-9 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-blue-600 hover:border-blue-600 transition-all duration-300 group">
                            <i class="fab fa-facebook-f text-[11px] text-gray-400 group-hover:text-white"></i>
                        </a>
                        <a href="{{ $settings->instagram_url ?? '#' }}"
                            class="w-9 h-9 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-gradient-to-br hover:from-pink-500 hover:to-orange-400 hover:border-pink-500 transition-all duration-300 group">
                            <i class="fab fa-instagram text-[11px] text-gray-400 group-hover:text-white"></i>
                        </a>
                        <a href="{{ $settings->tiktok_url ?? '#' }}"
                            class="w-9 h-9 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white hover:border-white transition-all duration-300 group">
                            <i class="fab fa-tiktok text-[11px] text-gray-400 group-hover:text-black"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Col 2: Navigasi --}}
            <div class="lg:col-span-2 lg:col-start-6">
                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-white mb-6 pb-3 border-b border-white/10">Navigasi</p>
                <ul class="space-y-3">
                    @foreach([
                        ['label' => 'Beranda', 'route' => 'home'],
                        ['label' => 'Tentang Kami', 'href' => '#tentang-kami'],
                        ['label' => 'Produk', 'route' => 'products.products'],
                        ['label' => 'Portofolio', 'route' => 'portofolio.index'],
                        ['label' => 'Kontak', 'route' => 'contact'],
                    ] as $nav)
                    <li>
                        <a href="{{ isset($nav['route']) ? route($nav['route']) : $nav['href'] }}"
                            class="text-gray-500 hover:text-white text-sm transition-colors duration-200 flex items-center gap-2 group">
                            <span class="w-1 h-1 rounded-full bg-blue-600 opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0"></span>
                            {{ $nav['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Col 3: Kontak --}}
            <div class="lg:col-span-4 lg:col-start-9">
                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-white mb-6 pb-3 border-b border-white/10">Hubungi Kami</p>
                <div class="space-y-5">

                    {{-- Alamat --}}
                    <div class="flex items-start gap-4">
                        <div class="w-8 h-8 rounded-lg bg-blue-600/15 border border-blue-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-map-marker-alt text-blue-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-white text-xs font-bold mb-0.5">Alamat</p>
                            <p class="text-gray-400 text-xs leading-relaxed">{{ $settings->address ?? 'Jl. Gandaria V No.11E, Jagakarsa, Jakarta Selatan' }}</p>
                        </div>
                    </div>

                    {{-- WhatsApp --}}
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded-lg bg-emerald-600/15 border border-emerald-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-whatsapp text-emerald-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-white text-xs font-bold mb-0.5">WhatsApp</p>
                            <a href="https://wa.me/{{ $settings->whatsapp ?? '6285810761209' }}"
                                target="_blank"
                                class="text-gray-400 hover:text-emerald-400 text-xs transition-colors">
                                +{{ $settings->whatsapp ?? '6285810761209' }}
                            </a>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 rounded-lg bg-blue-600/15 border border-blue-500/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-blue-400 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-white text-xs font-bold mb-0.5">Email</p>
                            <a href="mailto:{{ $settings->email ?? 'hilwa.hidayati20@gmail.com' }}"
                                class="text-gray-400 hover:text-blue-400 text-xs transition-colors">
                                {{ $settings->email ?? 'hilwa.hidayati20@gmail.com' }}
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="pt-8 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-gray-600 text-[11px] uppercase tracking-[0.15em]">
                &copy; {{ date('Y') }} <span class="text-blue-500 font-black">{{ $settings->site_name ?? 'PrintPro' }}</span>. All rights reserved.
            </p>
            <div class="flex items-center gap-6 text-[11px] font-bold uppercase tracking-[0.15em] text-gray-600">
                <a href="#" class="hover:text-gray-300 transition-colors">Privacy Policy</a>
                <span class="w-px h-3 bg-white/10"></span>
                <a href="#" class="hover:text-gray-300 transition-colors">Terms of Service</a>
            </div>
        </div>

    </div>
</footer>