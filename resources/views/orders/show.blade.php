@extends('admin.member')

@section('member_content')
<div class="max-w-3xl mx-auto px-4 mb-8 space-y-4">

    <a href="{{ route('orders.index') }}"
        class="inline-flex items-center gap-2 text-[10px] font-black text-neutral-400 hover:text-primary-600 uppercase tracking-widest transition-all">
        <i class="fas fa-arrow-left text-[9px]"></i> Kembali ke Riwayat
    </a>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2">
            <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ══ CARD 1: Info Order ══ --}}
    <div class="bg-white rounded-2xl border border-neutral-100 overflow-hidden">
        <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-6 py-5 flex items-center justify-between">
            <div>
                <p class="text-white/60 text-[9px] font-black uppercase tracking-widest">No. Pesanan</p>
                <p class="text-white font-black text-lg">#{{ $order->order_number }}</p>
            </div>
            <span class="px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest border {{ $statusClass[$order->status] ?? 'bg-gray-50 text-gray-400 border-gray-100' }}">
                {{ $statusLabel[$order->status] ?? $order->status }}
            </span>
        </div>

        <div class="p-5 grid grid-cols-2 sm:grid-cols-4 gap-4 text-center border-b border-neutral-50">
            <div>
                <p class="text-[9px] text-neutral-400 uppercase font-black tracking-widest mb-1">Tanggal</p>
                <p class="text-[11px] font-bold text-neutral-700">{{ $order->created_at->format('d M Y') }}</p>
                <p class="text-[10px] text-neutral-400">{{ $order->created_at->format('H:i') }}</p>
            </div>
            <div>
                <p class="text-[9px] text-neutral-400 uppercase font-black tracking-widest mb-1">Subtotal</p>
                <p class="text-[11px] font-bold text-neutral-700">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-[9px] text-neutral-400 uppercase font-black tracking-widest mb-1">Pajak</p>
                <p class="text-[11px] font-bold text-neutral-700">Rp {{ number_format($order->tax, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-[9px] text-neutral-400 uppercase font-black tracking-widest mb-1">Total</p>
                <p class="text-[13px] font-black text-primary-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Pengiriman + Cashback --}}
        <div class="px-5 py-4 flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2 text-[10px] text-neutral-500 font-bold">
                <i class="fas fa-truck text-neutral-300"></i>
                {{ $metodeLbl[$order->shipping_method] ?? $order->shipping_method }}
                @if($order->shipping_cost > 0)
                    <span class="text-neutral-400">· Ongkir Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                @endif
            </div>
            @if(isset($order->commission_earned) && $order->commission_earned > 0)
                <span class="text-[10px] font-black text-emerald-600">
                    <i class="fas fa-coins mr-1"></i>Cashback +Rp {{ number_format($order->commission_earned, 0, ',', '.') }}
                </span>
            @endif
        </div>

        {{-- Tracking info jika sudah shipped (ekspedisi) --}}
        @if($order->status === 'shipped' && $order->tracking_number)
            <div class="mx-5 mb-5 flex items-center gap-3 px-4 py-3 bg-blue-50 border border-blue-100 rounded-xl">
                <i class="fas fa-truck text-blue-400 text-[10px]"></i>
                <div>
                    <p class="text-[10px] font-black text-blue-700 uppercase tracking-widest">Sedang Dikirim</p>
                    <p class="text-[11px] text-blue-600 font-bold">{{ $order->kurir_name }} · {{ $order->tracking_number }}</p>
                </div>
            </div>
        @endif

        {{-- Countdown Timer (hanya untuk pending midtrans) --}}
        @if($order->status === 'pending' && $order->payment_method === 'midtrans')
            @if(!$isExpired)
            <div class="mx-5 mb-5 flex items-center gap-2 px-4 py-3 bg-red-50 border border-red-100 rounded-xl">
                <i class="fas fa-clock text-red-400 text-[10px]"></i>
                <span class="text-[10px] font-black text-red-500 uppercase tracking-widest">Bayar sebelum:</span>
                <span class="text-[11px] font-black text-red-600 countdown-timer" data-seconds="{{ $sisaDetik }}">--:--:--</span>
                <span class="text-[9px] text-red-400 italic ml-auto hidden sm:block">Pesanan otomatis dibatalkan jika tidak dibayar</span>
            </div>
            @else
            <div class="mx-5 mb-5 flex items-center gap-2 px-4 py-3 bg-neutral-100 border border-neutral-200 rounded-xl">
                <i class="fas fa-clock text-neutral-400 text-[10px]"></i>
                <span class="text-[10px] font-black text-neutral-500 uppercase">Waktu pembayaran telah habis</span>
            </div>
            @endif
        @endif

        {{-- Tombol Aksi --}}
        <div class="px-5 pb-5 flex flex-wrap gap-2">
            @if($order->status === 'pending' && $order->payment_method === 'midtrans' && !$isExpired)
                <button onclick="fetchAndPay('{{ $order->order_number }}', this)"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-[10px] font-black uppercase tracking-wider transition-all shadow-md shadow-blue-200">
                    <i class="fas fa-credit-card"></i> Bayar Sekarang
                </button>
            @endif

            @if(in_array($order->status, ['paid', 'processing', 'shipped', 'completed']))
                <a href="{{ route('orders.invoice', $order->order_number) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all">
                    <i class="fas fa-file-invoice"></i> Download Invoice
                </a>
            @endif

            @if($order->status === 'pending')
                <form action="{{ route('orders.cancel', $order->order_id) }}" method="POST"
                    onsubmit="return confirm('Batalkan pesanan ini?')">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-50 hover:bg-red-100 text-red-500 border border-red-100 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all">
                        <i class="fas fa-times"></i> Batalkan Pesanan
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- ══ CARD 2: Produk ══ --}}
    <div class="bg-white rounded-2xl border border-neutral-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-neutral-50 flex items-center gap-2">
            <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
            <h3 class="text-[11px] font-black text-neutral-800 uppercase tracking-widest">Produk Dipesan</h3>
        </div>

        <div class="divide-y divide-neutral-50">
            @foreach($order->items as $item)
                @php
                    $productImage = $item->product?->images?->where('is_primary', true)->first()
                                 ?? $item->product?->images?->first();
                @endphp
                <div class="p-5 space-y-3">
                    <div class="flex gap-4">
                        <div class="relative flex-shrink-0">
                            <img src="{{ $productImage ? asset('storage/' . $productImage->photo) : 'https://placehold.co/64x64' }}"
                                class="w-16 h-16 object-cover rounded-xl">
                            <span class="absolute -top-1.5 -right-1.5 bg-neutral-900 text-white text-[9px] font-black w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">
                                {{ $item->qty }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-black text-neutral-800 text-[13px] uppercase tracking-tight">
                                {{ $item->product?->product_name }}
                            </h4>
                            @if($item->width_cm > 0 && $item->height_cm > 0)
                                <p class="text-[10px] text-primary-500 font-bold mt-0.5">
                                    {{ number_format($item->width_cm, 0) }} × {{ number_format($item->height_cm, 0) }} cm
                                </p>
                            @endif
                            <p class="text-[11px] text-neutral-400 font-bold italic mt-0.5">
                                Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                @if($item->qty > 1) × {{ $item->qty }} =
                                    <span class="text-neutral-600">Rp {{ number_format($item->unit_price * $item->qty, 0, ',', '.') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Upload Desain --}}
                    @if(in_array($order->status, ['paid', 'processing']))
                        @if(!$item->design_file)
                            <form action="{{ route('orders.upload', $item->order_item_id) }}"
                                method="POST" enctype="multipart/form-data"
                                onsubmit="return handleUpload(this)">
                                @csrf
                                <input type="file" name="design_file" required
                                    id="file-{{ $item->order_item_id }}" class="hidden"
                                    onchange="this.form.submit()">
                                <label for="file-{{ $item->order_item_id }}"
                                    class="inline-flex items-center px-4 py-2 bg-neutral-50 border border-neutral-200 rounded-xl text-[10px] font-bold cursor-pointer hover:bg-neutral-100 transition-all gap-2">
                                    <i class="fas fa-upload text-primary-500"></i> Upload File Desain
                                </label>
                            </form>
                        @else
                            <span class="inline-flex items-center px-4 py-2 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl text-[10px] font-black uppercase gap-1.5">
                                <i class="fas fa-check-circle"></i> File Desain Terupload
                            </span>
                        @endif
                    @endif

                    {{-- Rating --}}
                    @if($order->status === 'completed')
                        @php
                            $hasRated = \App\Models\Ratings::where('user_id', auth()->id())
                                        ->where('order_id', $order->order_id)
                                        ->where('product_id', $item->product_id)
                                        ->exists();
                        @endphp
                        @if(!$hasRated)
                            <button onclick="openRatingModal('{{ $order->order_id }}','{{ $item->order_item_id }}','{{ $item->product_id }}','{{ addslashes($item->product->product_name) }}')"
                                class="inline-flex items-center px-4 py-2 bg-yellow-50 border border-yellow-200 rounded-xl text-[10px] font-bold text-yellow-700 hover:bg-yellow-100 transition-all gap-2">
                                <i class="fas fa-star text-yellow-500"></i> Beri Rating & Ulasan
                            </button>
                        @else
                            <span class="inline-flex items-center px-4 py-2 bg-green-50 text-green-600 border border-green-100 rounded-xl text-[10px] font-black uppercase gap-1.5">
                                <i class="fas fa-check-circle"></i> Sudah Dinilai
                            </span>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- ══ CARD 3: Catatan ══ --}}
    <div class="bg-white rounded-2xl border border-neutral-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-neutral-50 flex items-center gap-2">
            <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
            <h3 class="text-[11px] font-black text-neutral-800 uppercase tracking-widest">Catatan Pesanan</h3>
        </div>
        <div class="p-5">
            @php $orderNotes = $order->items->first()?->notes; @endphp

            @if(in_array($order->status, ['pending', 'paid']))
                <form action="{{ route('orders.update-notes', $order->order_id) }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="notes" value="{{ $orderNotes }}"
                        placeholder="Contoh: Warna dominan merah, jangan glossy..."
                        class="flex-1 bg-neutral-50 border border-neutral-200 rounded-xl px-4 py-2.5 text-[11px] font-bold text-neutral-700 outline-none focus:border-primary-500 transition-all">
                    <button type="submit"
                        class="px-5 py-2.5 bg-neutral-900 text-white rounded-xl hover:bg-primary-600 transition-all text-[10px] font-black uppercase flex items-center gap-2">
                        <i class="fas fa-paper-plane text-[9px]"></i>
                        {{ $orderNotes ? 'Update' : 'Simpan' }}
                    </button>
                </form>
                @if($orderNotes)
                    <div class="mt-3 flex items-start gap-2 py-2.5 px-4 bg-primary-50 border border-primary-100 rounded-xl">
                        <i class="fas fa-check-circle text-primary-500 text-[10px] mt-0.5"></i>
                        <p class="text-[11px] font-bold text-primary-700">{{ $orderNotes }}</p>
                    </div>
                    <p class="text-[9px] text-neutral-400 mt-2 italic">
                        <i class="fas fa-info-circle mr-1"></i> Catatan bisa diubah selama pesanan belum diproses.
                    </p>
                @endif
            @elseif($orderNotes)
                <div class="flex items-center gap-2 py-2.5 px-4 bg-neutral-50 border border-neutral-100 rounded-xl">
                    <i class="fas fa-lock text-neutral-300 text-[10px]"></i>
                    <p class="text-[11px] font-bold text-neutral-600 flex-1">{{ $orderNotes }}</p>
                    <span class="text-[8px] font-black text-neutral-300 uppercase tracking-widest">Terkunci</span>
                </div>
            @else
                <div class="flex items-center gap-2 py-2.5 px-4 bg-neutral-50 border border-neutral-100 rounded-xl">
                    <i class="fas fa-lock text-neutral-300 text-[10px]"></i>
                    <p class="text-[11px] text-neutral-400 italic">Tidak ada catatan.</p>
                </div>
            @endif
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

