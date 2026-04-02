@extends('admin.guest')

@section('title', 'PrintPro - Digital Printing & Ecommerce')

@section('content')
    <section class="relative overflow-hidden bg-gradient-primary text-white min-h-[85vh] md:min-h-[75vh] flex items-center">
        <!-- Animated Background -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-grid-pattern bg-grid-sm"></div>
        </div>
        
        <!-- CMYK Dots Animation -->
        <div class="absolute top-10 left-10 w-3 h-3 bg-printing-cyan rounded-full animate-bounce"></div>
        <div class="absolute top-20 right-20 w-4 h-4 bg-printing-magenta rounded-full animate-pulse animation-delay-300"></div>
        <div class="absolute bottom-20 left-1/4 w-3.5 h-3.5 bg-printing-yellow rounded-full animate-bounce animation-delay-500"></div>
        <div class="absolute bottom-10 right-1/3 w-2.5 h-2.5 bg-printing-black rounded-full animate-pulse animation-delay-700"></div>

        <div class="container mx-auto px-4 py-12 md:py-20 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Badge -->
                <div class="inline-flex items-center px-3 py-1.5 bg-white/20 backdrop-blur-sm rounded-full mb-4 md:mb-6 animate-fade-in text-sm">
                    <span class="font-medium">{{$hero->label}}</span>
                </div>
                
                <!-- Main Heading -->
                <h1 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold mb-4 md:mb-6 animate-fade-in-up leading-tight">
                    <span class="block">{{$hero->headline}}</span>
                </h1>
                
                <!-- Description -->
                <div class="mb-8 md:mb-10 animate-fade-in-up animation-delay-200">
                    <p class="text-lg md:text-xl text-white/60 text-center mx-auto max-w-2xl leading-relaxed">
                        {{ Str::limit($hero->subheadline, 150) }}
                    </p>
                </div>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center mb-12 md:mb-16 animate-fade-in-up animation-delay-400">
                    <a href="{{ route('products.index') }}" 
                       class="px-6 md:px-8 py-3 md:py-4 bg-white text-primary-600 font-bold rounded-xl hover:bg-neutral-100 transition-all duration-300 shadow-dp-lg hover:shadow-dp-xl hover:scale-105 flex items-center justify-center space-x-2 group">
                        <span>Lihat Produk</span>
                        <svg class="w-4 h-4 md:w-5 md:h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    <a href="https://wa.me/6285810761209?text=Halo%20Admin,%20saya%20ingin%20konsultasi%20gratis%20tentang%20layanan%20digital%20printing.%0A%0ANama:%0AProduk%20yang%20dibutuhkan:%0AJumlah:%0AUkuran:%0ATerima%20kasih."
                        target="_blank"
                        class="px-6 md:px-8 py-3 md:py-4 bg-white/20 backdrop-blur-sm text-white font-bold rounded-xl hover:bg-white/30 transition-all duration-300 border border-white/30 hover:border-white/50 group">
                        <span class="flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <span>Konsultasi Gratis</span>
                        </span>
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 max-w-3xl mx-auto animate-fade-in-up animation-delay-600">
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold mb-1">10K+</div>
                        <div class="text-white/60 text-xs md:text-sm">Proyek Selesai</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold mb-1">500+</div>
                        <div class="text-white/60 text-xs md:text-sm">Klien Puas</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold mb-1">24/7</div>
                        <div class="text-white/60 text-xs md:text-sm">Dukungan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl md:text-3xl font-bold mb-1">1K+</div>
                        <div class="text-white/60 text-xs md:text-sm">Produk Tersedia</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 animate-bounce-slow">
            <a href="#featured-products" class="text-white/60 hover:text-white transition-colors">
                <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </a>
        </div>
    </section>
    <!-- Tentang Kami Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-primary-50 via-white to-secondary-50 py-12 md:py-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
                <!-- Teks Konten -->
                <div class="text-center lg:text-left" data-animate>
                    <!-- Badge/Label -->
                    <span
                        class="inline-block px-3 py-1.5 bg-primary-100 text-primary-700 rounded-full text-sm font-semibold mb-3 md:mb-4">
                        Tentang Nusan
                    </span>

                    <!-- Judul -->
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4 md:mb-6 leading-tight text-neutral-900">
                        Digital Printing  <span class="text-primary-600">Terpercaya</span>
                    </h1>

                    <!-- Deskripsi -->
                    <p class="text-lg md:text-xl text-neutral-600 mb-6 md:mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        Kami adalah penyedia layanan digital printing yang telah berpengalaman
                        lebih dari 10 tahun dalam industri percetakan. Dengan teknologi terkini
                        dan tim profesional, kami berkomitmen memberikan hasil cetak berkualitas
                        tinggi untuk berbagai kebutuhan bisnis dan personal.
                    </p>
                </div>


                <!-- Gambar Ilustrasi -->
                <div class="relative max-w-xl mx-auto">
                    <div class="relative rounded-3xl overflow-hidden shadow-xl bg-white border-0">
                        <img src="{{ $hero->photo ? asset('storage/heros/' . $hero->photo) : asset('images/no-image.png') }}"
                            alt="{{ $hero->label }}" class="w-full h-full object-cover">
                    </div>

                    <div
                        class="absolute -top-4 -right-6
           bg-white/95 backdrop-blur-sm rounded-xl p-3
           shadow-lg border border-gray-100
           flex items-center gap-3
           animate-bounce-slow
           z-20">

                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        <div class="pr-1">
                            <p class="text-sm font-bold text-gray-800 leading-tight">Quality First</p>
                            <p class="text-[10px] text-gray-500 font-medium italic leading-none">Garansi hasil</p>
                        </div>
                    </div>

                    <div
                        class="absolute -bottom-4 -left-6
           bg-white/95 backdrop-blur-sm rounded-xl p-3
           shadow-lg border border-gray-100
           flex items-center gap-3
           animate-float
           z-20">

                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <div class="pr-1">
                            <p class="text-sm font-bold text-gray-800 leading-tight">Fast Delivery</p>
                            <p class="text-[10px] text-gray-500 font-medium italic leading-none">Tepat waktu</p>
                        </div>
                    </div>

                </div>


                <!-- Background Pattern -->
                <div class="absolute top-0 left-0 w-full h-full opacity-5 pointer-events-none">
                    <div class="absolute inset-0"
                        style="background-image: url('data:image/svg+xml,%3Csvg width=\"100\" height=\"100\" viewBox=\"0 0 100 100\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z\" fill=\"%230075ff\" fill-opacity=\"0.4\" fill-rule=\"evenodd\"/%3E%3C/svg%3E');">
                    </div>
                </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-neutral-900 mb-4">Produk Unggulan Kami</h2>
                <p class="text-lg text-neutral-600 max-w-2xl mx-auto">
                    Kualitas cetak terbaik untuk berbagai kebutuhan bisnis dan personal Anda.
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                @forelse ($products as $product)
                    <div
                        class="group bg-white rounded-2xl border border-neutral-200 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full">

                        <!-- IMAGE -->
                        <div class="relative w-full h-48 md:h-56 overflow-hidden bg-gray-100">

                            @if ($product->category)
                                <div class="absolute top-3 left-3 z-10">
                                    <span
                                        class="bg-blue-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider shadow-sm">
                                        {{ $product->category->category_name }}
                                    </span>
                                </div>
                            @endif

                            @if ($product->photo)
                                <img src="{{ asset('storage/products/' . $product->photo) }}"
                                    alt="{{ $product->product_name }}"
                                    class="w-full h-full object-cover object-center group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- CONTENT -->
                        <div class="p-4 md:p-5 flex flex-col flex-grow">

                            <h3 class="text-base md:text-lg font-bold text-neutral-800 mb-1 line-clamp-1">
                                {{ $product->product_name }}
                            </h3>

                            <p class="text-xs text-neutral-500 mb-4 line-clamp-2">
                                {{ strip_tags($product->description) }}
                            </p>

                            <div class="mt-auto">

                                <div class="mb-4">
                                    <div class="flex items-baseline gap-1">
                                        <span class="text-lg font-extrabold text-blue-700">
                                            {{ $product->formatted_price }}
                                        </span>
                                        <span class="text-[10px] text-neutral-500 italic">
                                            / {{ $product->unit->unit_name ?? 'pcs' }}
                                        </span>
                                    </div>
                                </div>

                                <a href="{{ url('products/' . $product->slug) }}"
                                    class="flex items-center justify-center gap-2 w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition shadow-md shadow-blue-200">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>

                                    Detail Produk
                                </a>

                            </div>

                        </div>

                    </div>
                @empty
                    <div class="col-span-full text-center py-10">
                        <p class="text-neutral-500">Belum ada produk tersedia.</p>
                    </div>
                @endforelse
            </div>


            <div class="text-center mt-12">
                <a href="{{ url('/products') }}"
                    class="inline-flex items-center px-8 py-3 bg-white border-2 border-blue-600 text-blue-600 font-bold rounded-full hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-sm group">
                    Lihat Semua Produk
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-primary-600 to-secondary-600">
        <div class="c

    <!-- CTA Section -->
    <section class="py-12 md:py-16 bg-gradient-to-r from-primary-600
            to-secondary-600">
            <div class="container mx-auto px-4 text-center" data-animate>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-3 md:mb-4">
                    Siap Mencetak dengan PrintPro?
                </h2>
                <p class="text-lg md:text-xl text-white/90 mb-6 md:mb-8 max-w-2xl mx-auto">
                    Dapatkan kualitas cetak terbaik dengan harga terjangkau. Free ongkir untuk order pertama!
                </p>
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
                    <a href="https://wa.me/6281234567890" target="_blank"
                        class="px-6 md:px-8 py-2.5 md:py-3 bg-white text-primary-600 font-semibold rounded-lg hover:bg-neutral-100 transition duration-300 shadow-dp hover:shadow-dp-lg text-sm md:text-base">
                        Konsultasi Gratis via WhatsApp
                    </a>
                    <a href=""
                        class="px-6 md:px-8 py-2.5 md:py-3 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white/10 transition duration-300 text-sm md:text-base">
                        Hubungi Kami
                    </a>
                </div>
            </div>
    </section>
@endsection

@section('newsletter')
    @include('partials.newsletter')
@endsection

@section('service-highlights')
    @include('partials.service-highlights')
@endsection
