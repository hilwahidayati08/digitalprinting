@extends('admin.admin')

@section('title', 'Laporan Penjualan - Admin Panel')

@section('content')
<div class="max-full" x-data="{ selected: 0 }">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Laporan Penjualan</h2>
            <p class="text-sm text-gray-500">Rekap penjualan, status order, dan produk terlaris</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.orders.report.pdf', request()->all()) }}"
                class="inline-flex items-center justify-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl shadow-lg shadow-red-200 transition-all font-bold text-sm gap-2">
                <i class="fas fa-file-pdf"></i>
                <span>Unduh PDF</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 animate-fade-in-down">
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl shadow-sm">
                <div class="flex-shrink-0 w-8 h-8 bg-emerald-500 text-white rounded-full flex items-center justify-center shadow-sm">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <p class="text-sm font-bold">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Filter Section --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <form action="{{ route('admin.orders.report') }}" method="GET" class="p-5">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from', $dateFrom->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to', $dateTo->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2">Status Order</label>
<select name="status"
    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm appearance-none">>
    <option value="">Semua Status</option>
    @php
        $statusLabels = [
            'pending'      => 'Menunggu Pembayaran',
            'paid'         => 'Pembayaran Dikonfirmasi',
            'processing'   => 'Sedang Diproses',
            'ready_pickup' => 'Siap Diambil',
            'shipped'      => 'Dikirim',
            'completed'    => 'Selesai',
            'cancelled'    => 'Dibatalkan',
        ];
    @endphp
    @foreach($statusLabels as $value => $label)
        <option value="{{ $value }}" @selected(request('status') == $value)>
            {{ $label }}
        </option>
    @endforeach
