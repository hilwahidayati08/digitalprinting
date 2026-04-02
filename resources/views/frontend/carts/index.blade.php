@extends('admin.guest')

@section('title', 'Keranjang Belanja - PrintPro')

@section('content')
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    input[type=number] { -moz-appearance: textfield; }
</style>

{{-- Page Header --}}
<div class="bg-gradient-to-br from-primary-600 to-secondary-600 py-8 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
    <div class="absolute bottom-0 left-0 w-24 h-24 bg-black/5 rounded-full translate-y-10 -translate-x-8"></div>
    <div class="container mx-auto px-4 max-w-6xl relative z-10">
        <h1 class="text-white text-2xl font-black tracking-tight">Keranjang Anda</h1>
    </div>
</div>

<section class="py-10 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-6xl">

        {{-- Alert --}}
        @if(session('success'))
        <div id="success-alert" class="flex items-center gap-3 p-4 bg-white border-l-4 border-primary-500 rounded-xl mb-6 shadow-sm transition-all duration-500">
            <p class="text-neutral-800 font-bold text-xs flex-1">{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="text-neutral-300 hover:text-neutral-700"><i class="fas fa-times text-xs"></i></button>
        </div>
        @endif

        @if(!$cart || $cart->items->count() == 0)
        {{-- Empty State --}}
        <div class="max-w-md mx-auto text-center py-16 px-6 bg-white border border-neutral-100 rounded-[1.5rem] shadow-sm">
            <div class="w-16 h-16 bg-neutral-50 rounded-xl flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-shopping-basket text-neutral-200 text-2xl"></i>
            </div>
            <h2 class="text-lg font-black text-neutral-800 mb-1 uppercase tracking-tight">Keranjang Kosong</h2>
            <p class="text-[10px] text-neutral-400 font-medium mb-5">Belum ada produk yang ditambahkan</p>
            <a href="{{ route('products.products') }}" class="inline-flex px-8 py-3 bg-neutral-900 hover:bg-primary-600 text-white font-black rounded-xl text-[10px] uppercase tracking-widest transition-all">Lihat Produk</a>
        </div>

        @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- LEFT: Item List --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Header Actions --}}
                <div class="flex items-center justify-between bg-white p-4 rounded-2xl border border-neutral-100 shadow-sm">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" id="select-all" class="w-4 h-4 rounded border-neutral-200 text-primary-600 focus:ring-primary-500 focus:ring-offset-0 transition-all cursor-pointer">
                        <span class="text-[10px] font-black text-neutral-600 uppercase tracking-widest group-hover:text-primary-600 transition-colors">Pilih Semua</span>
                    </label>
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan keranjang?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-[9px] font-black text-red-400 hover:text-red-600 uppercase tracking-widest transition-colors">
                            <i class="fas fa-trash-alt mr-1"></i> Kosongkan
                        </button>
                    </form>
                </div>

                {{-- Grouping by Date --}}
                @php
                    $groupedItems = $cart->items->groupBy(function($item) {
                        return $item->created_at->format('Y-m-d');
                    });
                @endphp

                @foreach($groupedItems as $date => $items)
                <div class="space-y-3">
                    {{-- Date Separator --}}
                    <div class="flex items-center gap-3">
                        <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                        <span class="text-[9px] font-black text-neutral-400 uppercase tracking-widest">
                            {{ \Carbon\Carbon::parse($date)->isoFormat('D MMMM YYYY') }}
                        </span>
                        <div class="h-[1px] flex-1 bg-neutral-100"></div>
                    </div>

                    @foreach($items as $item)
                    @php
                        $thumb = $item->product->images->where('is_primary', 1)->first() ?? $item->product->images->first();
                    @endphp

                    <div class="bg-white border border-neutral-100 rounded-2xl overflow-hidden hover:border-neutral-200 transition-all group">
                        <div class="flex flex-col sm:flex-row gap-5 p-5">

                            {{-- Checkbox --}}
                            <div class="flex items-center justify-center sm:justify-start">
                                <input type="checkbox"
                                       name="selected_items[]"
                                       value="{{ $item->cart_item_id }}"
                                       data-price="{{ $item->subtotal }}"
                                       class="item-checkbox w-4 h-4 rounded border-neutral-200 text-primary-600 focus:ring-primary-500 focus:ring-offset-0 transition-all cursor-pointer">
                            </div>

                            {{-- Thumbnail --}}
                            <div class="w-20 h-20 rounded-xl overflow-hidden border border-neutral-100 bg-neutral-50 flex-shrink-0 mx-auto sm:mx-0">
                                <img src="{{ $thumb ? asset('storage/' . $thumb->photo) : asset('images/no-image.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>

                            {{-- Content --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <div>
                                        <p class="text-primary-600 text-[8px] font-black uppercase tracking-[0.15em] mb-0.5">{{ $item->product->category->category_name }}</p>
                                        <h3 class="font-black text-neutral-800 text-sm leading-tight">{{ $item->product->product_name }}</h3>
                                    </div>
                                    <form method="POST" action="{{ route('cart.remove', $item->cart_item_id) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg border border-neutral-100 text-neutral-300 hover:text-red-400 hover:border-red-100 transition-all text-xs">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>

                                {{-- Spec Badges --}}
                                @if($item->width_cm > 0 && $item->height_cm > 0)
                                <div class="flex flex-wrap gap-1.5 mb-3">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-neutral-50 border border-neutral-100 text-neutral-500 rounded-md text-[9px] font-bold">
                                        <i class="fas fa-ruler-combined text-primary-400 text-[8px]"></i> {{ number_format($item->width_cm, 0) }} × {{ number_format($item->height_cm, 0) }} cm
                                    </span>
                                </div>
                                @endif

                                {{-- Bottom: Qty & Price --}}
                                <div class="flex items-center justify-between gap-4 pt-3 border-t border-neutral-50">
                                    <form method="POST" action="{{ route('cart.update', $item->cart_item_id) }}" class="flex items-center bg-neutral-900 rounded-xl p-0.5">
                                        @csrf @method('PATCH')
                                        <button type="button" onclick="stepQty({{ $item->cart_item_id }}, -1)" class="w-7 h-7 flex items-center justify-center text-white/40 hover:text-white transition-colors"><i class="fas fa-minus text-[8px]"></i></button>
                                        <input type="number" name="qty" id="qty-{{ $item->cart_item_id }}" value="{{ $item->qty }}" min="1" readonly
                                               class="w-10 bg-transparent border-0 text-center font-black text-xs text-white p-0 focus:ring-0">
                                        <button type="button" onclick="stepQty({{ $item->cart_item_id }}, 1)" class="w-7 h-7 flex items-center justify-center text-white/40 hover:text-white transition-colors"><i class="fas fa-plus text-[8px]"></i></button>
                                    </form>
                                    <p class="text-sm font-black text-primary-600">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>

            {{-- RIGHT: Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white border border-neutral-100 rounded-[1.5rem] overflow-hidden shadow-sm sticky top-24">

                    {{-- Summary Header --}}
                    <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-6 py-5 flex items-center gap-3 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-6 translate-x-6"></div>
                        <div class="w-8 h-8 bg-white/20 border border-white/30 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-file-invoice-dollar text-white text-xs"></i>
                        </div>
                        <span class="text-white font-black text-sm uppercase tracking-wider relative z-10">Ringkasan Order</span>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-neutral-400 font-medium">Subtotal (<span id="selected-count">0</span> item)</span>
                                <span class="font-bold text-neutral-800" id="display-subtotal">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-neutral-400 font-medium">PPN 11%</span>
                                <span class="font-bold text-neutral-800" id="display-ppn">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center text-xs pb-4 border-b border-neutral-50">
                                <span class="text-neutral-400 font-medium">Ongkos Kirim</span>
                                <span class="text-primary-600 font-black text-[9px] uppercase tracking-widest bg-primary-50 px-2 py-0.5 rounded-md">Dihitung nanti</span>
                            </div>
                        </div>

                        <div class="pt-1">
                            <div class="flex justify-between items-end">
                                <span class="font-black text-neutral-800 text-[10px] uppercase tracking-widest">Total Bayar</span>
                                <span class="text-xl font-black text-primary-600 tracking-tighter" id="display-total">Rp 0</span>
                            </div>
                            <p class="text-[9px] text-neutral-400 text-right mt-1 italic">*Sudah termasuk PPN 11%</p>
                        </div>

                        <button id="btn-checkout" disabled
                           class="flex items-center justify-center gap-2 w-full py-3.5 bg-neutral-200 text-white font-black rounded-xl transition-all text-[10px] uppercase tracking-widest cursor-not-allowed mt-2">
                           Lanjut ke Pembayaran <i class="fas fa-chevron-right ml-1"></i>
                        </button>

                        <div class="flex items-center justify-center gap-2 text-[9px] text-neutral-300 font-bold uppercase tracking-widest">
                            <i class="fas fa-lock text-green-400 text-[10px]"></i> Transaksi Aman
                        </div>

                        <div class="pt-4 border-t border-neutral-50">
                            <p class="text-[9px] font-black text-neutral-400 uppercase tracking-widest text-center mb-3">Metode Pembayaran</p>
                            <div class="flex items-center justify-center flex-wrap gap-2 opacity-40 hover:opacity-100 transition-all duration-500">
                                @foreach(['VISA','BCA','BNI','QRIS'] as $method)
                                <span class="px-2 py-1 border border-neutral-200 rounded text-[9px] font-black text-neutral-500 bg-neutral-50">{{ $method }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select-all');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const displaySubtotal = document.getElementById('display-subtotal');
        const displayPpn = document.getElementById('display-ppn');
        const displayTotal = document.getElementById('display-total');
        const displayCount = document.getElementById('selected-count');
        const btnCheckout = document.getElementById('btn-checkout');

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(number).replace("Rp", "Rp ");
        }

        function calculateSummary() {
            let subtotal = 0;
            let count = 0;

            itemCheckboxes.forEach(cb => {
                if (cb.checked) {
                    subtotal += parseFloat(cb.getAttribute('data-price'));
                    count++;
                }
            });

            const ppn = subtotal * 0.11;
            const total = subtotal + ppn;

            displayCount.textContent = count;
            displaySubtotal.textContent = formatRupiah(subtotal);
            displayPpn.textContent = formatRupiah(ppn);
            displayTotal.textContent = formatRupiah(total);

            if (count > 0) {
                btnCheckout.disabled = false;
                btnCheckout.classList.remove('bg-neutral-200', 'cursor-not-allowed');
                btnCheckout.classList.add('bg-neutral-900', 'hover:bg-primary-600', 'shadow-md');
                btnCheckout.onclick = () => window.location.href = "{{ route('checkout.index') }}";
            } else {
                btnCheckout.disabled = true;
                btnCheckout.classList.add('bg-neutral-200', 'cursor-not-allowed');
                btnCheckout.classList.remove('bg-neutral-900', 'hover:bg-primary-600', 'shadow-md');
                btnCheckout.onclick = null;
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                itemCheckboxes.forEach(cb => cb.checked = selectAll.checked);
                calculateSummary();
            });
        }

        itemCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const totalChecked = document.querySelectorAll('.item-checkbox:checked').length;
                if (selectAll) selectAll.checked = (totalChecked === itemCheckboxes.length);
                calculateSummary();
            });
        });

        calculateSummary();

        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        }
    });

    function stepQty(itemId, delta) {
        const input = document.getElementById('qty-' + itemId);
        const next = Math.max(1, parseInt(input.value) + delta);
        input.value = next;
        input.closest('form').submit();
    }
</script>
@endpush