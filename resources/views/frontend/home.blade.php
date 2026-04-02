@extends('admin.guest')

@section('title', 'PrintPro - Digital Printing & Ecommerce')

@section('content')
<section class="relative overflow-hidden text-white min-h-[90vh] md:min-h-screen flex items-center">

    {{-- ===== BACKGROUND IMAGE ===== --}}
<div class="absolute inset-0 z-0">
    <img
        src="{{ $hero->photo ? asset('storage/heros/' . $hero->photo) : asset('images/no-image.png') }}"
        alt="Hero Background"
        class="w-full h-full object-cover object-center"
    />
    <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20"></div>
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 256 256%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noise%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noise)%22/%3E%3C/svg%3E'); background-size: 128px;"></div>
</div>

    {{-- ===== CMYK DOTS ANIMATION ===== --}}
    <div class="absolute top-10 left-10 w-3 h-3 bg-printing-cyan rounded-full animate-bounce opacity-70"></div>
    <div class="absolute top-20 right-20 w-4 h-4 bg-printing-magenta rounded-full animate-pulse animation-delay-300 opacity-70"></div>
    <div class="absolute bottom-20 left-1/4 w-3.5 h-3.5 bg-printing-yellow rounded-full animate-bounce animation-delay-500 opacity-70"></div>
    <div class="absolute bottom-10 right-1/3 w-2.5 h-2.5 bg-printing-black rounded-full animate-pulse animation-delay-700 opacity-70"></div>



    {{-- ===== MAIN CONTENT ===== --}}
<div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12 py-20 md:py-28 relative z-10 w-full">
        <div class="max-w-3xl mx-auto lg:mx-0 text-left">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-md rounded-full mb-6 border border-white/20 animate-fade-in">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span class="font-medium text-sm tracking-wide text-white/90">{{ $hero->label ?? 'Digital Printing Terpercaya' }}</span>
            </div>

            {{-- Heading --}}
            <h1 class="font-display text-4xl md:text-5xl lg:text-6xl font-black mb-6 animate-fade-in-up leading-[1.1] tracking-tight">
                <span class="block text-white drop-shadow-lg">{{ $hero->headline ?? 'Solusi Cetak Profesional' }}</span>
                <span class="text-primary-600">
                    Berkualitas Tinggi
                </span>
            </h1>

            {{-- Divider --}}
            <div class="flex items-center gap-3 mb-6 animate-fade-in-up animation-delay-200">
                <div class="h-px w-12 bg-primary-400"></div>
                <div class="w-1.5 h-1.5 rounded-full bg-primary-400"></div>
                <div class="h-px w-6 bg-white/30"></div>
            </div>

            {{-- Description --}}
            <p class="text-white/80 text-base md:text-lg mb-10 leading-relaxed max-w-xl animate-fade-in-up animation-delay-200">
                {{ Str::limit(
                    $hero->subheadline ?? 'Kami menyediakan layanan digital printing terbaik untuk kebutuhan bisnis dan personal Anda.',
                    150
                ) }}
            </p>
            
            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 md:gap-4 mb-16 animate-fade-in-up animation-delay-400">
                <a href="{{ route('products.products') }}"
                    class="group inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white text-primary-700 font-bold rounded-xl hover:bg-primary-50 transition-all duration-300 shadow-xl hover:shadow-2xl hover:scale-105 text-sm md:text-base">
                    <span>Lihat Produk</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
                <a href="https://wa.me/6285810761209?text=Halo%20Admin,%20saya%20ingin%20konsultasi%20gratis%20tentang%20layanan%20digital%20printing.%0A%0ANama:%0AProduk%20yang%20dibutuhkan:%0AJumlah:%0AUkuran:%0ATerima%20kasih."
                    target="_blank"
                    class="inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-transparent text-white font-bold rounded-xl border border-white/40 hover:bg-white/10 hover:border-white/60 transition-all duration-300 backdrop-blur-sm text-sm md:text-base">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span>Konsultasi Gratis</span>
                </a>
            </div>

        </div>
    </div>
