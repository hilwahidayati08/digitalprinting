@extends('layouts.app')

@section('title', 'Portofolio')
@section('page-title', 'Portofolio')

@section('content')

{{-- ===== HERO SECTION ===== --}}
<div class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-blue-600 to-blue-500 rounded-2xl mb-10 px-8 py-14 shadow-xl shadow-blue-200">
    {{-- Decorative circles --}}
    <div class="absolute -top-10 -right-10 w-56 h-56 rounded-full bg-white/10 blur-2xl"></div>
    <div class="absolute bottom-0 left-0 w-40 h-40 rounded-full bg-indigo-400/20 blur-xl"></div>
    <div class="absolute top-6 right-1/3 w-6 h-6 rounded-full bg-white/30"></div>
    <div class="absolute bottom-8 right-1/4 w-3 h-3 rounded-full bg-yellow-300/60"></div>

    <div class="relative z-10 text-center max-w-xl mx-auto">
        <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-white text-[10px] font-black uppercase tracking-widest mb-4">
            ✦ Karya Terbaik Kami
        </span>
        <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight leading-tight mb-3">
            Portofolio
        </h1>
        <p class="text-blue-100 text-sm font-medium leading-relaxed">
            Koleksi proyek dan karya terbaik yang telah kami selesaikan.<br>
            Kualitas adalah prioritas utama kami.
        </p>
    </div>
</div>

{{-- ===== FILTER & SEARCH ===== --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-8">
    <form action="{{ route('portofolio.index') }}" method="GET"
          class="flex flex-col md:flex-row gap-3 items-center justify-between">

        <div class="relative w-full md:w-80">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400 pointer-events-none">
                <i class="fas fa-search text-xs"></i>
            </span>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari portofolio..."
                   class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                          focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all
                          text-xs font-bold shadow-sm outline-none">
        </div>

        <div class="flex items-center gap-2 w-full md:w-auto">
            <select name="sort" onchange="this.form.submit()"
                    class="flex-1 md:w-44 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                           text-[11px] font-black uppercase focus:ring-4 focus:ring-blue-500/10
                           outline-none cursor-pointer shadow-sm">
                <option value="newest" {{ request('sort','newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                <option value="az"     {{ request('sort') == 'az' ? 'selected' : '' }}>A – Z</option>
                <option value="za"     {{ request('sort') == 'za' ? 'selected' : '' }}>Z – A</option>
            </select>

            <button type="submit"
                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl
                           text-[11px] font-black uppercase tracking-wider transition-all shadow-md shadow-blue-200 flex items-center gap-2">
                <i class="fas fa-filter text-xs"></i> Filter
            </button>

            @if(request()->anyFilled(['search', 'sort']))
                <a href="{{ route('portofolio.index') }}"
                   class="px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl
                          text-[11px] font-black uppercase transition-all shadow-sm flex items-center gap-2">
                    <i class="fas fa-sync-alt"></i> Reset
                </a>
            @endif
        </div>
    </form>
</div>

{{-- ===== GRID CARDS ===== --}}
@if($portofolios->isEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-24 text-center">
        <i class="fas fa-image text-5xl text-gray-200 mb-4 block"></i>
        <p class="text-gray-400 font-bold uppercase tracking-widest text-sm italic">Belum ada portofolio tersedia</p>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($portofolios as $item)
        <a href="{{ route('portfolio.show', $item->slug) }}"
           class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden
                  hover:shadow-xl hover:shadow-blue-100 hover:-translate-y-1 transition-all duration-300 cursor-pointer block">

            {{-- Thumbnail --}}
            <div class="relative overflow-hidden aspect-video bg-gray-100">
                @if($item->photo)
                    <img src="{{ asset('storage/portofolios/' . $item->photo) }}"
                         alt="{{ $item->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
                        <i class="fas fa-image text-3xl text-blue-200"></i>
                    </div>
                @endif

                {{-- Overlay on hover --}}
                <div class="absolute inset-0 bg-gradient-to-t from-blue-900/70 via-blue-900/20 to-transparent
                            opacity-0 group-hover:opacity-100 transition-opacity duration-300
                            flex items-end justify-start p-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/90 rounded-lg
                                 text-[10px] font-black uppercase text-blue-700 tracking-wider">
                        <i class="fas fa-eye text-[9px]"></i> Lihat Detail
                    </span>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-5">
                <h3 class="text-sm font-black text-gray-900 uppercase tracking-tight leading-snug mb-2
                           group-hover:text-blue-600 transition-colors line-clamp-2">
                    {{ $item->title }}
                </h3>
                <p class="text-[11px] text-gray-500 font-medium leading-relaxed line-clamp-2">
                    {{ strip_tags($item->description) }}
                </p>
            </div>

            {{-- Footer --}}
            <div class="px-5 pb-4 flex items-center justify-between">
                <span class="inline-flex items-center gap-1 px-2 py-1 bg-emerald-50 text-emerald-700
                             rounded-lg text-[9px] font-black uppercase tracking-wider border border-emerald-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Aktif
                </span>
                <span class="text-blue-500 group-hover:translate-x-1 transition-transform duration-200">
                    <i class="fas fa-arrow-right text-xs"></i>
                </span>
            </div>

        </a>
        @endforeach
    </div>

    {{-- ===== PAGINATION ===== --}}
    @if($portofolios->hasPages())
    <div class="mt-8 flex justify-center">
        <div class="inline-flex items-center gap-1 bg-white border border-gray-100 rounded-2xl shadow-sm px-4 py-3">
            {{-- Prev --}}
            @if($portofolios->onFirstPage())
                <span class="px-3 py-1.5 text-gray-300 text-xs font-black cursor-not-allowed rounded-lg">
                    <i class="fas fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $portofolios->previousPageUrl() }}"
                   class="px-3 py-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 text-xs font-black rounded-lg transition-all">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif

            {{-- Pages --}}
            @foreach($portofolios->getUrlRange(1, $portofolios->lastPage()) as $page => $url)
                @if($page == $portofolios->currentPage())
                    <span class="px-3.5 py-1.5 bg-blue-600 text-white text-xs font-black rounded-lg shadow-sm shadow-blue-200">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}"
                       class="px-3.5 py-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 text-xs font-black rounded-lg transition-all">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($portofolios->hasMorePages())
                <a href="{{ $portofolios->nextPageUrl() }}"
                   class="px-3 py-1.5 text-gray-500 hover:text-blue-600 hover:bg-blue-50 text-xs font-black rounded-lg transition-all">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="px-3 py-1.5 text-gray-300 text-xs font-black cursor-not-allowed rounded-lg">
                    <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>
    </div>
    @endif

@endif

@endsection