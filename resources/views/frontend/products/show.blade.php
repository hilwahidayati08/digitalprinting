@extends('admin.guest')

@section('title', $product->product_name . ' - PrintPro')

@section('content')
<section class="py-8 bg-[#F8FAFC]">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            {{-- KIRI: Galeri Foto --}}
            <div class="lg:col-span-5">
                <div class="sticky top-24 space-y-4">
                    @php
                        $primaryImage = $product->images->where('is_primary', 1)->first() ?? $product->images->first();
                        $allImages    = $product->images;
                        $calcType     = $product->category->calc_type; 
                    @endphp

                    {{-- Main Image Card --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden relative group">
                        <div class="w-full flex items-center justify-center p-6 bg-white" style="height: 380px;">
                            <img src="{{ $primaryImage ? asset('storage/' . $primaryImage->photo) : asset('images/no-image.png') }}"
                                 class="max-w-full max-h-full object-contain transition-all duration-700 group-hover:scale-105"
                                 id="mainProductImage"
                                 alt="{{ $product->product_name }}">
                        </div>

                        @if($product->is_active == 0)
                            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[4px] flex items-center justify-center">
                                <span class="bg-white text-slate-900 px-6 py-2 rounded-xl font-black uppercase tracking-tighter shadow-2xl text-xs">Stok Habis</span>
                            </div>
                        @endif
                    </div>

                    {{-- Thumbnails --}}
                    @if($allImages->count() > 1)
                        <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                            @foreach($allImages as $img)
                                <button type="button" 
                                    onclick="changeMainImage('{{ asset('storage/' . $img->photo) }}', this)"
                                    class="thumbnail-item flex-shrink-0 rounded-xl border-2 {{ $img->is_primary ? 'border-blue-600' : 'border-slate-200' }} overflow-hidden transition-all hover:border-blue-400"
                                    style="width: 60px; height: 60px;">
                                    <img src="{{ asset('storage/' . $img->photo) }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- KANAN: Detail & Form --}}
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 lg:p-8">
                    
                    {{-- Header Produk --}}
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider border border-blue-100">
                                {{ $product->category->category_name }}
                            </span>
                            <div class="flex items-center text-amber-400 text-xs font-bold">
                                <i class="fas fa-star mr-1"></i>
                                <span class="text-slate-900">{{ number_format($product->ratings->avg('rating') ?: 0, 1) }}</span>
                            </div>
                        </div>
                        
                        <h1 class="text-2xl lg:text-3xl font-black text-slate-900 mb-6 leading-tight tracking-tight">
                            {{ $product->product_name }}
                        </h1>

                        {{-- Feature Highlights --}}
                        <div class="grid grid-cols-3 gap-3 mb-6">
                            <div class="flex flex-col gap-1 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <i class="fas fa-bolt text-blue-600 text-sm"></i>
                                <p class="text-[9px] font-black text-slate-400 uppercase">Proses</p>
                                <p class="text-[11px] font-bold text-slate-900">Cepat & Kilat</p>
                            </div>
                            <div class="flex flex-col gap-1 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <i class="fas fa-shield-check text-emerald-600 text-sm"></i>
                                <p class="text-[9px] font-black text-slate-400 uppercase">Kualitas</p>
                                <p class="text-[11px] font-bold text-slate-900">High-Res</p>
                            </div>
                            <div class="flex flex-col gap-1 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <i class="fas fa-palette text-purple-600 text-sm"></i>
                                <p class="text-[9px] font-black text-slate-400 uppercase">Warna</p>
                                <p class="text-[11px] font-bold text-slate-900">Anti Pudar</p>
                            </div>
                        </div>

                        {{-- Tabs Deskripsi --}}
                        <div x-data="{ tab: 'desc' }" class="space-y-4">
                            <div class="flex border-b border-slate-100 gap-6">
                                <button @click="tab = 'desc'" :class="tab === 'desc' ? 'text-blue-600 border-blue-600' : 'text-slate-400 border-transparent'" class="pb-3 text-[11px] font-black uppercase tracking-widest border-b-2 transition-all outline-none">Deskripsi</button>
                                <button @click="tab = 'spec'" :class="tab === 'spec' ? 'text-blue-600 border-blue-600' : 'text-slate-400 border-transparent'" class="pb-3 text-[11px] font-black uppercase tracking-widest border-b-2 transition-all outline-none">Spesifikasi</button>
                            </div>
                            <div x-show="tab === 'desc'" class="text-slate-500 text-xs leading-relaxed italic">
                                {!! nl2br(e($product->description ?? 'Cetak berkualitas premium dengan pengerjaan cepat.')) !!}
                            </div>
                            <div x-show="tab === 'spec'" class="space-y-2">
                                <div class="flex justify-between py-2 border-b border-slate-50">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase">Material</span>
                                    <span class="text-[11px] text-slate-900 font-black">{{ $product->material->material_name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-slate-50">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase">Satuan</span>
                                    <span class="text-[11px] text-slate-900 font-black">{{ $product->unit->unit_name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Form --}}
                    <form id="addToCartForm" method="POST" action="{{ route('cart.add') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <input type="hidden" name="buy_now" id="buy_now_flag" value="0">

                        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 text-[10px] font-bold uppercase">Harga /{{ $product->unit->unit_name }}</span>
                                <span class="text-xl font-black text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>

                            @if($product->allow_custom_size && $calcType !== 'satuan')
                            <div class="grid grid-cols-2 gap-3">
                                <input type="number" name="width_cm" id="width_cm" placeholder="P (cm)" class="w-full bg-white px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 outline-none font-bold text-sm" value="{{ $product->default_width_cm }}">
                                <input type="number" name="height_cm" id="height_cm" placeholder="L (cm)" class="w-full bg-white px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 outline-none font-bold text-sm" value="{{ $product->default_height_cm }}">
                            </div>
                            @endif
                        </div>

                        <div class="bg-slate-900 rounded-3xl p-6 text-white shadow-lg">
                            <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
                                <div class="space-y-1">
                                    <p class="text-white/40 text-[9px] font-black uppercase">Ukuran</p>
                                    <p class="text-sm font-bold" id="preview_ukuran">—</p>
                                </div>
<div class="flex items-center bg-white/10 rounded-xl p-1 border border-white/20">
    {{-- Tombol Kurang --}}
    <button type="button" id="decreaseQty" 
        class="w-10 h-10 flex items-center justify-center hover:bg-white/10 rounded-lg transition-colors text-white text-lg">
        <i class="fas fa-minus"></i>
    </button>
    
    {{-- Input Angka: Lebar ditambah ke w-14 agar 2-3 digit aman --}}
    <input type="number" name="qty" id="qty" value="1" readonly 
        class="bg-transparent border-0 w-14 text-center font-black text-base text-white focus:ring-0 focus:outline-none appearance-none">
    
    {{-- Tombol Tambah --}}
    <button type="button" id="increaseQty" 
        class="w-10 h-10 flex items-center justify-center hover:bg-white/10 rounded-lg transition-colors text-white text-lg">
        <i class="fas fa-plus"></i>
    </button>
</div>
                            </div>
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-white/40 text-[9px] font-black uppercase mb-1">Total</p>
                                    <p class="text-2xl font-black text-blue-400" id="realtime_subtotal">Rp 0</p>
                                </div>
                                <button type="submit" class="p-3 bg-blue-600 rounded-xl hover:bg-blue-700 transition-all"><i class="fas fa-shopping-basket"></i></button>
                            </div>
                        </div>
                        <button type="button" id="buyNowBtn" class="w-full py-4 bg-blue-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest hover:scale-[1.01] transition-all">Beli Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SECTION RATING & ULASAN --}}
<section class="pb-16 bg-[#F8FAFC]">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-12">
                <div class="lg:col-span-4 p-8 bg-slate-50/50 border-r border-slate-100 text-center flex flex-col items-center justify-center">
                    <h3 class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-4">Rating Produk</h3>
                    <div class="text-5xl font-black text-slate-900 mb-2">{{ number_format($product->ratings->avg('rating') ?: 0, 1) }}</div>
                    <div class="flex gap-1 text-amber-400 mb-4">
                        @php $avg = $product->ratings->avg('rating') ?: 0; @endphp
                        @for($i=1; $i<=5; $i++) <i class="{{ $i <= $avg ? 'fas' : 'far' }} fa-star"></i> @endfor
                    </div>
                    <p class="text-slate-400 text-xs italic">{{ $product->ratings->count() }} ulasan</p>
                </div>
                <div class="lg:col-span-8 p-8">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6">Ulasan Pembeli</h3>
                    <div class="space-y-6">
                        @forelse($product->ratings as $review)
                            <div class="border-b border-slate-50 pb-6 last:border-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-[10px]">{{ strtoupper(substr($review->user->username, 0, 1)) }}</div>
                                    <span class="text-xs font-bold text-slate-900">{{ $review->user->username }}</span>
                                </div>
                                <p class="text-xs text-slate-500 italic">"{{ $review->review }}"</p>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic">Belum ada ulasan.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SECTION REKOMENDASI --}}
<section class="pb-20 bg-[#F8FAFC]">
    <div class="container mx-auto px-4 max-w-6xl">
        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-8">Produk Rekomendasi</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($relatedProducts as $related)
            <a href="{{ route('products.show', $related->slug) }}" class="group bg-white rounded-2xl border border-slate-100 p-3 hover:shadow-lg transition-all">
                <div class="aspect-square rounded-xl bg-slate-50 mb-3 overflow-hidden">
                    @php $relImg = $related->images->where('is_primary', 1)->first() ?? $related->images->first(); @endphp
                    <img src="{{ $relImg ? asset('storage/' . $relImg->photo) : asset('images/no-image.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-all">
                </div>
                <h4 class="text-xs font-bold text-slate-900 mb-2 truncate">{{ $related->product_name }}</h4>
                <p class="text-blue-600 font-black text-xs">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
function changeMainImage(src, element) {
    document.getElementById('mainProductImage').src = src;
    document.querySelectorAll('.thumbnail-item').forEach(i => i.classList.replace('border-blue-600', 'border-slate-200'));
    element.classList.replace('border-slate-200', 'border-blue-600');
}

document.addEventListener('DOMContentLoaded', function () {
    const product = @json($product);
    const calcType = "{{ $calcType }}";
    const basePrice = parseFloat(product.price);
    
    const qtyInput = document.getElementById('qty');
    const widthInput = document.getElementById('width_cm');
    const heightInput = document.getElementById('height_cm');
    const subtotalDisplay = document.getElementById('realtime_subtotal');

    function calculate() {
        let w = parseFloat(widthInput?.value || product.default_width_cm);
        let h = parseFloat(heightInput?.value || product.default_height_cm);
        let qty = parseInt(qtyInput.value) || 1;
        let subtotal = 0;

        if (calcType === 'luas') {
            subtotal = Math.max((w * h) / 10000, 1) * basePrice * qty;
        } else {
            subtotal = basePrice * qty;
        }

        if(document.getElementById('preview_ukuran')) document.getElementById('preview_ukuran').innerText = `${w} × ${h} cm`;
        subtotalDisplay.innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(subtotal);
    }

    widthInput?.addEventListener('input', calculate);
    heightInput?.addEventListener('input', calculate);
    document.getElementById('increaseQty').onclick = () => { qtyInput.value++; calculate(); };
    document.getElementById('decreaseQty').onclick = () => { if(qtyInput.value > 1) { qtyInput.value--; calculate(); } };
    document.getElementById('buyNowBtn').onclick = () => { document.getElementById('buy_now_flag').value = "1"; document.getElementById('addToCartForm').submit(); };
    
    calculate();
});
</script>
@endpush