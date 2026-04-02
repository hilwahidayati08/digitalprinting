@extends('layouts.member')

@section('member_content')
<div class="max-w-5xl mx-auto px-4 mb-8">
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-neutral-100 overflow-hidden">

        {{-- Header --}}
        <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-8 py-8 flex items-center justify-between relative overflow-hidden">
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

        <div class="p-6 lg:p-8 space-y-8">

            {{-- FILTER SECTION --}}
            <div class="space-y-5">
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

                        @if (request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                            <a href="{{ route('orders.index') }}" class="text-[10px] font-black text-red-400 uppercase tracking-widest hover:text-red-600 flex items-center gap-1.5 pb-3">
                                <i class="fas fa-times-circle"></i> Reset
                            </a>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-[9px] font-black text-neutral-400 uppercase tracking-[0.15em] mr-1">Status:</span>
                        @php
                            $statuses = ['' => 'Semua', 'pending' => 'Pending', 'paid' => 'Lunas', 'processing' => 'Proses', 'shipped' => 'Kirim', 'delivered' => 'Selesai', 'cancelled' => 'Batal'];
                            $activeStatus = request('status', '');
                        @endphp
                        @foreach ($statuses as $value => $label)
                            <button type="button" onclick="setStatus('{{ $value }}')"
                                @class([
                                    'px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-tighter transition-all border',
                                    'bg-primary-600 border-primary-600 text-white shadow-md shadow-primary-600/20' => $activeStatus === $value,
                                    'bg-neutral-50 border-neutral-100 text-neutral-500 hover:border-neutral-300' => $activeStatus !== $value
                                ])>
                                {{ $label }}
                            </button>
                        @endforeach
                        <input type="hidden" name="status" id="statusInput" value="{{ $activeStatus }}">
                    </div>
                </form>
            </div>

            {{-- ORDER LIST --}}
            <div class="space-y-5">
                <div class="flex items-center gap-2 border-b border-neutral-50 pb-2">
                    <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                    <h3 class="text-[11px] font-black text-neutral-800 uppercase tracking-widest">Daftar Pesanan</h3>
                </div>

                <div class="space-y-4 max-h-[700px] overflow-y-auto pr-1 custom-scrollbar">
                    @forelse($orders as $order)
                        <div @class([
                            'rounded-2xl border border-neutral-100 overflow-hidden transition-all',
                            'opacity-60 grayscale-[0.5]' => $order->status == 'cancelled'
                        ])>

                            {{-- Order Header --}}
                            <div class="bg-neutral-50 px-5 py-4 border-b border-neutral-100 flex justify-between items-center">
                                <div class="flex items-center gap-5">
                                    <div>
                                        <p class="text-[9px] text-neutral-400 uppercase font-black tracking-widest mb-0.5">No. Pesanan</p>
                                        <p class="font-black text-neutral-900 text-[13px]">#{{ $order->order_number }}</p>
                                    </div>
                                    <div class="h-7 w-[1px] bg-neutral-200 hidden sm:block"></div>
                                    <div class="hidden sm:block">
                                        <p class="text-[9px] text-neutral-400 uppercase font-black tracking-widest mb-0.5">Tanggal</p>
                                        <p class="text-[11px] text-neutral-600 font-bold italic">{{ $order->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span @class([
                                        'px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border',
                                        'bg-neutral-100 text-neutral-500 border-neutral-200'   => $order->status == 'pending',
                                        'bg-emerald-50 text-emerald-600 border-emerald-100'    => $order->status == 'paid',
                                        'bg-blue-50 text-blue-600 border-blue-100'             => $order->status == 'processing',
                                        'bg-purple-50 text-purple-600 border-purple-100'       => $order->status == 'shipped',
                                        'bg-teal-50 text-teal-600 border-teal-100'             => $order->status == 'delivered',
                                        'bg-red-50 text-red-400 border-red-100'                => $order->status == 'cancelled',
                                    ])>
                                        {{ str_replace('_', ' ', $order->status) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Order Items --}}
                            <div class="p-5 bg-white space-y-4">
                                @foreach ($order->items as $item)
                                    <div class="flex flex-col sm:flex-row justify-between gap-4 pb-4 border-b border-neutral-50 last:border-0 last:pb-0">

                                        {{-- Product Info --}}
                                        <div class="flex gap-4 items-center">
                                            @php
                                                $productImage = $item->product?->images?->where('is_primary', true)->first()
                                                             ?? $item->product?->images?->first();
                                            @endphp
                                            <div class="relative flex-shrink-0">
                                                <img src="{{ $productImage ? asset('storage/' . $productImage->photo) : 'https://placehold.co/60x60' }}"
                                                    class="w-14 h-14 object-cover rounded-xl">
                                                <span class="absolute -top-1.5 -right-1.5 bg-neutral-900 text-white text-[9px] font-black w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">
                                                    {{ $item->qty }}
                                                </span>
                                            </div>
                                            <div>
                                                <h4 class="font-black text-neutral-800 text-[12px] uppercase tracking-tight">
                                                    {{ $item->product?->product_name }}
                                                </h4>
                                                <p class="text-[11px] text-neutral-400 font-bold italic">
                                                    IDR {{ number_format($item->unit_price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>

                                        {{-- Action Buttons --}}
                                        <div class="flex items-center">

                                            @if ($order->status == 'pending')
                                                {{--
                                                    ✅ PERBAIKAN UTAMA:
                                                    Tombol Bayar selalu memanggil fetchAndPay() via AJAX.
                                                    Controller akan return token dari DB jika sudah ada,
                                                    atau generate baru jika belum ada.
                                                    Tidak ada lagi pengecekan snap_token di sini (blade).
                                                --}}
                                                <div class="flex gap-2 w-full">
                                                    <button
                                                        id="pay-btn-{{ $order->order_number }}"
                                                        onclick="fetchAndPay('{{ $order->order_number }}', this)"
                                                        class="flex-1 px-6 py-2.5 bg-neutral-900 text-white rounded-xl text-[10px] font-black tracking-widest hover:bg-primary-600 transition-all uppercase">
                                                        Bayar
                                                    </button>

                                                    <form action="{{ route('orders.cancel', $order->order_id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="px-4 py-2.5 text-red-400 border border-red-100 rounded-xl text-[10px] font-black uppercase hover:bg-red-50 transition-all">
                                                            Batal
                                                        </button>
                                                    </form>
                                                </div>

                                            @elseif (in_array($order->status, ['paid', 'processing']))
                                                @if (!$item->design_file)
                                                    <form action="{{ route('orders.upload', $item->order_item_id) }}"
                                                        method="POST" enctype="multipart/form-data"
                                                        class="flex gap-2"
                                                        onsubmit="return handleUpload(this)">
                                                        @csrf
                                                        <input type="file" name="design_file" required
                                                            id="file-{{ $item->order_item_id }}"
                                                            class="hidden"
                                                            onchange="this.form.submit()">
                                                        <label for="file-{{ $item->order_item_id }}"
                                                            class="px-4 py-2 bg-neutral-50 border border-neutral-200 rounded-xl text-[10px] font-bold cursor-pointer hover:bg-neutral-100 transition-all">
                                                            <i class="fas fa-upload mr-1"></i> Upload Desain
                                                        </label>
                                                    </form>
                                                @else
                                                    <span class="px-3 py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-[10px] font-black uppercase">
                                                        <i class="fas fa-check-circle mr-1"></i> Desain Terupload
                                                    </span>
                                                @endif
                                            @endif

                                        </div>
                                        {{-- End Action Buttons --}}

                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @empty
                        <div class="text-center py-16 border-2 border-dashed border-neutral-100 rounded-2xl">
                            <i class="fas fa-box-open text-neutral-300 text-3xl mb-3 block"></i>
                            <p class="text-[10px] text-neutral-400 font-black uppercase tracking-widest">Belum ada pesanan</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Loading Overlay --}}
<div id="payment-loading" class="hidden fixed inset-0 bg-black/40 z-50 flex items-center justify-center backdrop-blur-sm">
    <div class="bg-white rounded-2xl px-8 py-6 flex items-center gap-4 shadow-xl">
        <i class="fas fa-spinner animate-spin text-primary-600 text-xl"></i>
        <div>
            <p class="font-black text-neutral-800 text-[13px]">Memproses Pembayaran</p>
            <p class="text-[11px] text-neutral-400 font-medium mt-0.5">Mohon tunggu sebentar...</p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    {{-- Midtrans Snap SDK --}}
    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

    <script>
        // Gunakan global constant agar mudah diakses
        const CSRF_TOKEN = '{{ csrf_token() }}';
        const SUCCESS_URL = '{{ route("checkout.success") }}';

        /* ── Filter helpers ─────────────────────────────────── */
        function setStatus(value) {
            const statusInput = document.getElementById('statusInput');
            const filterForm = document.getElementById('filterForm');
            if (statusInput && filterForm) {
                statusInput.value = value;
                filterForm.submit();
            }
        }

        /* ── Upload design ──────────────────────────────────── */
        function handleUpload(form) {
            const label = form.querySelector('label');
            if (label) {
                label.innerHTML = '<i class="fas fa-spinner animate-spin mr-1"></i> Mengupload...';
                // Mencegah klik ganda saat proses upload
                form.querySelector('input[type="file"]').style.display = 'none';
            }
            return true;
        }

        /* ── Fetch token dari controller, lalu buka Snap ────── */
        async function fetchAndPay(orderNumber, btn) {
            const overlay = document.getElementById('payment-loading');
            
            // Tampilkan loading overlay jika ada
            if (overlay) overlay.classList.remove('hidden');

            // Simpan label asli tombol
            const originalLabel = btn ? btn.innerHTML : 'BAYAR';
            
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner animate-spin mr-1"></i> Memproses...';
            }

            try {
                // Pastikan URL ini sesuai dengan Route::post di web.php Anda
                const res = await fetch(`/orders/${orderNumber}/snap-token`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                });

                // Periksa jika response bukan 200 OK
                if (!res.ok) {
                    const errorData = await res.json();
                    throw new Error(errorData.message || 'Server Error');
                }

                const data = await res.json();

                if (data.status === 'success' && data.snap_token) {
                    // Sembunyikan loading tepat sebelum popup muncul
                    if (overlay) overlay.classList.add('hidden');

                    window.snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            window.location.href = SUCCESS_URL + '?order_id=' + orderNumber;
                        },
                        onPending: function(result) {
                            // Jika user memilih transfer bank tapi belum bayar
                            location.reload(); 
                        },
                        onError: function(result) {
                            console.error('Snap error:', result);
                            alert('Pembayaran gagal. Silakan coba lagi.');
                            resetBtn(btn, originalLabel);
                        },
                        onClose: function() {
                            // User menutup popup tanpa bayar
                            alert('Anda menutup jendela pembayaran.');
                            resetBtn(btn, originalLabel);
                        }
                    });
                } else {
                    // Kasus jika response sukses tapi token tidak ada (karena error logic di controller)
                    throw new Error(data.message || 'Token tidak valid');
                }

            } catch (err) {
                if (overlay) overlay.classList.add('hidden');
                console.error('Payment Error:', err);
                
                // Menampilkan pesan error spesifik dari server (untuk memudahkan debug)
                alert('Gagal memproses pembayaran: ' + err.message);
                
                resetBtn(btn, originalLabel);
            }
        }

        /* ── Helper untuk reset tombol ──────────────────────── */
        function resetBtn(btn, label) {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = label;
            }
        }
    </script>
@endpush