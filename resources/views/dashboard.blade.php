@extends('admin.admin')

@section('title', 'Dashboard - Admin Panel')
@section('page-title', 'Dashboard')

@section('content')

<div class="space-y-6">

    {{-- ═══════════════════════════════════════
         PAGE HEADER
    ═══════════════════════════════════════ --}}
    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight leading-none">Dashboard</h1>
            <p class="text-xs text-gray-400 mt-1">Selamat datang kembali — berikut ringkasan bisnis Anda hari ini.</p>
        </div>
        <div class="inline-flex items-center gap-2 bg-white border border-gray-200 rounded-xl px-4 py-2 text-xs font-semibold text-gray-500 shadow-sm">
            <i class="fas fa-calendar-alt text-blue-400"></i>
            <span id="live-date"></span>
        </div>
    </div>

    {{-- ═══════════════════════════════════════
         ALERT PILLS
    ═══════════════════════════════════════ --}}
    {{-- @if($pendingOrders > 0 || $lowStockProducts > 0 || $lowStockMaterialsCount > 0 || $pendingWithdrawals > 0 || $pendingMemberRequests > 0)
    <div class="flex flex-wrap gap-2">

        @if($lowStockMaterialsCount > 0)
        <a href="{{ route('materials.index') }}"
           class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold border border-red-200 bg-red-50 text-red-800 hover:-translate-y-0.5 hover:shadow-md transition-all">
            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
            <i class="fas fa-exclamation-triangle"></i>
            {{ $lowStockMaterialsCount }} Bahan Baku Hampir Habis
        </a>
        @endif

        @if($pendingOrders > 0)
        <a href="{{ route('admin.orders.index') }}"
           class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold border border-amber-200 bg-amber-50 text-amber-800 hover:-translate-y-0.5 hover:shadow-md transition-all">
            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
            <i class="fas fa-shopping-bag"></i>
            {{ $pendingOrders }} Pesanan Menunggu Konfirmasi
        </a>
        @endif

        @if($lowStockProducts > 0)
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold border border-red-200 bg-red-50 text-red-800 hover:-translate-y-0.5 hover:shadow-md transition-all">
            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
            <i class="fas fa-box"></i>
            {{ $lowStockProducts }} Produk Stok Menipis
        </a>
        @endif

        @if($pendingWithdrawals > 0)
        <a href="#"
           class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold border border-amber-200 bg-amber-50 text-amber-800 hover:-translate-y-0.5 hover:shadow-md transition-all">
            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
            <i class="fas fa-money-bill-wave"></i>
            {{ $pendingWithdrawals }} Withdrawal Menunggu
        </a>
        @endif

        @if($pendingMemberRequests > 0)
        <a href="{{ route('member-requests.index') }}"
           class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold border border-blue-200 bg-blue-50 text-blue-800 hover:-translate-y-0.5 hover:shadow-md transition-all">
            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
            <i class="fas fa-user-plus"></i>
            {{ $pendingMemberRequests }} Member Request Baru
        </a>
        @endif

    </div>
    @endif --}}

    {{-- ═══════════════════════════════════════
         KPI CARDS
    ═══════════════════════════════════════ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- Revenue --}}
        <div class="relative bg-gradient-to-br from-blue-50 to-white border border-gray-200 rounded-2xl p-5 overflow-hidden hover:-translate-y-1 hover:shadow-xl hover:border-blue-200 transition-all duration-200">
            <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-blue-600"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fas fa-chart-line"></i>
                </div>
                @if($revenueGrowth >= 0)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                    <i class="fas fa-arrow-up" style="font-size:8px;"></i> {{ $revenueGrowth }}%
                </span>
                @else
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                    <i class="fas fa-arrow-down" style="font-size:8px;"></i> {{ abs($revenueGrowth) }}%
                </span>
                @endif
            </div>
            <p class="text-xs font-extrabold uppercase tracking-widest text-gray-400 mb-1">Total Revenue</p>
            <p class="text-base font-black text-gray-900 font-mono leading-none mb-1">Rp {{ number_format($totalRevenue,0,',','.') }}</p>
            <p class="text-xs text-gray-400">Bulan ini: <span class="font-bold text-gray-600">Rp {{ number_format($revenueThisMonth,0,',','.') }}</span></p>
        </div>

        {{-- Orders --}}
        <div class="relative bg-gradient-to-br from-amber-50 to-white border border-gray-200 rounded-2xl p-5 overflow-hidden hover:-translate-y-1 hover:shadow-xl hover:border-amber-200 transition-all duration-200">
            <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-amber-500"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-700">
                    <i class="fas fa-calendar" style="font-size:8px;"></i> {{ $ordersThisMonth }} bln ini
                </span>
            </div>
            <p class="text-xs font-extrabold uppercase tracking-widest text-gray-400 mb-1">Total Pesanan</p>
            <p class="text-2xl font-black text-gray-900 leading-none mb-1">{{ number_format($totalOrders) }}</p>
            <p class="text-xs text-gray-400">
                <span class="font-bold text-amber-600">{{ $pendingOrders }} pending</span>
                · <span class="font-bold text-blue-600">{{ $processingOrders }} diproses</span>
            </p>
        </div>

        {{-- Users --}}
        <div class="relative bg-gradient-to-br from-purple-50 to-white border border-gray-200 rounded-2xl p-5 overflow-hidden hover:-translate-y-1 hover:shadow-xl hover:border-purple-200 transition-all duration-200">
            <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-purple-600"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                    <i class="fas fa-users"></i>
                </div>
                @if($userGrowth >= 0)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                    <i class="fas fa-arrow-up" style="font-size:8px;"></i> {{ $userGrowth }}%
                </span>
                @else
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                    <i class="fas fa-arrow-down" style="font-size:8px;"></i> {{ abs($userGrowth) }}%
                </span>
                @endif
            </div>
            <p class="text-xs font-extrabold uppercase tracking-widest text-gray-400 mb-1">Total Pengguna</p>
            <p class="text-2xl font-black text-gray-900 leading-none mb-1">{{ number_format($totalUsers) }}</p>
            <p class="text-xs text-gray-400">+{{ $newUsersThisMonth }} pengguna baru bulan ini</p>
        </div>

        {{-- Stok Bahan Baku --}}
        <div class="relative bg-gradient-to-br from-green-50 to-white border border-gray-200 rounded-2xl p-5 overflow-hidden hover:-translate-y-1 hover:shadow-xl hover:border-green-200 transition-all duration-200">
            <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl bg-green-600"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                    <i class="fas fa-layer-group"></i>
                </div>
                @if($lowStockMaterialsCount > 0)
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">
                    <i class="fas fa-exclamation-triangle" style="font-size:8px;"></i> {{ $lowStockMaterialsCount }} Kritis
                </span>
                @else
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                    <i class="fas fa-check" style="font-size:8px;"></i> Aman
                </span>
                @endif
            </div>
            <p class="text-xs font-extrabold uppercase tracking-widest text-gray-400 mb-1">Stok Bahan Baku</p>
            <p class="text-2xl font-black text-gray-900 leading-none mb-1">{{ number_format($totalMaterials) }} Jenis</p>
            <p class="text-xs text-gray-400">
                Habis: <span class="font-bold text-red-500">{{ $outOfStockProducts }}</span>
                · Menipis: <span class="font-bold text-amber-500">{{ $lowStockMaterialsCount }}</span>
            </p>
        </div>

    </div>

    {{-- ═══════════════════════════════════════
         SECTION: ANALITIK & DISTRIBUSI
    ═══════════════════════════════════════ --}}
    <div class="flex items-center gap-3">
        <div class="w-1.5 h-4 bg-blue-600 rounded-full"></div>
        <span class="text-xs font-extrabold uppercase tracking-widest text-gray-400">Analitik &amp; Distribusi</span>
        <div class="flex-1 h-px bg-gray-200"></div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        {{-- Revenue Chart --}}
        <div class="xl:col-span-2 bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-gray-900">Revenue 6 Bulan Terakhir</p>
                        <p class="text-xs text-gray-400">Pendapatan dari pesanan selesai </p>
                    </div>
                </div>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                    <i class="fas fa-circle-notch fa-spin mr-1" style="font-size:9px;"></i>Live
                </span>
            </div>
            <div class="p-5">
                @php $maxRev = collect($revenueChart)->max('revenue') ?: 1; @endphp
                <div class="flex justify-between mb-3 px-0.5">
                    <span class="text-xs text-gray-300 font-semibold">Rp {{ number_format($maxRev/1000000,1) }}jt</span>
                    <span class="text-xs text-gray-300 font-semibold">0</span>
                </div>
                <div class="flex items-end gap-2" style="height:160px;">
                    @foreach($revenueChart as $rc)
                    <div class="flex-1 flex flex-col items-center gap-1.5 h-full justify-end group">
                        <div class="relative w-full flex justify-center items-end"
                             style="height:{{ max(6, ($rc['revenue']/$maxRev)*130) }}px">
                            <div class="w-full max-w-[40px] rounded-t-lg
                                        bg-gradient-to-b from-blue-400 to-blue-600
                                        group-hover:from-blue-300 group-hover:to-blue-500
                                        transition-all cursor-pointer h-full">
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-1.5
                                            bg-gray-900 text-white text-xs font-bold
                                            px-2 py-1 rounded-lg whitespace-nowrap
                                            opacity-0 group-hover:opacity-100 transition-opacity
                                            pointer-events-none z-10">
                                    Rp {{ number_format($rc['revenue'],0,',','.') }}
                                    <br><span class="text-gray-400 font-normal">{{ $rc['orders'] }} pesanan</span>
                                </div>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-gray-400">{{ \Illuminate\Support\Str::substr($rc['month'],0,3) }}</span>
                        <span class="text-xs text-gray-300">{{ $rc['orders'] }}x</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Status Pesanan --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div>
                    <p class="text-sm font-extrabold text-gray-900">Status Pesanan</p>
                    <p class="text-xs text-gray-400">Distribusi semua pesanan</p>
                </div>
            </div>
            <div class="p-5 space-y-3">
                @php $tot = max(1, $totalOrders); @endphp

                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1.5 w-24 shrink-0">
                        <i class="fas fa-check-circle text-green-500" style="font-size:10px;"></i>
                        <span class="text-xs font-bold text-gray-600">Selesai</span>
                    </div>
                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full transition-all duration-700"
                             style="width:{{ round(($completedOrders/$tot)*100) }}%"></div>
                    </div>
                    <span class="text-xs font-black text-gray-900 w-6 text-right shrink-0">{{ $completedOrders }}</span>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1.5 w-24 shrink-0">
                        <i class="fas fa-cog text-blue-500" style="font-size:10px;"></i>
                        <span class="text-xs font-bold text-gray-600">Diproses</span>
                    </div>
                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full transition-all duration-700"
                             style="width:{{ round(($processingOrders/$tot)*100) }}%"></div>
                    </div>
                    <span class="text-xs font-black text-gray-900 w-6 text-right shrink-0">{{ $processingOrders }}</span>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1.5 w-24 shrink-0">
                        <i class="fas fa-clock text-amber-400" style="font-size:10px;"></i>
                        <span class="text-xs font-bold text-gray-600">Pending</span>
                    </div>
                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-400 rounded-full transition-all duration-700"
                             style="width:{{ round(($pendingOrders/$tot)*100) }}%"></div>
                    </div>
                    <span class="text-xs font-black text-gray-900 w-6 text-right shrink-0">{{ $pendingOrders }}</span>
                </div>

                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-1.5 w-24 shrink-0">
                        <i class="fas fa-times-circle text-red-400" style="font-size:10px;"></i>
                        <span class="text-xs font-bold text-gray-600">Dibatalkan</span>
                    </div>
                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-red-400 rounded-full transition-all duration-700"
                             style="width:{{ round(($cancelledOrders/$tot)*100) }}%"></div>
                    </div>
                    <span class="text-xs font-black text-gray-900 w-6 text-right shrink-0">{{ $cancelledOrders }}</span>
                </div>

                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                    <span class="text-xs text-gray-400 font-semibold">
                        <i class="fas fa-list-ol mr-1"></i>Total Pesanan
                    </span>
                    <span class="text-xl font-black text-gray-900">{{ number_format($totalOrders) }}</span>
                </div>

                <div class="flex items-center justify-between bg-green-50 border border-green-200 rounded-xl px-4 py-2.5">
                    <span class="text-xs font-bold text-green-700">
                        <i class="fas fa-percentage mr-1"></i>Completion Rate
                    </span>
                    <span class="text-base font-black text-green-600">
                        {{ $totalOrders > 0 ? round(($completedOrders/$tot)*100) : 0 }}%
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════
         SECTION: TRANSAKSI & PRODUK
    ═══════════════════════════════════════ --}}
    <div class="flex items-center gap-3">
        <div class="w-1.5 h-4 bg-green-500 rounded-full"></div>
        <span class="text-xs font-extrabold uppercase tracking-widest text-gray-400">Transaksi &amp; Produk</span>
        <div class="flex-1 h-px bg-gray-200"></div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        {{-- Tabel Pesanan Terbaru --}}
        <div class="xl:col-span-2 bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-gray-900">Pesanan Terbaru</p>
                        <p class="text-xs text-gray-400">Transaksi paling baru</p>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index') }}"
                   class="text-xs font-bold text-blue-600 px-3 py-1.5 bg-blue-50 rounded-full hover:bg-blue-100 transition-colors whitespace-nowrap">
                    <i class="fas fa-arrow-right mr-1"></i>Lihat semua
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-4 py-3 text-left text-xs font-extrabold uppercase tracking-wider text-gray-400">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-extrabold uppercase tracking-wider text-gray-400">Pelanggan</th>
                            <th class="px-4 py-3 text-left text-xs font-extrabold uppercase tracking-wider text-gray-400">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-extrabold uppercase tracking-wider text-gray-400">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-extrabold uppercase tracking-wider text-gray-400">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition-colors border-b border-gray-50">
                            <td class="px-4 py-3">
                                <span class="font-mono text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-md">#{{ $order->order_id }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white text-xs font-black shrink-0">
                                        {{ strtoupper(substr(optional($order->user)->username ?? 'G', 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">{{ optional($order->user)->username ?? 'Guest' }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="font-mono text-sm font-bold text-gray-900">Rp {{ number_format($order->total,0,',','.') }}</span>
                            </td>
                            <td class="px-4 py-3">
                                @if($order->status === 'completed')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                        <i class="fas fa-check" style="font-size:8px;"></i> Selesai
                                    </span>
                                @elseif($order->status === 'processing')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                        <i class="fas fa-circle-notch fa-spin" style="font-size:8px;"></i> Diproses
                                    </span>
                                @elseif($order->status === 'pending')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="fas fa-clock" style="font-size:8px;"></i> Pending
                                    </span>
                                @elseif($order->status === 'cancelled')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                        <i class="fas fa-times" style="font-size:8px;"></i> Batal
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-gray-50 text-gray-600 border border-gray-200">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-xs text-gray-400">
                                    <i class="far fa-calendar mr-1"></i>{{ $order->created_at->format('d M Y') }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-14 text-gray-400">
                                <i class="fas fa-inbox text-3xl block mb-3 text-gray-300"></i>
                                <p class="text-sm font-semibold">Belum ada pesanan</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Products --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-gray-900">Produk Terlaris</p>
                        <p class="text-xs text-gray-400">Top 5 paling banyak terjual</p>
                    </div>
                </div>
                <a href="{{ route('products.index') }}"
                   class="text-xs font-bold text-blue-600 px-3 py-1.5 bg-blue-50 rounded-full hover:bg-blue-100 transition-colors">
                    <i class="fas fa-arrow-right mr-1"></i>Lihat
                </a>
            </div>
            <div class="p-5 space-y-4">
                @php $maxSold = $topProducts->max('total_sold') ?: 1; @endphp
                @forelse($topProducts as $i => $tp)
                <div class="flex items-center gap-3">
                    @if($i === 0)
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs font-black shrink-0 bg-yellow-100 text-yellow-700 border border-yellow-200">
                        <i class="fas fa-trophy" style="font-size:10px;"></i>
                    </div>
                    @elseif($i === 1)
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs font-black shrink-0 bg-slate-100 text-slate-600 border border-slate-200">
                        <i class="fas fa-medal" style="font-size:10px;"></i>
                    </div>
                    @elseif($i === 2)
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs font-black shrink-0 bg-orange-100 text-orange-600 border border-orange-200">
                        <i class="fas fa-medal" style="font-size:10px;"></i>
                    </div>
                    @else
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center text-xs font-black shrink-0 bg-gray-100 text-gray-500 border border-gray-200">
                        {{ $i+1 }}
                    </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-gray-900 truncate">{{ optional($tp->product)->product_name ?? '-' }}</p>
                        <div class="mt-1.5 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full rounded-full bg-gradient-to-r from-purple-400 to-purple-600 transition-all duration-700"
                                 style="width:{{ ($tp->total_sold/$maxSold)*100 }}%"></div>
                        </div>
                    </div>
                    <span class="font-mono text-xs font-bold text-gray-600 shrink-0 bg-gray-100 px-2 py-0.5 rounded-md">{{ $tp->total_sold }}</span>
                </div>
                @empty
                <div class="text-center py-10 text-gray-400">
                    <i class="fas fa-box-open text-3xl block mb-3 text-gray-300"></i>
                    <p class="text-sm font-semibold">Belum ada data penjualan</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════
         SECTION: KEUANGAN, ULASAN & DATA
    ═══════════════════════════════════════ --}}
    <div class="flex items-center gap-3">
        <div class="w-1.5 h-4 bg-purple-500 rounded-full"></div>
        <span class="text-xs font-extrabold uppercase tracking-widest text-gray-400">Keuangan, Ulasan &amp; Data</span>
        <div class="flex-1 h-px bg-gray-200"></div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        {{-- Keuangan & Saldo --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div>
                        <p class="text-sm font-extrabold text-gray-900">Keuangan &amp; Saldo</p>
                        <p class="text-xs text-gray-400">Arus kas &amp; penarikan</p>
                    </div>
                </div>
                <a href="#" class="text-xs font-bold text-blue-600 px-3 py-1.5 bg-blue-50 rounded-full hover:bg-blue-100 transition-colors">
                    <i class="fas fa-cog mr-1"></i>Kelola
                </a>
            </div>
            <div class="p-5 space-y-3">

                {{-- Saldo Masuk --}}
                <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-arrow-down text-green-600" style="font-size:11px;"></i>
                        <p class="text-xs font-extrabold uppercase tracking-wider text-green-700">Saldo Masuk</p>
                    </div>
                    <p class="font-mono text-xl font-black text-green-800">Rp {{ number_format($totalSaldoIn/1000000,1) }}jt</p>
                    <p class="text-xs text-green-600 mt-0.5">Total dana yang masuk ke sistem</p>
                </div>

                {{-- Saldo Keluar --}}
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-arrow-up text-red-500" style="font-size:11px;"></i>
                        <p class="text-xs font-extrabold uppercase tracking-wider text-red-700">Saldo Keluar</p>
                    </div>
                    <p class="font-mono text-xl font-black text-red-800">Rp {{ number_format($totalSaldoOut/1000000,1) }}jt</p>
                    <p class="text-xs text-red-500 mt-0.5">Total dana yang keluar dari sistem</p>
                </div>

                {{-- Withdrawal Disetujui --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fas fa-money-bill-wave text-blue-600" style="font-size:11px;"></i>
                        <p class="text-xs font-extrabold uppercase tracking-wider text-blue-700">Withdrawal Disetujui</p>
                    </div>
                    <p class="font-mono text-xl font-black text-blue-800">Rp {{ number_format($totalWithdrawals,0,',','.') }}</p>
                    <p class="text-xs text-blue-500 mt-0.5">Total penarikan yang diapprove</p>
                </div>

                {{-- Warning jika ada pending --}}
                @if($pendingWithdrawals > 0)
                <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 rounded-xl px-4 py-3">
                    <i class="fas fa-exclamation-triangle text-amber-500 mt-0.5"></i>
                    <div>
                        <p class="text-xs font-bold text-amber-800">{{ $pendingWithdrawals }} withdrawal menunggu persetujuan</p>
                        <p class="text-xs text-amber-600 mt-0.5">Segera tinjau permintaan ini</p>
                    </div>
                </div>
                @else
                <div class="flex items-center gap-3 bg-gray-50 border border-gray-100 rounded-xl px-4 py-3">
                    <i class="fas fa-check-circle text-gray-300"></i>
                    <p class="text-xs font-semibold text-gray-400">Tidak ada withdrawal pending</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Rating & Ulasan --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-500 flex items-center justify-center">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <p class="text-sm font-extrabold text-gray-900">Rating &amp; Ulasan</p>
                    <p class="text-xs text-gray-400">Kepuasan pelanggan</p>
                </div>
            </div>
            <div class="p-5">

                {{-- Big Score --}}
                <div class="flex flex-col items-center justify-center pb-5 mb-5 border-b border-gray-100">
                    <div class="text-6xl font-black text-gray-900 leading-none tracking-tighter">{{ number_format($avgRating,1) }}</div>
                    <div class="flex gap-0.5 justify-center mt-2 mb-1">
                        @for($s=1; $s<=5; $s++)
                        <span class="text-2xl {{ $s <= round($avgRating) ? 'text-amber-400' : 'text-gray-200' }}">★</span>
                        @endfor
                    </div>
                    <div class="text-xs text-gray-400 font-semibold">
                        <i class="far fa-comment-dots mr-1"></i>{{ number_format($totalRatings) }} ulasan pelanggan
                    </div>
                </div>

                {{-- Breakdown per bintang --}}
                <div class="space-y-2">
                    @for($r=5; $r>=1; $r--)
                    @php
                        $cnt = \App\Models\Ratings::where('rating',$r)->count();
                        $pct = $totalRatings > 0 ? ($cnt/$totalRatings)*100 : 0;
                    @endphp
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-0.5 w-16 shrink-0">
                            @for($si=1; $si<=$r; $si++)
                            <span class="text-amber-400" style="font-size:9px;">★</span>
                            @endfor
                        </div>
                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-amber-300 to-amber-500 rounded-full"
                                 style="width:{{ $pct }}%"></div>
                        </div>
                        <span class="text-xs font-bold text-gray-500 w-5 text-right shrink-0">{{ $cnt }}</span>
                    </div>
                    @endfor
                </div>

                {{-- Summary tiles --}}
                <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-2 gap-2">
                    <div class="text-center bg-amber-50 rounded-xl p-3">
                        <p class="text-xl font-black text-amber-600">{{ number_format($avgRating,1) }}</p>
                        <p class="text-xs text-amber-500 font-semibold">Rata-rata</p>
                    </div>
                    <div class="text-center bg-gray-50 rounded-xl p-3">
                        <p class="text-xl font-black text-gray-700">{{ $totalRatings }}</p>
                        <p class="text-xs text-gray-400 font-semibold">Total Ulasan</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ringkasan Data --}}
        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100">
                <div class="w-9 h-9 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                    <i class="fas fa-th-large"></i>
                </div>
                <div>
                    <p class="text-sm font-extrabold text-gray-900">Ringkasan Data</p>
                    <p class="text-xs text-gray-400">Jumlah keseluruhan entitas</p>
                </div>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-3 gap-2">

                    <a href="{{ route('categories.index') }}"
                       class="flex flex-col items-center text-center p-3 rounded-xl bg-blue-50 border border-blue-100 hover:-translate-y-0.5 hover:shadow-md transition-all">
                        <i class="fas fa-tags text-blue-500 text-lg mb-1.5"></i>
                        <span class="text-2xl font-black text-blue-700 leading-none">{{ $totalCategories }}</span>
                        <span class="text-xs font-bold text-blue-400 mt-0.5">Kategori</span>
                    </a>

                    <a href="{{ route('services.index') }}"
                       class="flex flex-col items-center text-center p-3 rounded-xl bg-purple-50 border border-purple-100 hover:-translate-y-0.5 hover:shadow-md transition-all">
                        <i class="fas fa-concierge-bell text-purple-500 text-lg mb-1.5"></i>
                        <span class="text-2xl font-black text-purple-700 leading-none">{{ $totalServices }}</span>
                        <span class="text-xs font-bold text-purple-400 mt-0.5">Layanan</span>
                    </a>

                    <a href="{{ route('portofolios.index') }}"
                       class="flex flex-col items-center text-center p-3 rounded-xl bg-fuchsia-50 border border-fuchsia-100 hover:-translate-y-0.5 hover:shadow-md transition-all">
                        <i class="fas fa-images text-fuchsia-500 text-lg mb-1.5"></i>
                        <span class="text-2xl font-black text-fuchsia-700 leading-none">{{ $totalPortofolios }}</span>
                        <span class="text-xs font-bold text-fuchsia-400 mt-0.5">Portfolio</span>
                    </a>

                    <div class="flex flex-col items-center text-center p-3 rounded-xl bg-green-50 border border-green-100">
                        <i class="fas fa-check-circle text-green-500 text-lg mb-1.5"></i>
                        <span class="text-2xl font-black text-green-700 leading-none">{{ $completedOrders }}</span>
                        <span class="text-xs font-bold text-green-400 mt-0.5">Selesai</span>
                    </div>

                    <a href="{{ route('member-requests.index') }}"
                       class="flex flex-col items-center text-center p-3 rounded-xl bg-amber-50 border border-amber-100 hover:-translate-y-0.5 hover:shadow-md transition-all">
                        <i class="fas fa-user-clock text-amber-500 text-lg mb-1.5"></i>
                        <span class="text-2xl font-black text-amber-700 leading-none">{{ $pendingMemberRequests }}</span>
                        <span class="text-xs font-bold text-amber-400 mt-0.5">Req. Member</span>
                    </a>

                    <a href="{{ route('materials.index') }}"
                       class="flex flex-col items-center text-center p-3 rounded-xl bg-red-50 border border-red-100 hover:-translate-y-0.5 hover:shadow-md transition-all">
                        <i class="fas fa-box-open text-red-400 text-lg mb-1.5"></i>
                        <span class="text-2xl font-black text-red-700 leading-none">{{ $outOfStockProducts }}</span>
                        <span class="text-xs font-bold text-red-400 mt-0.5">Stok Habis</span>
                    </a>

                </div>

                {{-- Daftar bahan kritis dari $lowStockItems --}}
                @if(isset($lowStockItems) && $lowStockItems->count() > 0)
                <div class="mt-3 bg-red-50 border border-red-200 rounded-xl p-3">
                    <p class="text-xs font-extrabold text-red-700 mb-2 flex items-center gap-1.5">
                        <i class="fas fa-exclamation-circle"></i>
                        Bahan Kritis ({{ $lowStockItems->count() }} item)
                    </p>
                    <div class="space-y-1.5 max-h-28 overflow-y-auto pr-1">
                        @foreach($lowStockItems as $item)
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-red-700 font-semibold truncate max-w-[120px]">
                                <i class="fas fa-circle" style="font-size:5px;"></i>
                                {{ $item->material_name }}
                            </span>
                            <span class="text-xs font-black text-red-600 ml-2 shrink-0 bg-red-100 px-2 py-0.5 rounded-md">
                                Sisa {{ $item->stock }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
(function(){
    const d = new Date();
    const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
    const el = document.getElementById('live-date');
    if (el) el.textContent = days[d.getDay()] + ', ' + d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
})();
</script>
@endpush

@endsection 