{{-- Rating Modal --}}
<div id="ratingModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-black text-neutral-800 text-lg">Beri Rating Produk</h3>
            <button onclick="closeRatingModal()" class="text-neutral-400 hover:text-neutral-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mb-4 p-3 bg-neutral-50 rounded-xl">
            <p class="text-[11px] text-neutral-500">Produk:</p>
            <p class="font-bold text-neutral-800 text-sm" id="productName"></p>
        </div>
        <form id="ratingForm" action="{{ route('orders.rate') }}" method="POST">
            @csrf
            <input type="hidden" name="order_id"      id="ratingOrderId">
            <input type="hidden" name="order_item_id" id="ratingOrderItemId">
            <input type="hidden" name="product_id"    id="ratingProductId">
            <div class="mb-4">
                <label class="block text-[11px] font-black text-neutral-600 uppercase mb-2">Rating</label>
                <div class="flex gap-2">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setRating({{ $i }})" class="rating-star focus:outline-none hover:scale-110 transition-all">
                            <i class="far fa-star text-yellow-400 text-3xl"></i>
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="ratingValue" required>
            </div>
            <div class="mb-4">
                <label class="block text-[11px] font-black text-neutral-600 uppercase mb-2">Ulasan (Opsional)</label>
                <textarea name="review" rows="3"
                    class="w-full bg-neutral-50 border border-neutral-200 rounded-xl px-4 py-2 text-[11px] font-bold text-neutral-700 outline-none focus:border-primary-600"
                    placeholder="Tulis pengalaman Anda dengan produk ini..."></textarea>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="closeRatingModal()"
                    class="flex-1 px-4 py-2 bg-neutral-100 text-neutral-600 rounded-xl text-[11px] font-black uppercase">Batal</button>
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-yellow-500 text-white rounded-xl text-[11px] font-black uppercase hover:bg-yellow-600 transition-all">Kirim</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

