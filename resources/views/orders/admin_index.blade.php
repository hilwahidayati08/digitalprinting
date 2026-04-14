@extends('admin.admin')

@section('title', 'Manajemen Pesanan Masuk')

@section('content')
    <div class="max-full">
        {{-- 1. HEADER & SEARCH --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Pesanan Masuk</h2>
                <p class="text-sm text-gray-500">Total {{ $orders->total() }} pesanan terdaftar dalam sistem</p>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('admin.orders.index') }}" method="GET" class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all text-sm w-64 shadow-sm"
                        placeholder="No. Order / Nama...">
                </form>

                <a href="{{ route('orders.create') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white rounded-xl shadow-lg shadow-orange-200 transition-all font-bold text-sm">
                    <i class="fas fa-plus mr-2"></i> Baru
                </a>

                <button type="submit"
                    class="inline-flex items-center px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl shadow-lg transition-all font-bold text-sm">
                    Filter
                </button>
            </div>
        </div>

        {{-- 2. STATS CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Pesanan</p>
                <p class="text-2xl font-black text-gray-900">{{ $orders->total() }} <span class="text-xs font-bold text-gray-400">Order</span></p>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 [border-left:4px_solid_#f59e0b]">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Menunggu Bayar</p>
                <p class="text-2xl font-black text-amber-600">{{ $orders->where('status', 'pending')->count() }}</p>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 [border-left:4px_solid_#3b82f6]">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Sedang Diproses</p>
                <p class="text-2xl font-black text-blue-600">{{ $orders->where('status', 'processing')->count() }}</p>
            </div>
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 [border-left:4px_solid_#22c55e]">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Selesai</p>
                <p class="text-2xl font-black text-green-600">{{ $orders->where('status', 'completed')->count() }}</p>
            </div>
        </div>

        {{-- 3. TABEL DATA --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-16">#</th>
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Informasi Produk</th>
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Total Pembayaran</th>
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Status Alur</th>
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50/50 transition-colors group cursor-pointer"
                                onclick="toggleDetail({{ $order->order_id }})">
                                <td class="px-6 py-4 text-center">
                                    <div id="icon-bg-{{ $order->order_id }}"
                                        class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center transition-colors group-hover:bg-orange-100 text-gray-400 group-hover:text-orange-600">
                                        <i id="icon-{{ $order->order_id }}"
                                            class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-black text-orange-600 bg-orange-50 px-2 py-0.5 rounded-md w-fit mb-1 uppercase italic border border-orange-100">
                                            {{ $order->order_number }}
                                        </span>
                                        <span class="text-sm font-black text-gray-900">{{ $order->user->username }}</span>
                                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tight mt-0.5">
                                            <i class="far fa-clock mr-1"></i> {{ $order->created_at->format('d M, H:i') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-800 leading-tight">
                                        {{ Str::limit($order->items->first()?->product->product_name, 35) }}
                                    </div>
                                    @if ($order->items->count() > 1)
                                        <span class="text-orange-600 font-black text-[9px] uppercase bg-orange-50 px-1.5 py-0.5 rounded border border-orange-100 mt-1 inline-block">
                                            +{{ $order->items->count() - 1 }} Item Lainnya
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-black text-gray-900">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </div>
                                    @if ($order->discount_member > 0)
                                        <span class="text-[9px] text-emerald-600 font-black flex items-center gap-1 uppercase tracking-tighter">
                                            <i class="fas fa-certificate"></i> Member Disc.
                                        </span>
                                    @endif
                                </td>

                                {{-- ─── STATUS ALUR ──────────────────────────────────── --}}
                                <td class="px-6 py-4" onclick="event.stopPropagation()">
                                    @php
                                        $hasMissingFiles = $order->items->contains(
                                            fn($item) => empty($item->design_file) && empty($item->design_link),
                                        );

                                        $nextStatuses = $order->next_statuses;
                                        $nextStatus   = $nextStatuses[0] ?? null;

                                        $statusMeta = [
                                            'paid' => [
                                                'label' => 'Konfirmasi Bayar',
                                                'btn'   => 'bg-amber-500 shadow-amber-100',
                                                'icon'  => 'fa-wallet',
                                            ],
                                            'processing' => [
                                                'label' => 'Mulai Produksi',
                                                'btn'   => 'bg-emerald-500 shadow-emerald-100',
                                                'icon'  => 'fa-hammer',
                                            ],
                                            'ready_pickup' => [
                                                'label' => 'Siap Diambil',
                                                'btn'   => 'bg-teal-500 shadow-teal-100',
                                                'icon'  => 'fa-store',
                                            ],
                                            'shipped' => [
                                                'label' => 'Kirim Pesanan',
                                                'btn'   => 'bg-blue-500 shadow-blue-100',
                                                'icon'  => 'fa-truck-fast',
                                            ],
                                            'completed' => [
                                                'label' => 'Selesaikan',
                                                'btn'   => 'bg-green-500 shadow-green-100',
                                                'icon'  => 'fa-check-circle',
                                            ],
                                            'cancelled' => [
                                                'label' => 'Batalkan',
                                                'btn'   => 'bg-red-500 shadow-red-100',
                                                'icon'  => 'fa-times',
                                            ],
                                        ];

                                        $current = $nextStatus ? $statusMeta[$nextStatus] ?? null : null;
                                    @endphp

                                    <div class="flex items-center gap-2">

                                        @if($order->status === 'cancelled')
                                            <span class="inline-flex items-center px-3 py-1 text-[9px] font-black uppercase bg-red-50 text-red-400 rounded-lg border border-red-100">
                                                Dibatalkan
                                            </span>

                                        @elseif($order->status === 'completed')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[9px] font-black uppercase bg-green-50 text-green-600 rounded-lg border border-green-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                Selesai
                                            </span>

                                        @elseif($order->status === 'delivered')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[9px] font-black uppercase bg-indigo-50 text-indigo-600 rounded-lg border border-indigo-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
                                                Menunggu Konfirmasi User
                                            </span>

                                        @elseif($order->status === 'pending' && $order->payment_method === 'midtrans')
                                            {{-- Order midtrans yang belum dibayar: tampilkan tombol buka Snap --}}
                                            <button
                                                onclick="retryMidtrans('{{ $order->order_number }}', '{{ $order->order_id }}')"
                                                class="bg-blue-500 text-white px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-wider shadow-lg shadow-blue-100 transition-all hover:scale-105 flex items-center gap-1.5">
                                                <i class="fas fa-qrcode"></i> Bayar Midtrans
                                            </button>

                                        @elseif($order->status === 'pending' && $order->payment_method === 'cash')
                                            {{-- Seharusnya tidak terjadi karena cash langsung processing, tapi jaga-jaga --}}
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[9px] font-black uppercase bg-amber-50 text-amber-600 rounded-lg border border-amber-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                Menunggu Bayar
                                            </span>

                                        @elseif($current)
                                            @if (in_array($order->status, ['paid', 'processing']) && $hasMissingFiles && $nextStatus === 'processing')
                                                <div class="bg-gray-100 text-gray-400 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase border border-gray-200 flex items-center gap-1.5">
                                                    <i class="fas fa-lock"></i> File Kosong
                                                </div>
                                            @else
                                                <button
                                                    onclick="confirmStatusUpdate('{{ $order->order_id }}', '{{ $nextStatus }}', '{{ route('admin.orders.updateStatus', $order->order_id) }}')"
                                                    class="{{ $current['btn'] }} text-white px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-wider shadow-lg transition-all hover:scale-105 flex items-center gap-1.5">
                                                    <i class="fas {{ $current['icon'] }}"></i> {{ $current['label'] }}
                                                </button>
                                            @endif

                                        @else
                                            <span class="inline-flex items-center px-3 py-1 text-[9px] font-black uppercase bg-gray-50 text-gray-400 rounded-lg border border-gray-100">
                                                {{ $order->status }}
                                            </span>
                                        @endif

                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center" onclick="event.stopPropagation()">
                                    <a href="{{ route('orders.invoice', $order->order_number) }}" target="_blank"
                                        title="Download Invoice"
                                        class="w-8 h-8 inline-flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm">
                                        <i class="fas fa-file-invoice text-xs"></i>
                                    </a>

                                    @if (in_array($order->status, ['shipped', 'completed']) && $order->shipping_method === 'ekspedisi')
                                        <a href="{{ route('orders.resi', $order->order_number) }}" target="_blank"
                                            title="Download Resi"
                                            class="w-8 h-8 inline-flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-green-50 hover:text-green-600 hover:border-green-200 transition-all shadow-sm ml-1">
                                            <i class="fas fa-truck text-xs"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>

                            {{-- Row Detail --}}
                            <tr id="detail-{{ $order->order_id }}" class="hidden">
                                <td colspan="6" class="px-6 py-4 bg-gray-50/30">
                                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 animate-fadeIn">
                                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                            {{-- Kolom 1: Pengiriman --}}
                                            <div>
                                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                                                    <i class="fas fa-map-marker-alt text-orange-500"></i> Pengiriman
                                                </h4>
                                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                                    <p class="text-xs font-black text-gray-800">
                                                        {{ $order->user->full_name ?? $order->user->username }}
                                                    </p>
                                                    <p class="text-[11px] text-gray-500 mb-2">
                                                        {{ $order->user->no_telp ?? ($order->user->useremail ?? '-') }}
                                                    </p>
                                                    <span class="text-[9px] px-2 py-0.5 rounded-md font-black uppercase {{ $order->user->role === 'guest' ? 'bg-gray-100 text-gray-500' : 'bg-emerald-50 text-emerald-600' }}">
                                                        {{ $order->user->role === 'guest' ? 'Tamu' : 'Member' }}
                                                    </span>
                                                    <div class="pt-2 border-t border-gray-200 mt-2">
                                                        <p class="text-[11px] text-gray-600 leading-relaxed italic">
                                                            {{ $order->shipping_address ?? 'Ambil di Toko (Pickup)' }}
                                                        </p>
                                                    </div>
                                                    <div class="mt-2">
                                                        <span class="text-[9px] px-2 py-0.5 rounded-md font-black uppercase bg-blue-50 text-blue-600">
                                                            {{ match($order->shipping_method) {
                                                                'pickup'    => 'Ambil di Toko',
                                                                'gojek'     => 'Gojek / Grab',
                                                                'ekspedisi' => 'Ekspedisi',
                                                                default     => $order->shipping_method
                                                            } }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Kolom 2: Items --}}
                                            <div>
                                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                                                    <i class="fas fa-box text-orange-500"></i> Item Pesanan
                                                </h4>
                                                <div class="space-y-2">
                                                    @foreach ($order->items as $item)
                                                        <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                                            <div class="flex items-center justify-between">
                                                                <div class="flex-1 min-w-0 pr-2">
                                                                    <p class="text-xs font-black text-gray-800 truncate">
                                                                        {{ $item->product->product_name }}
                                                                    </p>
                                                                    @php
                                                                        $w = $item->width_cm > 0  ? $item->width_cm  : ($item->product->default_width_cm ?? 0);
                                                                        $h = $item->height_cm > 0 ? $item->height_cm : ($item->product->default_height_cm ?? 0);
                                                                    @endphp
                                                                    <p class="text-[9px] text-orange-600 font-bold uppercase">
                                                                        @if ($w > 0 && $h > 0)
                                                                            {{ number_format($w, 2) }}x{{ number_format($h, 2) }} cm ●
                                                                        @else
                                                                            Ukuran Standar ●
                                                                        @endif
                                                                        {{ $item->qty }} {{ $item->product->unit->unit_name ?? 'pcs' }}
                                                                    </p>
                                                                    @if ($item->notes)
                                                                        <div class="mt-2 flex items-start gap-1.5 bg-amber-50 p-2 rounded-lg border border-amber-100">
                                                                            <i class="fas fa-pen-alt text-amber-500 text-[8px] mt-0.5"></i>
                                                                            <p class="text-[10px] text-amber-700 leading-relaxed italic">{{ $item->notes }}</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="flex gap-1.5 ml-2">
                                                                    @if ($item->design_file)
                                                                        <a href="{{ asset('storage/' . $item->design_file) }}" target="_blank"
                                                                            class="w-7 h-7 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all">
                                                                            <i class="fas fa-file-download text-[10px]"></i>
                                                                        </a>
                                                                    @endif
                                                                    @if ($item->design_link)
                                                                        <a href="{{ $item->design_link }}" target="_blank"
                                                                            class="w-7 h-7 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-all">
                                                                            <i class="fas fa-link text-[10px]"></i>
                                                                        </a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            {{-- Kolom 3: Billing --}}
                                            <div>
                                                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                                                    <i class="fas fa-receipt text-orange-500"></i> Ringkasan
                                                </h4>
                                                <div class="bg-slate-900 text-white p-5 rounded-2xl shadow-md">
                                                    <div class="flex justify-between text-[10px] opacity-60 mb-1">
                                                        <span>Subtotal</span>
                                                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                                                    </div>
                                                    <div class="flex justify-between text-[10px] opacity-60 mb-1">
                                                        <span>PPN 11%</span>
                                                        <span>Rp {{ number_format($order->tax, 0, ',', '.') }}</span>
                                                    </div>
                                                    @if ($order->shipping_cost > 0)
                                                        <div class="flex justify-between text-[10px] opacity-60 mb-1">
                                                            <span>Ongkir ({{ match($order->shipping_method) { 'gojek' => 'Gojek/Grab', 'ekspedisi' => 'Ekspedisi', default => '-' } }})</span>
                                                            <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                                                        </div>
                                                    @endif
                                                    @if ($order->commission_earned > 0)
                                                        <div class="flex justify-between text-[10px] text-emerald-400 mb-1">
                                                            <span>Cashback Member</span>
                                                            <span>+Rp {{ number_format($order->commission_earned, 0, ',', '.') }}</span>
                                                        </div>
                                                    @endif
                                                    <div class="mt-2 pt-2 border-t border-white/10 flex justify-between items-end">
                                                        <div>
                                                            <p class="text-[8px] uppercase opacity-50 font-black">Total Akhir</p>
                                                            <p class="text-lg font-black tracking-tight">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                                                        </div>
                                                        <i class="fas fa-check-circle text-emerald-400"></i>
                                                    </div>

                                                    @if ($order->payment_method === 'cash' && $order->cash_amount_received > 0)
                                                        <div class="mt-3 pt-3 border-t border-white/10 space-y-1">
                                                            <div class="flex justify-between text-[10px]">
                                                                <span class="opacity-50">Dibayar</span>
                                                                <span class="text-green-400 font-black">Rp {{ number_format($order->cash_amount_received, 0, ',', '.') }}</span>
                                                            </div>
                                                            <div class="flex justify-between text-[10px]">
                                                                <span class="opacity-50">Kembalian</span>
                                                                <span class="text-yellow-400 font-black">Rp {{ number_format($order->cash_change, 0, ',', '.') }}</span>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @if ($order->tracking_number)
                                                        <div class="mt-3 pt-3 border-t border-white/10">
                                                            <p class="text-[8px] uppercase opacity-50 font-black mb-1">Tracking</p>
                                                            <p class="text-[11px] font-black text-blue-400">{{ $order->kurir_name }}</p>
                                                            <p class="text-[10px] font-mono text-white/70">{{ $order->tracking_number }}</p>
                                                        </div>
                                                    @endif

                                                    {{-- Tombol Midtrans di detail (jika pending midtrans) --}}
                                                    @if ($order->status === 'pending' && $order->payment_method === 'midtrans')
                                                        <button
                                                            onclick="retryMidtrans('{{ $order->order_number }}', '{{ $order->order_id }}')"
                                                            class="mt-3 w-full py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-[10px] font-black uppercase tracking-wider transition-all flex items-center justify-center gap-2">
                                                            <i class="fas fa-qrcode"></i> Buka Pembayaran Midtrans
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <i class="fas fa-inbox text-gray-200 text-4xl mb-3"></i>
                                    <p class="text-gray-400 italic text-sm font-bold">Belum ada pesanan masuk.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @include('partials.admin.pagination', ['paginator' => $orders->withQueryString()])
        </div>
    </div>

    <style>
        .font-black { font-weight: 900; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn { animation: fadeIn 0.3s ease-out forwards; }
    </style>
@endsection

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

    <script>
        const openRows = new Set();

        function toggleDetail(orderId) {
            const row  = document.getElementById('detail-' + orderId);
            const icon = document.getElementById('icon-' + orderId);
            if (openRows.has(orderId)) {
                row.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
                openRows.delete(orderId);
            } else {
                row.classList.remove('hidden');
                icon.style.transform = 'rotate(90deg)';
                openRows.add(orderId);
            }
        }

        function confirmStatusUpdate(orderId, nextStatus, url) {
            const statusLabels = {
                'paid':         'Konfirmasi pembayaran pesanan ini?',
                'processing':   'Mulai PROSES PRODUKSI pesanan ini?',
                'ready_pickup': 'Tandai pesanan SIAP DIAMBIL?',
                'shipped':      'Input Nama Kurir / Ekspedisi:',
                'completed':    'Selesaikan pesanan ini?',
                'cancelled':    'BATALKAN pesanan ini?',
            };

            let swalConfig = {
                title:              'Konfirmasi Perubahan',
                text:               statusLabels[nextStatus],
                icon:               nextStatus === 'cancelled' ? 'error' : 'question',
                showCancelButton:   true,
                confirmButtonColor: nextStatus === 'cancelled' ? '#d33' : '#2563eb',
                cancelButtonColor:  '#64748b',
                confirmButtonText:  'Ya, Lanjut!',
                cancelButtonText:   'Kembali',
                customClass:        { popup: 'rounded-3xl' }
            };

            if (nextStatus === 'shipped') {
                swalConfig = {
                    ...swalConfig,
                    title:            'Input Pengiriman',
                    input:            'text',
                    inputPlaceholder: 'Nama Kurir (contoh: JNE, J&T, dsb)',
                    inputValidator:   (value) => { if (!value) return 'Nama kurir harus diisi!'; }
                };
            }

            Swal.fire(swalConfig).then((result) => {
                if (result.isConfirmed) {
                    const courierName = nextStatus === 'shipped' ? result.value : null;
                    Swal.showLoading();
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            status:     nextStatus,
                            kurir_name: courierName
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Berhasil!', 'Status pesanan diperbarui.', 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
                        }
                    })
                    .catch(() => Swal.fire('Error!', 'Koneksi bermasalah.', 'error'));
                }
            });
        }

        async function retryMidtrans(orderNumber, orderId) {
            if (typeof snap === 'undefined') {
                Swal.fire({
                    icon:               'error',
                    title:              'Midtrans Tidak Tersedia',
                    text:               'Library pembayaran belum dimuat. Silakan refresh halaman.',
                    confirmButtonText:  'Refresh',
                    confirmButtonColor: '#f97316'
                }).then((result) => { if (result.isConfirmed) location.reload(); });
                return;
            }

            Swal.fire({ title: 'Membuka Pembayaran...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            try {
                const res  = await fetch(`/orders/${orderNumber}/snap-token`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const data = await res.json();

                if (data.status === 'success' && data.snap_token) {
                    Swal.close();
                    snap.pay(data.snap_token, {
                        onSuccess: async function (result) {
                            // Midtrans sukses → update ke paid (webhook akan handle juga, ini fallback)
                            await fetch(`/orders/update-status/${orderId}`, {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                body: JSON.stringify({ status: 'paid' })
                            }).catch(() => {});
                            Swal.fire('Sukses!', 'Pembayaran berhasil! Menunggu konfirmasi admin.', 'success').then(() => location.reload());
                        },
                        onPending: function () {
                            Swal.fire('Pending', 'Menunggu pembayaran dikonfirmasi.', 'info').then(() => location.reload());
                        },
                        onError: function () {
                            Swal.fire('Gagal', 'Terjadi kesalahan saat pembayaran.', 'error');
                        },
                        onClose: function () {
                            Swal.fire('Ditutup', 'Pembayaran belum selesai.', 'warning');
                        }
                    });
                } else {
                    throw new Error(data.message || 'Token tidak valid');
                }
            } catch (err) {
                Swal.fire('Error', err.message, 'error');
            }
        }
    </script>
@endpush