<div class="mb-6 animate-fade-in">
    {{-- Breadcrumb Navigation --}}
    <nav class="flex items-center space-x-2 text-[11px] font-bold uppercase tracking-widest text-neutral-400" aria-label="Breadcrumb">
        <a href="/" class="hover:text-primary-600 transition-colors">
            <i class="fas fa-home"></i>
        </a>

        @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
            @foreach($breadcrumbs as $breadcrumb)
                <span class="text-neutral-300 font-light">
                    <i class="fas fa-chevron-right text-[8px]"></i>
                </span>
                
                {{-- Solusi Error: Cek label dulu, kalau tidak ada pakai title --}}
                @php 
                    $text = $breadcrumb['label'] ?? $breadcrumb['title'] ?? 'Untitled'; 
                @endphp

                @if(isset($breadcrumb['url']) && $breadcrumb['url'] && !$loop->last)
                    <a href="{{ $breadcrumb['url'] }}" class="hover:text-primary-600 transition-colors">
                        {{ $text }}
                    </a>
                @else
                    <span class="text-neutral-400">
                        {{ $text }}
                    </span>
                @endif
            @endforeach
        @else
            <span class="text-neutral-300 font-light">
                <i class="fas fa-chevron-right text-[8px]"></i>
            </span>
            <span>Dashboard</span>
        @endif
    </nav>

    {{-- Page Header --}}
    <div class="mt-2">
        <h1 class="text-2xl md:text-3xl font-black text-neutral-900 tracking-tight leading-tight">
            @yield('page-title', 'Dashboard')
        </h1>
        @hasSection('page-description')
            <p class="mt-1 text-sm text-neutral-500 font-medium">
                @yield('page-description')
            </p>
        @endif
    </div>
</div>