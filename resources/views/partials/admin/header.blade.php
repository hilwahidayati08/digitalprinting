@php
    use App\Models\Notification;
    use App\Models\Materials;
    
    // ✅ Tambah whereNull('user_id') di semua query
    $stockNotifs = Notification::where('type', 'stock')
        ->whereNull('user_id')        // ← tambah ini
        ->where('is_read', false)
        ->latest()
        ->get();
    
    $otherNotifs = Notification::where('is_read', false)
        ->whereNull('user_id')        // ← tambah ini
        ->where('type', '!=', 'stock')
        ->latest()
        ->take(10)
        ->get();
    
    $unreadNotifs = $stockNotifs->concat($otherNotifs);
    
    $countNotif = Notification::whereNull('user_id')  // ← tambah ini
        ->where('is_read', false)
        ->count();
        
    $stockNotifCount = $stockNotifs->count();
@endphp

{{-- DEBUG BADGE SEMENTARA --}}
@if($stockNotifCount > 0)
<div id="stockDebugBadge" class="fixed top-20 right-4 z-50 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg animate-pulse">
    ⚠️ {{ $stockNotifCount }} Stok Kritis
</div>
<script>
    setTimeout(() => {
        const badge = document.getElementById('stockDebugBadge');
        if(badge) badge.style.display = 'none';
    }, 5000);
</script>
@endif

<header class="sticky top-0 z-40 w-full bg-white/70 backdrop-blur-lg border-b border-neutral-200/50">
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16 sm:h-20">
            
            {{-- Left: Search --}}
<div class="flex items-center flex-1 space-x-4">
    <button @click="sidebarOpen = true" class="p-2 md:hidden text-neutral-600 hover:bg-neutral-100 rounded-xl transition-all">
        <i class="fas fa-bars text-xl"></i>
    </button>
                
                <div class="relative hidden md:block group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fas fa-search text-neutral-400 group-focus-within:text-blue-500 transition-colors text-sm"></i>
                    </div>
                    <input type="text" 
                           class="pl-11 pr-4 py-2.5 bg-neutral-100/50 border border-neutral-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 focus:bg-white w-64 lg:w-[450px] transition-all duration-300 outline-none text-sm placeholder:text-neutral-400 font-medium"
                           placeholder="Cari pesanan, produk, atau pelanggan...">
                    <div class="absolute inset-y-0 right-3 items-center hidden lg:flex">
                        <kbd class="px-2 py-1 text-[10px] font-sans font-bold text-neutral-400 bg-white border border-neutral-200 rounded-lg shadow-sm">CTRL K</kbd>
                    </div>
                </div>
            </div>
            
            {{-- Right: Actions --}}
            <div class="flex items-center space-x-1.5 sm:space-x-4">
                
                <div class="hidden lg:flex items-center">
                    <a href="{{ route('admin.orders.index') }}" class="relative flex items-center px-4 py-2.5 bg-white text-neutral-700 rounded-xl hover:shadow-md hover:shadow-blue-500/5 border border-neutral-200 transition-all duration-200 group active:scale-95">
                        <i class="fas fa-layer-group mr-2.5 text-blue-600 group-hover:rotate-12 transition-transform"></i>
                        <span class="font-bold text-sm">Antrian</span>
                        <span class="ml-2.5 flex h-5 min-w-[20px] items-center justify-center rounded-lg bg-blue-600 px-1.5 text-[10px] font-black text-white shadow-sm shadow-blue-500/30">
                            {{ $countAntrian ?? 0 }}
                        </span>
                    </a>
                </div>
                
                <div class="hidden sm:block w-px h-6 bg-neutral-200 mx-2"></div>

                {{-- ===================================================== --}}
                {{-- NOTIFICATION SYSTEM --}}
                {{-- ===================================================== --}}
                <div class="relative">
                    <button id="notifyBtn" class="relative p-2.5 text-neutral-500 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200 active:scale-90">
                        <i class="fas fa-bell text-xl"></i>
                        @if($countNotif > 0)
                            <span id="notifBadge" class="absolute top-2 right-2 w-5 h-5 bg-red-500 border-2 border-white rounded-full text-[10px] flex items-center justify-center text-white font-black shadow-sm">
                                {{ $countNotif > 9 ? '9+' : $countNotif }}
                            </span>
                        @endif
                    </button>
                    
                    <div id="notifyPanel" class="hidden absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-neutral-100 z-50 overflow-hidden origin-top-right">
                        <div class="flex items-center justify-between px-4 py-4 border-b border-neutral-100 bg-neutral-50/50">
                            <h3 class="text-xs font-black text-neutral-800 uppercase tracking-widest">
                                <i class="fas fa-bell mr-2"></i>NOTIFIKASI
                            </h3>
                            @if($countNotif > 0)
                                <button onclick="markAllAsRead()" id="markAllBtn" class="text-[10px] text-blue-600 font-bold hover:underline uppercase tracking-tighter">
                                    Tandai Dibaca
                                </button>
                            @endif
                        </div>
                        
                        <div id="notifContainer" class="max-h-[400px] overflow-y-auto">
                            
                            {{-- ========================================= --}}
                            {{-- SECTION: STOK KRITIS (PRIORITAS UTAMA) --}}
                            {{-- ========================================= --}}
                            @if($stockNotifs->count() > 0)
                                <div class="bg-gradient-to-r from-red-600 to-red-500 px-4 py-2 sticky top-0">
                                    <p class="text-[10px] font-black text-white uppercase tracking-wider flex items-center gap-2">
                                        <i class="fas fa-exclamation-triangle animate-pulse"></i>
                                        STOK KRITIS - BUTUH TINDAKAN SEGERA!
                                    </p>
                                </div>
                                
                                @foreach($stockNotifs as $notif)
                                    <a href="{{ route('notifications.read', $notif->notif_id ?? $notif->id) }}" 
                                       class="flex items-start gap-3 px-4 py-3.5 hover:bg-red-50 transition-colors group border-b border-red-100 bg-red-50/30">
                                        
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 bg-red-100 text-red-600 animate-pulse">
                                            <i class="fas fa-exclamation-triangle text-sm"></i>
                                        </div>

                                        <div class="flex-1 overflow-hidden">
                                            <p class="text-[13px] font-black text-red-800 leading-tight">
                                                {{ $notif->title }}
                                            </p>
                                            <p class="text-[11px] text-red-600 mt-1 leading-relaxed font-semibold">
                                                {{ $notif->message }}
                                            </p>
                                            <span class="text-[9px] font-bold text-red-400 uppercase tracking-tighter mt-1.5 block">
                                                <i class="far fa-clock mr-1"></i>{{ $notif->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        
                                        <div class="w-2.5 h-2.5 bg-red-500 rounded-full animate-pulse"></div>
                                    </a>
                                @endforeach
                                
                                <div class="bg-red-50 px-4 py-2 border-t border-red-100">
                                    <a href="{{ route('materials.index') }}" 
                                       class="block text-center text-[10px] font-bold text-red-600 hover:text-red-700 uppercase tracking-wider">
                                        <i class="fas fa-boxes mr-1"></i> Kelola Stok Material
                                    </a>
                                </div>
                                
                                @if($otherNotifs->count() > 0)
                                    <div class="border-t border-neutral-100 my-1"></div>
                                    <div class="px-4 py-2 bg-neutral-50/50">
                                        <p class="text-[9px] font-bold text-neutral-400 uppercase tracking-wider">NOTIFIKASI LAINNYA</p>
                                    </div>
                                @endif
                            @endif
                            
                            {{-- ========================================= --}}
                            {{-- SECTION: NOTIFIKASI LAINNYA --}}
                            {{-- ========================================= --}}
                            @forelse($otherNotifs as $notif)
                                <a href="{{ route('notifications.read', $notif->notif_id ?? $notif->id) }}" 
                                   class="flex items-start gap-3 px-4 py-3.5 hover:bg-blue-50/30 transition-colors group border-b border-neutral-50">
                                    
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 
                                        {{ $notif->type == 'order' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }}">
                                        <i class="fas {{ $notif->type == 'order' ? 'fa-shopping-cart' : 'fa-credit-card' }} text-sm"></i>
                                    </div>

                                    <div class="flex-1 overflow-hidden">
                                        <p class="text-[13px] font-black text-neutral-900 leading-tight">
                                            {{ $notif->title }}
                                        </p>
                                        <p class="text-[11px] text-neutral-600 mt-1 leading-relaxed">
                                            {{ $notif->message }}
                                        </p>
                                        <span class="text-[9px] font-bold text-neutral-400 uppercase tracking-tighter mt-1.5 block">
                                            <i class="far fa-clock mr-1"></i>{{ $notif->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </a>
                            @empty
                                @if($stockNotifs->count() == 0)
                                    <div class="text-center py-12 px-4">
                                        <div class="w-14 h-14 bg-neutral-50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-bell-slash text-2xl text-neutral-300"></i>
                                        </div>
                                        <p class="text-sm font-black text-neutral-800">Tidak Ada Notifikasi</p>
                                        <p class="text-xs text-neutral-400 mt-1">Semua notifikasi telah dibaca</p>
                                    </div>
                                @endif
                            @endforelse
                        </div>
                        
                        @if($unreadNotifs->count() > 0)
                        <div class="p-2 border-t border-neutral-100 bg-neutral-50/30">
                            <a href="{{ route('notifications.index') }}" class="block text-center text-xs font-bold text-blue-600 py-2 hover:bg-blue-50 rounded-xl transition">
                                Lihat Semua Notifikasi
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- User Profile --}}
<div class="relative">
    <button id="userBtn" class="flex items-center p-1 sm:pl-2 sm:pr-1.5 sm:py-1 hover:bg-neutral-50 border border-transparent hover:border-neutral-200 rounded-2xl transition-all duration-200 group">
        <div class="text-right mr-3 hidden lg:block leading-tight">
            <p class="text-sm font-black text-neutral-900 leading-none">{{ auth()->user()->username }}</p>
            <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mt-1">ADMIN</p>
        </div>
        <div class="relative">
            {{-- Bagian Inisial di Kotak Biru --}}
            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-500 shadow-sm ring-2 ring-transparent group-hover:ring-blue-500/20 transition-all flex items-center justify-center overflow-hidden">
                <span class="text-white font-black text-sm sm:text-base tracking-tighter">
                    {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}{{ count(explode(' ', auth()->user()->username)) > 1 ? strtoupper(substr(explode(' ', auth()->user()->username)[1], 0, 1)) : '' }}
                </span>
            </div>
            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full shadow-sm"></div>
        </div>
        <i id="userChevron" class="fas fa-chevron-down ml-2 text-[10px] text-neutral-400 group-hover:text-neutral-600 transition-transform duration-300"></i>
    </button>
                    
                    <div id="userPanel" class="hidden absolute right-0 mt-3 w-60 bg-white rounded-2xl shadow-2xl border border-neutral-100 z-50 overflow-hidden origin-top-right">
                        <div class="p-4 bg-neutral-50/50 border-b border-neutral-100 flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->username) }}&background=0ea5e9&color=fff" class="w-10 h-10 rounded-xl shadow-sm">
                            <div class="overflow-hidden">
                                <p class="text-sm font-black text-neutral-900 truncate">{{ auth()->user()->username }}</p>
                                <p class="text-[11px] text-neutral-400 truncate uppercase">{{ auth()->user()->useremail }}</p>
                            </div>
                        </div>

                        <div class="p-2">
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-neutral-600 hover:bg-neutral-50 hover:text-blue-600 transition-all group">
                                <div class="w-8 h-8 rounded-lg bg-neutral-100 group-hover:bg-blue-100 flex items-center justify-center transition-colors">
                                    <i class="fas fa-user text-[10px]"></i>
                                </div>
                                Profil Saya
                            </a>
                            <div class="h-px bg-neutral-100 my-2 mx-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-bold text-red-500 hover:bg-red-50 transition-all group">
                                    <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <i class="fas fa-power-off text-[10px]"></i>
                                    </div>
                                    Keluar Sistem
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>

<style>
    @keyframes dropDownScale {
        from { opacity: 0; transform: scale(0.95) translateY(-10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    @keyframes pulseRed {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.05); }
    }
    .dropdown-animate { animation: dropDownScale 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .animate-pulse { animation: pulseRed 1.5s ease-in-out infinite; }
</style>

<script>
    // DROPDOWN TOGGLE
    const dropdownConfigs = [
        { btn: 'notifyBtn', panel: 'notifyPanel' },
        { btn: 'userBtn', panel: 'userPanel', chevron: 'userChevron' }
    ];

    dropdownConfigs.forEach(({ btn, panel, chevron }) => {
        const btnEl = document.getElementById(btn);
        const panelEl = document.getElementById(panel);
        
        if (btnEl && panelEl) {
            btnEl.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = panelEl.classList.contains('hidden');
                
                dropdownConfigs.forEach(c => {
                    const p = document.getElementById(c.panel);
                    if (p) p.classList.add('hidden');
                    if (c.chevron) {
                        const ch = document.getElementById(c.chevron);
                        if (ch) ch.classList.remove('rotate-180');
                    }
                });

                if (isHidden) {
                    panelEl.classList.remove('hidden');
                    panelEl.classList.add('dropdown-animate');
                    if (chevron) {
                        const ch = document.getElementById(chevron);
                        if (ch) ch.classList.add('rotate-180');
                    }
                }
            });
        }
    });

    document.addEventListener('click', () => {
        dropdownConfigs.forEach(c => {
            const panel = document.getElementById(c.panel);
            if (panel) panel.classList.add('hidden');
            if (c.chevron) {
                const ch = document.getElementById(c.chevron);
                if (ch) ch.classList.remove('rotate-180');
            }
        });
    });

    function markAllAsRead() {
        const btn = document.getElementById('markAllBtn');
        if(!btn) return;

        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btn.disabled = true;

        fetch("{{ route('notifications.readAll') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(err => {
            console.error('Error:', err);
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
</script>