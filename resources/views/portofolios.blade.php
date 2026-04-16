{{-- resources/views/frontend/portofolio/index.blade.php --}}
@extends('admin.guest')

@section('title', 'Portofolio - CetakKilat')

@section('content')
<style>
    /* Reset & Base */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Transisi Halus */
    .custom-input {
        transition: all 0.2s ease;
    }
    .custom-input:focus {
        border-color: #2563eb;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    /* Portfolio Card Styling */
    .porto-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #f0f0f0;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .porto-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.1);
        border-color: #e0e7ff;
    }

    /* Image Wrapper */
    .porto-img-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 4/3;
        overflow: hidden;
        background: #f8fafc;
        flex-shrink: 0;
    }
    
    .porto-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    
    .porto-card:hover .porto-img-wrapper img {
        transform: scale(1.05);
    }

    /* Badge */
    .porto-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 5;
        background: rgba(37, 99, 235, 0.92);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        letter-spacing: 0.5px;
        backdrop-filter: blur(4px);
    }

    /* Card Body */
    .porto-body {
        padding: 14px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    
    .porto-title {
        font-size: 14px;
        font-weight: 800;
        color: #1e293b;
        line-height: 1.4;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 40px;
    }
    
    .porto-desc {
        font-size: 11px;
        color: #64748b;
        line-height: 1.5;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }
    
    .porto-date {
        font-size: 10px;
        color: #94a3b8;
        font-weight: 600;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .porto-read-time {
        display: flex;
        align-items: center;
        gap: 4px;
        padding-top: 8px;
        border-top: 1px solid #f1f5f9;
        margin-bottom: 12px;
    }
    
    .porto-read-time span {
        font-size: 9px;
        font-weight: 700;
        color: #1d4ed8;
    }
    
    .porto-button {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        padding: 10px 0;
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .porto-button:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
        color: #fff;
    }
    
    .porto-button svg {
        width: 14px;
        height: 14px;
    }

    /* Placeholder */
    .porto-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
        color: #cbd5e1;
    }

    /* Animation */
    .porto-item {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.5s ease forwards;
    }
    
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .porto-item:nth-child(1) { animation-delay: 0.05s; }
    .porto-item:nth-child(2) { animation-delay: 0.10s; }
    .porto-item:nth-child(3) { animation-delay: 0.15s; }
    .porto-item:nth-child(4) { animation-delay: 0.20s; }
    .porto-item:nth-child(5) { animation-delay: 0.25s; }
    .porto-item:nth-child(6) { animation-delay: 0.30s; }
    .porto-item:nth-child(7) { animation-delay: 0.35s; }
    .porto-item:nth-child(8) { animation-delay: 0.40s; }

    /* Filter Bar Mobile Fix */
    @media (max-width: 768px) {
        .filter-bar {
            margin: -20px 12px 0 12px;
            padding: 16px;
        }
        
        .porto-body {
            padding: 12px;
        }
        
        .porto-title {
            font-size: 13px;
            min-height: 36px;
        }
        
        .porto-button {
            padding: 8px 0;
            font-size: 11px;
        }
    }

    /* Grid Mobile Optimization */
    @media (max-width: 480px) {
        .grid-cols-2 {
            gap: 12px;
        }
        
        .porto-badge {
            font-size: 8px;
            padding: 3px 8px;
        }
    }

    .btn-primary-gradient {
        background: linear-gradient(135deg, #2563eb, #4f46e5);
    }
    
    /* Pagination Styling */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .pagination .page-item {
        list-style: none;
    }
    
    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: 10px;
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .pagination .page-link:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    
    .pagination .active .page-link {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }
    
    @media (max-width: 640px) {
        .pagination .page-link {
            min-width: 32px;
            height: 32px;
            font-size: 12px;
            padding: 0 8px;
        }
    }
</style>

{{-- HERO SECTION --}}
<div class="bg-gradient-to-br from-primary-600 to-secondary-600 py-10 md:py-12 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 md:w-40 md:h-40 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
    <div class="absolute bottom-0 left-0 w-20 h-20 bg-black/5 rounded-full translate-y-10 -translate-x-8"></div>
    
    <div class="container mx-auto px-4 max-w-6xl relative z-10">
        <h1 class="text-white text-2xl md:text-3xl font-black tracking-tight">
            Portofolio <span class="font-normal opacity-80">CetakKilat</span>
        </h1>
        <p class="text-blue-100 text-sm mt-2 max-w-lg">
            Kumpulan hasil kerja terbaik kami — setiap proyek mencerminkan kualitas dan dedikasi CetakKilat.
        </p>
    </div>
</div>


{{-- MAIN CONTENT --}}
<div class="-mt-6 md:-mt-8 relative z-30">
    <div class="container mx-auto px-3 md:px-4 max-w-6xl">
        
        {{-- FILTER BAR --}}
        <div class="bg-white rounded-xl md:rounded-2xl shadow-xl shadow-blue-900/10 p-3 md:p-4 border border-slate-100 filter-bar">
            <form action="{{ route('portofolio.index') }}" method="GET" id="searchForm">
                <div class="space-y-3 md:space-y-0 md:grid md:grid-cols-12 gap-3">
                    {{-- Search --}}
                    <div class="md:col-span-7 relative">
                        <span class="absolute left-3 md:left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari project atau hasil cetak..." 
                               class="custom-input w-full pl-9 md:pl-11 pr-3 py-2.5 md:py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none">
                    </div>

                    {{-- Sort --}}
                    <div class="md:col-span-3">
                        <select name="sort" onchange="this.form.submit()" class="custom-input w-full px-3 py-2.5 md:py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>Nama A - Z</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="md:col-span-2 flex gap-2">
                        <button type="submit" class="flex-1 btn-primary-gradient text-white font-bold py-2.5 md:py-3 rounded-xl text-sm shadow-md hover:opacity-90 transition-opacity">
                            Filter
                        </button>
                        @if(request()->hasAny(['search','sort']))
                            <a href="{{ route('portofolio.index') }}" class="flex items-center justify-center px-3 bg-slate-100 text-slate-500 rounded-xl hover:bg-slate-200 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- PORTOFOLIO GRID SECTION --}}
        <section class="min-h-screen py-6 md:py-10 pb-16 md:pb-20">
            {{-- Header Info --}}
            <div class="mb-6 md:mb-8 flex justify-between items-center flex-wrap gap-2">
                <div>
                    <h2 class="text-lg md:text-xl font-extrabold text-slate-800">
                        {{ request('search') ? 'Hasil Pencarian' : (request('category') ? 'Kategori Terpilih' : 'Semua Koleksi') }}
                    </h2>
                    <p class="text-slate-500 text-xs mt-1 font-medium">
                        Menampilkan {{ $portofolios->count() }} Produk
                    </p>
                </div>
            </div>

            {{-- GRID --}}
            @if($portofolios->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5">
                    @foreach($portofolios as $item)
                        @if($item->is_active)
                            <div class="porto-item">
                                <div class="porto-card">
                                    <div class="porto-img-wrapper">
                                        <span class="porto-badge">Project</span>
                                        @if($item->photo)
                                            <img src="{{ asset('storage/portofolios/' . $item->photo) }}" 
                                                 alt="{{ $item->title }}"
                                                 loading="lazy"
                                                 onerror="this.src='{{ asset('images/placeholder.jpg') }}'">
                                        @else
                                            <div class="porto-placeholder">
                                                <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="porto-body">
                                        <div class="porto-date">
                                            <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $item->created_at->format('d M Y') }}
                                        </div>
                                        <h3 class="porto-title">{{ $item->title }}</h3>
                                        <p class="porto-desc">{{ Str::limit(strip_tags($item->description), 60) }}</p>
                                        
                                        <div class="porto-read-time">
                                            <svg width="10" height="10" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ ceil(str_word_count(strip_tags($item->description)) / 200) }} Menit Baca</span>
                                        </div>
                                        
                                        <a href="{{ url('portofolio/' . $item->slug) }}" class="porto-button">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Detail Project
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-2xl md:rounded-3xl py-16 md:py-24 text-center border border-dashed border-slate-200">
                    <div class="bg-slate-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Project Belum Tersedia</h3>
                    <p class="text-slate-400 text-sm mt-1 mb-6 md:mb-8">Maaf, kami tidak menemukan hasil untuk kriteria pencarian Anda.</p>
                    <a href="{{ route('portofolio.index') }}" class="inline-flex px-6 md:px-8 py-2.5 md:py-3 btn-primary-gradient text-white rounded-xl font-bold text-sm shadow-lg shadow-blue-200">
                        Reset Pencarian
                    </a>
                </div>
            @endif
        </section>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle broken images
        const images = document.querySelectorAll('img');
        images.forEach(img => {
            img.addEventListener('error', function() {
                this.src = '{{ asset("images/placeholder.jpg") }}';
                this.onerror = null;
            });
        });
    });
</script>
@endsection