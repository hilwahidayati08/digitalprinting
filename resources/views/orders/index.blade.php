@extends('admin.member')

@section('member_content')
<div class="max-w-5xl mx-auto px-4 mb-8">
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-neutral-100 overflow-hidden">

        {{-- Header --}}
        <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-8 py-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-receipt text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-white text-xl font-black italic uppercase tracking-tight leading-none">Riwayat Pesanan</h2>
                    <p class="text-white/70 text-[11px] mt-2 font-medium italic">Pantau status produksi dan desain Anda</p>
                </div>
            </div>
        </div>

        <div class="p-6 lg:p-8 space-y-6">

            @if(session('success') || request('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    {{ session('success') ?? request('success') }}
                </div>
            @endif

            {{-- FILTER --}}
            <div class="space-y-4">
                <div class="flex items-center gap-2 border-b border-neutral-50 pb-2">
                    <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                    <h3 class="text-[11px] font-black text-neutral-800 uppercase tracking-widest">Filter Pesanan</h3>
                </div>

                <form method="GET" action="{{ route('orders.index') }}" id="filterForm" class="space-y-4">
                    <div class="flex flex-col lg:flex-row gap-3 items-end">
                        <div class="relative flex-1 w-full">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400 text-[10px]"></i>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nomor pesanan..."
                                class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl text-[11px] font-bold text-neutral-700 outline-none focus:border-primary-600 focus:bg-white transition-all">
                        </div>
                        <div class="flex items-center gap-2 bg-neutral-50 border border-neutral-100 rounded-xl px-4 py-3 text-[11px] font-bold text-neutral-600 w-full lg:w-auto">
                            <i class="fas fa-calendar text-neutral-400 text-[10px]"></i>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="bg-transparent outline-none text-[11px]">
                            <span class="text-neutral-300">/</span>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="bg-transparent outline-none text-[11px]">
                        </div>
                        @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                            <a href="{{ route('orders.index') }}" class="text-[10px] font-black text-red-400 uppercase tracking-widest hover:text-red-600 flex items-center gap-1.5 pb-3">
                                <i class="fas fa-times-circle"></i> Reset
                            </a>
                        @endif
                    </div>

                    {{-- Status Chips --}}
                    @php
                        $statuses = [
                            ''           => 'Semua',
                            'pending'    => 'Pending',
                            'processing' => 'Proses',
                            'ready_pickup' => 'Siap Diambil',
                            'shipped'    => 'Dikirim',
                            'completed'  => 'Selesai',
                            'cancelled'  => 'Batal',
                        ];
                        $activeStatus = request('status', '');
                    @endphp
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-[9px] font-black text-neutral-400 uppercase tracking-[0.15em] mr-1">Status:</span>
                        @foreach($statuses as $value => $label)
                            <button type="button" onclick="setStatus('{{ $value }}')"
                                @class([
                                    'px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-tighter transition-all border',
                                    'bg-primary-600 border-primary-600 text-white shadow-md shadow-primary-600/20' => $activeStatus === $value,
                                    'bg-neutral-50 border-neutral-100 text-neutral-500 hover:border-neutral-300'   => $activeStatus !== $value,
                                ])>{{ $label }}</button>
                        @endforeach
                        <input type="hidden" name="status" id="statusInput" value="{{ $activeStatus }}">
                    </div>
                </form>
            </div>

            {{-- ORDER LIST --}}
            <div class="space-y-3">
                <div class="flex items-center justify-between border-b border-neutral-50 pb-2">
                    <div class="flex items-center gap-2">
                        <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                        <h3 class="text-[11px] font-black text-neutral-800 uppercase tracking-widest">Daftar Pesanan</h3>
                    </div>
                    <div class="text-[9px] text-neutral-400">
                        Total: <span class="font-black text-primary-600">{{ $orders->total() }}</span> pesanan
                    </div>
                </div>

                @forelse($orders as $order)
                @php
                    $expiredAt = $order->created_at->addHours(24);
                    $sisaDetik = max(0, now()->diffInSeconds($expiredAt, false));
                    $isExpired = $sisaDetik <= 0;

                    $firstItem  = $order->items->first();
                    $firstImage = $firstItem?->product?->images?->where('is_primary', true)->first()
                               ?? $firstItem?->product?->images?->first();
                @endphp

                <a href="{{ route('orders.show', $order->order_number) }}"
                    @class([
                        'flex items-center gap-4 p-4 rounded-2xl border border-neutral-100 hover:border-primary-200 hover:bg-primary-50/30 transition-all group',
                        'opacity-60' => $order->status === 'cancelled',
                    ])>

                    <div class="flex-shrink-0 w-12 h-12 rounded-xl overflow-hidden bg-neutral-100">
                        <img src="{{ $firstImage ? asset('storage/' . $firstImage->photo) : 'https://placehold.co/48x48' }}"
                            class="w-full h-full object-cover">
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <p class="font-black text-neutral-900 text-[12px]">#{{ $order->order_number }}</p>
                            @if($order->items->count() > 1)
                                <span class="text-[9px] text-neutral-400 font-bold">+{{ $order->items->count() - 1 }} produk lain</span>
                            @endif
                        </div>
                        <p class="text-[10px] text-neutral-400 font-bold truncate">
                            {{ $firstItem?->product?->product_name }}
                        </p>
                        <p class="text-[10px] text-neutral-400 mt-0.5">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <div class="flex-shrink-0 text-right space-y-1.5">
                        <p class="font-black text-primary-600 text-[12px]">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        <span class="inline-block px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border {{ $statusClass[$order->status] ?? 'bg-gray-50 text-gray-400 border-gray-100' }}">
                            {{ $statusLabel[$order->status] ?? $order->status }}
                        </span>

                        @if($order->status === 'pending' && $order->payment_method === 'midtrans' && !$isExpired)
                            <p class="text-[9px] text-red-400 font-bold countdown-timer" data-seconds="{{ $sisaDetik }}">--:--:--</p>
                        @endif
                    </div>

                    <div class="flex-shrink-0 text-neutral-300 group-hover:text-primary-400 transition-all group-hover:translate-x-1">
                        <i class="fas fa-chevron-right text-[11px]"></i>
                    </div>

                </a>
                @empty
                    <div class="text-center py-16 border-2 border-dashed border-neutral-100 rounded-2xl">
                        <i class="fas fa-box-open text-neutral-300 text-3xl mb-3 block"></i>
                        <p class="text-[10px] text-neutral-400 font-black uppercase tracking-widest">Belum ada pesanan</p>
                        <a href="{{ route('products.index') }}"
                            class="mt-4 inline-block px-6 py-2.5 bg-primary-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-primary-700 transition-all">
                            Mulai Belanja
                        </a>
                    </div>
                @endforelse

                {{-- PAGINATION --}}
                @if($orders->hasPages())
                    <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                        <p class="text-[10px] text-neutral-400 font-bold">
                            Menampilkan <span class="text-neutral-700">{{ $orders->firstItem() }}–{{ $orders->lastItem() }}</span>
                            dari <span class="text-primary-600 font-black">{{ $orders->total() }}</span> pesanan
                        </p>
                        <div class="flex items-center gap-1">
                            @if($orders->onFirstPage())
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-neutral-50 text-neutral-300 cursor-not-allowed">
                                    <i class="fas fa-chevron-left text-[9px]"></i>
                                </span>
                            @else
                                <a href="{{ $orders->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-neutral-50 hover:bg-primary-50 text-neutral-500 hover:text-primary-600 border border-neutral-100 transition-all">
                                    <i class="fas fa-chevron-left text-[9px]"></i>
                                </a>
                            @endif

                            @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                @if($page == $orders->currentPage())
                                    <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary-600 text-white text-[10px] font-black">{{ $page }}</span>
                                @elseif(abs($page - $orders->currentPage()) <= 2 || $page == 1 || $page == $orders->lastPage())
                                    <a href="{{ $url }}&{{ http_build_query(request()->except('page')) }}"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-neutral-50 hover:bg-primary-50 text-neutral-500 hover:text-primary-600 border border-neutral-100 text-[10px] font-bold transition-all">
                                        {{ $page }}
                                    </a>
                                @elseif(abs($page - $orders->currentPage()) == 3)
                                    <span class="text-neutral-300 text-[10px] px-1">…</span>
                                @endif
                            @endforeach

                            @if($orders->hasMorePages())
                                <a href="{{ $orders->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-neutral-50 hover:bg-primary-50 text-neutral-500 hover:text-primary-600 border border-neutral-100 transition-all">
                                    <i class="fas fa-chevron-right text-[9px]"></i>
                                </a>
                            @else
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-neutral-50 text-neutral-300 cursor-not-allowed">
                                    <i class="fas fa-chevron-right text-[9px]"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function setStatus(value) {
        document.getElementById('statusInput').value = value;
        document.getElementById('filterForm').submit();
    }

    document.querySelectorAll('.countdown-timer').forEach(el => {
        let sisa = parseInt(el.dataset.seconds);
        const interval = setInterval(() => {
            if (sisa <= 0) { clearInterval(interval); el.textContent = 'Expired'; return; }
            const j = Math.floor(sisa / 3600);
            const m = Math.floor((sisa % 3600) / 60);
            const d = sisa % 60;
            el.textContent = `${String(j).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(d).padStart(2,'0')}`;
            sisa--;
        }, 1000);
    });
</script>
@endpush