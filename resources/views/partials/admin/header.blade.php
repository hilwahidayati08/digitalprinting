<header class="sticky top-0 z-40 w-full bg-white/80 backdrop-blur-md border-b border-neutral-200/60">
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-20">
            
            <div class="flex items-center flex-1 space-x-4">
                <button onclick="mobileOpen = true" class="p-2 md:hidden text-neutral-600 hover:bg-neutral-100 rounded-lg transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <div class="relative hidden md:block group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-search text-neutral-400 group-focus-within:text-blue-500 transition-colors"></i>
                    </div>
                    <input type="text" 
                           class="pl-11 pr-4 py-2.5 bg-neutral-50 border border-neutral-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white w-64 lg:w-[400px] transition-all duration-300 outline-none text-sm"
                           placeholder="Cari pesanan, produk, atau pelanggan (Ctrl + K)">
                </div>
            </div>
            
            <div class="flex items-center space-x-2 sm:space-x-4">
                
                <div class="hidden lg:flex items-center px-1">
                    <a href="#" class="relative flex items-center px-4 py-2.5 bg-neutral-50 text-neutral-700 rounded-xl hover:bg-neutral-100 border border-neutral-200 transition-all duration-200 group">
                        <i class="fas fa-layer-group mr-2.5 text-blue-600"></i>
                        <span class="font-semibold text-sm">Antrian Cetak</span>
                        <span class="ml-2.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-blue-600 px-1.5 text-[10px] font-bold text-white">{{ $countAntrian ?? 0 }}</span>
                    </a>
                </div>
                
                <div class="hidden sm:block w-[1px] h-8 bg-neutral-200 mx-1"></div>

                <!-- NOTIFICATION DROPDOWN -->
                <div class="relative" id="notifyDropdown">
                    <button id="notifyBtn"
                            class="relative p-2.5 text-neutral-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-2.5 right-3 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                    </button>
                    
<!-- <div id="notifyPanel" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-neutral-100 z-50 overflow-hidden">
    
    <div class="flex items-center justify-between px-4 py-3 border-b border-neutral-100">
        <h3 class="text-sm font-bold text-neutral-800">Notifikasi</h3>
        @if($adminNotifs->count() > 0)
            <form action="" method="POST">
                @csrf
                <button type="submit" class="text-xs text-blue-500 font-semibold hover:underline">Tandai semua dibaca</button>
            </form>
        @endif
    </div>

    <div class="max-h-72 overflow-y-auto">
        @forelse($adminNotifs as $notif)
            {{-- Isi Notifikasi --}}
            <a href="#" 
               class="flex gap-3 px-4 py-3 {{ $notif->is_read ? '' : 'bg-blue-50' }} hover:bg-neutral-50 transition-colors border-b border-neutral-50">
                <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center text-sm
                    {{ $notif->type == 'order' ? 'bg-blue-100 text-blue-600' : 'bg-orange-100 text-orange-600' }}">
                    <i class="fas {{ $notif->type == 'order' ? 'fa-shopping-bag' : 'fa-bell' }}"></i>
                </div>
                <div>
                    <p class="text-xs text-neutral-700 leading-snug">{!! $notif->title !!} {!! $notif->message !!}</p>
                    <span class="text-[11px] text-neutral-400 mt-0.5 block">1</span>
                </div>
            </a>
        @empty
            {{-- TAMPILAN JIKA KOSONG --}}
            <div class="flex flex-col items-center justify-center py-12 px-4 text-center">
                <div class="w-16 h-16 bg-neutral-50 rounded-full flex items-center justify-center mb-3">
                    <i class="fas fa-bell-slash text-neutral-300 text-xl"></i>
                </div>
                <h4 class="text-sm font-bold text-neutral-800">Belum ada notifikasi</h4>
                <p class="text-xs text-neutral-400 mt-1">Semua update pesanan dan stok akan muncul di sini.</p>
            </div>
        @endforelse
    </div>

    @if($adminNotifs->count() > 0)
        <div class="px-4 py-2.5 border-t border-neutral-100 text-center">
            <a href="#" class="text-xs text-blue-500 font-semibold hover:underline">Lihat semua notifikasi →</a>
        </div>
    @endif
