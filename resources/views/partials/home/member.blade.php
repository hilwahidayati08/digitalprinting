@php
    $setting = \App\Models\Settings::first();
@endphp

<!-- Member Section -->
<section class="py-12 md:py-16 bg-gradient-to-br from-[#1E293B] via-[#1e3a5f] to-[#1E293B] relative overflow-hidden">

    <div class="absolute top-0 left-0 w-64 h-64 bg-blue-500/10 rounded-full -translate-x-32 -translate-y-32 blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-64 h-64 bg-amber-400/10 rounded-full translate-x-32 translate-y-32 blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-400/5 rounded-full blur-3xl"></div>

    <div class="max-w-7xl mx-auto px-5 sm:px-6 md:px-8 lg:px-12 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-12 items-center">

            {{-- Kiri --}}
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-400/20 border border-amber-400/30 rounded-full mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <span class="text-amber-400 text-xs font-black uppercase tracking-widest">Program Member Eksklusif</span>
                </div>

                <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-white mb-4 leading-tight">
                    Bergabung Jadi Member &<br>
                    <span class="text-amber-400">Dapatkan Cashback Setiap Order</span>
                </h2>

                <p class="text-slate-300 text-sm sm:text-base mb-8 leading-relaxed">
                    Daftarkan diri Anda sebagai member CetakKilat dan nikmati cashback otomatis di setiap transaksi.
                    Makin sering belanja, makin besar cashback yang Anda dapatkan.
                </p>

                <div class="space-y-4 max-w-md mx-auto lg:mx-0">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-blue-500/20 border border-blue-400/30 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-white font-bold text-sm">Cashback Otomatis Setiap Transaksi</p>
                            <p class="text-slate-400 text-xs mt-0.5 leading-relaxed">
                                Setiap order yang selesai, cashback langsung masuk ke saldo komisi kamu.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-emerald-500/20 border border-emerald-400/30 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-white font-bold text-sm">Naik Tier, Naik Cashback</p>
                            <p class="text-slate-400 text-xs mt-0.5 leading-relaxed">
                                Mulai dari Regular ({{ $setting->rate_regular ?? 5 }}%), Plus ({{ $setting->rate_plus ?? 10 }}%), hingga Premium ({{ $setting->rate_premium ?? 15 }}%).
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-purple-500/20 border border-purple-400/30 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-white font-bold text-sm">Gratis, Tanpa Syarat Apapun</p>
                            <p class="text-slate-400 text-xs mt-0.5 leading-relaxed">
                                Siapapun bisa langsung daftar jadi member. Tidak ada minimal order.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kanan: Card --}}
            <div class="flex justify-center lg:justify-end">
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-6 sm:p-8 w-full max-w-sm">

                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-amber-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-amber-400/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-white font-black text-xl">Program Member</h3>
                        <p class="text-slate-400 text-sm mt-1">Cashback otomatis, langsung ke saldo</p>
                    </div>

                    {{-- Tabel Tier --}}
                    <div class="space-y-3 mb-8">
                        <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/10">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">🥉</span>
                                <span class="text-white text-xs font-bold">Regular</span>
                            </div>
                            <span class="text-amber-400 text-xs font-black">{{ $setting->rate_regular ?? 5 }}% cashback</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/10">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">⭐</span>
                                <span class="text-white text-xs font-bold">Plus</span>
                                <span class="text-slate-500 text-[10px] hidden sm:inline-block">&gt; Rp {{ number_format($setting->tier_plus_min ?? 1000000, 0, ',', '.') }}</span>
                            </div>
                            <span class="text-amber-400 text-xs font-black">{{ $setting->rate_plus ?? 10 }}% cashback</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-amber-400/10 rounded-xl border border-amber-400/20">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">💎</span>
                                <span class="text-white text-xs font-bold">Premium</span>
                                <span class="text-slate-500 text-[10px] hidden sm:inline-block">&gt; Rp {{ number_format($setting->tier_premium_min ?? 5000000, 0, ',', '.') }}</span>
                            </div>
                            <span class="text-amber-400 text-xs font-black">{{ $setting->rate_premium ?? 15 }}% cashback</span>
                        </div>
                    </div>

                    {{-- Tombol / Status --}}
                    @auth
                        @if(auth()->user()->is_member)
                            <div class="w-full py-3.5 bg-emerald-500/20 border border-emerald-400/30 rounded-2xl text-center mb-3">
                                <span class="text-emerald-400 font-black text-xs sm:text-sm flex items-center justify-center gap-2 uppercase tracking-widest">
                                    ✅ Member Aktif
                                </span>
                            </div>
                            <div class="text-center">
                                <span class="inline-block px-4 py-1.5 rounded-full text-xs font-black {{ auth()->user()->tier_color }}">
                                    {{ auth()->user()->tier_label }}% cashback
                                </span>
                            </div>

                        @elseif(\App\Models\MemberRequest::where('user_id', auth()->user()->user_id)->where('status', 'pending')->exists())
                            <div class="w-full py-3.5 bg-amber-400/10 border border-amber-400/30 rounded-2xl text-center">
                                <span class="text-amber-400 font-black text-xs sm:text-sm flex items-center justify-center gap-2">
                                    ⏳ Permintaan Sedang Diproses
                                </span>
                            </div>
                            <p class="text-slate-500 text-xs text-center mt-3">
                                Admin sedang meninjau permintaan Anda.
                            </p>

                        @else
                            <button type="button"
                                onclick="document.getElementById('modalMember').classList.remove('hidden')"
                                class="w-full py-3.5 bg-amber-400 hover:bg-amber-300 text-white font-black rounded-2xl
                                       transition-all shadow-lg shadow-amber-400/30 hover:-translate-y-0.5
                                       text-xs sm:text-sm uppercase tracking-wider flex items-center justify-center gap-2">
                                ✨ Daftar Jadi Member — Gratis!
                            </button>
                            <p class="text-slate-500 text-xs text-center mt-3">
                                Langsung aktif setelah disetujui admin.
                            </p>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="w-full py-3.5 bg-blue-500 hover:bg-blue-400 text-white font-black rounded-2xl
                                  text-center block text-xs sm:text-sm uppercase tracking-wider transition-all">
                            Login Untuk Daftar Member
                        </a>
                        <p class="text-slate-500 text-xs text-center mt-3">
                            Sudah punya akun? Login sekarang.
                        </p>
                    @endauth

                </div>
            </div>

        </div>
    </div>
