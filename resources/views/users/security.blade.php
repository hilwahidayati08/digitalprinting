{{-- resources/views/profiles/security.blade.php --}}
@extends('admin.member')

@section('member_content')
<div class="max-w-4xl mx-auto px-4 mb-8 space-y-4">

    {{-- Security Form Card --}}
    <div class="bg-white rounded-[1.2rem] shadow-sm border border-neutral-100 overflow-hidden">

        {{-- Header Ramping --}}
        <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-6 py-6 flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
            
            <div class="relative z-10 flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-md border border-white/30 rounded-lg flex items-center justify-center shadow-lg">
                    <i class="fas fa-shield-halved text-white text-lg"></i>
                </div>
                <div>
                    <h2 class="text-white text-lg font-black italic uppercase tracking-tight leading-none">Keamanan Akun</h2>
                    <p class="text-white/70 text-[10px] mt-1 font-medium italic">Kelola kredensial login Anda</p>
                </div>
            </div>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('security.update') }}" method="POST" class="p-5 lg:p-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                {{-- Label Bagian --}}
                <div class="flex items-center gap-2 border-b border-neutral-50 pb-2">
                    <div class="w-1 h-3 bg-primary-600 rounded-full"></div>
                    <h3 class="text-[10px] font-black text-neutral-800 uppercase tracking-widest">Update Password</h3>
                </div>

                @if(Auth::user()->isGoogleAccount())
                    {{-- Alert Box Google Account (Lebih Kecil) --}}
                    <div class="p-4 bg-blue-50/50 rounded-xl border border-blue-100 space-y-3">
                        <div class="flex items-center gap-2">
                            <i class="fab fa-google text-blue-500 text-sm"></i>
                            <label class="text-[9px] font-bold text-blue-700 uppercase tracking-wider">Login via Google</label>
                        </div>
                        <p class="text-[11px] text-blue-600 leading-relaxed"> Akun Anda terhubung dengan Google. Anda bisa menambahkan password di bawah untuk login manual via email. </p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="space-y-1">
                                <label class="text-[9px] font-bold text-neutral-400 uppercase ml-1">Password Baru</label>
                                <input type="password" name="password" class="w-full px-3 py-2 bg-white border border-blue-200 rounded-lg outline-none focus:border-blue-400 text-xs font-bold text-neutral-700">
                            </div>
                            <div class="space-y-1">
                                <label class="text-[9px] font-bold text-neutral-400 uppercase ml-1">Konfirmasi</label>
                                <input type="password" name="password_confirmation" class="w-full px-3 py-2 bg-white border border-blue-200 rounded-lg outline-none focus:border-blue-400 text-xs font-bold text-neutral-700">
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Form Password Standar (Lebih Rapat) --}}
                    <div class="grid grid-cols-1 gap-4 max-w-2xl">
                        <div class="space-y-1">
                            <label class="text-[9px] font-bold text-neutral-400 uppercase ml-1">Password Saat Ini</label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-neutral-300 text-[10px]"></i>
                                <input type="password" name="current_password" class="w-full pl-9 pr-3 py-2 bg-neutral-50 border border-neutral-100 rounded-lg focus:border-primary-600 outline-none text-xs font-bold text-neutral-700 @error('current_password') border-red-300 @enderror">
                            </div>
                            @error('current_password') <span class="text-red-400 text-[9px] font-bold">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[9px] font-bold text-neutral-400 uppercase ml-1">Password Baru</label>
                                <div class="relative">
                                    <i class="fas fa-key absolute left-3 top-1/2 -translate-y-1/2 text-neutral-300 text-[10px]"></i>
                                    <input type="password" name="password" class="w-full pl-9 pr-3 py-2 bg-neutral-50 border border-neutral-100 rounded-lg focus:border-primary-600 outline-none text-xs font-bold text-neutral-700 @error('password') border-red-300 @enderror">
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[9px] font-bold text-neutral-400 uppercase ml-1">Konfirmasi Baru</label>
                                <div class="relative">
                                    <i class="fas fa-check-circle absolute left-3 top-1/2 -translate-y-1/2 text-neutral-300 text-[10px]"></i>
                                    <input type="password" name="password_confirmation" class="w-full pl-9 pr-3 py-2 bg-neutral-50 border border-neutral-100 rounded-lg focus:border-primary-600 outline-none text-xs font-bold text-neutral-700">
                                </div>
                            </div>
                        </div>
                        @error('password') <span class="text-red-400 text-[9px] font-bold ml-1">{{ $message }}</span> @enderror
                    </div>
                @endif

                {{-- Footer Form --}}
                <div class="pt-4 border-t border-neutral-50 flex items-center justify-between">
                    <div class="hidden sm:flex items-center gap-2">
                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-[9px] text-neutral-400 font-bold uppercase tracking-tighter">Member sejak {{ Auth::user()->created_at->format('M Y') }}</span>
                    </div>
                    <button type="submit" class="group px-6 py-2.5 bg-neutral-900 text-white rounded-lg hover:bg-primary-600 transition-all shadow-md flex items-center gap-2">
                        <span class="text-[10px] font-black uppercase tracking-widest">Update Keamanan</span>
                        <i class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Simple Shortcut Card --}}
    <a href="{{ route('shippings.index') }}" class="block bg-white rounded-[1.2rem] border border-neutral-100 hover:border-primary-200 transition-all group">
        <div class="p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-primary-50 rounded-lg flex items-center justify-center group-hover:bg-primary-600 transition-all">
                    <i class="fas fa-map-location-dot text-primary-600 group-hover:text-white text-sm"></i>
                </div>
                <div>
                    <h4 class="text-[11px] font-black text-neutral-800 uppercase">Buku Alamat</h4>
                    <p class="text-[9px] text-neutral-400 italic">Kelola alamat pengiriman Anda</p>
                </div>
            </div>
            <i class="fas fa-chevron-right text-neutral-300 text-[10px] group-hover:text-primary-600 transition-colors"></i>
        </div>
    </a>

</div>
@endsection