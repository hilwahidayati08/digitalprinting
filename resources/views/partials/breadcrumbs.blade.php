<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-neutral-500 hover:text-primary-600 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
                Beranda
            </a>
        </li>
        
        @if(isset($breadcrumbs))
            @foreach($breadcrumbs as $breadcrumb)
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        @if($loop->last)
                            <span class="ml-1 text-sm font-medium text-primary-600 md:ml-2">
                                {{ $breadcrumb['label'] }}
                            </span>
                        @else
                            <a href="{{ $breadcrumb['url'] }}" 
                               class="ml-1 text-sm font-medium text-neutral-500 hover:text-primary-600 transition-colors md:ml-2">
                                {{ $breadcrumb['label'] }}
                            </a>
                        @endif
                    </div>
                </li>
            @endforeach
        @endif
        
        <!-- Dynamic Breadcrumbs -->
        @yield('breadcrumbs-dynamic')
    </ol>
</nav>

<!-- Example usage in a page:
@section('breadcrumbs-dynamic')
    <li>
        <div class="flex items-center">
            <svg class="w-6 h-6 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <a href="{{ route('products') }}" class="ml-1 text-sm font-medium text-neutral-500 hover:text-primary-600 transition-colors md:ml-2">
                Produk
            </a>
        </div>
    </li>
    <li aria-current="page">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-neutral-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <span class="ml-1 text-sm font-medium text-primary-600 md:ml-2">
                Kartu Nama
            </span>
        </div>
    </li>
@endsection
-->