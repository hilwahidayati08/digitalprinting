{{-- Navbar untuk Guest & User --}}
<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-neutral-100">
    <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12">
        <div class="flex items-center justify-between h-20">

            <!-- Logo Section -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center group">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 overflow-hidden bg-slate-100 shadow-[0_0_15px_rgba(37,99,235,0.5)] border border-white/20">
                            <img src="{{ asset('storage/logo-cetakkilat2.png') }}"
                                 alt="CetakKilat Logo"
                                 class="w-full h-full object-contain p-1.5"
                                 onerror="this.src='https://placehold.co/40x40?text=CK'">
                        </div>
                    </div>
                    <div class="ml-4 hidden sm:block">
                        <div class="font-black text-xl tracking-tight text-neutral-900 leading-none">
                            Cetak<span class="text-primary-600">Kilat</span>
                        </div>
                        <div class="text-[9px] mt-1.5 leading-none text-neutral-400 font-bold uppercase tracking-[0.15em]">
                            Digital Printing
                        </div>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center bg-neutral-50/50 p-1.5 rounded-2xl border border-neutral-100">
                <a href="{{ route('home') }}"
                    class="px-5 py-2 text-sm font-bold rounded-xl transition-all duration-300 {{ request()->routeIs('home') ? 'text-primary-600 bg-white shadow-sm' : 'text-neutral-500 hover:text-primary-600' }}">
                    Beranda
                </a>
                <a href="{{ request()->routeIs('home') ? '#tentang-kami' : route('home') . '#tentang-kami' }}"
                    class="px-5 py-2 text-sm font-bold rounded-xl transition-all duration-300 text-neutral-500 hover:text-primary-600">
                    Tentang
                </a>
                <a href="{{ route('products') }}" class="px-5 py-2 text-sm font-bold text-neutral-500 hover:text-primary-600 transition-all">Produk</a>
                <a href="{{ route('portofolio.index') }}" class="px-5 py-2 text-sm font-bold text-neutral-500 hover:text-primary-600 transition-all">Portofolio</a>
                <a href="{{ route('contact') }}" class="px-5 py-2 text-sm font-bold text-neutral-500 hover:text-primary-600 transition-all">Kontak</a>
            </div>

            <!-- Right Side Icons -->
            <div class="flex items-center space-x-3">

                {{-- Keranjang: tampil untuk semua user --}}
                @guest
                    <a href="{{ route('login') }}" class="p-2.5 text-neutral-500 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all relative inline-flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </a>
                @endguest

                @auth
                    <a href="{{ route('cart.index') }}" class="p-2.5 text-neutral-500 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all relative group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>

                        @php
                            $cartCount = \App\Models\CartItems::whereHas('cart', function($query) {
                                $query->where('user_id', auth()->id());
                            })->count();
                        @endphp

                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-primary-600 rounded-full text-[10px] flex items-center justify-center text-white font-black shadow-md">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        @endif
                    </a>
                @endauth

                <div class="w-[1px] h-6 bg-neutral-200 mx-2"></div>

                {{-- Bell: tampil untuk semua user --}}
                <div class="relative">
                    @guest
                        <a href="{{ route('login') }}" class="p-2.5 text-neutral-500 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all inline-flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </a>
                    @endguest

                    @auth
                        <button id="userNotifBtn" class="relative p-2.5 text-neutral-500 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @php
                                $userUnreadNotif = \App\Models\Notification::where('user_id', auth()->id())
                                                    ->where('is_read', false)->count();
                            @endphp
                            @if($userUnreadNotif > 0)
                                <span id="notifBadge" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 border-2 border-white rounded-full text-[10px] flex items-center justify-center text-white font-bold">
                                    {{ $userUnreadNotif > 9 ? '9+' : $userUnreadNotif }}
                                </span>
                            @endif
                        </button>

                        <div id="userNotifPanel" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-neutral-100 z-50 overflow-hidden">
                            <div class="px-4 py-3 bg-gradient-to-r from-primary-50 to-white border-b border-primary-100">
                                <h3 class="text-xs font-bold text-neutral-800">
                                    <i class="fas fa-bell mr-2 text-primary-500"></i>Notifikasi Pesanan
                                </h3>
                            </div>
                            <div id="notifListContainer" class="max-h-96 overflow-y-auto">
                                @php
                                    // {{-- PERUBAHAN 1: hanya ambil notifikasi yang belum dibaca --}}
                                    $userNotifs = \App\Models\Notification::where('user_id', auth()->id())
                                                ->where('is_read', false)
                                                ->latest()->take(10)->get();
                                @endphp
                                @forelse($userNotifs as $notif)
                                    <a href="{{ $notif->url ? url($notif->url) : '#' }}"
                                       class="notif-item flex items-start gap-3 px-4 py-3 hover:bg-neutral-50 transition border-b border-neutral-50">
                                        <div class="w-8 h-8 rounded-lg {{ $notif->type == 'status' ? 'bg-green-100 text-green-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center shrink-0">
                                            <i class="fas {{ $notif->type == 'status' ? 'fa-check-circle' : 'fa-truck' }} text-xs"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs font-bold text-neutral-800">{{ $notif->title }}</p>
                                            <p class="text-[11px] text-neutral-500 mt-0.5">{{ $notif->message }}</p>
                                            <p class="text-[10px] text-neutral-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                        </div>
                                        <div class="notif-unread-dot w-1.5 h-1.5 bg-primary-500 rounded-full shrink-0 mt-1"></div>
                                    </a>
                                @empty
                                    <div id="notifEmptyState" class="text-center py-8">
                                        <i class="fas fa-bell-slash text-3xl text-neutral-300 mb-2"></i>
                                        <p class="text-xs text-neutral-400">Tidak ada notifikasi</p>
                                    </div>
                                @endforelse
                            </div>
                            <div class="p-2 border-t border-neutral-100 bg-neutral-50">
                                <a href="{{ route('orders.index') }}" class="block text-center text-xs font-bold text-primary-600 py-2">
                                    Lihat Semua Pesanan →
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>

                @auth
                    <div class="relative">
                        <button id="userDropdownBtn" class="p-1 rounded-full border-2 border-transparent hover:border-primary-100 transition-all group flex items-center gap-2">
                            <div class="w-10 h-10 bg-gradient-to-tr from-primary-600 to-primary-500 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                            </div>
                            <i id="userChevron" class="fas fa-chevron-down text-xs text-neutral-400 group-hover:text-primary-600 transition-transform duration-300 hidden sm:inline-block"></i>
                        </button>

                        <div id="userDropdownMenu" class="hidden absolute right-0 top-full mt-2 w-64 bg-white border border-neutral-100 rounded-2xl shadow-xl z-50 overflow-hidden origin-top-right">
                            <div class="p-4 bg-gradient-to-r from-primary-50 to-white border-b border-primary-100">
                                <p class="text-sm font-black text-neutral-900">{{ auth()->user()->username }}</p>
                                <p class="text-xs text-neutral-500 mt-0.5">{{ auth()->user()->email ?? auth()->user()->useremail }}</p>
                            </div>
                            <div class="p-2">
                                <a href="{{ route('profile.edit', Auth::user()->user_id) }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-neutral-700 hover:bg-neutral-50 hover:text-primary-600 rounded-xl transition-all">
                                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Profil Saya
                                </a>
                                <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-neutral-700 hover:bg-neutral-50 hover:text-primary-600 rounded-xl transition-all">
                                    <svg class="w-5 h-5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                    Pesanan Saya
                                </a>
                                <div class="my-2 border-t border-neutral-100"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full gap-3 px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden lg:flex items-center space-x-2">
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-bold text-neutral-600 hover:text-primary-600 transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 text-sm font-bold bg-primary-600 text-white rounded-xl hover:bg-primary-700 hover:shadow-lg hover:shadow-primary-200 transition-all active:scale-95">
                            Daftar
                        </a>
                    </div>
                @endauth

                <!-- Mobile Menu Button -->
                <button id="mobileMenuBtn" class="lg:hidden p-2.5 text-neutral-700 hover:bg-neutral-100 rounded-xl transition-colors" aria-expanded="false">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="lg:hidden hidden fixed inset-x-0 top-20 z-40 bg-white border-b border-neutral-100 shadow-xl max-h-[calc(100vh-5rem)] overflow-y-auto">
        <div class="px-6 py-4 space-y-2">
            <a href="{{ route('home') }}" class="block px-4 py-3 text-base font-bold rounded-xl {{ request()->routeIs('home') ? 'text-primary-600 bg-primary-50' : 'text-neutral-600 hover:bg-neutral-50' }}">
                Beranda
            </a>
            <a href="{{ request()->routeIs('home') ? '#tentang-kami' : route('home') . '#tentang-kami' }}" class="block px-4 py-3 text-base font-bold rounded-xl text-neutral-600 hover:bg-neutral-50">
                Tentang
            </a>
            <a href="{{ route('products') }}" class="block px-4 py-3 text-base font-bold rounded-xl text-neutral-600 hover:bg-neutral-50">
                Produk
            </a>
            <a href="{{ route('portofolio.index') }}" class="block px-4 py-3 text-base font-bold rounded-xl text-neutral-600 hover:bg-neutral-50">
                Portofolio
            </a>
            <a href="{{ route('contact') }}" class="block px-4 py-3 text-base font-bold rounded-xl text-neutral-600 hover:bg-neutral-50">
                Kontak
            </a>

            @guest
                <div class="pt-4 mt-2 border-t border-neutral-100 space-y-2">
                    <a href="{{ route('login') }}" class="block px-4 py-3 text-center text-base font-bold text-neutral-600 hover:bg-neutral-50 rounded-xl">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="block px-4 py-3 text-center text-base font-bold bg-primary-600 text-white rounded-xl hover:bg-primary-700">
                        Daftar
                    </a>
                </div>
            @else
                <div class="pt-4 mt-2 border-t border-neutral-100 space-y-2">
                    <div class="px-4 py-3 text-sm text-neutral-500">
                        Login sebagai: <span class="font-bold text-neutral-800">{{ auth()->user()->username }}</span>
                    </div>
                    <a href="{{ route('profile.edit', Auth::user()->user_id) }}" class="block px-4 py-3 text-base font-bold text-neutral-600 hover:bg-neutral-50 rounded-xl">
                        Profil Saya
                    </a>
                    <a href="{{ route('orders.index') }}" class="block px-4 py-3 text-base font-bold text-neutral-600 hover:bg-neutral-50 rounded-xl">
                        Pesanan Saya
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 text-base font-bold text-red-500 hover:bg-red-50 rounded-xl text-left">
                            Keluar
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Mobile Menu Toggle ──────────────────────────────────────────
    const mobileBtn  = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', function () {
            const isExpanded = mobileBtn.getAttribute('aria-expanded') === 'true';
            mobileBtn.setAttribute('aria-expanded', !isExpanded);

            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                mobileBtn.querySelector('svg').innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />`;
            } else {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = '';
                mobileBtn.querySelector('svg').innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />`;
            }
        });

        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                document.body.style.overflow = '';
                mobileBtn.setAttribute('aria-expanded', 'false');
                mobileBtn.querySelector('svg').innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />`;
            });
        });
    }

    // ── User Dropdown ───────────────────────────────────────────────
    const userBtn     = document.getElementById('userDropdownBtn');
    const userMenu    = document.getElementById('userDropdownMenu');
    const userChevron = document.getElementById('userChevron');

    if (userBtn && userMenu) {
        userBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isHidden = userMenu.classList.contains('hidden');

            if (isHidden) {
                userMenu.classList.remove('hidden');
                if (userChevron) userChevron.classList.add('rotate-180');
            } else {
                userMenu.classList.add('hidden');
                if (userChevron) userChevron.classList.remove('rotate-180');
            }
        });

        document.addEventListener('click', (e) => {
            if (!userBtn.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
                if (userChevron) userChevron.classList.remove('rotate-180');
            }
        });
    }

// ── Notifikasi Bell ─────────────────────────────────────────────
const userNotifBtn   = document.getElementById('userNotifBtn');
const userNotifPanel = document.getElementById('userNotifPanel');

if (userNotifBtn && userNotifPanel) {
    userNotifBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        const isHidden = userNotifPanel.classList.contains('hidden');
        userNotifPanel.classList.toggle('hidden');

        // Hanya tembak API jika panel baru saja dibuka
        if (isHidden) {
            fetch('{{ route("notifications.readAll") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // 1. Hapus badge angka merah
                    const badge = document.getElementById('notifBadge');
                    if (badge) badge.remove();

                    // 2. Hapus titik biru (indikator unread) di setiap item, 
                    // tapi JANGAN hapus itemnya.
                    const unreadDots = document.querySelectorAll('.notif-unread-dot');
                    unreadDots.forEach(dot => dot.remove());
                }
            })
            .catch(err => console.error('Gagal mark notif:', err));
        }
    });

    document.addEventListener('click', (e) => {
        if (!userNotifBtn.contains(e.target) && !userNotifPanel.contains(e.target)) {
            userNotifPanel.classList.add('hidden');
        }
    });
}

});
</script>

<style>
.rotate-180 { transform: rotate(180deg); }
</style>