@extends('admin.admin')

@section('title', 'Tambah User - Admin Panel')

@section('page-title', 'Tambah User Baru')
@section('page-description', 'Silakan isi formulir di bawah untuk mendaftarkan akun baru ke sistem.')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-primary-600 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar User
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-primary-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary-200">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Informasi Akun</h2>
                    <p class="text-sm text-gray-500">Pastikan alamat email aktif untuk keperluan verifikasi.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('users.store') }}" method="POST" class="p-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 ml-1">Username</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-primary-500 transition-colors">
                            <i class="fas fa-at"></i>
                        </span>
                        <input type="text" name="username" value="{{ old('username') }}"
                               class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none"
                               placeholder="Contoh: daffa_arkhab" required>
                    </div>
                    @error('username') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 ml-1">Alamat Email</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-primary-500 transition-colors">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="useremail" value="{{ old('useremail') }}"
                               class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none"
                               placeholder="email@contoh.com" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 ml-1">Password</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-primary-500 transition-colors">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" 
                               class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none"
                               placeholder="••••••••" required>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-bold text-gray-700 ml-1">Nomor WhatsApp/Telepon</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-primary-500 transition-colors">
                            <i class="fas fa-phone"></i>
                        </span>
                        <input type="text" name="no_telp" value="{{ old('no_telp') }}"
                               class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none"
                               placeholder="0812xxxxxx">
                    </div>
                </div>

<div class="col-span-1 md:col-span-2 space-y-3 pt-2">
                    <label class="text-[13px] font-bold text-slate-700 ml-1 uppercase tracking-wide">Hak Akses</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative flex items-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50/30 group">
                            <input type="radio" name="role" value="admin" class="sr-only" required>
                            <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-has-[:checked]:text-primary-600 group-has-[:checked]:border-primary-200 shadow-sm transition-all">
                                <i class="fas fa-user-shield text-base"></i>
                            </div>
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-slate-900 leading-none">Administrator</span>
                                <span class="block text-[11px] text-slate-500 mt-1">Akses penuh manajemen sistem</span>
                            </div>
                            <div class="ml-auto">
                                <div class="w-5 h-5 rounded-full border-2 border-slate-200 flex items-center justify-center group-has-[:checked]:border-primary-500 transition-colors">
                                    <div class="w-2.5 h-2.5 rounded-full bg-primary-500 opacity-0 group-has-[:checked]:opacity-100 transition-all scale-50 group-has-[:checked]:scale-100"></div>
                                </div>
                            </div>
                        </label>

                        <label class="relative flex items-center p-4 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/30 group">
                            <input type="radio" name="role" value="user" class="sr-only">
                            <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-has-[:checked]:text-blue-600 group-has-[:checked]:border-blue-200 shadow-sm transition-all">
                                <i class="fas fa-user text-base"></i>
                            </div>
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-slate-900 leading-none">User Biasa</span>
                                <span class="block text-[11px] text-slate-500 mt-1">Akses standar operasional</span>
                            </div>
                            <div class="ml-auto">
                                <div class="w-5 h-5 rounded-full border-2 border-slate-200 flex items-center justify-center group-has-[:checked]:border-blue-500 transition-colors">
                                    <div class="w-2.5 h-2.5 rounded-full bg-blue-500 opacity-0 group-has-[:checked]:opacity-100 transition-all scale-50 group-has-[:checked]:scale-100"></div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-50 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-xs text-gray-400">
                    <i class="fas fa-info-circle mr-1"></i>
                    Data yang disimpan dapat diubah kembali nanti melalui menu Edit.
                </p>
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <a href="{{ route('users.index') }}" 
                       class="w-full md:w-auto px-6 py-2.5 text-center text-sm font-bold text-gray-600 hover:text-gray-900 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="w-full md:w-auto px-8 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-bold shadow-lg shadow-primary-200 transition-all">
                        Simpan Data User
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection