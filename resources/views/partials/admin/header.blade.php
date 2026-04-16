@php
    use App\Models\Notification;
    use App\Models\Materials;
    use App\Models\Orders;

    // Notifications
    $stockNotifs = Notification::where('type', 'stock')
        ->whereNull('user_id')
        ->where('is_read', false)
        ->latest()
        ->get();

    $otherNotifs = Notification::where('is_read', false)
        ->whereNull('user_id')
        ->where('type', '!=', 'stock')
        ->latest()
        ->take(10)
        ->get();

    $unreadNotifs = $stockNotifs->concat($otherNotifs);
    $countNotif = Notification::whereNull('user_id')->where('is_read', false)->count();
    $stockNotifCount = $stockNotifs->count();
    $countAntrian = Orders::whereIn('status', ['paid', 'processing'])->count();
    $lowStockCount = Materials::whereColumn('stock', '<=', 'min_stock')->count();
    
    $user = auth()->user();
    $userInitial = strtoupper(substr($user->username, 0, 1));
@endphp

<header class="sticky top-0 z-50 w-full bg-white border-b border-gray-100 shadow-sm">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-20">

            {{-- ==================== LEFT SECTION ==================== --}}
            <div class="flex items-center gap-4">
                {{-- Mobile Menu Toggle --}}
                <button @click="sidebarOpen = true" 
                    class="p-2 -ml-2 text-gray-500 rounded-xl hover:bg-gray-100 lg:hidden transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>



                {{-- Divider --}}
                <div class="hidden lg:block w-px h-8 bg-gray-200"></div>

                {{-- Quick Date --}}
                <div class="hidden lg:flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-lg">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-xs font-medium text-gray-600">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMM YYYY') }}</span>
                </div>
            </div>

            {{-- ==================== RIGHT SECTION ==================== --}}
            <div class="flex items-center gap-2 sm:gap-3">

                {{-- Button: Orders Queue --}}
                <a href="{{ route('admin.orders.index') }}" 
                    class="hidden lg:flex items-center gap-2 px-3.5 py-2 bg-white text-gray-700 rounded-xl hover:shadow-md border border-gray-200 transition-all duration-200 hover:border-gray-300">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span class="text-sm font-semibold">Antrian</span>
                    <span class="flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[10px] font-bold text-white bg-blue-500 rounded-lg">{{ $countAntrian }}</span>
                </a>

                {{-- Button: Materials --}}
                <a href="{{ route('materials.index') }}" 
                    class="hidden md:flex items-center gap-2 px-3.5 py-2 bg-white text-gray-700 rounded-xl hover:shadow-md border border-gray-200 transition-all duration-200">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="text-sm font-semibold hidden xl:inline">Material</span>
                    @if($lowStockCount > 0)
                        <span class="flex items-center justify-center min-w-[20px] h-5 px-1.5 text-[10px] font-bold text-white bg-red-500 rounded-lg">{{ $lowStockCount }}</span>
                    @endif
                </a>

                {{-- Separator --}}
                <div class="hidden sm:block w-px h-6 bg-gray-200"></div>

                {{-- ==================== NOTIFICATION DROPDOWN ==================== --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false"
                        class="relative p-2 text-gray-500 rounded-xl hover:bg-gray-100 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if($countNotif > 0)
                            <span class="absolute -top-1 -right-1 flex items-center justify-center min-w-[18px] h-4 px-1 text-[9px] font-bold text-white bg-red-500 rounded-full">{{ $countNotif > 9 ? '9+' : $countNotif }}</span>
                        @endif
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden" style="display: none;">
                        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Notifikasi</h3>
                            @if($countNotif > 0)
                                <button onclick="markAllAsRead()" class="text-[10px] font-semibold text-blue-500 hover:text-blue-600">Tandai Dibaca</button>
                            @endif
                        </div>

                        <div class="max-h-96 overflow-y-auto divide-y divide-gray-100">
                            @if($stockNotifs->count() > 0)
                                <div class="bg-red-50 px-4 py-2">
                                    <p class="text-[10px] font-bold text-red-600 uppercase flex items-center gap-2"><span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>Stok Kritis!</p>
                                </div>
                                @foreach($stockNotifs as $notif)
                                    <a href="{{ route('notifications.read', $notif->notif_id) }}" class="flex items-start gap-3 px-4 py-3 hover:bg-red-50/50 transition-colors">
                                        <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center"><svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg></div>
                                        <div class="flex-1"><p class="text-xs font-bold text-red-800">{{ $notif->title }}</p><p class="text-[10px] text-red-600">{{ $notif->message }}</p><p class="text-[9px] text-red-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p></div>
                                    </a>
                                @endforeach
                            @endif
                            @forelse($otherNotifs as $notif)
                                <a href="{{ route('notifications.read', $notif->notif_id) }}" class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                                    <div class="w-8 h-8 rounded-lg {{ $notif->type == 'order' ? 'bg-green-100' : 'bg-blue-100' }} flex items-center justify-center"><svg class="w-4 h-4 {{ $notif->type == 'order' ? 'text-green-500' : 'text-blue-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $notif->type == 'order' ? 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z' : 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z' }}"/></svg></div>
                                    <div class="flex-1"><p class="text-xs font-bold text-gray-800">{{ $notif->title }}</p><p class="text-[10px] text-gray-500">{{ $notif->message }}</p><p class="text-[9px] text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p></div>
                                </a>
                            @empty
                                @if($stockNotifs->count() == 0)
                                    <div class="text-center py-8"><svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg><p class="text-sm text-gray-500">Tidak ada notifikasi</p></div>
                                @endif
                            @endforelse
                        </div>
                        @if($unreadNotifs->count() > 0)
                            <div class="p-2 border-t border-gray-100"><a href="{{ route('notifications.index') }}" class="block text-center text-xs font-semibold text-blue-500 py-2 hover:bg-gray-50 rounded-lg">Lihat Semua</a></div>
                        @endif
                    </div>
                </div>

                {{-- ==================== USER DROPDOWN ==================== --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false"
                        class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-gray-50 transition-all duration-200">
                        <div class="hidden sm:block text-right">
                            <p class="text-sm font-semibold text-gray-800">{{ $user->username }}</p>
                            <p class="text-[10px] font-medium text-blue-500">ADMIN</p>
                        </div>
                        <div class="relative">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-sm">
                                <span class="text-white font-bold text-sm">{{ $userInitial }}</span>
                            </div>
                            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <svg class="w-3 h-3 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden" style="display: none;">
                        <div class="p-3 border-b border-gray-100 flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&background=0ea5e9&color=fff&bold=true" class="w-8 h-8 rounded-lg" alt="Avatar">
                            <div><p class="text-sm font-semibold text-gray-800">{{ $user->username }}</p><p class="text-[10px] text-gray-400">{{ $user->email ?? $user->useremail }}</p></div>
                        </div>
                        <div class="p-1">

                            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-500 rounded-lg hover:bg-red-50"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>Keluar Sistem</button></form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>

<script>
    function markAllAsRead() {
        fetch("{{ route('notifications.readAll') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}", 'Content-Type': 'application/json' }
        }).then(res => res.json()).then(data => { if(data.success) location.reload(); });
    }
</script>