</select>
                </div>

                <div>
                    <label class="block text-[11px] font-black text-gray-400 uppercase tracking-wider mb-2">Cari Order</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-search text-xs"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm w-full"
                            placeholder="No. order atau pelanggan...">
                    </div>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold text-sm py-2.5 transition-all shadow-lg shadow-blue-200">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    <a href="{{ route('admin.orders.report') }}"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-bold text-sm py-2.5 text-center transition-all">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
            $cards = [
                ['icon'=>'fa-receipt',         'color'=>'blue',   'label'=>'Total Order',        'value'=> number_format($summary['total_orders'])],
                ['icon'=>'fa-money-bill-wave',  'color'=>'green',  'label'=>'Pendapatan',          'value'=> 'Rp '.number_format($summary['total_revenue'],0,',','.')],
                ['icon'=>'fa-boxes-stacked',    'color'=>'purple', 'label'=>'Total Item Terjual',  'value'=> number_format($summary['total_items'])],
                ['icon'=>'fa-chart-line',       'color'=>'orange', 'label'=>'Rata-rata Order',     'value'=> 'Rp '.number_format($summary['avg_order'],0,',','.')],
            ];
        @endphp

        @foreach($cards as $card)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-black text-gray-400 uppercase tracking-wider">{{ $card['label'] }}</p>
                    <p class="text-2xl font-black text-gray-800 mt-1">{{ $card['value'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-{{ $card['color'] }}-50 flex items-center justify-center">
                    <i class="fas {{ $card['icon'] }} text-xl text-{{ $card['color'] }}-500"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>


    {{-- Table Detail Orders --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <h3 class="text-sm font-black text-gray-700 flex items-center gap-2">
                <i class="fas fa-list-ul text-blue-500"></i>
                Detail Transaksi
                <span class="ml-2 text-[10px] bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full">{{ $orders->total() }} order</span>
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">No. Order</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Pelanggan</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Item</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-right">Total</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-32">Detail</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($orders as $order)
                    @php
                        $badge = match($order->status) {
                            'pending'    => 'bg-amber-50 text-amber-600 border-amber-100',
                            'paid'       => 'bg-teal-50 text-teal-600 border-teal-100',
                            'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                            'shipped'    => 'bg-purple-50 text-purple-600 border-purple-100',
                            'completed'  => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            'cancelled'  => 'bg-red-50 text-red-500 border-red-100',
                            default      => 'bg-gray-50 text-gray-400 border-gray-100',
                        };
                    @endphp

                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-gray-900 font-mono">{{ $order->order_number }}</div>
                            <div class="text-[10px] text-gray-400 mt-0.5">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-800">{{ $order->user->full_name ?? $order->user->username ?? '-' }}</div>
                            <div class="text-[10px] text-gray-400">{{ $order->user->useremail ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-black text-blue-600">{{ $order->items->sum('qty') }}</span>
                            <span class="text-[10px] text-gray-400"> item</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-black text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black border {{ $badge }}">
                                {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <button @click="selected = (selected === {{ $order->order_id }} ? 0 : {{ $order->order_id }})"
                                    class="inline-flex items-center gap-2 text-[11px] font-bold text-blue-600 hover:text-blue-800 transition-colors">
                                <span x-text="selected === {{ $order->order_id }} ? 'Tutup' : 'Lihat Detail'"></span>
                                <i class="fas fa-chevron-down text-[10px] transition-transform"
                                   :class="selected === {{ $order->order_id }} ? 'rotate-180' : ''"></i>
                            </button>
                        </td>
                    </tr>

                    {{-- Row Detail (Expandable) --}}
                    <tr x-show="selected === {{ $order->order_id }}"
                        x-cloak
                        x-collapse
                        class="bg-gray-50/30 border-b border-gray-100">
                        <td colspan="6" class="px-8 py-6">
                            <div class="space-y-4">
                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest flex items-center gap-2">
                                    <i class="fas fa-shopping-bag"></i>
                                    Detail Item Pesanan
                                </h4>

                                <div class="overflow-x-auto">
                                    <table class="w-full text-left text-sm">
                                        <thead class="bg-white rounded-lg">
                                            <tr class="border-b border-gray-200">
                                                <th class="px-4 py-2 text-[10px] font-black text-gray-400 uppercase">Produk</th>
                                                <th class="px-4 py-2 text-[10px] font-black text-gray-400 uppercase text-center">Qty</th>
                                                <th class="px-4 py-2 text-[10px] font-black text-gray-400 uppercase text-right">Harga</th>
                                                <th class="px-4 py-2 text-[10px] font-black text-gray-400 uppercase text-right">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @forelse($order->items as $item)
                                            <tr class="hover:bg-white/50 transition-colors">
                                                <td class="px-4 py-2">
                                                    <div class="flex items-center gap-3">
                                                        @php
                                                            $primaryImage = $item->product->images->where('is_primary', true)->first() ?? $item->product->images->first();
                                                        @endphp
                                                        @if($primaryImage)
                                                            <img src="{{ asset('storage/' . $primaryImage->photo) }}"
                                                                 class="w-10 h-10 object-cover rounded-lg border border-gray-200">
                                                        @else
                                                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center border border-dashed border-gray-300">
                                                                <i class="fas fa-image text-gray-400 text-sm"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="font-bold text-gray-800">{{ $item->product->product_name ?? 'Produk tidak tersedia' }}</div>
                                                            <div class="text-[9px] text-gray-400 font-mono">SKU: {{ $item->product->sku ?? '-' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-2 text-center">
                                                    <span class="font-bold text-gray-700">{{ number_format($item->qty) }}</span>
                                                    <span class="text-[9px] text-gray-400 block">{{ $item->product->unit->unit_name ?? 'pcs' }}</span>
                                                </td>
                                                <td class="px-4 py-2 text-right font-mono text-gray-600">
                                                    Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                                </td>
                                                <td class="px-4 py-2 text-right font-mono font-bold text-gray-800">
                                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-6 text-center text-gray-400 italic text-sm">
                                                    Tidak ada item dalam pesanan ini
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        @if($order->items->count() > 0)
                                        <tfoot class="border-t border-gray-200 bg-gray-50">
                                            <tr>
                                                <td colspan="3" class="px-4 py-2 text-right text-[10px] font-bold text-gray-600 uppercase">
                                                    Grand Total
                                                </td>
                                                <td class="px-4 py-2 text-right font-mono font-black text-blue-600">
                                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tfoot>
                                        @endif
                                    </table>
                                </div>

                                @if($order->shipping_address)
                                <div class="mt-4 pt-3 border-t border-gray-200 text-xs">
                                    <span class="text-[9px] font-bold text-gray-500 uppercase tracking-wider">Alamat Kirim:</span>
                                    <p class="text-gray-600 mt-1">{{ $order->shipping_address }}</p>
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic font-medium">
                            @if(request('search'))
                                Order "{{ request('search') }}" tidak ditemukan.
                            @else
                                Belum ada data transaksi.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

@include('partials.admin.pagination', ['paginator' => $orders->withQueryString()])

    </div>
</div>
@endsection

@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush