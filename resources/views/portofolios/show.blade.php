@extends('admin.guest')

@section('content')
<div class="bg-white min-h-screen font-sans text-neutral-800">
    
    <header class="bg-white pt-12 pb-12 md:pt-20 md:pb-20 border-b border-neutral-50">
        <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12">
            <div class="flex flex-col md:flex-row items-center gap-12 lg:gap-20">
                
                <div class="w-full md:w-1/2 order-2 md:order-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1 mb-6 rounded-full bg-primary-50 border border-primary-100">
                        <span class="w-2 h-2 rounded-full bg-primary-600"></span>
                        <span class="text-[10px] font-bold tracking-widest text-primary-700 uppercase">Project Detail</span>
                    </div>
                    
                    <h1 class="text-3xl md:text-5xl font-black text-neutral-900 leading-[1.1] mb-6 tracking-tight">
                        {{ $portfolio->title }}
                    </h1>
                    
                    <p class="text-lg text-neutral-500 leading-relaxed">
                        {{ $portfolio->description }}
                    </p>

                    <div class="hidden md:flex items-center gap-8 mt-10">
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-neutral-400 tracking-wider mb-1">Kategori</span>
                            <span class="text-sm font-bold text-neutral-900">Digital Printing</span>
                        </div>
                        <div class="w-[1px] h-8 bg-neutral-200"></div>
                        <div>
                            <span class="block text-[10px] uppercase font-bold text-neutral-400 tracking-wider mb-1">Tahun</span>
                            <span class="text-sm font-bold text-neutral-900">{{ $portfolio->created_at->format('Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/2 order-1 md:order-2">
                    <div class="relative aspect-[4/3] md:aspect-square lg:aspect-[4/3] rounded-[2.5rem] overflow-hidden shadow-2xl shadow-neutral-200/60 group">
                        <img src="{{ $portfolio->photo ? asset('storage/portofolios/' . $portfolio->photo) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=800&q=80' }}" 
                             alt="{{ $portfolio->title }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-[2.5rem]"></div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <section class="py-20 bg-neutral-50/30">
        <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                
                <div class="lg:col-span-8">
                    <article class="prose prose-neutral max-w-none">
                        <h2 class="text-2xl font-bold text-neutral-900 mb-8 flex items-center gap-3">
                            <span class="w-8 h-[2px] bg-primary-600"></span>
                            Deskripsi Lengkap
                        </h2>
                        <div class="text-neutral-600 leading-relaxed space-y-6 text-lg">
                            {!! nl2br(e($portfolio->description)) !!}
                        </div>
                    </article>

                    <div class="mt-16 p-10 bg-neutral-900 rounded-[2.5rem] text-white flex flex-col sm:flex-row items-center justify-between gap-6 overflow-hidden relative">
                        <div class="relative z-10">
                            <h3 class="text-2xl font-bold mb-2">Tertarik dengan project ini?</h3>
                            <p class="text-neutral-400">Dapatkan penawaran harga terbaik untuk instansi Anda.</p>
                        </div>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->whatsapp) }}?text={{ urlencode('Halo Tim Kami, saya tertarik dengan project ' . $portfolio->title . '. Berikut link detail projectnya: ' . url()->current()) }}" 
                            target="_blank" 
                            class="relative z-10 px-8 py-4 bg-primary-600 text-white font-bold rounded-2xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-600/20 active:scale-95">
                                Hubungi Tim Kami
                            </a>
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-primary-600/10 rounded-full blur-3xl"></div>
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <aside class="sticky top-28">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-neutral-400">Project Lainnya</h3>
                            <a href="{{ route('portofolio.index') }}" class="text-xs font-bold text-primary-600 hover:underline">Lihat Semua</a>
                        </div>
                        
                        <div class="space-y-6">
                            @forelse($relatedPortfolios as $related)
                            <a href="{{ route('portfolio.show', $related->slug) }}" class="group flex items-center gap-4 p-3 rounded-2xl hover:bg-white hover:shadow-sm transition-all border border-transparent hover:border-neutral-100">
                                <div class="w-16 h-16 flex-shrink-0 overflow-hidden rounded-xl bg-neutral-100">
                                    <img src="{{ $related->photo ? asset('storage/portofolios/' . $related->photo) : 'https://via.placeholder.com/150' }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-neutral-900 group-hover:text-primary-600 transition-colors line-clamp-1">
                                        {{ $related->title }}
                                    </h4>
                                    <span class="text-[11px] text-neutral-400 font-medium mt-1 block">Detail Project &rarr;</span>
                                </div>
                            </a>
                            @empty
                            <p class="text-neutral-400 text-sm italic">Tidak ada project serupa.</p>
                            @endforelse
                        </div>
                    </aside>
                </div>

            </div>
        </div>
    </section>
</div>

<style>
    .prose {
        max-width: 70ch;
    }
</style>
@endsection