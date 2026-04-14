<aside 
    id="sidebar"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed top-0 left-0 w-64 h-full bg-[#0f172a] text-slate-300 flex flex-col z-50 transition-transform duration-300 ease-in-out md:relative md:translate-x-0 border-r border-slate-800 shadow-xl md:shadow-none"
>

    {{-- Subtle grid texture overlay --}}
    <div class="pointer-events-none absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(148,163,184,1) 1px, transparent 1px), linear-gradient(90deg, rgba(148,163,184,1) 1px, transparent 1px); background-size: 32px 32px;"></div>

{{-- ─── Logo / Brand ──────────────────────────────────────── --}}
<div class="relative h-[68px] flex items-center px-5 shrink-0" style="border-bottom: 1px solid rgba(255,255,255,0.05);">
    <div class="flex items-center gap-3">
        {{-- Menggunakan BG Slate-100 (Putih Abu) agar outline hitam printer tetap terlihat tajam --}}
        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 overflow-hidden bg-slate-100 shadow-[0_0_15px_rgba(37,99,235,0.5)] border border-white/20">
            <img src="{{ asset('storage/logo-cetakkilat2.png') }}" 
                 alt="CetakKilat Logo" 
                 class="w-full h-full object-contain p-1.5">
        </div>
        
        <div class="flex flex-col leading-none">
            <span class="text-white font-bold tracking-tight text-[15px]">CetakKilat</span>
            <span class="text-[9px] font-extrabold uppercase tracking-[0.18em] text-slate-400 mt-[3px]">Admin Panel</span>
        </div>
    </div>

    {{-- Mobile close button --}}
    <button @click="sidebarOpen = false" class="md:hidden ml-auto text-slate-500 hover:text-white transition-colors p-1">
        <i class="fas fa-times text-base"></i>
    </button>
</div>
    {{-- ─── Navigation ─────────────────────────────────────────── --}}
    <nav class="flex-1 overflow-y-auto py-5 px-3 space-y-7" 
         style="scrollbar-width: thin; scrollbar-color: rgba(255,255,255,0.08) transparent;">

        {{-- Utama --}}
        <div>
            <p class="px-3 mb-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Ringkasan</p>
            <div class="space-y-0.5">
                <a href="{{ route('dashboard') }}" 
                   class="nav-item flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-150 group {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line w-4 text-center text-[13px] shrink-0 transition-colors"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" 
                   class="nav-item flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-150 group {{ request()->routeIs('admin.orders.*') && !request()->routeIs('admin.orders.report') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart w-4 text-center text-[13px] shrink-0 transition-colors"></i>
                    <span class="flex-1">Pesanan Masuk</span>
                    <span class="text-[10px] font-extrabold px-1.5 py-0.5 rounded-md" 
                          style="background: #2563eb; color: #fff; letter-spacing: 0.05em; box-shadow: 0 2px 6px rgba(37,99,235,0.4);">
                        {{ \App\Models\Orders::where('status', 'paid')->count() }}
                    </span>
                </a>

                <a href="{{ route('admin.orders.report') }}" 
                   class="nav-item flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-150 group {{ request()->routeIs('admin.orders.report') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar w-4 text-center text-[13px] shrink-0 transition-colors"></i>
                    <span>Laporan Penjualan</span>
                </a>
            </div>
        </div>

        {{-- Produksi & Stok --}}
        @php $openProduksi = request()->is('admin/products*', 'categories*', 'materials*', 'units*', 'stocklogs*') ? 'true' : 'false'; @endphp
        <div x-data="{ open: {{ $openProduksi }} }">
            <p class="px-3 mb-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Inventori & Produk</p>

            <button type="button" @click="open = !open"
                    class="nav-item w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-150 text-left">
                <i class="fas fa-boxes w-4 text-center text-[13px] shrink-0"></i>
                <span class="flex-1">Master Data</span>
                <svg :class="open ? 'rotate-90 text-blue-400' : 'rotate-0 text-slate-500'"
                     class="w-3 h-3 shrink-0 transition-transform duration-200"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <div x-show="open" class="mt-1 ml-3 pl-4 space-y-0.5 border-l border-slate-800">
                <a href="{{ route('products.index') }}" class="sub-nav-item flex items-center gap-2 px-2 py-2 text-[12.5px] rounded-md transition-all duration-150 {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i class="fas fa-box w-3.5 text-center text-[11px] opacity-70"></i><span>Katalog Produk</span>
                </a>
                <a href="{{ route('categories.index') }}" class="sub-nav-item flex items-center gap-2 px-2 py-2 text-[12.5px] rounded-md transition-all duration-150 {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tag w-3.5 text-center text-[11px] opacity-70"></i><span>Kategori Cetak</span>
                </a>
                <a href="{{ route('materials.index') }}" class="sub-nav-item flex items-center gap-2 px-2 py-2 text-[12.5px] rounded-md transition-all duration-150 {{ request()->routeIs('materials.*') ? 'active' : '' }}">
                    <i class="fas fa-layer-group w-3.5 text-center text-[11px] opacity-70"></i><span>Stok Bahan</span>
                </a>
                <a href="{{ route('units.index') }}" class="sub-nav-item flex items-center gap-2 px-2 py-2 text-[12.5px] rounded-md transition-all duration-150 {{ request()->routeIs('units.*') ? 'active' : '' }}">
                    <i class="fas fa-ruler w-3.5 text-center text-[11px] opacity-70"></i><span>Satuan Unit</span>
                </a>
                <a href="{{ route('stocklogs.index') }}" class="sub-nav-item flex items-center gap-2 px-2 py-2 text-[12.5px] rounded-md transition-all duration-150 {{ request()->routeIs('stocklogs.*') ? 'active' : '' }}">
                    <i class="fas fa-history w-3.5 text-center text-[11px] opacity-70"></i><span>Log Riwayat Stok</span>
                </a>
            </div>
        </div>

        {{-- Konten & Marketing --}}
        @php $openKonten = request()->is('heros*', 'faqs*', 'services*', 'portofolios*') ? 'true' : 'false'; @endphp
        <div x-data="{ open: {{ $openKonten }} }">
            <p class="px-3 mb-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Konten Web</p>

            <button type="button" @click="open = !open"
                    class="nav-item w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-150 text-left">
                <i class="fas fa-edit w-4 text-center text-[13px] shrink-0"></i>
                <span class="flex-1">Manajemen Konten</span>
                <svg :class="open ? 'rotate-90 text-blue-400' : 'rotate-0 text-slate-500'" class="w-3 h-3 shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>

            <div x-show="open" class="mt-1 ml-3 pl-4 space-y-0.5 border-l border-slate-800">
                <a href="{{ route('heros.index') }}" class="sub-nav-item flex items-center gap-2 px-2 py-2 text-[12.5px] rounded-md {{ request()->routeIs('heros.*') ? 'active' : '' }}">
                    <i class="fas fa-images w-3.5 text-center text-[11px] opacity-70"></i><span>Banner Promo</span>
                </a>
                <a href="{{ route('portofolios.index') }}" class="sub-nav-item flex items-center gap-2 px-2 py-2 text-[12.5px] rounded-md {{ request()->routeIs('portofolios.*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase w-3.5 text-center text-[11px] opacity-70"></i><span>Portofolio</span>
                </a>
                <a href="{{ route('faqs.index') }}" class="sub-nav-item flex items-center gap-2 px-2 py-2 text-[12.5px] rounded-md {{ request()->routeIs('faqs.*') ? 'active' : '' }}">
                    <i class="fas fa-question-circle w-3.5 text-center text-[11px] opacity-70"></i><span>FAQ</span>
                </a>
            </div>
        </div>

        {{-- Affiliate & Keuangan --}}
        @php $openAffiliate = request()->is('member-requests*', 'withdrawals*', 'admin-saldo-logs*') ? 'true' : 'false'; @endphp
        <div x-data="{ open: {{ $openAffiliate }} }">
            <p class="px-3 mb-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Affiliate & Keuangan</p>

            <button type="button" @click="open = !open"
                    class="nav-item w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-150 text-left">
                <i class="fas fa-users-cog w-4 text-center text-[13px] shrink-0"></i>
                <span class="flex-1">Member & Komisi</span>
                <svg :class="open ? 'rotate-90 text-blue-400' : 'rotate-0 text-slate-500'" class="w-3 h-3 shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>

            <div x-show="open" class="mt-1 ml-3 pl-4 space-y-0.5 border-l border-slate-800">
                <a href="{{ route('member-requests.index') }}" class="sub-nav-item flex items-center gap-2 px-2 py-2 text-[12.5px] rounded-md {{ request()->routeIs('member-requests.*') ? 'active' : '' }}">
                    <i class="fas fa-user-clock w-3.5 text-center text-[11px] opacity-70"></i>
                    <span class="flex-1">Permintaan Member</span>
                    <span class="bg-blue-600 text-[10px] px-1.5 rounded-full text-white">{{ \App\Models\MemberRequest::where('status', 'pending')->count() }}</span>
                </a>
                <a href="{{ route('admin.withdrawals.index') }}" class="sub-nav-item flex items-center gap-2 px-2 py-2 text-[12.5px] rounded-md {{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}">
                    <i class="fas fa-wallet w-3.5 text-center text-[11px] opacity-70"></i><span>Pencairan Dana</span>
                </a>
                <a href="{{ route('admin.saldo-logs.index') }}" class="sub-nav-item flex items-center gap-2 px-2 py-2 text-[12.5px] rounded-md {{ request()->routeIs('admin.saldo-logs.*') ? 'active' : '' }}">
                    <i class="fas fa-receipt w-3.5 text-center text-[11px] opacity-70"></i><span>Log Saldo</span>
                </a>
            </div>
        </div>

        {{-- Konfigurasi --}}
        <div>
            <p class="px-3 mb-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Sistem</p>
            <div class="space-y-0.5">
                <a href="{{ route('users.index') }}" class="nav-item flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-150 group {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fas fa-user-shield w-4 text-center text-[13px] shrink-0"></i>
                    <span>Kelola Pengguna</span>
                </a>
                <a href="{{ route('settings.index') }}" class="nav-item flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-[13px] font-medium transition-all duration-150 group {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                    <i class="fas fa-cog w-4 text-center text-[13px] shrink-0"></i>
                    <span>Pengaturan Toko</span>
                </a>
            </div>
        </div>

    </nav>
    
{{-- Bottom Section (Logout/Profile) --}}
<div class="p-3 border-t border-white/[0.06]">
    <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-[10px] bg-white/[0.04] border border-white/[0.07]">
        
        {{-- Avatar --}}
        <div class="w-[34px] h-[34px] rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-[13px] font-medium text-white uppercase shrink-0 tracking-wide">
            {{ substr(Auth::user()->username, 0, 1) }}
        </div>

        {{-- Info --}}
        <div class="flex-1 min-w-0">
            <p class="text-[12.5px] font-medium text-slate-100 truncate leading-snug">
                {{ Auth::user()->username }}
            </p>
            <p class="text-[10.5px] text-slate-500 mt-0.5 flex items-center gap-1 leading-none">
                <span class="w-[5px] h-[5px] rounded-full bg-green-500 shrink-0"></span>
                Admin Panel
            </p>
        </div>

        {{-- Logout Button --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    title="Logout"
                    class="w-[30px] h-[30px] rounded-lg bg-transparent border border-white/[0.08] flex items-center justify-center text-slate-500 hover:bg-red-500/[0.12] hover:border-red-500/30 hover:text-red-400 transition-all duration-150 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <polyline points="16 17 21 12 16 7"/>
                    <line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
            </button>
        </form>

    </div>
</div>
</aside>