</section>
@auth
    @if(!auth()->user()->is_member)
    <div id="modalMember" class="hidden fixed inset-0 z-[999] flex items-center justify-center px-4">

        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
             onclick="document.getElementById('modalMember').classList.add('hidden')"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden z-10 mx-4">

            {{-- Header --}}
            <div class="bg-[#1E293B] px-6 sm:px-8 py-6 sm:py-7">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-400 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-black text-sm sm:text-base uppercase tracking-widest">Daftar Member</h3>
                            <p class="text-slate-400 text-[10px] sm:text-[11px] mt-0.5">Gratis, langsung aktif setelah disetujui admin</p>
                        </div>
                    </div>
                    <button onclick="document.getElementById('modalMember').classList.add('hidden')"
                        class="w-8 h-8 bg-white/10 hover:bg-white/20 rounded-xl flex items-center justify-center transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-6 sm:p-8">

                {{-- Info user --}}
                <div class="bg-gray-50 rounded-2xl p-4 flex items-center gap-3 border border-gray-100 mb-5">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 text-white rounded-xl flex items-center justify-center font-black text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-bold text-gray-800 text-sm truncate">{{ auth()->user()->username }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->useremail }}</p>
                    </div>
                </div>

                {{-- Info cashback --}}
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-6">
                    <p class="text-amber-700 text-xs font-bold mb-2">✨ Yang akan kamu dapatkan:</p>
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-500 text-xs">✓</span>
                            <span class="text-amber-700 text-xs">Cashback <strong>{{ $setting->rate_regular ?? 5 }}%</strong> dari setiap transaksi</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-500 text-xs">✓</span>
                            <span class="text-amber-700 text-xs">Naik tier otomatis → cashback makin besar</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-500 text-xs">✓</span>
                            <span class="text-amber-700 text-xs">Saldo bisa dicairkan atau dipakai belanja</span>
                        </div>
                    </div>
                </div>

                {{-- Form tanpa textarea --}}
                <form action="{{ route('member.request') }}" method="POST">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="button"
                            onclick="document.getElementById('modalMember').classList.add('hidden')"
                            class="flex-1 py-3 border border-gray-200 text-gray-500 font-bold rounded-2xl hover:bg-gray-50 transition-all text-sm order-2 sm:order-1">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 py-3 bg-amber-400 hover:bg-amber-300 text-white font-black rounded-2xl transition-all text-sm uppercase tracking-wider order-1 sm:order-2">
                            Ya, Daftar Sekarang!
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @endif
@endauth
