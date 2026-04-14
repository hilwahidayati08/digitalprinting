<style>
    .prod-card { background: #fff; border-radius: 20px; border: 1.5px solid #ebebeb; overflow: hidden; display: flex; flex-direction: column; transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease; height: 100%; }
    .prod-card:hover { transform: translateY(-6px); box-shadow: 0 20px 50px -10px rgba(0,0,0,.13); border-color: #dbeafe; }
    .prod-img-wrap { position: relative; width: 100%; aspect-ratio: 4/3; overflow: hidden; background: #f1f5f9; flex-shrink: 0; }
    .prod-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s ease; }
    .prod-card:hover .prod-img-wrap img { transform: scale(1.07); }
    .prod-img-wrap::after { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,.18) 0%, transparent 45%); pointer-events: none; opacity: 0; transition: opacity .3s ease; }
    .prod-card:hover .prod-img-wrap::after { opacity: 1; }
    .prod-badge { position: absolute; top: 12px; left: 12px; z-index: 5; background: rgba(37,99,235,.92); color: #fff; font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 999px; letter-spacing: .06em; text-transform: uppercase; backdrop-filter: blur(4px); box-shadow: 0 2px 8px rgba(37,99,235,.3); }
    .prod-img-count { position: absolute; bottom: 10px; right: 10px; z-index: 5; background: rgba(0,0,0,.5); color: #fff; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 999px; backdrop-filter: blur(4px); display: flex; align-items: center; gap: 4px; }
    .prod-wish { position: absolute; top: 10px; right: 10px; z-index: 5; width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,.88); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(6px); box-shadow: 0 2px 8px rgba(0,0,0,.08); opacity: 0; transition: opacity .2s ease, transform .2s ease; color: #94a3b8; }
    .prod-card:hover .prod-wish { opacity: 1; }
    .prod-wish:hover { transform: scale(1.12); color: #ef4444; }
    .prod-body { padding: 14px 16px 18px; display: flex; flex-direction: column; flex: 1; }
    .prod-name { font-size: 13px; font-weight: 800; color: #111; line-height: 1.35; margin-bottom: 5px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .prod-desc { font-size: 11px; color: #64748b; line-height: 1.55; margin-bottom: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; flex: 1; }
    .prod-rating { display: flex; align-items: center; gap: 5px; margin-bottom: 12px; flex-wrap: wrap; }
    .prod-stars { color: #f59e0b; font-size: 10px; letter-spacing: 1px; }
    .prod-rating-txt { font-size: 10px; color: #94a3b8; font-weight: 600; }
    .prod-price-row { display: flex; align-items: baseline; gap: 4px; margin-bottom: 14px; flex-wrap: wrap; }
    .prod-price { font-size: 16px; font-weight: 900; color: #1d4ed8; line-height: 1; }
    .prod-unit { font-size: 10px; color: #94a3b8; font-weight: 600; }
    .prod-btn { display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%; padding: 10px 0; background: #2563eb; color: #fff; border: none; border-radius: 14px; cursor: pointer; font-size: 12px; font-weight: 700; letter-spacing: .02em; text-decoration: none; transition: background .2s, transform .18s, box-shadow .2s; box-shadow: 0 4px 14px rgba(37,99,235,.25); }
    .prod-btn:hover { background: #1d4ed8; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(37,99,235,.35); color: #fff; }
    .prod-btn svg { width: 14px; height: 14px; flex-shrink: 0; }
    .prod-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); color: #cbd5e1; }
    .see-all { display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; background: #fff; border: 2px solid #2563eb; color: #2563eb; border-radius: 999px; font-weight: 800; font-size: 13px; text-decoration: none; transition: all .22s ease; box-shadow: 0 2px 8px rgba(37,99,235,.08); }
    .see-all:hover { background: #2563eb; color: #fff; box-shadow: 0 8px 24px rgba(37,99,235,.28); transform: translateY(-2px); }
    .see-all svg { width: 16px; height: 16px; transition: transform .22s; }
    .see-all:hover svg { transform: translateX(4px); }
    .prod-card-wrap { opacity: 0; transform: translateY(24px); animation: cardUp .5s ease forwards; }
    @keyframes cardUp { to { opacity:1; transform:none; } }
    .prod-card-wrap:nth-child(1){animation-delay:.05s}
    .prod-card-wrap:nth-child(2){animation-delay:.10s}
    .prod-card-wrap:nth-child(3){animation-delay:.15s}
    .prod-card-wrap:nth-child(4){animation-delay:.20s}
    .prod-card-wrap:nth-child(5){animation-delay:.25s}
    .prod-card-wrap:nth-child(6){animation-delay:.30s}
    .prod-card-wrap:nth-child(7){animation-delay:.35s}
    .prod-card-wrap:nth-child(8){animation-delay:.40s}
</style>

<section class="relative overflow-hidden bg-gradient-to-br from-primary-50 via-white to-secondary-50 py-12 md:py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 md:px-8 lg:px-12">
        <div class="text-center mb-10 md:mb-12">
            <div class="flex justify-center">
                <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white rounded-full shadow-lg border border-neutral-100 mb-6">
                    <span class="flex w-2.5 h-2.5 bg-primary-600 rounded-full animate-pulse"></span>
                    <span class="text-xs sm:text-sm font-bold tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-600 uppercase">
                        PRODUK PILIHAN
                    </span>
                </span>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-neutral-900 mb-3 leading-tight">Produk <span class="text-primary-600">Unggulan</span> Kami</h2>
            <p class="text-sm sm:text-base text-neutral-600 max-w-2xl mx-auto leading-relaxed px-4">Kualitas cetak terbaik untuk berbagai kebutuhan bisnis dan personal Anda.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
            @forelse ($products as $product)
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
                                <span class="prod-badge">{{ Str::limit($product->category->category_name, 12) }}</span>
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
                            <h3 class="prod-name">{{ Str::limit($product->product_name, 35) }}</h3>
                            <p class="prod-desc">{{ strip_tags(Str::limit($product->description, 60)) ?: 'Produk berkualitas tinggi dengan hasil cetak tajam dan warna akurat.' }}</p>
                            <div class="prod-rating">
                                <span class="prod-stars" style="color: #fbbf24;">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $fullStars)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </span>
                                <span class="prod-rating-txt">
                                    {{ number_format($avgRating, 1) }}
                                    <span style="color: #cbd5e1; margin: 0 4px;">•</span>
                                    {{ $totalReviews }}
                                </span>
                            </div>
                            <div class="prod-price-row">
                                <span class="prod-price">{{ $product->formatted_price ?? 'Rp '.number_format($product->price,0,',','.') }}</span>
                                <span class="prod-unit">/ {{ $product->unit->unit_name ?? 'pcs' }}</span>
                            </div>
                            <a href="{{ url('products/' . $product->slug) }}" class="prod-btn">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 sm:py-16 text-center">
                    <div style="width:64px;height:64px;background:#f1f5f9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                        <svg width="28" height="28" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p style="color:#94a3b8;font-weight:600;">Belum ada produk tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-10 md:mt-14">
            <a href="{{ route('products') }}" class="see-all">
                Lihat Semua Produk
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
