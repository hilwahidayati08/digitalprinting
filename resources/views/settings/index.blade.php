@extends('admin.admin')

@section('title', 'Pengaturan - Admin Panel')
@section('page-title', 'Pengaturan')

@section('breadcrumbs')
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="/" class="text-sm text-gray-500 hover:text-primary-600">Dashboard</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                    <span class="text-sm font-medium text-gray-900">Pengaturan</span>
                </div>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="space-y-6">

    @if(session('success'))
    <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl text-sm font-medium">
        <i class="fas fa-check-circle text-green-500"></i>
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- KOLOM KIRI --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Syarat Pengajuan Member --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-orange-100 flex items-center justify-center">
                                <i class="fas fa-user-check text-orange-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Syarat Pengajuan Member</h3>
                                <p class="text-xs text-gray-400">Penuhi salah satu syarat ini</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fas fa-shopping-bag text-orange-400 mr-1"></i> Minimal Jumlah Order
                            </label>
                            <div class="relative">
                                <input type="number" name="member_min_orders"
                                    value="{{ old('member_min_orders', $settings->member_min_orders ?? 5) }}"
                                    min="1"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 pr-16 text-sm font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition-all">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold">order</span>
                            </div>
                            @error('member_min_orders') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fas fa-money-bill text-orange-400 mr-1"></i> ATAU Min. Total Belanja
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold">Rp</span>
                                <input type="number" name="member_min_spent"
                                    value="{{ old('member_min_spent', $settings->member_min_spent ?? 500000) }}"
                                    min="0" step="10000"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 pl-10 text-sm font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition-all">
                            </div>
                            @error('member_min_spent') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="p-3 bg-orange-50 rounded-xl">
                            <p class="text-xs text-orange-600 leading-relaxed">
                                <i class="fas fa-info-circle mr-1"></i>
                                User bisa ajukan member jika sudah <strong>min. X order</strong> <u>atau</u> total belanja <strong>min. Rp X</strong>.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Jam Operasional --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center">
                                <i class="fas fa-clock text-amber-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Jam Operasional</h3>
                                <p class="text-xs text-gray-400">Ditampilkan di halaman kontak</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jam Buka</label>
                            <input type="time" name="time_open"
                                value="{{ old('time_open', $settings->time_open ?? '08:00') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-400 transition-all">
                            @error('time_open') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jam Tutup</label>
                            <input type="time" name="time_close"
                                value="{{ old('time_close', $settings->time_close ?? '17:00') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:border-amber-400 transition-all">
                            @error('time_close') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Tier Member --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-layer-group text-purple-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Tier Member & Komisi</h3>
                                <p class="text-xs text-gray-400">Diskon otomatis naik sesuai total belanja kumulatif</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 space-y-4">

                        {{-- Regular --}}
                        <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-2 py-1 bg-gray-200 text-gray-700 text-[10px] font-black uppercase rounded-lg">🥉 Regular</span>
                                <span class="text-xs text-gray-400">Tier awal saat member diapprove</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Diskon (%)</label>
                                    <div class="relative">
                                        <input type="number" name="rate_regular"
                                            value="{{ old('rate_regular', $settings->rate_regular ?? 5) }}"
                                            min="0" max="100" step="0.5"
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-8 text-sm font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all">
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">%</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Naik ke Plus jika belanja ≥</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold">Rp</span>
                                        <input type="number" name="tier_plus_min"
                                            value="{{ old('tier_plus_min', $settings->tier_plus_min ?? 1000000) }}"
                                            min="0" step="100000"
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pl-9 text-sm font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Plus --}}
                        <div class="p-4 bg-blue-50 rounded-xl border border-blue-100">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-2 py-1 bg-blue-200 text-blue-700 text-[10px] font-black uppercase rounded-lg">⭐ Plus</span>
                                <span class="text-xs text-gray-400">Naik otomatis setelah capai batas Regular</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Diskon (%)</label>
                                    <div class="relative">
                                        <input type="number" name="rate_plus"
                                            value="{{ old('rate_plus', $settings->rate_plus ?? 10) }}"
                                            min="0" max="100" step="0.5"
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-8 text-sm font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all">
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">%</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Naik ke Premium jika belanja ≥</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold">Rp</span>
                                        <input type="number" name="tier_premium_min"
                                            value="{{ old('tier_premium_min', $settings->tier_premium_min ?? 5000000) }}"
                                            min="0" step="100000"
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pl-9 text-sm font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Premium --}}
                        <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-100">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-2 py-1 bg-yellow-200 text-yellow-700 text-[10px] font-black uppercase rounded-lg">💎 Premium</span>
                                <span class="text-xs text-gray-400">Tier tertinggi</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Diskon (%)</label>
                                    <div class="relative">
                                        <input type="number" name="rate_premium"
                                            value="{{ old('rate_premium', $settings->rate_premium ?? 15) }}"
                                            min="0" max="100" step="0.5"
                                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 pr-8 text-sm font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-300 transition-all">
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">%</span>
                                    </div>
                                </div>
                                <div class="flex items-end pb-1">
                                    <p class="text-xs text-yellow-600 italic">Tidak ada batas atas — ini tier tertinggi.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Kontak --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-address-book text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Informasi Kontak</h3>
                                <p class="text-xs text-gray-400">Nomor WA & email bisnis</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fab fa-whatsapp text-green-500 mr-1"></i> WhatsApp
                            </label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', $settings->whatsapp) }}"
                                placeholder="628xxxxxxxxxx"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fas fa-envelope text-blue-500 mr-1"></i> Email
                            </label>
                            <input type="email" name="email" value="{{ old('email', $settings->email) }}"
                                placeholder="info@toko.com"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all">
                        </div>
                    </div>
                </div>

                {{-- Sosmed --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-pink-100 flex items-center justify-center">
                                <i class="fas fa-share-alt text-pink-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Sosial Media</h3>
                                <p class="text-xs text-gray-400">URL lengkap profil media sosial</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fab fa-instagram text-pink-500 mr-1"></i> Instagram URL
                            </label>
                            <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url) }}"
                                placeholder="https://instagram.com/username"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fab fa-facebook text-blue-600 mr-1"></i> Facebook URL
                            </label>
                            <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url) }}"
                                placeholder="https://facebook.com/username"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                <i class="fab fa-tiktok text-gray-800 mr-1"></i> TikTok URL
                            </label>
                            <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $settings->tiktok_url) }}"
                                placeholder="https://tiktok.com/@username"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-gray-400 transition-all">
                        </div>
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Alamat Workshop</h3>
                                <p class="text-xs text-gray-400">Ditampilkan di halaman kontak & invoice</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <textarea name="address" rows="3" placeholder="Jl. Contoh No. 123, Kota, Provinsi"
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-300 focus:border-green-400 transition-all resize-none">{{ old('address', $settings->address) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-bold px-8 py-3 rounded-xl transition-all shadow-sm hover:shadow-md">
                        <i class="fas fa-save"></i>
                        Simpan Pengaturan
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection