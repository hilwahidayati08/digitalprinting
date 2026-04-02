<aside id="sidebar" class="w-64 bg-[#0f172a] text-slate-300 flex flex-col transition-all duration-300 ease-in-out fixed md:relative -translate-x-full md:translate-x-0 z-50 shadow-2xl border-r border-slate-800">
    
    <div class="h-20 flex items-center px-5 border-b border-slate-800/50">
        <div class="flex items-center space-x-3 group cursor-pointer">
            <div class="w-9 h-9 rounded-lg bg-primary-600 flex items-center justify-center shadow-lg group-hover:rotate-6 transition-transform">
                <i class="fas fa-print text-white text-base"></i>
            </div>
            <div class="flex flex-col">
                <h2 class="text-white font-bold tracking-tight text-base leading-none">PrintMaster</h2>
                <span class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-1">Nusan Digital</span>
            </div>
        </div>
    </div>
    
    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-6 custom-scrollbar">
        
        <div>
            <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3">Main</p>
            <div class="space-y-0.5">
                <a href="#" class="flex items-center px-3 py-2.5 rounded-lg transition-all group {{ request()->routeIs('dashboard') ? 'bg-primary-600/10 text-primary-400' : 'hover:bg-slate-800/40 hover:text-white' }}">
                    <i class="fas fa-grid-2 w-5 mr-2 text-base {{ request()->routeIs('dashboard') ? 'text-primary-400' : 'text-slate-500 group-hover:text-slate-300' }}"></i>
                    <span class="font-medium text-[13px]">Dashboard</span>
                </a>

                <a href="#" class="flex items-center px-3 py-2.5 rounded-lg transition-all group hover:bg-slate-800/40 hover:text-white">
                    <i class="fas fa-shopping-bag w-5 mr-2 text-base text-slate-500 group-hover:text-slate-300"></i>
                    <span class="font-medium text-[13px]">Pesanan</span>
                    <span class="ml-auto bg-slate-800 group-hover:bg-primary-600 text-[10px] text-slate-400 group-hover:text-white px-1.5 py-0.5 rounded transition-colors">15</span>
                </a>
            </div>
        </div>

        <div>
            <p class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3">Layanan</p>
            <div class="space-y-0.5">
                <a href="#" class="flex items-center px-3 py-2.5 rounded-lg transition-all group hover:bg-slate-800/40 hover:text-white">
                    <i class="fas fa-box w-5 mr-2 text-base text-slate-500 group-hover:text-slate-300"></i>
                    <span class="font-medium text-[13px]">Katalog</span>
                </a>
                <a href="#" class="flex items-center px-3 py-2.5 rounded-lg transition-all group hover:bg-slate-800/40 hover:text-white">
                    <i class="fas fa-layer-group w-5 mr-2 text-base text-slate-500 group-hover:text-slate-300"></i>
                    <span class="font-medium text-[13px]">Jenis Cetak</span>
                </a>
            </div>
        </div>

        <div class="mx-1 p-4 rounded-xl bg-slate-800/30 border border-slate-700/50">
            <div class="flex items-center justify-between mb-3">
                <span class="text-[10px] font-bold text-slate-500 uppercase">System</span>
                <span class="h-1.5 w-1.5 rounded-full bg-green-500 shadow-[0_0_5px_#22c55e]"></span>
            </div>
            <div class="space-y-2">
                <div class="flex items-center justify-between text-[11px]">
                    <span class="text-slate-400">Printer UV</span>
                    <span class="text-primary-400 font-bold">Ready</span>
                </div>
                <div class="w-full bg-slate-700 h-1 rounded-full overflow-hidden">
                    <div class="bg-primary-500 h-full w-[70%]"></div>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="p-3 border-t border-slate-800/50">
        <button type="button" onclick="confirmLogout()" 
                class="w-full flex items-center px-3 py-2 rounded-lg text-slate-400 hover:bg-red-500/10 hover:text-red-400 transition-all group">
            <i class="fas fa-power-off w-5 mr-2 text-base opacity-50 group-hover:opacity-100"></i>
            <span class="font-bold text-[13px]">Sign Out</span>
        </button>
    </div>
</aside>