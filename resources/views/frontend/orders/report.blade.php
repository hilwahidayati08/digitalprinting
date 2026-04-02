@extends('admin.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="p-6 bg-[#f8fafc] min-h-screen">
    <div class="max-w-7xl mx-auto">

        {{-- ===== HEADER ===== --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">LAPORAN PENJUALAN</h1>
                <p class="text-slate-500 text-sm font-medium">
                    Periode: {{ $dateFrom->format('d M Y') }} — {{ $dateTo->format('d M Y') }}
                </p>
            </div>

            {{-- Export PDF --}}
            <a href="{{ route('admin.orders.report', array_merge(request()->all(), ['download_pdf' => 1])) }}" 
            class="bg-orange-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-orange-600 transition-all flex items-center gap-2">
                <i class="fas fa-file-pdf"></i> Unduh PDF
            </a>
        </div>

        {{-- ===== FILTER FORM ===== --}}
        <form action="{{ route('admin.orders.report') }}" method="GET"
              class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">

                {{-- Dari Tanggal --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Dari Tanggal</label>
                    <input type="date" name="date_from"
                           value="{{ request('date_from', $dateFrom->format('Y-m-d')) }}"
                           class="px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all">
                </div>

                {{-- Sampai Tanggal --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sampai Tanggal</label>
                    <input type="date" name="date_to"
                           value="{{ request('date_to', $dateTo->format('Y-m-d')) }}"
                           class="px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all">
                </div>

                {{-- Status --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</label>
                    <select name="status"
                            class="px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all">
                        <option value="">Semua Status</option>
                        @foreach(['pending','paid','processing','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" @selected(request('status') == $s)>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Search --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Cari</label>
                    <div class="relative">
                        <input type="text" name="search"
                               value="{{ request('search') }}"
                               placeholder="No. order / customer..."
                               class="pl-9 pr-4 py-2.5 w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 outline-none transition-all">
                        <i class="fas fa-search absolute left-3 top-3.5 text-slate-400 text-xs"></i>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest opacity-0 select-none">Aksi</label>
                    <div class="flex gap-2">
                        <button type="submit"
                                class="flex-1 bg-slate-900 hover:bg-black text-white px-4 py-2.5 rounded-xl text-sm font-black transition-all">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.orders.report') }}"
                           class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-2.5 rounded-xl text-sm font-bold transition-all">
                            Reset
                        </a>
                    </div>
                </div>

            </div>
        </form>

        {{-- ===== SUMMARY CARDS ===== --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-receipt text-orange-500"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Order</p>
                    <p class="text-2xl font-black text-slate-800">{{ number_format($summary['total_orders']) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-money-bill-wave text-emerald-500"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pendapatan</p>
                    <p class="text-sm font-black text-slate-800 font-mono">
                        Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-boxes-stacked text-blue-500"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Item</p>
                    <p class="text-2xl font-black text-slate-800">{{ number_format($summary['total_items']) }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center shrink-0">
                    <i class="fas fa-chart-line text-purple-500"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Rata-rata</p>
                    <p class="text-sm font-black text-slate-800 font-mono">
                        Rp {{ number_format($summary['avg_order'], 0, ',', '.') }}
                    </p>
                </div>
            </div>

        </div>

        {{-- ===== BREAKDOWN + TOP PRODUK ===== --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

            {{-- Breakdown Status --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Breakdown per Status</h2>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse($statusBreakdown as $st => $data)
                    @php
                        $cfg = match($st) {
                            'pending'    => ['bg-orange-50',  'text-orange-500'],
                            'paid'       => ['bg-teal-50',    'text-teal-500'],
                            'processing' => ['bg-yellow-50',  'text-yellow-600'],
                            'shipped'    => ['bg-blue-50',    'text-blue-500'],
                            'delivered'  => ['bg-emerald-50', 'text-emerald-600'],
                            'cancelled'  => ['bg-red-50',     'text-red-500'],
                            default      => ['bg-slate-100',  'text-slate-500'],
                        };
                    @endphp
                    <div class="flex items-center justify-between px-5 py-3">
                        <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-lg {{ $cfg[0] }} {{ $cfg[1] }}">
                            {{ $st }}
                        </span>
                        <div class="text-right">
                            <span class="text-xs font-black text-slate-700">{{ $data['count'] }} order</span>
                            <p class="text-[10px] text-slate-400 font-mono">
                                Rp {{ number_format($data['revenue'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="px-5 py-8 text-center text-slate-400 text-xs italic">Tidak ada data</div>
                    @endforelse
                </div>
            </div>

            {{-- Top 5 Produk --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Top 5 Produk Terlaris</h2>
                </div>
                <div class="divide-y divide-slate-50">
                    @forelse($topProducts as $i => $item)
                    <div class="flex items-center gap-4 px-5 py-3">
                        <span class="w-7 h-7 rounded-lg bg-slate-900 text-white text-[10px] font-black flex items-center justify-center shrink-0">
                            {{ $i + 1 }}
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-800 truncate">
                                {{ $item->product->product_name ?? '-' }}
                            </p>
                            <p class="text-[10px] text-slate-400 font-mono">
                                Rp {{ number_format($item->total_revenue, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="shrink-0 text-right">
                            <span class="text-xs font-black text-orange-500">{{ number_format($item->total_qty) }}</span>
                            <p class="text-[9px] text-slate-400">terjual</p>
                        </div>
                    </div>
                    @empty
                    <div class="px-5 py-8 text-center text-slate-400 text-xs italic">Tidak ada data</div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- ===== TABLE DETAIL ORDER ===== --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <h2 class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Detail Order</h2>
                <span class="bg-slate-100 text-slate-600 text-[10px] font-black px-2 py-0.5 rounded-lg font-mono">
                    {{ $orders->count() }} data
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                            <th class="px-6 py-5">No. Order</th>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Item</th>
                            <th class="px-6 py-4 text-right">Total</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($orders as $order)
                        @php
                            $badge = match($order->status) {
                                'pending'    => ['bg-orange-50',  'text-orange-500'],
                                'paid'       => ['bg-teal-50',    'text-teal-500'],
                                'processing' => ['bg-yellow-50',  'text-yellow-600'],
                                'shipped'    => ['bg-blue-50',    'text-blue-500'],
                                'delivered'  => ['bg-emerald-50', 'text-emerald-600'],
                                'cancelled'  => ['bg-red-50',     'text-red-400'],
                                default      => ['bg-slate-100',  'text-slate-500'],
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-black text-orange-500">#{{ $order->order_number }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-slate-800 block">{{ $order->user->username ?? '-' }}</span>
                                <span class="text-[10px] text-slate-400 italic">{{ $order->user->useremail ?? '' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs text-slate-600">{{ $order->created_at->format('d M Y') }}</span>
                                <span class="text-[10px] text-slate-400 block">{{ $order->created_at->format('H:i') }} WIB</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold text-slate-700">{{ $order->items->sum('qty') }} item</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-black text-slate-800 font-mono">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-lg {{ $badge[0] }} {{ $badge[1] }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center text-slate-400 font-bold italic">
                                Tidak ada order pada periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                    @if($orders->count())
                    <tfoot>
                        <tr class="bg-slate-900 text-white">
                            <td colspan="4" class="px-6 py-4 text-right text-xs font-black uppercase tracking-widest">
                                Grand Total
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-black font-mono">
                                    Rp {{ number_format($orders->sum('total_price'), 0, ',', '.') }}
                                </span>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif

                </table>
            </div>
        </div>

    </div>
</div>
@endsection