<script>
    const CSRF_TOKEN  = '{{ csrf_token() }}';
    const SUCCESS_URL = '{{ route("checkout.success") }}';

    // Countdown
    document.querySelectorAll('.countdown-timer').forEach(el => {
        let sisa = parseInt(el.dataset.seconds);
        const interval = setInterval(() => {
            if (sisa <= 0) { clearInterval(interval); el.textContent = 'Kedaluwarsa'; return; }
            const j = Math.floor(sisa / 3600);
            const m = Math.floor((sisa % 3600) / 60);
            const d = sisa % 60;
            el.textContent = `${String(j).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(d).padStart(2,'0')}`;
            sisa--;
        }, 1000);
    });

    // Upload
    function handleUpload(form) {
        const label = form.querySelector('label');
        if (label) label.innerHTML = '<i class="fas fa-spinner animate-spin mr-1"></i> Mengupload...';
        return true;
    }

    // Midtrans
    async function fetchAndPay(orderNumber, btn) {
        const overlay = document.getElementById('payment-loading');
        overlay?.classList.remove('hidden');
        const ori = btn?.innerHTML ?? '';
        if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner animate-spin mr-1"></i> Memproses...'; }

        try {
            const res  = await fetch(`/orders/${orderNumber}/snap-token`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json', 'Content-Type': 'application/json' },
            });
            const data = await res.json();
            if (!res.ok || data.status !== 'success' || !data.snap_token) throw new Error(data.message || 'Token tidak valid');
            overlay?.classList.add('hidden');
            window.snap.pay(data.snap_token, {
                onSuccess: () => window.location.href = SUCCESS_URL + '?order_id=' + orderNumber,
                onPending: () => location.reload(),
                onError:   () => { alert('Pembayaran gagal.'); resetBtn(btn, ori); },
                onClose:   () => { overlay?.classList.add('hidden'); resetBtn(btn, ori); }
            });
        } catch(err) {
            overlay?.classList.add('hidden');
            alert('Gagal: ' + err.message);
            resetBtn(btn, ori);
        }
    }

    function resetBtn(btn, label) {
        if (btn) { btn.disabled = false; btn.innerHTML = label; }
    }

    // Rating
    function openRatingModal(orderId, orderItemId, productId, productName) {
        document.getElementById('ratingOrderId').value     = orderId;
        document.getElementById('ratingOrderItemId').value = orderItemId;
        document.getElementById('ratingProductId').value   = productId;
        document.getElementById('productName').innerHTML   = productName;
        document.getElementById('ratingValue').value       = '';
        document.querySelectorAll('.rating-star i').forEach(s => s.className = 'far fa-star text-yellow-400 text-3xl');
        document.getElementById('ratingModal').classList.remove('hidden');
    }

    function closeRatingModal() {
        document.getElementById('ratingModal').classList.add('hidden');
    }

    function setRating(rating) {
        document.getElementById('ratingValue').value = rating;
        document.querySelectorAll('.rating-star i').forEach((s, i) => {
            s.className = i < rating ? 'fas fa-star text-yellow-400 text-3xl' : 'far fa-star text-yellow-400 text-3xl';
        });
    }

    document.getElementById('ratingForm')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (!document.getElementById('ratingValue').value) { alert('Silakan pilih rating terlebih dahulu'); return; }
        const btn = this.querySelector('button[type="submit"]');
        const ori = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner animate-spin"></i>';
        try {
            const res  = await fetch(this.action, { method: 'POST', headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }, body: new FormData(this) });
            const data = await res.json();
            if (res.ok && data.status === 'success') { alert('Terima kasih!'); location.reload(); }
            else throw new Error(data.message || 'Gagal');
        } catch(err) {
            alert('Error: ' + err.message);
            btn.disabled = false; btn.innerHTML = ori;
        }
    });
</script>
@endpush