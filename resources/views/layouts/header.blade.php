<header class="sticky top-0 z-40 w-full bg-white/80 backdrop-blur-md border-b border-neutral-200/60">
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-20">
            
            <div class="flex items-center flex-1 space-x-4">
                <button id="mobile-menu-button" class="p-2 md:hidden text-neutral-600 hover:bg-neutral-100 rounded-lg transition-colors">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <div class="relative hidden md:block group">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fas fa-search text-neutral-400 group-focus-within:text-primary-500 transition-colors"></i>
                    </div>
                    <input type="text" 
                           class="pl-11 pr-4 py-2.5 bg-neutral-50 border border-neutral-200 rounded-xl focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 focus:bg-white w-64 lg:w-[400px] transition-all duration-300 outline-none text-sm"
                           placeholder="Cari pesanan, produk, atau pelanggan (Ctrl + K)">
                </div>
            </div>
            
            <div class="flex items-center space-x-2 sm:space-x-4">
                
                <div class="hidden lg:flex items-center px-1">
                    <a href="#" class="relative flex items-center px-4 py-2.5 bg-neutral-50 text-neutral-700 rounded-xl hover:bg-neutral-100 border border-neutral-200 transition-all duration-200 group">
                        <i class="fas fa-layer-group mr-2.5 text-primary-600"></i>
                        <span class="font-semibold text-sm">Antrian Cetak</span>
                        <span class="ml-2.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-primary-600 px-1.5 text-[10px] font-bold text-white">3</span>
                    </a>
                </div>
                
                <div class="hidden sm:block w-[1px] h-8 bg-neutral-200 mx-1"></div>

                <div class="relative">
                    <button id="notification-button" 
                            class="relative p-2.5 text-neutral-500 hover:text-primary-600 hover:bg-primary-50 rounded-xl transition-all duration-200">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-2.5 right-3 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                    </button>
                    
                    <div id="notification-dropdown" 
                         class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-xl border border-neutral-100 hidden z-50 overflow-hidden transform origin-top-right transition-all">
                        </div>
                </div>
                
                <div class="relative">
                    <button id="user-menu-button" 
                            class="flex items-center pl-2 pr-1 py-1 hover:bg-neutral-50 border border-transparent hover:border-neutral-200 rounded-2xl transition-all duration-200 group">
                        <div class="text-right mr-3 hidden lg:block">
                            <p class="text-sm font-bold text-neutral-900 leading-tight">Daffa Arkhab</p>
                            <p class="text-[11px] font-medium text-neutral-400 uppercase tracking-wider">Super Admin</p>
                        </div>
                        <div class="relative ring-2 ring-offset-2 ring-transparent group-hover:ring-primary-500/20 rounded-full transition-all">
                            <img src="https://ui-avatars.com/api/?name=Daffa+Arkhab&background=0ea5e9&color=fff" 
                                 alt="Profile" 
                                 class="w-10 h-10 rounded-full object-cover">
                            <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <i class="fas fa-chevron-down ml-2 text-[10px] text-neutral-400 group-hover:text-neutral-600 transition-colors"></i>
                    </button>
                    
                    <div id="user-dropdown" 
                         class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-xl border border-neutral-100 hidden z-50 overflow-hidden">
                        <div class="p-2">
                            <a href="#" class="flex items-center px-3 py-2.5 text-sm text-neutral-600 hover:bg-neutral-50 hover:text-primary-600 rounded-lg transition-colors">
                                <i class="fas fa-user-circle mr-3 opacity-50"></i> Profil Saya
                            </a>
                            <a href="#" class="flex items-center px-3 py-2.5 text-sm text-neutral-600 hover:bg-neutral-50 hover:text-primary-600 rounded-lg transition-colors">
                                <i class="fas fa-cog mr-3 opacity-50"></i> Pengaturan
                            </a>
                            <div class="h-px bg-neutral-100 my-1"></div>
                            <button class="w-full flex items-center px-3 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                <i class="fas fa-sign-out-alt mr-3"></i> Keluar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>