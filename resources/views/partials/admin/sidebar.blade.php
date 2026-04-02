<script defer src="https://unpkg.com/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<aside 
    id="sidebar" 
    x-data="{ 
        mobileOpen: false,
        openMenu: '{{ request()->is('admin/products*', 'categories*', 'materials*', 'units*', 'stocklogs*') ? 'produksi' : (request()->is('member-requests*', 'withdrawals*', 'admin-saldo-logs*') ? 'affiliate' : (request()->is('portofolios*', 'heros*', 'faqs*', 'services*') ? 'cms' : '')) }}'
    }"
    @open-sidebar.window="mobileOpen = true"
    :class="mobileOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
    class="w-64 bg-[#0f172a] text-slate-300 flex flex-col fixed md:sticky top-0 h-screen transition-all duration-300 ease-in-out border-r border-slate-800 z-[9999]"
>
    <div class="pointer-events-none absolute inset-0 opacity-[0.03] z-0" style="background-image: linear-gradient(rgba(148,163,184,1) 1px, transparent 1px), linear-gradient(90deg, rgba(148,163,184,1) 1px, transparent 1px); background-size: 32px 32px;"></div>

    <div class="relative z-10 h-[68px] flex items-center px-5 shrink-0 border-b border-white/5 bg-[#0f172a]">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-gradient-to-br from-blue-600 to-blue-800 shadow-lg shadow-blue-900/50">
                <i class="fas fa-print text-white text-[15px]"></i>
            </div>
            <div class="flex flex-col leading-none">
                <span class="text-white font-bold tracking-tight text-[15px]">PrintMaster</span>
                <span class="text-[9px] font-extrabold uppercase tracking-[0.2em] text-slate-500 mt-[3px]">Admin Panel</span>
            </div>
        </div>
        <button @click="mobileOpen = false" class="md:hidden ml-auto text-slate-500 hover:text-white p-2">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="relative z-10 flex-1 overflow-y-auto py-6 px-3 space-y-7 custom-scrollbar">
        
        <div>
            <p class="px-4 mb-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500/80">Main Menu</p>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-th-large"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-basket"></i> 
                    <span class="flex-1">Pesanan</span>
                    @php $pendingCount = \App\Models\Orders::where('status', 'paid')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="badge-blue">{{ $pendingCount }}</span>
                    @endif
                </a>
            </div>
        </div>

        <div class="space-y-1">
            <p class="px-4 mb-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500/80">Inventory</p>
            <div class="dropdown-container">
                <button type="button" 
                        @click="openMenu = (openMenu === 'produksi' ? '' : 'produksi')" 
                        class="nav-link w-full flex items-center justify-between bg-transparent border-none cursor-pointer outline-none transition-all"
                        :class="openMenu === 'produksi' ? 'text-white bg-white/5' : ''">
                    <div class="flex items-center gap-3 pointer-events-none">
                        <i class="fas fa-boxes"></i> <span>Master Data</span>
                    </div>
                    <i class="fas fa-chevron-right text-[10px] transition-transform duration-300 pointer-events-none" :class="openMenu === 'produksi' ? 'rotate-90' : ''"></i>
                </button>
                
                <div x-show="openMenu === 'produksi'" x-collapse x-cloak class="dropdown-content">
                    <a href="{{ route('products.index') }}" class="sub-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Katalog Produk</a>
                    <a href="{{ route('categories.index') }}" class="sub-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">Kategori Cetak</a>
                    <a href="{{ route('materials.index') }}" class="sub-link {{ request()->routeIs('materials.*') ? 'active' : '' }}">Stok Bahan</a>
                    <a href="{{ route('units.index') }}" class="sub-link {{ request()->routeIs('units.*') ? 'active' : '' }}">Satuan Unit</a>
                    <a href="{{ route('stocklogs.index') }}" class="sub-link {{ request()->routeIs('stocklogs.*') ? 'active' : '' }}">Riwayat Stok</a>
                </div>
            </div>
        </div>

        <div class="space-y-1">
            <p class="px-4 mb-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500/80">Finance</p>
            <div class="dropdown-container">
                <button type="button" 
                        @click="openMenu = (openMenu === 'affiliate' ? '' : 'affiliate')" 
                        class="nav-link w-full flex items-center justify-between bg-transparent border-none cursor-pointer outline-none transition-all"
                        :class="openMenu === 'affiliate' ? 'text-white bg-white/5' : ''">
                    <div class="flex items-center gap-3 pointer-events-none">
                        <i class="fas fa-hand-holding-usd"></i> <span>Affiliate</span>
                    </div>
                    <i class="fas fa-chevron-right text-[10px] transition-transform duration-300 pointer-events-none" :class="openMenu === 'affiliate' ? 'rotate-90' : ''"></i>
                </button>
                
                <div x-show="openMenu === 'affiliate'" x-collapse x-cloak class="dropdown-content">
                    <a href="{{ route('member-requests.index') }}" class="sub-link {{ request()->routeIs('member-requests.*') ? 'active' : '' }}">Request Member</a>
                    <a href="{{ route('admin.withdrawals.index') }}" class="sub-link {{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}">Pencairan Komisi</a>
                </div>
            </div>
        </div>

        <div class="space-y-1">
            <p class="px-4 mb-3 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500/80">Content</p>
            <div class="dropdown-container">
                <button type="button" 
                        @click="openMenu = (openMenu === 'cms' ? '' : 'cms')" 
                        class="nav-link w-full flex items-center justify-between bg-transparent border-none cursor-pointer outline-none transition-all"
                        :class="openMenu === 'cms' ? 'text-white bg-white/5' : ''">
                    <div class="flex items-center gap-3 pointer-events-none">
                        <i class="fas fa-laptop-code"></i> <span>Website CMS</span>
                    </div>
                    <i class="fas fa-chevron-right text-[10px] transition-transform duration-300 pointer-events-none" :class="openMenu === 'cms' ? 'rotate-90' : ''"></i>
                </button>
                
                <div x-show="openMenu === 'cms'" x-collapse x-cloak class="dropdown-content">
                    <a href="{{ route('portofolios.index') }}" class="sub-link {{ request()->routeIs('portofolios.*') ? 'active' : '' }}">Portfolio</a>
                    <a href="{{ route('services.index') }}" class="sub-link {{ request()->routeIs('services.*') ? 'active' : '' }}">Layanan</a>
                    <a href="{{ route('heros.index') }}" class="sub-link {{ request()->routeIs('heros.*') ? 'active' : '' }}">Banner</a>
                    <a href="{{ route('faqs.index') }}" class="sub-link {{ request()->routeIs('faqs.*') ? 'active' : '' }}">FAQ</a>
                </div>
            </div>
        </div>

        <div class="pt-4 border-t border-white/5">
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="fas fa-user-shield"></i> <span>Kelola Akun</span>
            </a>
            <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> <span>Pengaturan Situs</span>
            </a>
        </div>
    </nav>

    <div class="shrink-0 p-4 border-t border-white/5 bg-[#0f172a] relative z-20">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-[13px] font-semibold text-red-400 bg-red-500/5 hover:bg-red-500/10 border border-red-500/20 transition-all group">
                <i class="fas fa-sign-out-alt group-hover:scale-110 transition-transform"></i> <span>Keluar Sistem</span>
            </button>
        </form>
    </div>
