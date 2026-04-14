@extends('admin.guest')

@section('title', $product->product_name . ' - CetakKilat')

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
                        $material     = $product->material;
                        $minStock     = $material->min_stock ?? 0;
                        $currentStock = $material->stock ?? 0;
                        $isStockLow   = $currentStock <= $minStock && $currentStock > 0;
                        $isStockOut   = $currentStock <= 0;
                    @endphp

                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden relative group">
                        <div class="w-full flex items-center justify-center p-6 bg-white" style="height: 380px;">
                            <img src="{{ $primaryImage ? asset('storage/' . $primaryImage->photo) : asset('images/no-image.png') }}"
                                 class="max-w-full max-h-full object-contain transition-all duration-700 group-hover:scale-105"
                                 id="mainProductImage"
                                 alt="{{ $product->product_name }}">
                        </div>

                        @if($product->is_active == 0)
                            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[4px] flex items-center justify-center">
                                <span class="bg-white text-slate-900 px-6 py-2 rounded-xl font-black uppercase tracking-tighter shadow-2xl text-xs">Tidak Aktif</span>
                            </div>
                        @endif

                        @if($isStockOut)
                            <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider shadow-lg">
                                <i class="fas fa-times-circle mr-1"></i> STOK HABIS
                            </div>
                        @elseif($isStockLow)
                            <div class="absolute top-4 right-4 bg-orange-500 text-white px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider shadow-lg">
                                <i class="fas fa-exclamation-triangle mr-1"></i> STOK MENIPIS
                            </div>
                        @endif
                    </div>

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
                                @if($calcType === 'luas')
                                <div class="flex justify-between py-2 border-b border-slate-50">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase">Sistem Harga</span>
                                    <span class="text-[11px] text-slate-900 font-black">Per m² (luas cetak)</span>
                                </div>
                                @endif
                                @if($product->default_width_cm && $product->default_height_cm && $calcType !== 'luas')
                                <div class="flex justify-between py-2 border-b border-slate-50">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase">Ukuran Default</span>
                                    <span class="text-[11px] text-slate-900 font-black">{{ $product->default_width_cm }} × {{ $product->default_height_cm }} cm</span>
                                </div>
                                @endif
                                @if($product->material && $product->material->width_cm && $product->material->height_cm && $calcType === 'stiker')
                                <div class="flex justify-between py-2 border-b border-slate-50">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase">Ukuran Material</span>
                                    <span class="text-[11px] text-slate-900 font-black">{{ $product->material->width_cm }} × {{ $product->material->height_cm }} cm</span>
                                </div>
                                @endif
                                @if($product->material && $product->material->spacing_mm && $calcType === 'stiker')
                                <div class="flex justify-between py-2 border-b border-slate-50">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase">Spacing</span>
                                    <span class="text-[11px] text-slate-900 font-black">{{ $product->material->spacing_mm }} mm</span>
                                </div>
                                @endif
                                @if($product->material && $product->material->min_stock)
                                <div class="flex justify-between py-2 border-b border-slate-50">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase">Minimal Stok</span>
                                    <span class="text-[11px] text-slate-900 font-black">{{ $product->material->min_stock }} {{ $calcType === 'luas' ? 'meter' : ($calcType === 'stiker' ? 'lembar' : 'pcs') }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Form --}}
                    <form id="addToCartForm" method="POST" action="{{ route('cart.add') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                        <input type="hidden" name="buy_now" id="buy_now_flag" value="0">
                        <input type="hidden" name="used_material_qty" id="used_material_qty" value="">
                        <input type="hidden" name="total_yield_pcs" id="total_yield_pcs" value="">

                        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 space-y-4">

                            {{-- Harga --}}
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 text-[10px] font-bold uppercase">
                                    @if($calcType === 'stiker') Harga / Lembar Material
                                    @elseif($calcType === 'luas') Harga / m²
                                    @else Harga / {{ $product->unit->unit_name ?? 'Pcs' }}
                                    @endif
                                </span>
                                <span class="text-xl font-black text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>

                            {{-- Stok Material --}}
                            @if($product->material)
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 text-[10px] font-bold uppercase">Stok Material</span>
                                <div class="text-right">
                                    <span class="text-[11px] font-black {{ $isStockOut ? 'text-red-500' : ($isStockLow ? 'text-orange-500' : 'text-emerald-600') }}">
                                        {{ $currentStock }}
                                        @if($calcType === 'luas') meter
                                        @elseif($calcType === 'stiker') lembar
                                        @else {{ $product->unit->unit_name ?? 'pcs' }}
                                        @endif
                                    </span>
                                    @if($isStockLow && !$isStockOut)
                                        <div class="text-[9px] text-orange-500 font-bold mt-1">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Stok menipis! (minimal stok: {{ $minStock }})
                                        </div>
                                    @endif
                                    @if($isStockOut)
                                        <div class="text-[9px] text-red-500 font-bold mt-1">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Stok habis, tidak dapat dipesan
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            {{-- Input Ukuran --}}
                            @if($calcType === 'luas' || $product->allow_custom_size)
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-[10px] text-slate-400 font-bold uppercase mb-1 block">Panjang (cm)</label>
                                    <input type="number" name="width_cm" id="width_cm"
                                           placeholder="P (cm)"
                                           class="w-full bg-white px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 outline-none font-bold text-sm"
                                           value="{{ $product->default_width_cm }}"
                                           step="0.1" min="0.1"
                                           {{ $isStockOut ? 'disabled' : '' }}>
                                </div>
                                <div>
                                    <label class="text-[10px] text-slate-400 font-bold uppercase mb-1 block">Lebar (cm)</label>
                                    <input type="number" name="height_cm" id="height_cm"
                                           placeholder="L (cm)"
                                           class="w-full bg-white px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 outline-none font-bold text-sm"
                                           value="{{ $product->default_height_cm }}"
                                           step="0.1" min="0.1"
                                           {{ $isStockOut ? 'disabled' : '' }}>
                                </div>
                            </div>
                            @if($calcType === 'luas')
                            <p class="text-[10px] text-slate-400 italic">
                                <i class="fas fa-info-circle mr-1 text-blue-400"></i>
                                Harga = panjang × lebar × Rp {{ number_format($product->price, 0, ',', '.') }} / m². Minimum 1 m².
                            </p>
                            @endif
                            @endif

                            {{-- Yield Preview (stiker saja) --}}
                            @if($calcType === 'stiker' && $product->material && !$isStockOut)
                            <div id="yieldPreviewBox" class="mt-3 p-4 bg-blue-50 border border-blue-100 rounded-2xl hidden">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-black text-blue-400 uppercase tracking-wider">Hasil Per Lembar</p>
                                            <p id="paperSizeLabel" class="text-xs text-blue-600 font-bold">Memuat...</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-black text-blue-700" id="yieldCount">—</p>
                                        <p class="text-[10px] text-blue-400 font-bold uppercase">pcs / lembar</p>
                                    </div>
                                </div>
                                <div class="mt-3 pt-3 border-t border-blue-100 flex items-center justify-between">
                                    <p class="text-[10px] text-slate-400">Susunan: <span id="yieldLayout" class="font-bold text-slate-600">—</span></p>
                                    <p class="text-[10px] text-slate-400">Sisa: <span id="yieldWaste" class="font-bold text-slate-600">—</span></p>
                                </div>
                                <div id="sheetInfo" class="mt-2 pt-2 border-t border-blue-100 hidden">
                                    <p class="text-[10px] text-blue-600 font-bold" id="sheetCountInfo"></p>
                                </div>
                            </div>
                            @endif

                            {{-- Pricing Card --}}
                            <div class="bg-slate-900 rounded-3xl p-6 text-white shadow-lg">
                                <div class="flex justify-between items-center mb-6 border-b border-white/10 pb-4">
                                    <div class="space-y-1">
                                        <p class="text-white/40 text-[9px] font-black uppercase">Ukuran Cetak</p>
                                        <p class="text-sm font-bold" id="preview_ukuran">
                                            @if($product->default_width_cm && $product->default_height_cm)
                                                {{ $product->default_width_cm }} × {{ $product->default_height_cm }} cm
                                            @else —
                                            @endif
                                        </p>
                                        @if($calcType === 'luas')
                                        <p class="text-white/40 text-[9px]" id="preview_luas">— m²</p>
                                        @endif
                                    </div>

                                    <div class="flex flex-col items-end gap-1">
                                        <div id="stockWarning" class="hidden text-red-400 text-[9px] font-bold text-right max-w-[200px]"></div>
                                        <div class="flex items-center bg-white/10 rounded-xl p-1 border border-white/20">
                                            <button type="button" id="decreaseQty" class="w-10 h-10 flex items-center justify-center hover:bg-white/10 rounded-lg transition-colors text-white text-lg" {{ $isStockOut ? 'disabled' : '' }}>
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" name="qty" id="qty" value="1" readonly
                                                   class="bg-transparent border-0 w-14 text-center font-black text-base text-white focus:ring-0 focus:outline-none appearance-none"
                                                   {{ $isStockOut ? 'disabled' : '' }}>
                                            <button type="button" id="increaseQty" class="w-10 h-10 flex items-center justify-center hover:bg-white/10 rounded-lg transition-colors text-white text-lg" {{ $isStockOut ? 'disabled' : '' }}>
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        {{-- Label dinamis: stiker = lembar, lainnya = pcs/unit --}}
                                        <p class="text-white/30 text-[9px]">
                                            @if($calcType === 'luas') Jumlah lembar cetak
                                            @elseif($calcType === 'stiker') Jumlah lembar
                                            @else Jumlah {{ $product->unit->unit_name ?? 'pcs' }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-end justify-between">
                                    <div>
                                        <p class="text-white/40 text-[9px] font-black uppercase mb-1">Subtotal Estimasi</p>
                                        <p class="text-2xl font-black text-blue-400" id="realtime_subtotal">Rp 0</p>
                                        <p class="text-white/30 text-[9px] mt-0.5" id="lembar_info"></p>
                                    </div>
                                    @if(!$isStockOut)
                                    <button type="submit" id="addCartBtn" class="p-3 bg-blue-600 rounded-xl hover:bg-blue-700 transition-all">
                                        <i class="fas fa-shopping-basket"></i>
                                    </button>
                                    @else
                                    <button type="button" disabled class="p-3 bg-slate-600 rounded-xl cursor-not-allowed opacity-50">
                                        <i class="fas fa-shopping-basket"></i>
                                    </button>
                                    @endif
                                </div>
                            </div>

                            @if(!$isStockOut)
                            <button type="button" id="buyNowBtn"
                                class="w-full py-4 bg-blue-600 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest hover:scale-[1.01] transition-all">
                                Beli Sekarang
                            </button>
                            @else
                            <button type="button" disabled
                                class="w-full py-4 bg-slate-400 text-white rounded-2xl font-black text-[11px] uppercase tracking-widest cursor-not-allowed opacity-50">
                                Stok Habis
                            </button>
                            @endif
                        </div>
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
            @php
                $relMaterial = $related->material;
                $relIsStockOut = $relMaterial && $relMaterial->stock <= 0;
            @endphp
            <a href="{{ route('products.show', $related->slug) }}" class="group bg-white rounded-2xl border border-slate-100 p-3 hover:shadow-lg transition-all {{ $relIsStockOut ? 'opacity-50' : '' }}">
                <div class="aspect-square rounded-xl bg-slate-50 mb-3 overflow-hidden relative">
                    @php $relImg = $related->images->where('is_primary', 1)->first() ?? $related->images->first(); @endphp
                    <img src="{{ $relImg ? asset('storage/' . $relImg->photo) : asset('images/no-image.png') }}" class="w-full h-full object-cover group-hover:scale-105 transition-all">
                    @if($relIsStockOut)
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                            <span class="text-white text-[8px] font-black uppercase bg-red-500 px-2 py-1 rounded">Habis</span>
                        </div>
                    @endif
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
    const product   = @json($product);
    const calcType  = "{{ $product->category->calc_type }}";
    const basePrice = parseFloat(product.price);

    const MAT_W     = parseFloat(product.material?.width_cm)    || 0;
    const MAT_H     = parseFloat(product.material?.height_cm)   || 0;
    const SPACING   = (parseFloat(product.material?.spacing_mm) || 0) / 10;
    const MAT_STOCK = parseFloat(product.material?.stock)       || 0;
    const MIN_STOCK = parseFloat(product.material?.min_stock)   || 0;
    const IS_STOCK_OUT = MAT_STOCK <= 0;

    const qtyInput             = document.getElementById('qty');
    const widthInput           = document.getElementById('width_cm');
    const heightInput          = document.getElementById('height_cm');
    const subtotalDisplay      = document.getElementById('realtime_subtotal');
    const yieldBox             = document.getElementById('yieldPreviewBox');
    const paperSizeLabel       = document.getElementById('paperSizeLabel');
    const previewUkuran        = document.getElementById('preview_ukuran');
    const previewLuas          = document.getElementById('preview_luas');
    const sheetInfo            = document.getElementById('sheetInfo');
    const sheetCountInfo       = document.getElementById('sheetCountInfo');
    const lembarInfo           = document.getElementById('lembar_info');
    const stockWarning         = document.getElementById('stockWarning');
    const increaseBtn          = document.getElementById('increaseQty');
    const decreaseBtn          = document.getElementById('decreaseQty');
    const submitBtn            = document.getElementById('addCartBtn');
    const buyNowBtn            = document.getElementById('buyNowBtn');
    const usedMaterialQtyInput = document.getElementById('used_material_qty');
    const totalYieldPcsInput   = document.getElementById('total_yield_pcs');

    /**
     * KONSEP QTY:
     * - stiker : qty input = jumlah LEMBAR. +/- = +/- 1 lembar.
     *            total pcs = lembar × yieldPerSheet (ditampilkan di info)
     * - luas   : qty = jumlah pcs (lembar cetak)
     * - satuan : qty = jumlah pcs/unit
     */
    let currentMaxQty        = 999999;
    let currentYieldPerSheet = 1;

    if (IS_STOCK_OUT) {
        if (widthInput)  widthInput.disabled  = true;
        if (heightInput) heightInput.disabled = true;
        if (increaseBtn) increaseBtn.disabled = true;
        if (decreaseBtn) decreaseBtn.disabled = true;
        if (submitBtn)   { submitBtn.disabled = true;  submitBtn.classList.add('opacity-50','cursor-not-allowed'); }
        if (buyNowBtn)   { buyNowBtn.disabled = true;  buyNowBtn.classList.add('opacity-50','cursor-not-allowed'); }
        return;
    }

    function hitungYield(w, h) {
        if (!w || !h || MAT_W <= 0 || MAT_H <= 0) return null;
        const fw = w + SPACING, fh = h + SPACING;
        const cols1 = Math.floor(MAT_W / fw), rows1 = Math.floor(MAT_H / fh), total1 = cols1 * rows1;
        const cols2 = Math.floor(MAT_W / fh), rows2 = Math.floor(MAT_H / fw), total2 = cols2 * rows2;
        if (total1 >= total2 && total1 > 0)
            return { total: total1, cols: cols1, rows: rows1, wasteW: (MAT_W-cols1*fw).toFixed(1), wasteH: (MAT_H-rows1*fh).toFixed(1), rotated: false };
        if (total2 > 0)
            return { total: total2, cols: cols2, rows: rows2, wasteW: (MAT_W-cols2*fh).toFixed(1), wasteH: (MAT_H-rows2*fw).toFixed(1), rotated: true };
        return null;
    }

    function setButtonsDisabled(disabled) {
        [submitBtn, buyNowBtn].forEach(btn => {
            if (!btn) return;
            btn.disabled = disabled;
            btn.classList.toggle('opacity-50', disabled);
            btn.classList.toggle('cursor-not-allowed', disabled);
        });
    }

    function updateStockUI(currentQty, maxQty) {
        if (!stockWarning) return;
        const isNearMinStock = MAT_STOCK <= MIN_STOCK && MAT_STOCK > 0;
        const unitLabel = calcType === 'stiker' ? 'lembar' : (calcType === 'luas' ? 'meter' : 'pcs');

        if (MAT_STOCK <= 0) {
            stockWarning.classList.remove('hidden');
            stockWarning.innerHTML = '⚠️ Stok material habis.';
            stockWarning.className = 'text-red-400 text-[9px] font-bold text-right max-w-[200px]';
            if (increaseBtn) increaseBtn.disabled = true;
            setButtonsDisabled(true);
        } else if (isNearMinStock) {
            stockWarning.classList.remove('hidden');
            stockWarning.innerHTML = `⚠️ Stok menipis! Tersisa ${MAT_STOCK} ${unitLabel} (min: ${MIN_STOCK})`;
            stockWarning.className = 'text-orange-400 text-[9px] font-bold text-right max-w-[200px]';
            if (increaseBtn) increaseBtn.disabled = false;
            setButtonsDisabled(false);
        } else if (currentQty >= maxQty && maxQty < 999999 && maxQty > 0) {
            stockWarning.classList.remove('hidden');
            stockWarning.innerHTML = `⚠️ Maksimal ${maxQty} ${unitLabel}`;
            stockWarning.className = 'text-red-400 text-[9px] font-bold text-right max-w-[200px]';
            if (increaseBtn) increaseBtn.disabled = true;
            setButtonsDisabled(false);
        } else {
            stockWarning.classList.add('hidden');
            if (increaseBtn) increaseBtn.disabled = false;
            setButtonsDisabled(false);
        }
    }

    function calculate() {
        let w = widthInput  ? (parseFloat(widthInput.value)  || parseFloat(product.default_width_cm)  || 0) : (parseFloat(product.default_width_cm)  || 0);
        let h = heightInput ? (parseFloat(heightInput.value) || parseFloat(product.default_height_cm) || 0) : (parseFloat(product.default_height_cm) || 0);
        let qtyVal = parseInt(qtyInput?.value) || 1;
        if (qtyVal < 1) qtyVal = 1;

        let subtotal = 0, maxQty = 999999, usedMaterial = 0, totalYieldPcs = 0;

        if (previewUkuran) previewUkuran.innerText = (w > 0 && h > 0) ? `${w} × ${h} cm` : '—';

        // ── LUAS ──────────────────────────────────────────────────────────────
        if (calcType === 'luas') {
            if (w > 0 && h > 0) {
                let luasMeter = (w * h) / 10000;
                if (luasMeter < 1) luasMeter = 1;
                if (MAT_STOCK > 0) { maxQty = Math.floor(MAT_STOCK / luasMeter); if (maxQty <= 0) maxQty = 0; }
                if (maxQty <= 0 && MAT_STOCK > 0) {
                    if (stockWarning) { stockWarning.classList.remove('hidden'); stockWarning.innerHTML = `⚠️ Butuh min ${luasMeter.toFixed(2)} m, tersisa ${MAT_STOCK} m.`; stockWarning.className = 'text-red-400 text-[9px] font-bold text-right max-w-[200px]'; }
                    setButtonsDisabled(true); subtotal = 0;
                } else {
                    if (MAT_STOCK > 0 && qtyVal > maxQty && maxQty > 0) { qtyVal = maxQty; if (qtyInput) qtyInput.value = maxQty; }
                    subtotal = luasMeter * basePrice * qtyVal;
                    usedMaterial = luasMeter * qtyVal;
                    totalYieldPcs = qtyVal;
                    if (previewLuas) previewLuas.innerText = `${luasMeter.toFixed(2)} m²`;
                    if (lembarInfo) lembarInfo.innerText = `${luasMeter.toFixed(2)} m² × ${qtyVal} pcs × Rp ${basePrice.toLocaleString('id-ID')}`;
                }
            } else {
                if (previewLuas) previewLuas.innerText = '0 m²';
                if (lembarInfo) lembarInfo.innerText = 'Masukkan ukuran panjang dan lebar';
            }
            if (yieldBox)  yieldBox.classList.add('hidden');
            if (sheetInfo) sheetInfo.classList.add('hidden');
        }

        // ── STIKER ────────────────────────────────────────────────────────────
        // qtyVal = jumlah LEMBAR yang dipesan
        else if (calcType === 'stiker') {
            if (paperSizeLabel) paperSizeLabel.innerText = MAT_W > 0 ? `${MAT_W} × ${MAT_H} cm` : 'Data material tidak tersedia';

            let jmlLembar = qtyVal; // qty IS lembar

            if (MAT_W <= 0 || MAT_H <= 0) {
                currentYieldPerSheet = 1;
                maxQty        = MAT_STOCK || 999999;
                subtotal      = jmlLembar * basePrice;
                usedMaterial  = jmlLembar;
                totalYieldPcs = jmlLembar;
                if (yieldBox) yieldBox.classList.add('hidden');

            } else if (w > MAT_W || h > MAT_H) {
                currentYieldPerSheet = 1;
                maxQty = MAT_STOCK;
                if (jmlLembar > maxQty && maxQty > 0) { jmlLembar = maxQty; if (qtyInput) qtyInput.value = jmlLembar; }
                subtotal      = jmlLembar * basePrice;
                usedMaterial  = jmlLembar;
                totalYieldPcs = jmlLembar;
                const yc = document.getElementById('yieldCount'), yl = document.getElementById('yieldLayout'), yw = document.getElementById('yieldWaste');
                if (yc) yc.innerHTML  = `1 <span class="text-[10px] font-normal">pcs/lembar</span>`;
                if (yl) yl.innerHTML  = 'Melebihi ukuran material';
                if (yw) yw.innerHTML  = '—';
                if (sheetInfo && sheetCountInfo) { sheetInfo.classList.remove('hidden'); sheetCountInfo.innerHTML = `📄 ${jmlLembar} lembar = ${totalYieldPcs} pcs`; }
                if (yieldBox) yieldBox.classList.remove('hidden');

            } else {
                const hasil = hitungYield(w, h);
                if (hasil && hasil.total > 0) {
                    currentYieldPerSheet = hasil.total;
                    maxQty = MAT_STOCK; // max lembar = stok lembar
                    if (jmlLembar > maxQty && maxQty > 0) { jmlLembar = maxQty; if (qtyInput) qtyInput.value = jmlLembar; }

                    subtotal      = jmlLembar * basePrice;           // Rp per lembar × lembar
                    usedMaterial  = jmlLembar;
                    totalYieldPcs = jmlLembar * hasil.total;          // ← TOTAL PCS yang didapat

                    const yc = document.getElementById('yieldCount'), yl = document.getElementById('yieldLayout'), yw = document.getElementById('yieldWaste');
                    if (yc) yc.innerHTML  = `${hasil.total} <span class="text-[10px] font-normal">pcs/lembar</span>`;
                    if (yl) yl.innerHTML  = `${hasil.cols} × ${hasil.rows}${hasil.rotated ? ' (Diputar 90°)' : ''}`;
                    if (yw) yw.innerHTML  = `${hasil.wasteW} × ${hasil.wasteH} cm`;
                    if (sheetInfo && sheetCountInfo) {
                        sheetInfo.classList.remove('hidden');
                        // Tampilkan: X lembar = Y pcs (total)
                        sheetCountInfo.innerHTML = `📄 ${jmlLembar} lembar = <strong>${totalYieldPcs} pcs</strong>`;
                    }
                    if (yieldBox) yieldBox.classList.remove('hidden');
                } else {
                    currentYieldPerSheet = 1;
                    maxQty        = MAT_STOCK || 999999;
                    subtotal      = jmlLembar * basePrice;
                    usedMaterial  = jmlLembar;
                    totalYieldPcs = jmlLembar;
                    if (yieldBox)  yieldBox.classList.add('hidden');
                    if (sheetInfo) sheetInfo.classList.add('hidden');
                }
            }

            // Info di pricing card: "X lembar × Rp Y = Z pcs"
            if (lembarInfo) {
                lembarInfo.innerText = jmlLembar > 0
                    ? `${jmlLembar} lembar × Rp ${basePrice.toLocaleString('id-ID')} = ${totalYieldPcs} pcs`
                    : '';
            }
        }

        // ── SATUAN ────────────────────────────────────────────────────────────
        else {
            maxQty = MAT_STOCK > 0 ? MAT_STOCK : 999999;
            if (qtyVal > maxQty) { qtyVal = maxQty; if (qtyInput) qtyInput.value = maxQty; }
            subtotal      = basePrice * qtyVal;
            usedMaterial  = qtyVal;
            totalYieldPcs = qtyVal;
            if (lembarInfo) lembarInfo.innerText = '';
            if (yieldBox)   yieldBox.classList.add('hidden');
            if (sheetInfo)  sheetInfo.classList.add('hidden');
        }

        currentMaxQty = maxQty;
        if (usedMaterialQtyInput) usedMaterialQtyInput.value = usedMaterial;
        if (totalYieldPcsInput)   totalYieldPcsInput.value   = totalYieldPcs;

        updateStockUI(parseInt(qtyInput?.value) || 1, maxQty);

        if (subtotalDisplay) {
            subtotalDisplay.innerText = new Intl.NumberFormat('id-ID', {
                style: 'currency', currency: 'IDR', minimumFractionDigits: 0, maximumFractionDigits: 0
            }).format(subtotal);
        }
    }

    if (widthInput)  { widthInput.addEventListener('input',  calculate); widthInput.addEventListener('change',  calculate); }
    if (heightInput) { heightInput.addEventListener('input', calculate); heightInput.addEventListener('change', calculate); }

    // +/- selalu naik/turun 1 (untuk stiker = 1 lembar, untuk lainnya = 1 pcs/unit)
    if (increaseBtn) {
        increaseBtn.onclick = function(e) {
            e.preventDefault();
            let cur = parseInt(qtyInput?.value) || 1;
            if (cur + 1 <= currentMaxQty) { if (qtyInput) qtyInput.value = cur + 1; calculate(); }
        };
    }
    if (decreaseBtn) {
        decreaseBtn.onclick = function(e) {
            e.preventDefault();
            let cur = parseInt(qtyInput?.value) || 1;
            if (cur - 1 >= 1) { if (qtyInput) qtyInput.value = cur - 1; calculate(); }
        };
    }

    if (buyNowBtn) {
        buyNowBtn.onclick = function(e) {
            e.preventDefault();
            if (buyNowBtn.disabled) return;
            const f = document.getElementById('buy_now_flag');
            if (f) f.value = "1";
            document.getElementById('addToCartForm')?.submit();
        };
    }

    calculate();
});
</script>
@endpush