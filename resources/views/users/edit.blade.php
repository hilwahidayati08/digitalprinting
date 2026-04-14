@extends('admin.admin')

@section('title', 'Edit Data User')

@section('content')
<div class="max-full mx-auto px-4 py-8">
    
    {{-- Header & Breadcrumbs --}}
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Data User</h1>
            <p class="text-sm text-gray-500">Kelola informasi akun, hak akses, dan pengaturan finansial member.</p>
        </div>
        <div class="text-right">
            <span class="px-4 py-2 bg-gray-100 rounded-2xl text-xs font-bold text-gray-600 uppercase tracking-widest">
                ID User: #{{ $user->user_id }}
            </span>
        </div>
    </div>

    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
            <p class="font-bold mb-1 italic text-sm">Ada kesalahan input:</p>
            <ul class="text-xs list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->user_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-12 gap-8">

            {{-- KOLOM KIRI: Informasi Akun & Profil --}}
            <div class="col-span-12 lg:col-span-8 space-y-6">
                
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-6">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-4">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Informasi Profil & Login</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Username --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Username <span class="text-red-500">*</span></label>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="useremail" value="{{ old('useremail', $user->useremail) }}" required
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Lengkap --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 outline-none">
                        </div>

                        {{-- No Telp --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp/Telp</label>
                            <input type="text" name="no_telp" value="{{ old('no_telp', $user->no_telp) }}"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 outline-none"
                                   placeholder="0812xxxx">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="p-6 bg-orange-50/50 rounded-3xl border border-orange-100 mt-4">
                        <label class="block text-sm font-bold text-orange-800 mb-1">Ganti Password</label>
                        <p class="text-[11px] text-orange-600 mb-3 italic">*Biarkan kosong jika tidak ingin mengubah password user.</p>
                        <input type="password" name="password" 
                               class="w-full px-4 py-3 bg-white border border-orange-200 rounded-2xl focus:ring-4 focus:ring-orange-500/10 outline-none"
                               placeholder="••••••••">
                    </div>
                </div>

                {{-- DATA KEUANGAN / TRANSAKSI --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-4 mb-6">
                        <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Data Keuangan & Komisi</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Saldo Komisi (IDR)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 font-bold">Rp</span>
                                <input type="number" name="saldo_komisi" value="{{ old('saldo_komisi', $user->saldo_komisi) }}"
                                       class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-black text-emerald-600 outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Total Belanja (Total Spent)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 font-bold">Rp</span>
                                <input type="number" name="total_spent" value="{{ old('total_spent', $user->total_spent) }}"
                                       class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl font-black text-blue-600 outline-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Membership & Hak Akses --}}
            <div class="col-span-12 lg:col-span-4 space-y-6">
                
                {{-- Membership Status --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 space-y-5">
                    <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-id-card text-blue-500"></i> Status Membership
                    </h3>

                    <div class="space-y-4">
                        {{-- Is Member Toggle --}}
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-gray-700 uppercase">Status Member</span>
                                <span class="text-[10px] text-gray-400">Aktifkan fitur komisi</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="is_member" value="0">
                                <input type="checkbox" name="is_member" value="1" class="sr-only peer" {{ $user->is_member ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        {{-- Tier --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Member Tier</label>
<select name="member_tier" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-bold outline-none">
    <option value="" {{ is_null($user->member_tier) ? 'selected' : '' }}>-- Tanpa Tier --</option>
    <option value="regular" {{ $user->member_tier == 'regular' ? 'selected' : '' }}>Regular</option>
    <option value="plus" {{ $user->member_tier == 'plus' ? 'selected' : '' }}>Plus</option>
    <option value="premium" {{ $user->member_tier == 'premium' ? 'selected' : '' }}>Premium</option>
</select>
                        </div>

                </div>

                {{-- Hak Akses (Role) --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4">Level Akses (Role)</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative flex flex-col p-4 border rounded-2xl cursor-pointer transition-all {{ $user->role == 'user' ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-100' }}">
                            <input type="radio" name="role" value="user" class="sr-only" {{ $user->role == 'user' ? 'checked' : '' }}>
                            <span class="text-xs font-black {{ $user->role == 'user' ? 'text-blue-700' : 'text-gray-500' }}">USER</span>
                            <span class="text-[10px] text-gray-400 mt-1">Pelanggan</span>
                        </label>
                        <label class="relative flex flex-col p-4 border rounded-2xl cursor-pointer transition-all {{ $user->role == 'admin' ? 'bg-red-50 border-red-200' : 'bg-gray-50 border-gray-100' }}">
                            <input type="radio" name="role" value="admin" class="sr-only" {{ $user->role == 'admin' ? 'checked' : '' }}>
                            <span class="text-xs font-black {{ $user->role == 'admin' ? 'text-red-700' : 'text-gray-500' }}">ADMIN</span>
                            <span class="text-[10px] text-gray-400 mt-1">Pengelola</span>
                        </label>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="space-y-3">
                    <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black shadow-lg shadow-blue-200 transition-all transform active:scale-95">
                        UPDATE DATA USER
                    </button>
                    <a href="{{ route('users.index') }}" class="w-full block py-4 bg-white border border-gray-200 text-gray-500 rounded-2xl text-center text-sm font-bold hover:bg-gray-50 transition-all">
                        Batal & Kembali
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>

<style>
    /* Custom Radio Styling jika diperlukan */
    input[type="radio"]:checked + span {
        --tw-text-opacity: 1;
    }
</style>
@endsection