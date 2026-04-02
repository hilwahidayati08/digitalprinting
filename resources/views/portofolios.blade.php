{{-- resources/views/frontend/portofolio/index.blade.php --}}
@extends('admin.guest')

@section('title', 'Portofolio - PrintPro')

@section('content')
<style>
/* =============================================
   HERO SECTION — Konsisten dengan Products Page
   ============================================= */
.hero-portfolio {
    background: #1e3a8a;
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.hero-portfolio::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    border-radius: 50%;
}

.hero-portfolio::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -5%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
    border-radius: 50%;
}

.hero-content {
    position: relative;
    z-index: 10;
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
    color: white;
}

/* =============================================
   SECTION KICKER — Konsisten
   ============================================= */
.section-kicker {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #eff6ff;
    color: #2563eb;
    border: 1.5px solid #bfdbfe;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .1em;
    padding: 5px 14px;
    border-radius: 999px;
    margin-bottom: 16px;
}

/* =============================================
   PORTFOLIO SECTION — Background sama dengan Products
   ============================================= */
.portfolio-section {
    background: #f8f7f4;
    padding: 4rem 0;
}

/* =============================================
   FILTER WRAPPER — Konsisten dengan Products
   ============================================= */
.filter-wrapper {
    background: white;
    border-radius: 2rem;
    padding: 2rem;
    box-shadow: 0 20px 40px -15px rgba(0,0,0,0.1);
    border: 1px solid #ebebeb;
    margin-bottom: 3rem;
}

.filter-input {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    background: #f8f7f4;
    border: 1.5px solid #ebebeb;
    border-radius: 1rem;
    font-size: 0.95rem;
    transition: all 0.2s ease;
}

.filter-input:focus {
    outline: none;
    border-color: #2563eb;
    background: white;
    box-shadow: 0 0 0 4px rgba(37,99,235,0.1);
}

.filter-select {
    appearance: none;
    width: 100%;
    padding: 1rem 2.5rem 1rem 1.25rem;
    background: #f8f7f4 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E") no-repeat;
    background-position: right 1.25rem center;
    background-size: 1.25rem;
    border: 1.5px solid #ebebeb;
    border-radius: 1rem;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.2s ease;
    cursor: pointer;
}

.filter-select:focus {
    outline: none;
    border-color: #2563eb;
    background-color: white;
}

.filter-btn {
    width: 100%;
    background: #2563eb;
    color: white;
    padding: 1rem;
    border: none;
    border-radius: 1rem;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 14px rgba(37,99,235,.25);
}

.filter-btn:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(37,99,235,.35);
}

/* =============================================
   PORTFOLIO CARD — Konsisten dengan prod-card
   ============================================= */
.porto-card {
    background: #fff;
    border-radius: 20px;
    border: 1.5px solid #ebebeb;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
    height: 100%;
}

.porto-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px -10px rgba(0,0,0,.13);
    border-color: #dbeafe;
}

.porto-img-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 4/3;
    overflow: hidden;
    background: #f1f5f9;
    flex-shrink: 0;
}

.porto-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .4s ease;
}

.porto-card:hover .porto-img-wrap img {
    transform: scale(1.07);
}

.porto-img-wrap::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,.25) 0%, transparent 50%);
    pointer-events: none;
    opacity: 0;
    transition: opacity .3s ease;
}

.porto-card:hover .porto-img-wrap::after {
    opacity: 1;
}

/* Badge "Project" sama dengan prod-badge */
.porto-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    z-index: 5;
    background: rgba(37,99,235,.92);
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 999px;
    letter-spacing: .06em;
    text-transform: uppercase;
    backdrop-filter: blur(4px);
    box-shadow: 0 2px 8px rgba(37,99,235,.3);
}

/* Overlay "quick view" saat hover — tambahan eksklusif porto */
.porto-overlay {
    position: absolute;
    inset: 0;
    background: rgba(30, 58, 138, 0.55);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity .3s ease;
    z-index: 6;
}

