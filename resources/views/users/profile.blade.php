{{-- resources/views/profiles/edit.blade.php --}}
@extends('admin.member')

@section('member_content')
<div class="max-w-4xl mx-auto px-4 mb-8 space-y-4">

    {{-- Profile Form Card --}}
    <div class="bg-white rounded-[1.2rem] shadow-sm border border-neutral-100 overflow-hidden">
        
        {{-- Header: Dibuat lebih ramping --}}
        <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-6 py-6 flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
            
            <div class="relative z-10 flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-md border border-white/30 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-user-gear text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-white text-lg font-black italic uppercase tracking-tight leading-none">Pengaturan Profil</h2>
                    <p class="text-white/70 text-[10px] mt-1 font-medium italic">Update identitas akun Anda</p>
                </div>
            </div>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('profile.update') }}" method="POST" class="p-5 lg:p-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                {{-- Bagian 01: Identitas --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-2 border-b border-neutral-50 pb-2">
                        <div class="w-1 h-3 bg-primary-600 rounded-full"></div>
                        <h3 class="text-[10px] font-black text-neutral-800 uppercase tracking-widest">Identitas Akun</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3">
                        {{-- Username --}}
                        <div class="space-y-1">
                            <label class="text-[9px] font-bold text-neutral-400 uppercase ml-1">Username</label>
                            <div class="relative">
                                <i class="fas fa-at absolute left-3 top-1/2 -translate-y-1/2 text-neutral-300 text-[10px]"></i>
                                <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}"
                                    class="w-full pl-9 pr-3 py-2 bg-neutral-50 border border-neutral-100 rounded-lg focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-xs @error('username') border-red-300 @enderror">
                            </div>
                            @error('username') <span class="text-red-400 text-[9px] italic font-bold ml-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Nama Lengkap --}}
                        <div class="space-y-1">
                            <label class="text-[9px] font-bold text-neutral-400 uppercase ml-1">Nama Lengkap</label>
                            <div class="relative">
                                <i class="fas fa-signature absolute left-3 top-1/2 -translate-y-1/2 text-neutral-300 text-[10px]"></i>
                                <input type="text" name="full_name" value="{{ old('full_name', Auth::user()->full_name) }}"
                                    class="w-full pl-9 pr-3 py-2 bg-neutral-50 border border-neutral-100 rounded-lg focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-xs @error('full_name') border-red-300 @enderror">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="space-y-1">
                            <label class="text-[9px] font-bold text-neutral-400 uppercase ml-1">Email</label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-neutral-300 text-[10px]"></i>
                                <input type="email" name="useremail" value="{{ old('useremail', Auth::user()->useremail) }}"
                                    class="w-full pl-9 pr-3 py-2 bg-neutral-50 border border-neutral-100 rounded-lg focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-xs @error('useremail') border-red-300 @enderror">
                            </div>
                        </div>

                        {{-- WhatsApp --}}
                        <div class="space-y-1">
                            <label class="text-[9px] font-bold text-neutral-400 uppercase ml-1">No. WhatsApp</label>
                            <div class="relative">
                                <i class="fab fa-whatsapp absolute left-3 top-1/2 -translate-y-1/2 text-neutral-300 text-xs"></i>
                                <input type="text" name="no_telp" value="{{ old('no_telp', Auth::user()->no_telp) }}"
                                    class="w-full pl-9 pr-3 py-2 bg-neutral-50 border border-neutral-100 rounded-lg focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-xs @error('no_telp') border-red-300 @enderror">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Aksi Simpan --}}
                <div class="pt-4 border-t border-neutral-50 flex items-center justify-end gap-2">
                    <button type="reset" class="px-4 py-2 text-[10px] font-bold text-neutral-400 hover:text-neutral-600 transition-colors uppercase tracking-widest">
                        Reset
                    </button>
                    <button type="submit" class="group px-6 py-2.5 bg-neutral-900 text-white rounded-lg hover:bg-primary-600 transition-all shadow-md flex items-center gap-2">
                        <span class="text-[10px] font-black uppercase tracking-widest">Simpan Perubahan</span>
                        <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Shortcut Card Alamat --}}
    <a href="{{ route('shippings.index') }}"
       class="block bg-white rounded-[1.2rem] shadow-sm border border-neutral-100 overflow-hidden hover:border-primary-200 transition-all group">
        <div class="p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-50 border border-primary-100 rounded-lg flex items-center justify-center group-hover:bg-primary-600 transition-all">
                    <i class="fas fa-map-location-dot text-primary-600 group-hover:text-white transition-all text-base"></i>
                </div>
                <div>
                    <h4 class="text-[11px] font-black text-neutral-800 uppercase tracking-tight">Buku Alamat</h4>
                    <p class="text-[9px] text-neutral-400 font-medium italic">Kelola daftar alamat pengiriman.</p>
                </div>
            </div>
            <div class="text-neutral-400 group-hover:text-primary-600 transition-all">
                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </div>
        </div>
    </a>

</div>
@endsection