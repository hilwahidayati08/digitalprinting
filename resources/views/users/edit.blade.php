@extends('layouts.member')

@section('member_content')
<div class="max-w-5xl mx-auto px-4 mb-8 space-y-6">

    {{-- Profile Form --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-neutral-100 overflow-hidden">

        {{-- Header --}}
        <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-8 py-8 flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
            <div class="absolute bottom-0 left-0 w-20 h-20 bg-black/5 rounded-full translate-y-8 -translate-x-6"></div>

            <div class="relative z-10 flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-gear text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-white text-xl font-black italic uppercase tracking-tight leading-none">Pengaturan Profil</h2>
                    <p class="text-white/70 text-[11px] mt-2 font-medium italic">Kelola identitas akun dan keamanan kata sandi Anda</p>
                </div>
            </div>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('users.update', Auth::user()->user_id) }}" method="POST" class="p-6 lg:p-8">
            @csrf
            @method('PUT')

            <div class="space-y-10">

                {{-- Bagian 01: Identitas Akun --}}
                <div class="space-y-5">
                    <div class="flex items-center gap-2 border-b border-neutral-50 pb-2">
                        <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                        <h3 class="text-[11px] font-black text-neutral-800 uppercase tracking-widest">Identitas Akun</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Username --}}
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Username</label>
                            <div class="relative">
                                <i class="fas fa-at absolute left-4 top-1/2 -translate-y-1/2 text-neutral-300 text-xs"></i>
                                <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}"
                                       class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-sm @error('username') border-red-300 @enderror">
                            </div>
                            @error('username') <span class="text-red-400 text-[10px] italic font-bold ml-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Nama Lengkap --}}
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Nama Lengkap</label>
                            <div class="relative">
                                <i class="fas fa-signature absolute left-4 top-1/2 -translate-y-1/2 text-neutral-300 text-xs"></i>
                                <input type="text" name="full_name" value="{{ old('full_name', Auth::user()->full_name) }}"
                                       class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-sm @error('full_name') border-red-300 @enderror"
                                       placeholder="Nama sesuai KTP">
                            </div>
                            @error('full_name') <span class="text-red-400 text-[10px] italic font-bold ml-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Alamat Email</label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-neutral-300 text-xs"></i>
                                <input type="email" name="useremail" value="{{ old('useremail', Auth::user()->useremail) }}"
                                       class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-sm @error('useremail') border-red-300 @enderror">
                            </div>
                            @error('useremail') <span class="text-red-400 text-[10px] italic font-bold ml-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- No. WhatsApp --}}
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">No. WhatsApp</label>
                            <div class="relative">
                                <i class="fab fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-neutral-300 text-sm"></i>
                                <input type="text" name="no_telp" value="{{ old('no_telp', Auth::user()->no_telp) }}"
                                       class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-sm @error('no_telp') border-red-300 @enderror"
                                       placeholder="08xxxxxxxxxx">
                            </div>
                            @error('no_telp') <span class="text-red-400 text-[10px] italic font-bold ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Bagian 02: Keamanan Akun --}}
                <div class="space-y-5">
                    <div class="flex items-center gap-2 border-b border-neutral-50 pb-2">
                        <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                        <h3 class="text-[11px] font-black text-neutral-800 uppercase tracking-widest">Keamanan Akun</h3>
                    </div>

                    <div class="p-4 bg-primary-50/50 rounded-2xl border border-primary-100">
                        <label class="text-[10px] font-bold text-primary-700 uppercase tracking-wider flex items-center gap-2 mb-3">
                            <i class="fas fa-key"></i> Ganti Password Baru
                        </label>
                        <input type="password" name="password"
                               class="w-full px-4 py-3 bg-white border border-primary-100 rounded-xl outline-none focus:border-primary-600 focus:ring-4 focus:ring-primary-500/10 transition-all font-bold text-neutral-700 text-sm"
                               placeholder="Masukkan password baru jika ingin diubah">
                        <p class="text-[10px] text-primary-400 italic font-medium mt-2 ml-1">Biarkan kosong jika tetap menggunakan password saat ini.</p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-6 border-t border-neutral-50 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full"></div>
                        <p class="text-[10px] text-neutral-400 font-bold uppercase tracking-widest">
                            Aktif sejak {{ Auth::user()->created_at->translatedFormat('F Y') }}
                        </p>
                    </div>
                    <button type="submit" class="w-full md:w-auto px-10 py-3.5 bg-neutral-900 text-white font-black rounded-xl hover:bg-primary-600 transition-all shadow-lg hover:shadow-primary-600/20 uppercase tracking-widest text-[10px] flex items-center justify-center gap-2">
                        <span>Simpan Perubahan</span>
                        <i class="fas fa-check-circle"></i>
                    </button>
                </div>

            </div>
        </form>
    </div>

    {{-- Shortcut Card Alamat --}}
    <a href="{{ route('shippings.index') }}"
       class="block bg-white rounded-[1.5rem] shadow-sm border border-neutral-100 overflow-hidden hover:border-primary-200 transition-all group">
        <div class="p-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-primary-50 border border-primary-100 rounded-xl flex items-center justify-center group-hover:bg-primary-600 transition-all">
                    <i class="fas fa-map-location-dot text-primary-600 group-hover:text-white transition-all text-lg"></i>
                </div>
                <div>
                    <h4 class="text-[12px] font-black text-neutral-800 uppercase tracking-tight">Atur Buku Alamat</h4>
                    <p class="text-[10px] text-neutral-400 font-medium mt-0.5 italic">Kelola daftar alamat pengiriman pesanan Anda.</p>
                </div>
            </div>
            <div class="flex items-center gap-1.5 text-neutral-400 group-hover:text-primary-600 transition-all font-black text-[10px] uppercase tracking-widest">
                <span class="hidden md:inline">Buka</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </div>
        </div>
    </a>

</div>
@endsection