.porto-card:hover .porto-overlay {
    opacity: 1;
}

.porto-overlay-btn {
    background: white;
    color: #1d4ed8;
    border: none;
    border-radius: 999px;
    padding: 10px 22px;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .04em;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 6px;
    transform: translateY(10px);
    transition: transform .3s ease;
    text-decoration: none;
    box-shadow: 0 8px 24px rgba(0,0,0,.15);
}

.porto-card:hover .porto-overlay-btn {
    transform: translateY(0);
}

/* Body card */
.porto-body {
    padding: 16px 18px 18px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.porto-date {
    font-size: 10px;
    color: #94a3b8;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 6px;
}

.porto-title {
    font-size: 14px;
    font-weight: 800;
    color: #111;
    line-height: 1.35;
    margin-bottom: 6px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.4rem;
}

.porto-desc {
    font-size: 12px;
    color: #64748b;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2rem;
    margin-bottom: 14px;
    flex: 1;
}

.porto-meta {
    display: flex;
    align-items: center;
    gap: 4px;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
    margin-bottom: 12px;
}

.porto-read {
    font-size: 10px;
    font-weight: 700;
    color: #2563eb;
    font-style: italic;
}

/* CTA button — sama persis dengan prod-btn */
.porto-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    padding: 11px 0;
    background: #2563eb;
    color: #fff;
    border: none;
    border-radius: 14px;
    cursor: pointer;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: .02em;
    text-decoration: none;
    transition: background .2s, transform .18s, box-shadow .2s;
    box-shadow: 0 4px 14px rgba(37,99,235,.25);
}

.porto-btn:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(37,99,235,.35);
    color: #fff;
}

/* =============================================
   CARD ANIMATION — Konsisten dengan Products
   ============================================= */
.porto-card-wrap {
    opacity: 0;
    transform: translateY(24px);
    animation: cardUp .5s ease forwards;
}

@keyframes cardUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.porto-card-wrap:nth-child(1){animation-delay:.05s}
.porto-card-wrap:nth-child(2){animation-delay:.10s}
.porto-card-wrap:nth-child(3){animation-delay:.15s}
.porto-card-wrap:nth-child(4){animation-delay:.20s}
.porto-card-wrap:nth-child(5){animation-delay:.25s}
.porto-card-wrap:nth-child(6){animation-delay:.30s}
.porto-card-wrap:nth-child(7){animation-delay:.35s}
.porto-card-wrap:nth-child(8){animation-delay:.40s}
.porto-card-wrap:nth-child(9){animation-delay:.45s}
.porto-card-wrap:nth-child(10){animation-delay:.50s}
.porto-card-wrap:nth-child(11){animation-delay:.55s}
.porto-card-wrap:nth-child(12){animation-delay:.60s}

/* =============================================
   EMPTY STATE
   ============================================= */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    border: 1.5px dashed #dbeafe;
}
</style>

{{-- Hero Section — Konsisten dengan Products Page --}}
<section class="hero-portfolio">
    <div class="container mx-auto px-8 lg:px-20">
        <div class="hero-content">
            <h1 class="text-4xl md:text-5xl font-black mb-4 tracking-tight">
                Portofolio
            </h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto font-medium">
                Kumpulan hasil kerja terbaik kami — dari desain hingga finishing, setiap proyek mencerminkan kualitas dan dedikasi PrintPro.
            </p>
        </div>
    </div>
</section>

