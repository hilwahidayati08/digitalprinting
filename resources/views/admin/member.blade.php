@extends('admin.guest')

@section('content')
@php
    $setting = \App\Models\Settings::first();
    $hasRequested = \App\Models\MemberRequest::where('user_id', Auth::id())->where('status', 'pending')->exists();
    $user = Auth::user();
    
    // Logika Progress Bar
    $currentSpent = $user->total_spent ?? 0;
    $progress = 0; $target = 0; $nextTierLabel = ""; $isMax = false;
    $minPlus = $setting->tier_plus_min ?? 1000000;
    $minPremium = $setting->tier_premium_min ?? 5000000;

    if ($currentSpent < $minPlus) {
        $target = $minPlus; $nextTierLabel = "Plus";
        $progress = ($target > 0) ? ($currentSpent / $target) * 100 : 0;
    } elseif ($currentSpent < $minPremium) {
        $target = $minPremium; $nextTierLabel = "Premium";
        $range = $minPremium - $minPlus;
        $achieved = $currentSpent - $minPlus;
        $progress = ($range > 0) ? ($achieved / $range) * 100 : 0;
    } else {
        $progress = 100; $isMax = true;
    }

    $navs = [
        ['route' => 'profile.edit',    'url' => route('profile.edit'),    'label' => 'Akun Saya',          'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
        ['route' => 'profile.security','url' => route('profile.security'),'label' => 'Keamanan',            'icon' => 'M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z'],
        ['route' => 'shippings.*',     'url' => route('shippings.index'), 'label' => 'Alamat Pengiriman',   'icon' => 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z M15 11a3 3 0 11-6 0 3 3 0 016 0z'],
        ['route' => 'orders.*',        'url' => route('orders.index'),    'label' => 'Pesanan Saya',        'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
    ];

    if ($user->is_member) {
        $navs[] = [
            'route' => 'withdrawal.*',
            'url'   => route('withdrawal.index'),
            'label' => 'Penarikan Dana',
            'icon'  => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ];
    }
@endphp

<section class="py-10 bg-[#F8FAFC] min-h-screen">
    <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- ===== SIDEBAR ===== --}}
            <div class="w-full lg:w-[280px] flex-shrink-0">
                <div class="bg-white rounded-[2rem] overflow-hidden shadow-sm border border-neutral-100 lg:sticky lg:top-24">

                    {{-- Profile Header --}}
                    <div class="relative bg-gradient-to-br from-primary-600 to-secondary-600 px-7 pt-8 pb-14 overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
                        <div class="absolute bottom-0 left-0 w-20 h-20 bg-black/5 rounded-full translate-y-8 -translate-x-6"></div>
                        
                        <div class="relative flex items-center gap-4">
                            <div class="relative">
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-md border border-white/30 text-white rounded-2xl flex items-center justify-center text-xl font-black shadow-lg">
                                    {{ strtoupper(substr($user->username, 0, 1)) }}
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-400 rounded-full border-2 border-primary-600"></div>
                            </div>
                            <div class="z-10">
                                <div class="flex items-center gap-1.5">
                                    <p class="text-[10px] text-white/70 font-bold uppercase tracking-widest">Halo,</p>
                                    @if($user->is_member)
                                        <span class="px-2 py-0.5 rounded-md text-[9px] font-black tracking-tighter {{ $user->member_tier == 'premium' ? 'bg-amber-400 text-amber-900' : 'bg-white/20 text-white' }}">
                                            {{ strtoupper($user->member_tier ?? 'REGULAR') }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-lg font-black text-white leading-tight tracking-tight">{{ $user->username }}</p>
                                <p class="text-[10px] text-white/60 mt-0.5 truncate max-w-[150px]">{{ $user->useremail }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Saldo Card --}}
                    @if($user->is_member)
                    <div class="mx-5 -mt-7 relative z-10">
                        <div class="bg-white border border-neutral-100 rounded-2xl px-5 py-4 flex flex-col shadow-xl shadow-primary-900/5">
                            <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-widest mb-1">Saldo Komisi</p>
                            <div class="flex items-center justify-between">
                                <p class="text-2xl font-black text-neutral-900 leading-none">
                                    <span class="text-primary-600 text-sm mr-0.5">Rp</span>{{ number_format($user->saldo_komisi ?? 0, 0, ',', '.') }}
                                </p>
                                <a href="{{ route('withdrawal.index') }}"
                                    class="text-[9px] font-black text-primary-600 uppercase tracking-widest hover:underline flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Tarik Dana
                                </a>
                            </div>

                            {{-- Progress Bar --}}
                            <div class="mt-4 pt-3 border-t border-neutral-50">
                                <div class="flex justify-between mb-1.5">
                                    <span class="text-[9px] font-bold text-neutral-500 uppercase">
                                        @if($isMax)
                                            Tier Tertinggi 🎉
                                        @else
                                            Progress {{ $nextTierLabel }}
                                        @endif
                                    </span>
                                    <span class="text-[9px] font-black text-primary-600">{{ number_format($progress, 0) }}%</span>
                                </div>
                                <div class="w-full bg-neutral-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-primary-600 h-full rounded-full transition-all duration-1000" style="width: {{ $progress }}%"></div>
                                </div>
                                @if(!$isMax)
                                    <p class="text-[9px] text-neutral-400 mt-1.5 italic">
                                        Belanja Rp {{ number_format($target - $currentSpent, 0, ',', '.') }} lagi untuk naik ke tier <span class="font-black text-primary-500">{{ $nextTierLabel }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Navigation --}}
                    <nav class="px-3 py-5 space-y-1">
                        @foreach($navs as $nav)
                        <a href="{{ $nav['url'] }}"
                           class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300
                               {{ request()->routeIs($nav['route']) ? 'bg-primary-50 text-primary-600' : 'text-neutral-500 hover:bg-neutral-50 hover:text-primary-600' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all
                                {{ request()->routeIs($nav['route']) ? 'bg-primary-600 text-white shadow-md shadow-primary-200' : 'bg-neutral-100 text-neutral-400 group-hover:bg-white group-hover:shadow-sm' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $nav['icon'] }}" />
                                </svg>
                            </div>
                            <span class="font-bold text-sm">{{ $nav['label'] }}</span>
                        </a>
                        @endforeach

                        @if(!$user->is_member)
                        <div class="pt-2 px-1">
                            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-6 h-6 bg-amber-400 rounded-lg flex items-center justify-center text-white text-[10px]">⭐</div>
                                    <p class="text-xs font-black text-amber-700">Program Member</p>
                                </div>
                                @if($hasRequested)
                                    <p class="text-[10px] text-amber-600 font-bold italic">⏳ Sedang diverifikasi...</p>
                                @else
                                    <form action="{{ route('member.request') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full block text-center py-2 bg-amber-400 hover:bg-amber-500 text-white text-xs font-black rounded-xl transition-all">
                                            Daftar Sekarang
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        @endif
                    </nav>

                    {{-- Logout --}}
                    <div class="px-4 pb-5">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-all font-bold group">
                                <div class="w-8 h-8 bg-red-50 group-hover:bg-red-500 group-hover:text-white rounded-lg flex items-center justify-center transition-all text-red-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                                <span class="text-sm">Keluar</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            {{-- ===== MAIN CONTENT ===== --}}
            <div class="flex-1 w-full min-w-0">
                @yield('member_content')
            </div>

        </div>
    </div>
</section>
@endsection