<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-neutral-100">
    <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12">
        <div class="flex items-center justify-between h-20">

            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center group">
                    <div class="relative">
                        <div class="w-11 h-11 bg-gradient-to-br from-primary-600 to-secondary-600 rounded-xl flex items-center justify-center group-hover:rotate-6 transition-all duration-500 shadow-lg shadow-primary-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 hidden sm:block">
                        <div class="font-black text-xl tracking-tight text-neutral-900 leading-none">
                            Print<span class="text-primary-600">Pro</span>
                        </div>
                        <div class="text-[9px] mt-1.5 leading-none text-neutral-400 font-bold uppercase tracking-[0.15em]">
                            Digital Printing
                        </div>
                    </div>
                </a>
            </div>

            <div class="hidden lg:flex items-center bg-neutral-50/50 p-1.5 rounded-2xl border border-neutral-100">
                <a href="{{ route('home') }}"
                    class="px-5 py-2 text-sm font-bold rounded-xl transition-all duration-300 {{ request()->routeIs('home') ? 'text-primary-600 bg-white shadow-sm' : 'text-neutral-500 hover:text-primary-600' }}">
                    Beranda
                </a>
<a href="{{ request()->routeIs('home') ? '#tentang-kami' : route('home') . '#tentang-kami' }}"
   class="px-5 py-2 text-sm font-bold rounded-xl transition-all duration-300 {{ request()->routeIs('home') && request()->is('#tentang') ? 'text-primary-600 bg-white shadow-sm' : 'text-neutral-500 hover:text-primary-600' }}">
   Tentang
</a>
                <a href="{{ route(name: 'products.products') }}" class="px-5 py-2 text-sm font-bold text-neutral-500 hover:text-primary-600 transition-all">Produk</a>
                <a href="{{ route('portofolio.index') }}" class="px-5 py-2 text-sm font-bold text-neutral-500 hover:text-primary-600 transition-all">Portofolio</a>
                <a href="{{ route(name: 'contact') }}" class="px-5 py-2 text-sm font-bold text-neutral-500 hover:text-primary-600 transition-all">Kontak</a>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('cart.index') }}" class="p-2.5 text-neutral-500 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-primary-600 rounded-full border-2 border-white"></span>
                </a>

                <div class="w-[1px] h-6 bg-neutral-200 mx-2"></div>

                @auth
                    <div class="relative group">
                        <button class="p-1 rounded-full border-2 border-transparent group-hover:border-primary-100 transition-all">
                            <div class="w-10 h-10 bg-gradient-to-tr from-primary-600 to-primary-500 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                                {{ substr(auth()->user()->username, 0, 1) }}
                            </div>
                        </button>

                        <div class="absolute right-0 top-full mt-2 w-52 bg-white border border-neutral-100 rounded-2xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 transform origin-top-right group-hover:translate-y-0 translate-y-2">
                            <div class="p-2">
                                <a href="{{ route('users.edit', Auth::user()->user_id) }}" class="flex items-center px-4 py-3 text-sm font-bold text-neutral-700 hover:bg-neutral-50 hover:text-primary-600 rounded-xl transition-colors">
                                    <svg class="w-4 h-4 mr-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Profil Saya
                                </a>
                                <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-3 text-sm font-bold text-neutral-700 hover:bg-neutral-50 hover:text-primary-600 rounded-xl transition-colors">
                                    <svg class="w-4 h-4 mr-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                    Pesanan Saya
                                </a>
                                <div class="my-2 border-t border-neutral-50"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-3 text-sm font-black text-red-500 hover:bg-red-50 rounded-xl transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
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

                <button id="mobile-menu-button" class="lg:hidden p-2.5 text-neutral-700 hover:bg-neutral-100 rounded-xl transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>