<section id="faq" class="py-12 md:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 md:px-8 lg:px-12">
        <div class="text-center mb-10 md:mb-12">
            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white rounded-full shadow-lg border border-neutral-100 mb-6">
                <span class="flex w-2.5 h-2.5 bg-primary-600 rounded-full animate-pulse"></span>
                <span class="text-xs sm:text-sm font-bold tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-secondary-600 uppercase">
                    BANTUAN & PERTANYAAN
                </span>
            </span>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-neutral-800 mb-4 leading-tight">
                <span class="text-primary-600">Pertanyaan</span> yang Sering Diajukan
            </h2>
            <p class="text-sm sm:text-base text-neutral-600 max-w-2xl mx-auto px-4">
                Temukan jawaban untuk pertanyaan umum seputar layanan digital printing kami.
            </p>
        </div>

        @if($faqs->count() > 0)
            <div class="max-w-3xl mx-auto">
                <div class="space-y-3 md:space-y-4" id="faq-accordion">
                    @foreach($faqs as $index => $faq)
                        <div class="faq-item bg-white rounded-xl border border-neutral-200 shadow-soft overflow-hidden transition-all duration-300 hover:shadow-dp"
                            data-faq-index="{{ $index }}">
                            <button
                                class="faq-toggle w-full px-5 md:px-6 py-3 md:py-4 text-left flex justify-between items-center hover:bg-neutral-50 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50"
                                aria-expanded="false" aria-controls="faq-content-{{ $index }}">
                                <span class="text-sm md:text-lg font-semibold text-neutral-800 pr-4 leading-tight">
                                    {{ $faq->question }}
                                </span>
                                <svg class="faq-arrow w-5 h-5 md:w-6 md:h-6 text-primary-600 transform transition-transform duration-300 flex-shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="faq-content-{{ $index }}"
                                class="faq-content overflow-hidden transition-all duration-300 ease-in-out"
                                style="max-height: 0;">
                                <div class="px-5 md:px-6 pb-4 pt-2 border-t border-neutral-100">
                                    <div class="prose prose-sm max-w-none text-neutral-600 text-xs md:text-sm">
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
                <div class="bg-neutral-50 rounded-2xl p-6 md:p-8 border border-neutral-200">
                    <svg class="w-10 h-10 md:w-12 md:h-12 text-neutral-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-lg md:text-xl font-semibold text-neutral-700 mb-2">Belum ada FAQ tersedia</h3>
                    <p class="text-sm md:text-base text-neutral-600 mb-4">Silakan hubungi kami langsung untuk informasi lebih lanjut.</p>
                    <a href="{{ url('/contact') }}" class="inline-flex items-center text-primary-600 font-semibold hover:text-primary-700 text-sm md:text-base">
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