{{-- Portfolio Section --}}
<section class="portfolio-section">
    <div class="container mx-auto px-8 lg:px-20">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 mb-12">
            <div class="max-w-2xl">
                <span class="section-kicker">
                    <i class="fas fa-images text-[10px]"></i> SEMUA PORTOFOLIO
                </span>
                <h2 style="font-size:2.5rem; font-weight:900; color:#0b1426; margin-bottom:16px; line-height:1.1;">
                    Hasil Karya PrintPro
                </h2>
                <p style="font-size:16px; color:#64748b; line-height:1.7;">
                    Lebih dari sekadar cetakan — setiap proyek adalah wujud kepercayaan pelanggan kami.
                </p>
            </div>

            <div class="bg-white px-6 py-3 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-3">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-gray-600 font-bold text-sm">{{ $portofolios->total() }} Project Selesai</span>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="filter-wrapper">
            <form action="{{ route('portofolio.index') }}" method="GET" id="searchForm">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

                    {{-- Search --}}
                    <div class="lg:col-span-6">
                        <div class="relative">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari project..."
                                class="filter-input">
                            <i class="fas fa-search absolute left-4 top-4 text-gray-400"></i>
                        </div>
                    </div>

                    {{-- Sort --}}
                    <div class="lg:col-span-4">
                        <select name="sort" class="filter-select">
                            <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>
                                Terbaru
                            </option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                Terlama
                            </option>
                            <option value="az" {{ request('sort') == 'az' ? 'selected' : '' }}>
                                A – Z
                            </option>
                            <option value="za" {{ request('sort') == 'za' ? 'selected' : '' }}>
                                Z – A
                            </option>
                        </select>
                    </div>

                    {{-- Submit --}}
                    <div class="lg:col-span-2">
                        <button type="submit" class="filter-btn">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Portfolio Grid --}}
        @if($portofolios->count() > 0)
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                @foreach ($portofolios as $item)
                    @if($item->is_active)
                        <div class="porto-card-wrap">
                            <div class="porto-card">

                                {{-- Image --}}
                                <div class="porto-img-wrap">
                                    <span class="porto-badge">Project</span>

                                    @if($item->photo)
                                        <img
                                            src="{{ asset('storage/portofolios/' . $item->photo) }}"
                                            alt="{{ $item->title }}"
                                            loading="lazy">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-300">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif

                                    {{-- Hover overlay --}}
                                    <div class="porto-overlay">
                                        <a href="{{ url('portofolio/' . $item->slug) }}" class="porto-overlay-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Lihat Project
                                        </a>
                                    </div>
                                </div>

                                {{-- Body --}}
                                <div class="porto-body">
                                    <p class="porto-date">
                                        📅 {{ $item->created_at->format('d M Y') }}
                                    </p>
                                    <h3 class="porto-title">{{ $item->title }}</h3>
                                    <p class="porto-desc">{{ strip_tags($item->description) }}</p>

                                    <div class="porto-meta">
                                        <svg class="w-3 h-3 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="porto-read">
                                            {{ ceil(str_word_count(strip_tags($item->description)) / 200) }} Menit Baca
                                        </span>
                                    </div>

                                    <a href="{{ url('portofolio/' . $item->slug) }}" class="porto-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail Project
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Pagination — Konsisten --}}
            @if($portofolios->hasPages())
                <div class="mt-20 flex justify-center">
                    {{ $portofolios->withQueryString()->links() }}
                </div>
            @endif

        @else
            <div class="empty-state">
                <i class="fas fa-folder-open text-5xl text-blue-200 mb-4"></i>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Portofolio</h3>
                <p class="text-gray-400 text-sm">
                    @if(request('search'))
                        Tidak ada project yang cocok dengan "<strong>{{ request('search') }}</strong>".
                    @else
                        Portofolio akan segera ditampilkan di sini.
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ route('portofolio.index') }}"
                        class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700 transition">
                        <i class="fas fa-times-circle"></i> Reset Pencarian
                    </a>
                @endif
            </div>
        @endif

    </div>
</section>
@endsection

@push('scripts')
<script>
// Auto-submit saat sort berubah
document.querySelector('select[name="sort"]')?.addEventListener('change', function () {
    document.getElementById('searchForm').submit();
});

// Debounce search input (500ms) — sama dengan products page
let searchTimeout;
document.querySelector('input[name="search"]')?.addEventListener('input', function () {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        document.getElementById('searchForm').submit();
    }, 500);
});
</script>
@endpush