</div> -->
                </div>

                <!-- USER DROPDOWN -->
                <div class="relative" id="userDropdown">
                    <button id="userBtn"
                            class="flex items-center pl-2 pr-1 py-1 hover:bg-neutral-50 border border-transparent hover:border-neutral-200 rounded-2xl transition-all duration-200 group">
                        <div class="text-right mr-3 hidden lg:block leading-tight">
                            <p class="text-sm font-bold text-neutral-900">Daffa Arkhab</p>
                            <p class="text-[11px] font-medium text-neutral-400 uppercase tracking-wider">Super Admin</p>
                        </div>
                        <div class="relative rounded-full transition-all ring-2 ring-offset-2 ring-transparent group-hover:ring-blue-500/20">
                            <img src="https://ui-avatars.com/api/?name=Daffa+Arkhab&background=0ea5e9&color=fff" class="w-10 h-10 rounded-full object-cover">
                            <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <i id="userChevron" class="fas fa-chevron-down ml-2 text-[10px] text-neutral-400 transition-transform duration-200"></i>
                    </button>
                    
                    <div id="userPanel"
                         class="hidden absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-neutral-100 z-50 overflow-hidden"
                         style="animation: fadeDown .2s ease">

                        <div class="flex items-center gap-3 px-4 py-3.5 border-b border-neutral-100">
                            <img src="https://ui-avatars.com/api/?name=Daffa+Arkhab&background=0ea5e9&color=fff" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="text-sm font-bold text-neutral-900 leading-tight">Daffa Arkhab</p>
                                <p class="text-[11px] text-neutral-400">daffa@example.com</p>
                            </div>
                        </div>

                        <div class="p-2">
                            <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm text-neutral-700 hover:bg-neutral-100 transition-colors">
                                <i class="fas fa-user w-4 text-center text-neutral-400"></i> Profil Saya
                            </a>
                            <a href="#" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm text-neutral-700 hover:bg-neutral-100 transition-colors">
                                <i class="fas fa-cog w-4 text-center text-neutral-400"></i> Pengaturan
                            </a>
                            <div class="h-px bg-neutral-100 my-1.5 mx-1"></div>
                            <button class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm text-red-500 hover:bg-red-50 transition-colors">
                                <i class="fas fa-sign-out-alt w-4 text-center"></i> Keluar
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>

<!-- Tambahkan script ini sebelum </body> -->
<style>
    @keyframes fadeDown {
        from { opacity: 0; transform: translateY(6px) scale(.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }
</style>
<script>
    function toggleDropdown(btnId, panelId, chevronId) {
        const panel   = document.getElementById(panelId);
        const isOpen  = !panel.classList.contains('hidden');

        // Tutup semua dropdown dulu
        ['notifyPanel', 'userPanel'].forEach(id => document.getElementById(id).classList.add('hidden'));
        if (chevronId) document.getElementById('userChevron').classList.remove('rotate-180');

        // Buka yang diklik kalau sebelumnya tertutup
        if (!isOpen) {
            panel.classList.remove('hidden');
            if (chevronId) document.getElementById(chevronId).classList.add('rotate-180');
        }
    }

    document.getElementById('notifyBtn').addEventListener('click', (e) => {
        e.stopPropagation();
        toggleDropdown('notifyBtn', 'notifyPanel');
    });

    document.getElementById('userBtn').addEventListener('click', (e) => {
        e.stopPropagation();
        toggleDropdown('userBtn', 'userPanel', 'userChevron');
    });

    // Klik di luar → tutup semua
    document.addEventListener('click', () => {
        ['notifyPanel', 'userPanel'].forEach(id => document.getElementById(id).classList.add('hidden'));
        document.getElementById('userChevron').classList.remove('rotate-180');
    });
</script>