@php
    // Deteksi paginator secara otomatis dari variabel yang umum digunakan
    $paginator = $items ?? $users ?? $data ?? null;
    $isPaginator = $paginator instanceof \Illuminate\Pagination\LengthAwarePaginator;
@endphp

@if($isPaginator && $paginator->hasPages())
<div class="mt-8 flex flex-col lg:flex-row items-center justify-between gap-6 px-2">
    <div class="order-2 lg:order-1 flex items-center gap-4">
        <div class="bg-neutral-100/50 px-4 py-2 rounded-full border border-neutral-200/60">
            <p class="text-sm text-neutral-600">
                Menampilkan <span class="font-bold text-neutral-900">{{ $paginator->firstItem() }}</span> 
                - <span class="font-bold text-neutral-900">{{ $paginator->lastItem() }}</span> 
                <span class="mx-1 text-neutral-400">dari</span> 
                <span class="font-bold text-neutral-900">{{ $paginator->total() }}</span>
            </p>
        </div>

        @if(method_exists($paginator, 'perPage'))
        <div class="hidden sm:flex items-center gap-2">
            <select onchange="window.location.href = this.value" 
                    class="bg-transparent border-none text-sm font-medium text-neutral-500 focus:ring-0 cursor-pointer hover:text-primary-600 transition-colors">
                @foreach([10, 25, 50, 100] as $size)
                    <option value="{{ $paginator->url(1) }}&perPage={{ $size }}" {{ $paginator->perPage() == $size ? 'selected' : '' }}>
                        {{ $size }} / hlm
                    </option>
                @endforeach
            </select>
        </div>
        @endif
    </div>
    
    <nav class="order-1 lg:order-2 flex items-center gap-1">
        {{-- Tombol Previous --}}
        @if($paginator->onFirstPage())
            <span class="w-10 h-10 flex items-center justify-center text-neutral-300 cursor-not-allowed">
                <i class="fas fa-chevron-left text-xs"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="w-10 h-10 flex items-center justify-center rounded-xl text-neutral-600 hover:bg-white hover:shadow-sm border border-transparent hover:border-neutral-200 transition-all duration-200 group">
                <i class="fas fa-chevron-left text-xs group-hover:-translate-x-0.5 transition-transform"></i>
            </a>
        @endif
        
        {{-- Page Numbers --}}
        <div class="flex items-center gap-1 mx-2">
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $start = max(1, $currentPage - 1); // Lebih compact (hanya 1 kiri, 1 kanan)
                $end = min($lastPage, $currentPage + 1);
            @endphp
            
            @if($start > 1)
                <a href="{{ $paginator->url(1) }}" class="w-10 h-10 flex items-center justify-center rounded-xl text-sm font-medium text-neutral-600 hover:bg-white hover:border-neutral-200 border border-transparent transition-all">1</a>
                @if($start > 2) <span class="text-neutral-400 px-1">...</span> @endif
            @endif
            
            @for($i = $start; $i <= $end; $i++)
                @if($i == $currentPage)
                    <span class="w-10 h-10 flex items-center justify-center rounded-xl bg-primary-600 text-white text-sm font-bold shadow-md shadow-primary-200 shadow-sm">
                        {{ $i }}
                    </span>
                @else
                    <a href="{{ $paginator->url($i) }}" 
                       class="w-10 h-10 flex items-center justify-center rounded-xl text-sm font-medium text-neutral-600 hover:bg-white hover:border-neutral-200 border border-transparent transition-all">
                        {{ $i }}
                    </a>
                @endif
            @endfor
            
            @if($end < $lastPage)
                @if($end < $lastPage - 1) <span class="text-neutral-400 px-1">...</span> @endif
                <a href="{{ $paginator->url($lastPage) }}" class="w-10 h-10 flex items-center justify-center rounded-xl text-sm font-medium text-neutral-600 hover:bg-white hover:border-neutral-200 border border-transparent transition-all">{{ $lastPage }}</a>
            @endif
        </div>
        
        {{-- Tombol Next --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="w-10 h-10 flex items-center justify-center rounded-xl text-neutral-600 hover:bg-white hover:shadow-sm border border-transparent hover:border-neutral-200 transition-all duration-200 group">
                <i class="fas fa-chevron-right text-xs group-hover:translate-x-0.5 transition-transform"></i>
            </a>
        @else
            <span class="w-10 h-10 flex items-center justify-center text-neutral-300 cursor-not-allowed">
                <i class="fas fa-chevron-right text-xs"></i>
            </span>
        @endif
    </nav>
</div>

@elseif($paginator && count($paginator) > 0)
    <div class="mt-6 px-4 py-3 bg-neutral-50 rounded-xl border border-neutral-100">
        <p class="text-sm text-neutral-500 italic">
            Menampilkan semua <span class="font-bold text-neutral-700">{{ count($paginator) }}</span> data (Tanpa paginasi)
        </p>
    </div>
@endif