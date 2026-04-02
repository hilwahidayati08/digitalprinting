{{-- resources/views/frontend/products/products.blade.php --}}
@extends('admin.guest')

@section('title', 'Semua Produk - PrintPro')

@section('content')
<style>
    /* ===== HERO ===== */
    .products-hero {
        position: relative;
        background: #0b1426;
        padding: 5rem 0 4rem;
        overflow: hidden;
    }
    .products-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 20% 50%, rgba(37,99,235,0.15) 0%, transparent 50%),
                          radial-gradient(circle at 80% 20%, rgba(99,102,241,0.1) 0%, transparent 40%);
    }
    .products-hero::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(37,99,235,0.5), transparent);
    }

    /* ===== PRODUCT CARDS ===== */
    .prod-card {
        background: #fff;
        border-radius: 20px;
        border: 1.5px solid #ebebeb;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
        height: 100%;
    }
    .prod-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 50px -10px rgba(0,0,0,.13);
        border-color: #dbeafe;
    }
    .prod-img-wrap {
        position: relative;
        width: 100%;
        aspect-ratio: 4/3;
        overflow: hidden;
        background: #f1f5f9;
        flex-shrink: 0;
    }
    .prod-img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
    }
    .prod-card:hover .prod-img-wrap img { transform: scale(1.07); }
    .prod-img-wrap::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,.18) 0%, transparent 45%);
        pointer-events: none; opacity: 0;
        transition: opacity .3s ease;
    }
    .prod-card:hover .prod-img-wrap::after { opacity: 1; }
    .prod-badge {
        position: absolute; top: 12px; left: 12px; z-index: 5;
        background: rgba(37,99,235,.92); color: #fff;
        font-size: 10px; font-weight: 800;
        padding: 4px 10px; border-radius: 999px;
        text-transform: uppercase; backdrop-filter: blur(4px);
        box-shadow: 0 2px 8px rgba(37,99,235,.3);
    }
    .prod-img-count {
        position: absolute; bottom: 10px; right: 10px; z-index: 5;
        background: rgba(0,0,0,.5); color: #fff;
        font-size: 10px; font-weight: 700;
        padding: 3px 8px; border-radius: 999px;
        backdrop-filter: blur(4px);
        display: flex; align-items: center; gap: 4px;
    }
    .prod-body { padding: 16px 18px 18px; display: flex; flex-direction: column; flex: 1; }
    .prod-name {
        font-size: 14px; font-weight: 800; color: #111;
        line-height: 1.35; margin-bottom: 5px;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden;
    }
    .prod-desc {
        font-size: 12px; color: #64748b; line-height: 1.55;
        margin-bottom: 12px;
        display: -webkit-box; -webkit-line-clamp: 2;
        -webkit-box-orient: vertical; overflow: hidden; flex: 1;
    }
    .prod-rating { display: flex; align-items: center; gap: 5px; margin-bottom: 12px; }
    .prod-stars { color: #f59e0b; font-size: 10px; letter-spacing: 1px; }
    .prod-rating-txt { font-size: 11px; color: #94a3b8; font-weight: 600; }
    .prod-price-row { display: flex; align-items: baseline; gap: 4px; margin-bottom: 14px; }
    .prod-price { font-size: 18px; font-weight: 900; color: #1d4ed8; line-height: 1; }
    .prod-unit { font-size: 11px; color: #94a3b8; font-weight: 600; }
    .prod-btn {
        display: flex; align-items: center; justify-content: center; gap: 7px;
        width: 100%; padding: 11px 0;
        background: #2563eb; color: #fff !important;
        border-radius: 14px; font-size: 13px; font-weight: 700;
        text-decoration: none;
        transition: background .2s, transform .18s, box-shadow .2s;
        box-shadow: 0 4px 14px rgba(37,99,235,.25);
    }
    .prod-btn:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(37,99,235,.35);
        color: #fff !important;
    }
    .prod-placeholder {
        width: 100%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        color: #cbd5e1;
    }

    /* ===== FILTER ===== */
    .filter-input, .filter-select {
        width: 100%;
        padding: 0.75rem 1rem;
        background: #f8f7f4;
        border: 1.5px solid #e5e7eb;
        border-radius: 14px;
        font-size: 14px;
        color: #374151;
        transition: all 0.2s;
        appearance: none;
    }
    .filter-input:focus, .filter-select:focus {
        outline: none;
        border-color: #2563eb;
        background: white;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.1);
    }
    .filter-input::placeholder { color: #9ca3af; }

    /* ===== ANIMATION ===== */
    .prod-card-wrap {
        opacity: 0;
        transform: translateY(24px);
        animation: cardUp .5s ease forwards;
    }
    @keyframes cardUp { to { opacity: 1; transform: none; } }
    .prod-card-wrap:nth-child(1){animation-delay:.04s}
    .prod-card-wrap:nth-child(2){animation-delay:.08s}
    .prod-card-wrap:nth-child(3){animation-delay:.12s}
    .prod-card-wrap:nth-child(4){animation-delay:.16s}
    .prod-card-wrap:nth-child(5){animation-delay:.20s}
    .prod-card-wrap:nth-child(6){animation-delay:.24s}
    .prod-card-wrap:nth-child(7){animation-delay:.28s}
    .prod-card-wrap:nth-child(8){animation-delay:.32s}
    .prod-card-wrap:nth-child(9){animation-delay:.36s}
    .prod-card-wrap:nth-child(10){animation-delay:.40s}
    .prod-card-wrap:nth-child(11){animation-delay:.44s}
    .prod-card-wrap:nth-child(12){animation-delay:.48s}
</style>

{{-- ===== HERO ===== --}}
<section class="products-hero">
    <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12 relative z-10">
        <div class="max-w-2xl">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-500/15 border border-blue-500/30 rounded-full mb-5">
                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full animate-pulse"></span>
                <span class="text-blue-300 text-xs font-bold uppercase tracking-widest">Koleksi Produk</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white mb-4 leading-tight tracking-tight">
                Semua Produk <span class="text-blue-400">PrintPro</span>
            </h1>
            <p class="text-blue-200/70 text-base leading-relaxed">
                Solusi cetak digital terbaik untuk kebutuhan bisnis dan personal Anda — dari banner hingga kartu nama.
            </p>
        </div>
    </div>
</section>

{{-- ===== MAIN CONTENT ===== --}}
<section class="bg-[#f8f7f4] py-12 md:py-16">
    <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12">

        {{-- ===== FILTER BAR ===== --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 mb-10">
            <form action="{{ route('products.products') }}" method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3">

                    {{-- Search --}}
                    <div class="lg:col-span-5 relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama produk..."
                            class="filter-input pl-10">
                    </div>

                    {{-- Kategori --}}
                    <div class="lg:col-span-3 relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"/>
                        </svg>
                        <select name="category" class="filter-select pl-10">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}"
                                    {{ request('category') == $category->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sort --}}
                    <div class="lg:col-span-2 relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9M3 12h5m10 4l-4 4m0 0l-4-4m4 4V8"/>
                        </svg>
                        <select name="sort" class="filter-select pl-10">
                            <option value="newest" {{ request('sort','newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        </select>
                    </div>

                    {{-- Tombol --}}
                    <div class="lg:col-span-2 flex gap-2">
                        <button type="submit"
                            class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-[14px] transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                            </svg>
                            Filter
                        </button>
                        @if(request()->hasAny(['search','category','sort']))
                        <a href="{{ route('products.products') }}"
                            class="flex items-center justify-center w-11 bg-gray-100 hover:bg-gray-200 text-gray-500 rounded-[14px] transition-all" title="Reset">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- ===== INFO BAR ===== --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-black text-gray-900">
                    @if(request('search'))
                        Hasil pencarian "<span class="text-blue-600">{{ request('search') }}</span>"
                    @elseif(request('category'))
                        Kategori: <span class="text-blue-600">{{ $categories->firstWhere('category_id', request('category'))?->category_name ?? '' }}</span>
                    @else
                        Koleksi Lengkap
                    @endif
                </h2>
                <p class="text-gray-400 text-sm mt-1">Menampilkan {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk</p>
            </div>
            <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-gray-100 shadow-sm">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                <span class="text-gray-600 font-bold text-sm">{{ $products->total() }} Produk Tersedia</span>
            </div>
        </div>

        {{-- ===== GRID PRODUK ===== --}}
        @if($products->count() > 0)
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach ($products as $product)
                    @php
                        $primaryImage = $product->images->where('is_primary', 1)->first();
                        $imgCount = $product->images->count();
                        $avgRating = $product->ratings->avg('rating') ?: 0;
                        $totalReviews = $product->ratings->count();
                        $fullStars = floor($avgRating);
                    @endphp
                    <div class="prod-card-wrap">
                        <div class="prod-card">
                            <div class="prod-img-wrap">
                                @if ($product->category)
                                    <span class="prod-badge">{{ $product->category->category_name }}</span>
                                @endif
                                @if($imgCount > 1)
                                    <div class="prod-img-count">
                                        <svg width="10" height="10" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $imgCount }}
                                    </div>
                                @endif

                                @if ($primaryImage)
                                    <img src="{{ asset('storage/' . $primaryImage->photo) }}" alt="{{ $product->product_name }}" loading="lazy">
                                @elseif ($product->photo)
                                    <img src="{{ asset('storage/products/' . $product->photo) }}" alt="{{ $product->product_name }}" loading="lazy">
                                @else
                                    <div class="prod-placeholder">
                                        <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="prod-body">
                                <h3 class="prod-name">{{ $product->product_name }}</h3>
                                <p class="prod-desc">{{ strip_tags($product->description) ?: 'Produk berkualitas tinggi dengan hasil cetak tajam dan warna akurat.' }}</p>

                                <div class="prod-rating">
                                    <span class="prod-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            {{ $i <= $fullStars ? '★' : '☆' }}
                                        @endfor
                                    </span>
                                    <span class="prod-rating-txt">
                                        {{ number_format($avgRating, 1) }}
                                        <span style="color:#cbd5e1;margin:0 3px;">•</span>
                                        {{ $totalReviews }} Ulasan
                                    </span>
                                </div>

                                <div class="prod-price-row">
                                    <span class="prod-price">Rp {{ number_format($product->price,0,',','.') }}</span>
                                    <span class="prod-unit">/ {{ $product->unit->unit_name ?? 'pcs' }}</span>
                                </div>

                                <a href="{{ route('products.show', $product->slug) }}" class="prod-btn">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-14 flex justify-center">
                {{ $products->withQueryString()->links() }}
            </div>

        @else
            <div class="text-center py-24 bg-white rounded-2xl border border-dashed border-gray-200">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-700 mb-1">Produk Tidak Ditemukan</h3>
                <p class="text-gray-400 text-sm mb-6">Coba gunakan kata kunci atau kategori yang berbeda.</p>
                <a href="{{ route('products.products') }}"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-all">
                    Lihat Semua Produk
                </a>
            </div>
        @endif

    </div>
</section>
@endsection