</aside>

<style>
/* --- UTILITIES --- */
[x-cloak] { display: none !important; }

/* --- CUSTOM SCROLLBAR (Elegan & Modern) --- */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
}
.custom-scrollbar:hover::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.15);
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #2563eb;
}

/* --- NAV LINKS --- */
.nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 16px;
    border-radius: 12px;
    font-size: 13.5px;
    font-weight: 500;
    color: #94a3b8;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
}
.nav-link i {
    width: 20px;
    text-align: center;
    font-size: 14px;
    opacity: 0.7;
}
.nav-link:hover {
    background: rgba(255, 255, 255, 0.05);
    color: #f1f5f9;
}
.nav-link.active {
    background: linear-gradient(to right, rgba(37, 99, 235, 0.15), transparent);
    color: #60a5fa;
    border-left: 3px solid #2563eb;
    border-radius: 4px 12px 12px 4px;
}
.nav-link.active i { color: #60a5fa; opacity: 1; }

/* --- DROPDOWN STYLES --- */
.dropdown-content {
    margin-top: 4px;
    margin-left: 22px;
    padding-left: 16px;
    border-left: 1px solid rgba(255, 255, 255, 0.08);
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.sub-link {
    padding: 8px 12px;
    font-size: 12.5px;
    color: #64748b;
    border-radius: 8px;
    transition: all 0.2s ease;
    text-decoration: none;
}
.sub-link:hover { color: #f1f5f9; background: rgba(255, 255, 255, 0.03); }
.sub-link.active { color: #60a5fa; font-weight: 600; background: rgba(37, 99, 235, 0.05); }

/* --- BADGE --- */
.badge-blue {
    background: #2563eb;
    color: white;
    font-size: 10px;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 6px;
    box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
}
</style>