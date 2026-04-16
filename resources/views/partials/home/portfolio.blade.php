<section class="relative overflow-hidden bg-gradient-to-br from-neutral-50 via-white to-neutral-50 py-12 md:py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 md:px-8 lg:px-12">
        <div class="text-center mb-10 md:mb-12">
            <div class="flex justify-center">
                <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white rounded-full shadow-lg border border-neutral-100 mb-6">
                    <span class="flex w-2.5 h-2.5 bg-primary-600 rounded-full animate-pulse"></span>
                    <span class="text-xs sm:text-sm font-bold tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-600 uppercase">PORTOFOLIO KAMI</span>
                </span>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-neutral-900 mb-3 leading-tight">Hasil <span class="text-primary-600">Memuaskan</span> Para Pelanggan</h2>
            <p class="text-sm sm:text-base text-neutral-600 max-w-2xl mx-auto leading-relaxed px-4">Dari desain hingga finishing, kami menyediakan layanan lengkap dengan kualitas terbaik</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
            @forelse($portofolios as $item)
                @if($item->is_active)
                    <div class="porto-card-wrap">
                        <div class="porto-card">
                            <div class="porto-img-wrap">
                                <span class="porto-badge">Project</span>
                                <div class="porto-date">
                                    <svg width="10" height="10" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
                                    {{ $item->created_at->format('d/m/Y') }}
                                </div>
                                @if($item->photo)
                                    <img src="{{ asset('storage/portofolios/' . $item->photo) }}" alt="{{ $item->title }}" loading="lazy">
                                @else
                                    <div class="porto-placeholder">
                                        <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="porto-body">
                                <h3 class="porto-title">{{ Str::limit($item->title, 40) }}</h3>
                                <div class="porto-category"><span>{{ $item->category ?? 'Digital Printing' }}</span></div>
                                <p class="porto-desc">{{ strip_tags(Str::limit($item->description, 70)) ?: 'Hasil cetak berkualitas tinggi dengan detail sempurna.' }}</p>
                                <a href="{{ url('portofolio/' . $item->slug) }}" class="porto-btn">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Project
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-span-full py-12 sm:py-16 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3"><svg width="28" height="28" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                    <p class="text-slate-500 font-semibold">Belum ada portofolio tersedia.</p>
                </div>
            @endforelse
        </div>

        @if($portofolios->count() > 0 && $portofolios->count() >= 4)
        <div class="text-center mt-10 md:mt-14">
            <a href="{{ route('portofolio.index') }}" class="see-all">
                Lihat Semua Portofolio
                <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        @endif
    </div>
</section>