</section>

<!-- Tentang Kami Section -->
<section id="tentang-kami" class="relative overflow-hidden bg-gradient-to-br from-primary-50 via-white to-secondary-50 py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
            <!-- Teks Konten -->
            <div class="text-center lg:text-left" data-animate>
                <span class="inline-block px-3 py-1.5 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-3 md:mb-4">
                    {{ $about->label ?? 'Tentang Kami' }}
                </span>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 md:mb-6 leading-tight text-neutral-900">
                    {{ $about->headline ?? 'Digital Printing Terpercaya & Profesional' }}
                </h1>
                <p class="text-lg md:text-xl text-neutral-600 mb-6 md:mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    {{ $about->subheadline ?? 'Kami telah melayani ribuan klien dengan hasil cetak berkualitas tinggi, menggunakan teknologi modern dan tim profesional yang berpengalaman.' }}
                </p>
            </div>

            <!-- Gambar Ilustrasi -->
            <div class="relative max-w-xl mx-auto">
                <div class="relative rounded-3xl overflow-hidden shadow-xl bg-white border-0">
                    <img src="{{ $about->photo ? asset('storage/heros/' . $about->photo) : asset('images/no-image.png') }}"
                        alt="{{ $about->label }}" class="w-full h-full object-cover">
                </div>
                <div class="absolute -top-4 -right-6 bg-white/95 backdrop-blur-sm rounded-xl p-3 shadow-lg border border-gray-100 flex items-center gap-3 animate-bounce-slow z-20">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="pr-1">
                        <p class="text-sm font-bold text-gray-800 leading-tight">Kualitas Terbaik</p>
                        <p class="text-[10px] text-gray-500 font-medium italic leading-none">Garansi hasil</p>
                    </div>
                </div>
                <div class="absolute -bottom-4 -left-6 bg-white/95 backdrop-blur-sm rounded-xl p-3 shadow-lg border border-gray-100 flex items-center gap-3 animate-float z-20">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="pr-1">
                        <p class="text-sm font-bold text-gray-800 leading-tight">Cepat Sampai</p>
                        <p class="text-[10px] text-gray-500 font-medium italic leading-none">Tepat waktu</p>
                    </div>
                </div>
            </div>

            <!-- Background Pattern -->
            <div class="absolute top-0 left-0 w-full h-full opacity-5 pointer-events-none">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"100\" height=\"100\" viewBox=\"0 0 100 100\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z\" fill=\"%230075ff\" fill-opacity=\"0.4\" fill-rule=\"evenodd\"/%3E%3C/svg%3E');"></div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<style>
    .prod-section { background: #f8f7f4; }
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
    .prod-body { padding: 16px 18px 18px; display: flex; flex-direction: column; flex: 1; }
    .prod-name { font-size: 14px; font-weight: 800; color: #111; line-height: 1.35; margin-bottom: 5px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .prod-desc { font-size: 12px; color: #64748b; line-height: 1.55; margin-bottom: 12px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; flex: 1; }
    .prod-rating { display: flex; align-items: center; gap: 5px; margin-bottom: 12px; }
    .prod-stars { color: #f59e0b; font-size: 10px; letter-spacing: 1px; }
    .prod-rating-txt { font-size: 11px; color: #94a3b8; font-weight: 600; }
    .prod-price-row { display: flex; align-items: baseline; gap: 4px; margin-bottom: 14px; }
    .prod-price { font-size: 18px; font-weight: 900; color: #1d4ed8; line-height: 1; }
    .prod-unit { font-size: 11px; color: #94a3b8; font-weight: 600; }
    .prod-btn { display: flex; align-items: center; justify-content: center; gap: 7px; width: 100%; padding: 11px 0; background: #2563eb; color: #fff; border: none; border-radius: 14px; cursor: pointer; font-size: 13px; font-weight: 700; letter-spacing: .02em; text-decoration: none; transition: background .2s, transform .18s, box-shadow .2s; box-shadow: 0 4px 14px rgba(37,99,235,.25); }
    .prod-btn:hover { background: #1d4ed8; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(37,99,235,.35); color: #fff; }
    .prod-btn svg { width: 15px; height: 15px; flex-shrink: 0; }
    .prod-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f1f5f9, #e2e8f0); color: #cbd5e1; }
    .section-kicker { display: inline-flex; align-items: center; gap: 6px; background: #eff6ff; color: #2563eb; border: 1.5px solid #bfdbfe; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: .1em; padding: 5px 14px; border-radius: 999px; margin-bottom: 16px; }
    .see-all { display: inline-flex; align-items: center; gap: 8px; padding: 13px 32px; background: #fff; border: 2px solid #2563eb; color: #2563eb; border-radius: 999px; font-weight: 800; font-size: 14px; text-decoration: none; transition: all .22s ease; box-shadow: 0 2px 8px rgba(37,99,235,.08); }
    .see-all:hover { background: #2563eb; color: #fff; box-shadow: 0 8px 24px rgba(37,99,235,.28); transform: translateY(-2px); }
    .see-all svg { width: 18px; height: 18px; transition: transform .22s; }
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

<section class="prod-section py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12">
        <div class="text-center mb-12">
            <div class="flex justify-center">
            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white rounded-full shadow-lg border border-neutral-100 mb-6">
                <span class="flex w-2.5 h-2.5 bg-primary-600 rounded-full animate-pulse"></span>
                <span class="text-sm font-bold tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-600 uppercase">
                    PRODUK PILIHAN 
                </span>
            </span>
            </div>
            <h2 style="font-size:2.1rem;font-weight:900;color:#0f172a;margin-bottom:12px;line-height:1.15;">Produk <span class="text-primary-600">Unggulam</span> Kami</h2>
            <p style="font-size:16px;color:#64748b;max-width:520px;margin:0 auto;line-height:1.7;">Kualitas cetak terbaik untuk berbagai kebutuhan bisnis dan personal Anda.</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            @forelse ($products as $product)
                @php
                    $primaryImage = $product->images->where('is_primary', 1)->first();
                    $imgCount = $product->images->count();
                    // Hitung rata-rata rating, default 0 jika belum ada
                    $avgRating = $product->ratings->avg('rating') ?: 0;
                    // Hitung total ulasan
                    $totalReviews = $product->ratings->count();
                    // Bulatkan untuk tampilan bintang
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
        {{ $totalReviews }} Ulasan
    </span>                            </div>
                            <div class="prod-price-row">
                                <span class="prod-price">{{ $product->formatted_price ?? 'Rp '.number_format($product->price,0,',','.') }}</span>
                                <span class="prod-unit">/ {{ $product->unit->unit_name ?? 'pcs' }}</span>
                            </div>
                            <a href="{{ url('products/' . $product->slug) }}" class="prod-btn">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div style="width:64px;height:64px;background:#f1f5f9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                        <svg width="28" height="28" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <p style="color:#94a3b8;font-weight:600;">Belum ada produk tersedia.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-14">
            <a href="{{ route('products.products') }}" class="see-all">
                Lihat Semua Produk
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>

@php
    $setting = \App\Models\Settings::first();
    $userOrders = 0;
    $userSpent = 0;

    if(auth()->check()){
        $validStatuses = ['paid', 'processing', 'shipped', 'delivered'];
        $userOrders = \App\Models\Orders::where('user_id', auth()->user()->user_id)
                        ->whereIn('status', $validStatuses)->count();
        $userSpent = \App\Models\Orders::where('user_id', auth()->user()->user_id)
                        ->whereIn('status', $validStatuses)->sum('total');
    }

    $isQualified = ($userOrders >= ($setting->member_min_orders ?? 5) || $userSpent >= ($setting->member_min_spent ?? 500000));
@endphp
<!-- Member Section -->
<section class="py-12 md:py-16 bg-gradient-to-br from-[#1E293B] via-[#1e3a5f] to-[#1E293B] relative overflow-hidden">

    {{-- Decorative blobs --}}
    <div class="absolute top-0 left-0 w-64 h-64 bg-blue-500/10 rounded-full -translate-x-32 -translate-y-32 blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-64 h-64 bg-amber-400/10 rounded-full translate-x-32 translate-y-32 blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-400/5 rounded-full blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- Kiri: Penjelasan Member --}}
            <div>
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-400/20 border border-amber-400/30 rounded-full mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <span class="text-amber-400 text-xs font-black uppercase tracking-widest">Program Member Eksklusif</span>
                </div>

                <h2 class="text-3xl md:text-4xl font-black text-white mb-4 leading-tight">
                    Bergabung Jadi Member &<br>
                    <span class="text-amber-400">Dapatkan Keuntungan Lebih</span>
                </h2>

                <p class="text-slate-300 text-base mb-8 leading-relaxed">
                    Daftarkan diri Anda sebagai member PrintPro dan nikmati berbagai keuntungan eksklusif yang tidak tersedia untuk pengguna biasa.
                </p>

                {{-- Benefit List --}}
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-blue-500/20 border border-blue-400/30 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-bold text-sm">Harga Spesial Member</p>
                            <p class="text-slate-400 text-xs mt-0.5 leading-relaxed">Dapatkan diskon eksklusif dan harga khusus untuk setiap transaksi sebagai member terdaftar.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-emerald-500/20 border border-emerald-400/30 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.5 2C6.81 2 3 5.81 3 10.5S6.81 19 11.5 19h.5v3c4.86-2.34 8-7 8-11.5C20 5.81 16.19 2 11.5 2zm1 14.5h-2v-2h2v2zm0-4h-2c0-3.25 3-3 3-5 0-1.1-.9-2-2-2s-2 .9-2 2h-2c0-2.21 1.79-4 4-4s4 1.79 4 4c0 2.5-3 2.75-3 5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-bold text-sm">Komisi & Referral</p>
                            <p class="text-slate-400 text-xs mt-0.5 leading-relaxed">Kumpulkan poin dari setiap transaksi dan referral. Tukarkan poin dengan diskon atau saldo.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-purple-500/20 border border-purple-400/30 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-bold text-sm">Prioritas & Layanan Khusus</p>
                            <p class="text-slate-400 text-xs mt-0.5 leading-relaxed">Antrian produksi diprioritaskan dan mendapat notifikasi penawaran eksklusif lebih awal.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kanan: Card Daftar Member --}}
            <div class="flex justify-center lg:justify-end">
<div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 w-full max-w-sm">

    <div class="text-center mb-6">
        <div class="w-16 h-16 bg-amber-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-amber-400/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
            </svg>
        </div>
        <h3 class="text-white font-black text-xl">Program Member</h3>
        <p class="text-slate-400 text-sm mt-1">Dapatkan keuntungan eksklusif</p>
    </div>

    {{-- Checklist Syarat --}}
    <div class="space-y-3 mb-8">
        <div class="flex items-center gap-3">
            <div class="w-5 h-5 {{ $userOrders >= $setting->member_min_orders ? 'bg-emerald-500/20' : 'bg-white/5' }} rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-3 h-3 {{ $userOrders >= $setting->member_min_orders ? 'text-emerald-400' : 'text-slate-500' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            </div>
            <span class="text-slate-300 text-xs">Min. <b>{{ $setting->member_min_orders }} Order</b></span>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-5 h-5 {{ $userSpent >= $setting->member_min_spent ? 'bg-emerald-500/20' : 'bg-white/5' }} rounded-full flex items-center justify-center flex-shrink-0">
                <svg class="w-3 h-3 {{ $userSpent >= $setting->member_min_spent ? 'text-emerald-400' : 'text-slate-500' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
            </div>
            <span class="text-slate-300 text-xs">Atau Belanja <b>Rp {{ number_format($setting->member_min_spent, 0, ',', '.') }}</b></span>
        </div>
    </div>

    {{-- LOGIKA TOMBOL & STATUS --}}
    @auth
        @if(auth()->user()->is_member)
            {{-- 1. JIKA SUDAH JADI MEMBER --}}
            <div class="w-full py-3.5 bg-emerald-500/20 border border-emerald-400/30 rounded-2xl text-center">
                <span class="text-emerald-400 font-black text-sm flex items-center justify-center gap-2 uppercase tracking-widest">
                    ✅ Member Aktif ({{ strtoupper(auth()->user()->tier ?? 'Regular') }})
                </span>
            </div>
        @elseif(auth()->user()->member_requested_at || \App\Models\MemberRequest::where('user_id', auth()->user()->user_id)->where('status', 'pending')->exists())
            {{-- 2. JIKA SUDAH REQUEST (MENUNGGU PROSES) --}}
            <div class="w-full py-3.5 bg-amber-400/10 border border-amber-400/30 rounded-2xl text-center">
                <span class="text-amber-400 font-black text-sm flex items-center justify-center gap-2">
                    ⏳ Permintaan Sedang Diproses
                </span>
            </div>
        @else
            {{-- 3. JIKA BELUM REQUEST (TAMPILKAN TOMBOL) --}}
            <button type="button" 
                onclick="{{ $isQualified ? "document.getElementById('modalMember').classList.remove('hidden')" : "showRequirementAlert()" }}"
                class="w-full py-3.5 bg-amber-400 hover:bg-amber-300 text-white font-black rounded-2xl transition-all shadow-lg shadow-amber-400/30 hover:-translate-y-0.5 text-sm uppercase tracking-wider flex items-center justify-center gap-2">
                Daftar Jadi Member
            </button>
        @endif
    @else
        {{-- 4. JIKA BELUM LOGIN --}}
        <a href="{{ route('login') }}" class="w-full py-3.5 bg-blue-500 hover:bg-blue-400 text-white font-black rounded-2xl text-center block text-sm uppercase">
            Login Untuk Daftar
        </a>
    @endauth

</div>
            </div>

        </div>
    </div>
</section>

{{-- MODAL DAFTAR MEMBER --}}
@auth
    @if(!auth()->user()->is_member && !auth()->user()->member_requested_at)
    <div id="modalMember" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"
             onclick="document.getElementById('modalMember').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden z-10">
            <div class="bg-[#1E293B] px-8 py-7">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-400 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-black text-base uppercase tracking-widest">Daftar Member</h3>
                            <p class="text-slate-400 text-[11px] mt-0.5">Isi form untuk mengajukan permintaan</p>
                        </div>
                    </div>
                    <button onclick="document.getElementById('modalMember').classList.add('hidden')"
                        class="w-8 h-8 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </button>
                </div>
            </div>
            <form action="{{ route('member.request') }}" method="POST" class="p-8 space-y-5">
                @csrf
                <div class="bg-gray-50 rounded-2xl p-4 flex items-center gap-3 border border-gray-100">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 text-white rounded-xl flex items-center justify-center font-black text-sm flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm">{{ Auth::user()->username }}</p>
                        <p class="text-xs text-gray-400">{{ Auth::user()->useremail }}</p>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-gray-600 uppercase tracking-wider block">
                        Alasan Ingin Menjadi Member <span class="text-red-400">*</span>
                    </label>
                    <textarea name="reason" rows="4" id="reasonInput"
                        placeholder="Ceritakan alasan Anda ingin bergabung sebagai member... (min. 20 karakter)"
                        class="w-full p-4 bg-gray-50 border border-gray-200 rounded-2xl text-sm outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all resize-none">{{ old('reason') }}</textarea>
                    <p class="text-[11px] text-gray-400" id="charCount">0 / 500 karakter</p>
                </div>
                <div class="flex gap-3 pt-1">
                    <button type="button"
                        onclick="document.getElementById('modalMember').classList.add('hidden')"
                        class="flex-1 py-3 border border-gray-200 text-gray-500 font-bold rounded-2xl hover:bg-gray-50 transition-all text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 bg-[#1E293B] text-white font-black rounded-2xl hover:bg-blue-900 transition-all text-sm uppercase tracking-wider">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endauth

<!-- Portfolio Blog -->
<section class="relative py-16 md:py-24 overflow-hidden bg-gradient-to-br from-neutral-50 via-white to-neutral-50">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 right-20 w-72 h-72 bg-primary-100/40 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-secondary-100/40 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12 relative">
        <div class="text-center mb-16">
            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white rounded-full shadow-lg border border-neutral-100 mb-6">
                <span class="flex w-2.5 h-2.5 bg-primary-600 rounded-full animate-pulse"></span>
                <span class="text-sm font-bold tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-600 uppercase">
                    PORTOFOLIO 
                </span>
            </span>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-neutral-800 mb-4">
                Hasil <span class="text-primary-600">Memuaskan</span> Bagi Para Pelanggan
            </h2>
            <p class="text-neutral-600 max-w-2xl mx-auto">
                Dari desain hingga finishing, kami menyediakan layanan lengkap dengan kualitas terbaik
            </p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            @forelse($portofolios as $item)
                @if($item->is_active)
                    <div class="group bg-white rounded-2xl border border-neutral-200 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full">
                        <div class="relative w-full h-40 md:h-52 shrink-0 overflow-hidden bg-gray-100">
                            <div class="absolute top-3 left-3 z-10">
                                <span class="bg-blue-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">Project</span>
                            </div>
                            @if($item->photo)
                                <img src="{{ asset('storage/portofolios/' . $item->photo) }}" alt="{{ $item->title }}"
                                    class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4 md:p-5 flex flex-col flex-grow">
                            <div class="flex items-center gap-1 mb-2">
                                <span class="text-[10px] text-neutral-400 font-semibold uppercase tracking-tighter">
                                    📅 {{ $item->created_at->format('d M Y') }}
                                </span>
                            </div>
                            <h3 class="text-sm md:text-base font-bold text-neutral-800 mb-2 line-clamp-2 min-h-[2.5rem] md:min-h-[3rem] leading-tight">
                                {{ $item->title }}
                            </h3>
                            <p class="text-xs text-neutral-500 mb-4 line-clamp-2 min-h-[2rem]">
                                {{ strip_tags($item->description) }}
                            </p>
                            <div class="mt-auto">
                                <div class="mb-4 pt-3 border-t border-neutral-50">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-[10px] font-bold text-blue-700 italic">
                                            {{ ceil(str_word_count(strip_tags($item->description)) / 200) }} Menit Baca
                                        </span>
                                    </div>
                                </div>
                                <a href="{{ url('portofolio/' . $item->slug) }}"
                                    class="flex items-center justify-center gap-2 w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition shadow-md shadow-blue-100 group-hover:shadow-blue-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail Project
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-neutral-500">Belum ada portofolio tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Layanan Unggulan -->
<section class="py-16 bg-gradient-white">
    <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12">
        <div class="text-center mb-12">
            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white rounded-full shadow-lg border border-neutral-100 mb-6">
                <span class="flex w-2.5 h-2.5 bg-primary-600 rounded-full animate-pulse"></span>
                <span class="text-sm font-bold tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-600 uppercase">
                    LAYANAN UNGGULAN 
                </span>
            </span>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-neutral-800 mb-4">
                Solusi Printing <span class="text-primary-600">Lengkap</span> untuk Semua Kebutuhan
            </h2>
            <p class="text-neutral-600 max-w-2xl mx-auto">
                Dari desain hingga finishing, kami menyediakan layanan lengkap dengan kualitas terbaik
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($services as $service)
                @if($service->is_active)
                    <div class="flex flex-col bg-white rounded-3xl p-8 shadow-[0_4px_20px_rgba(0,0,0,0.03)] hover:shadow-[0_20px_40px_rgba(0,0,0,0.08)] transition-all duration-300 group hover:-translate-y-2 border border-slate-50 overflow-hidden">
                        <div class="absolute -top-12 -right-12 w-32 h-32 bg-slate-50 rounded-full group-hover:bg-blue-50 transition-colors duration-500"></div>
                        <div class="relative w-16 h-16 mb-8">
                            <div class="absolute inset-0 bg-gradient-to-br {{ $service->gradient_class ?? 'from-blue-500 to-indigo-600' }} rounded-2xl rotate-6 group-hover:rotate-12 transition-transform duration-500 opacity-20"></div>
                            <div class="relative w-16 h-16 bg-gradient-to-br {{ $service->gradient_class ?? 'from-blue-500 to-indigo-600' }} rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 group-hover:scale-110 transition-transform duration-500">
                                @if($service->icon)
                                    <img src="{{ asset('storage/services/' . $service->icon) }}" class="w-8 h-8 object-contain filter brightness-0 invert">
                                @else
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                @endif
                            </div>
                        </div>
                        <div class="relative flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-blue-600 transition-colors">
                                {{ $service->service_name }}
                            </h3>
                            <div class="overflow-hidden">
                                <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-3 min-h-[4.5rem] break-words">
                                    {{ $service->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section id="faq" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12">
        <div class="text-center mb-12">
            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white rounded-full shadow-lg border border-neutral-100 mb-6">
                <span class="flex w-2.5 h-2.5 bg-primary-600 rounded-full animate-pulse"></span>
                <span class="text-sm font-bold tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-600 uppercase">
                    BANTUAN & PERTANYAAN 
                </span>
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-neutral-800 mb-4">
                <span class="text-primary-600">Pertanyaan</span> yang Sering Diajukan
            </h2>
            <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                Temukan jawaban untuk pertanyaan umum seputar layanan digital printing kami.
            </p>
        </div>

        @if($faqs->count() > 0)
            <div class="max-w-3xl mx-auto">
                <div class="space-y-4" id="faq-accordion">
                    @foreach($faqs as $index => $faq)
                        <div class="faq-item bg-white rounded-xl border border-neutral-200 shadow-soft overflow-hidden transition-all duration-300 hover:shadow-dp"
                            data-faq-index="{{ $index }}">
                            <button
                                class="faq-toggle w-full px-6 py-4 text-left flex justify-between items-center hover:bg-neutral-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50"
                                aria-expanded="false" aria-controls="faq-content-{{ $index }}">
                                <span class="text-lg font-semibold text-neutral-800 pr-4">
                                    {{ $faq->question }}
                                </span>
                                <svg class="faq-arrow w-6 h-6 text-primary-600 transform transition-transform duration-300 flex-shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="faq-content-{{ $index }}"
                                class="faq-content overflow-hidden transition-all duration-300 ease-in-out"
                                style="max-height: 0;">
                                <div class="px-6 pb-4 pt-2 border-t border-neutral-100">
                                    <div class="prose prose-sm max-w-none text-neutral-600">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="max-w-3xl mx-auto text-center py-8">
                <div class="bg-neutral-50 rounded-2xl p-8 border border-neutral-200">
                    <svg class="w-12 h-12 text-neutral-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-neutral-700 mb-2">Belum ada FAQ tersedia</h3>
                    <p class="text-neutral-600 mb-4">Silakan hubungi kami langsung untuk informasi lebih lanjut.</p>
                    <a href="{{ url('/contact') }}" class="inline-flex items-center text-primary-600 font-semibold hover:text-primary-700">
                        Hubungi Kami
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showRequirementAlert() {
        Swal.fire({
            title: '<span class="text-slate-800">Syarat Belum Terpenuhi</span>',
            html: `
                <div class="text-left text-sm text-slate-600 space-y-3">
                    <p>Untuk menjadi member, Anda harus memenuhi salah satu syarat berikut:</p>
                    <div class="p-3 bg-slate-50 rounded-lg border border-slate-100">
                        <div class="flex justify-between mb-1">
                            <span>Minimal Order:</span>
                            <span class="font-bold {{ $userOrders >= $setting->member_min_orders ? 'text-emerald-500' : 'text-rose-500' }}">
                                {{ $userOrders }} / {{ $setting->member_min_orders }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Minimal Belanja:</span>
                            <span class="font-bold {{ $userSpent >= $setting->member_min_spent ? 'text-emerald-500' : 'text-rose-500' }}">
                                Rp {{ number_format($userSpent,0,',','.') }} / Rp {{ number_format($setting->member_min_spent,0,',','.') }}
                            </span>
                        </div>
                    </div>
                    <p class="text-xs italic text-slate-400">*Selesaikan pesanan Anda hingga status "Delivered" untuk menambah progres.</p>
                </div>
            `,
            icon: 'warning',
            confirmButtonText: 'Siap, Mengerti!',
            confirmButtonColor: '#fbbf24',
            borderRadius: '1.5rem',
            customClass: {
                popup: 'rounded-3xl',
            }
        });
    }
</script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const faqItems = document.querySelectorAll('.faq-item');
            let activeFaq = null;

            faqItems.forEach(item => {
                const button = item.querySelector('.faq-toggle');
                const content = item.querySelector('.faq-content');
                const arrow = button.querySelector('.faq-arrow');

                button.addEventListener('click', function () {
                    const isActive = item === activeFaq;

                    if (activeFaq && activeFaq !== item) {
                        const activeButton = activeFaq.querySelector('.faq-toggle');
                        const activeContent = activeFaq.querySelector('.faq-content');
                        const activeArrow = activeButton.querySelector('.faq-arrow');
                        activeButton.setAttribute('aria-expanded', 'false');
                        activeContent.style.maxHeight = '0';
                        activeContent.style.opacity = '0';
                        activeArrow.style.transform = 'rotate(0deg)';
                        setTimeout(() => { activeContent.style.overflow = 'hidden'; }, 150);
                    }

                    if (isActive) {
                        button.setAttribute('aria-expanded', 'false');
                        content.style.maxHeight = '0';
                        content.style.opacity = '0';
                        arrow.style.transform = 'rotate(0deg)';
                        activeFaq = null;
                        setTimeout(() => { content.style.overflow = 'hidden'; }, 150);
                        return;
                    }

                    button.setAttribute('aria-expanded', 'true');
                    content.style.overflow = 'hidden';
                    content.style.opacity = '1';
                    const contentHeight = content.scrollHeight + 20;
                    content.style.maxHeight = contentHeight + 'px';
                    arrow.style.transform = 'rotate(180deg)';
                    setTimeout(() => { content.style.overflow = 'visible'; }, 300);
                    activeFaq = item;

                    if (!isElementInViewport(item)) {
                        item.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }
                });

                button.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                    if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                        e.preventDefault();
                        const currentIndex = Array.from(faqItems).indexOf(item);
                        let nextIndex;
                        if (e.key === 'ArrowDown') {
                            nextIndex = (currentIndex + 1) % faqItems.length;
                        } else {
                            nextIndex = (currentIndex - 1 + faqItems.length) % faqItems.length;
                        }
                        faqItems[nextIndex].querySelector('.faq-toggle').focus();
                    }
                });
            });

            function isElementInViewport(el) {
                const rect = el.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            }
        });
    </script>

    <style>
        .faq-content { transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease; }
        .faq-toggle { cursor: pointer; transition: background-color 0.2s ease; }
        .faq-toggle:hover { background-color: #f8fafc; }
        .faq-toggle:focus { outline: none; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .faq-arrow { transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .prose { line-height: 1.6; }
        .prose ul { margin-top: 0.5rem; margin-bottom: 0.5rem; padding-left: 1.5rem; }
        .prose ol { margin-top: 0.5rem; margin-bottom: 0.5rem; padding-left: 1.5rem; }
        .prose li { margin-bottom: 0.25rem; }
        .prose strong { color: #1f2937; font-weight: 600; }
        .prose p { margin-bottom: 0.75rem; }
        .prose p:last-child { margin-bottom: 0; }
    </style>
@endpush