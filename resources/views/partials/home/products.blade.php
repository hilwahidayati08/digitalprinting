<section class="relative overflow-hidden bg-gradient-to-br from-primary-50 via-white to-secondary-50 py-12 md:py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 md:px-8 lg:px-12">
        <div class="text-center mb-10 md:mb-12">
            <div class="flex justify-center">
                <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white rounded-full shadow-lg border border-neutral-100 mb-6">
                    <span class="flex w-2.5 h-2.5 bg-primary-600 rounded-full animate-pulse"></span>
                    <span class="text-xs sm:text-sm font-bold tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-600 uppercase">PRODUK PILIHAN</span>
                </span>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-neutral-900 mb-3 leading-tight">Produk <span class="text-primary-600">Terlaris</span> Kami</h2>
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
                    $price = $product->formatted_price ?? 'Rp '.number_format($product->price,0,',','.');
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
                            
                            {{-- RATING DENGAN SVG BINTANG --}}
                            <div class="flex items-center gap-2 mt-1 mb-2">
                                <div class="flex items-center gap-0.5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $fullStars)
                                            <svg class="w-3.5 h-3.5 text-yellow-400 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @else
                                            <svg class="w-3.5 h-3.5 text-gray-300 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-xs font-semibold text-gray-700">{{ number_format($avgRating, 1) }}</span>
                                <span class="text-xs text-gray-400">• {{ $totalReviews }} ulasan</span>
                            </div>

                            <p class="prod-desc">{{ strip_tags(Str::limit($product->description, 60)) ?: 'Produk berkualitas tinggi dengan hasil cetak tajam dan warna akurat.' }}</p>
                            
                            <div class="prod-price-row">
                                <span class="prod-price">{{ $price }}</span>
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
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg width="28" height="28" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p class="text-slate-500 font-semibold">Belum ada produk tersedia.</p>
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