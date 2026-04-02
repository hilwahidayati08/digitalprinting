<section class="relative py-16 md:py-24 overflow-hidden bg-gradient-to-br from-neutral-50 via-white to-neutral-50">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 right-20 w-72 h-72 bg-primary-100/40 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-secondary-100/40 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <div class="container relative px-4 mx-auto">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white rounded-full shadow-lg border border-neutral-100 mb-6">
                    <span class="flex w-2.5 h-2.5 bg-primary-600 rounded-full animate-pulse"></span>
                    <span class="text-sm font-bold tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-600 uppercase">
                        PORTFOLIO BLOG
                    </span>
                </span>
                
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-neutral-800 mb-4">
                    <span class="relative inline-block">
                        Hasil Memuaskan
                        <span class="absolute -bottom-2 left-0 w-full h-3 bg-primary-200/50 -z-10 rounded-lg"></span>
                    </span>
                    <br>Bagi Para Pelanggan
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                
                <article class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 overflow-hidden border border-neutral-100 flex flex-col h-full">
                    <div class="relative aspect-[4/3] overflow-hidden bg-neutral-200">
                        <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80" 
                             alt="Sertifikasi TOEIC"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 text-[10px] font-bold text-white bg-primary-600 rounded-full shadow-lg uppercase tracking-wider">Sertifikasi</span>
                        </div>
                    </div>
                    
                    <div class="p-5 flex flex-col flex-grow">
                        <time class="text-[11px] font-medium text-neutral-500 mb-2 block">📅 28 Okt 2024</time>
                        <h3 class="text-lg font-bold text-neutral-800 mb-4 line-clamp-2 group-hover:text-primary-700 transition-colors leading-tight">
                            Sertifikasi TOEIC sebagai Bekal di Dunia Kerja
                        </h3>
                        <div class="mt-auto pt-4 border-t border-neutral-50 flex items-center justify-between">
@foreach($portofolios as $porto)

<span class="text-xs font-medium text-neutral-600">2 min read</span>

<a href="{{ url('portofolio/'.$porto->slug) }}"
   class="text-primary-600 font-bold text-xs inline-flex items-center gap-1 group/link">

    Baca
    <svg class="w-3 h-3 group-hover/link:translate-x-1 transition-transform"
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
              d="M13 7l5 5m0 0l-5 5m5-5H6"/>
    </svg>

</a>

@endforeach

                        </div>
                    </div>
                </article>

                <article class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 overflow-hidden border border-neutral-100 flex flex-col h-full">
                    <div class="relative aspect-[4/3] overflow-hidden bg-neutral-200">
                        <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=800&q=80" 
                             alt="Karya Mijel"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 text-[10px] font-bold text-white bg-secondary-600 rounded-full shadow-lg uppercase tracking-wider">Peresmian</span>
                        </div>
                    </div>
                    
                    <div class="p-5 flex flex-col flex-grow">
                        <time class="text-[11px] font-medium text-neutral-500 mb-2 block">📅 23 Jun 2023</time>
                        <h3 class="text-lg font-bold text-neutral-800 mb-4 line-clamp-2 group-hover:text-secondary-700 transition-colors leading-tight">
                            Karya Mijel Diresmikan oleh Pemkot Depok
                        </h3>
                        <div class="mt-auto pt-4 border-t border-neutral-50 flex items-center justify-between">
                            <span class="text-xs font-medium text-neutral-600">3 min read</span>
                            <a href="#" class="text-secondary-600 font-bold text-xs inline-flex items-center gap-1 group/link">
                                Baca <svg class="w-3 h-3 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        </div>
                    </div>
                </article>

                <article class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 overflow-hidden border border-neutral-100 flex flex-col h-full">
                    <div class="relative aspect-[4/3] overflow-hidden bg-neutral-200">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=800&q=80" 
                             alt="Tips Desain"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 text-[10px] font-bold text-white bg-accent-600 rounded-full shadow-lg uppercase tracking-wider">Tips</span>
                        </div>
                    </div>
                    
                    <div class="p-5 flex flex-col flex-grow">
                        <time class="text-[11px] font-medium text-neutral-500 mb-2 block">📅 15 Jan 2024</time>
                        <h3 class="text-lg font-bold text-neutral-800 mb-4 line-clamp-2 group-hover:text-accent-700 transition-colors leading-tight">
                            Rahasia Memilih Warna CMYK untuk Hasil Cetak Berkualitas Tinggi
                        </h3>
                        <div class="mt-auto pt-4 border-t border-neutral-50 flex items-center justify-between">
                            <span class="text-xs font-medium text-neutral-600">5 min read</span>
                            <a href="#" class="text-accent-600 font-bold text-xs inline-flex items-center gap-1 group/link">
                                Baca <svg class="w-3 h-3 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        </div>
                    </div>
                </article>

                <article class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 overflow-hidden border border-neutral-100 flex flex-col h-full">
                    <div class="relative aspect-[4/3] overflow-hidden bg-neutral-200">
                        <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=800&q=80" 
                             alt="Studi Kasus"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 text-[10px] font-bold text-white bg-neutral-800 rounded-full shadow-lg uppercase tracking-wider">Project</span>
                        </div>
                    </div>
                    
                    <div class="p-5 flex flex-col flex-grow">
                        <time class="text-[11px] font-medium text-neutral-500 mb-2 block">📅 10 Des 2023</time>
                        <h3 class="text-lg font-bold text-neutral-800 mb-4 line-clamp-2 group-hover:text-primary-700 transition-colors leading-tight">
                            Transformasi Brand Lokal Lewat Packaging Baru
                        </h3>
                        <div class="mt-auto pt-4 border-t border-neutral-50 flex items-center justify-between">
                            <span class="text-xs font-medium text-neutral-600">4 min read</span>
                            <a href="#" class="text-neutral-800 font-bold text-xs inline-flex items-center gap-1 group/link">
                                Baca <svg class="w-3 h-3 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        </div>
                    </div>
                </article>

            </div>

<div class="flex justify-center">
            <a href="#" class="group relative inline-flex items-center gap-3 px-8 py-4 bg-slate-900 text-white rounded-full font-bold text-sm transition-all duration-300 hover:bg-blue-600 hover:shadow-[0_10px_20px_rgba(37,99,235,0.3)] hover:-translate-y-1">
                <span>Lihat Semua Portfolio</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
        </div>
    </div>
</section>