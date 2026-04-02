@extends('admin.admin')

@section('title', 'Tambah Unit - Admin Panel')
@section('page-title', 'Unit Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-5">
        <a href="{{ route('units.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-primary-600 transition-colors group">
            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 bg-slate-50/30">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center text-white shadow-md shadow-primary-200">
                    <i class="fas fa-plus text-sm"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold text-slate-900">Tambah Unit Baru</h2>
                    <p class="text-[12px] text-slate-500">Gunakan nama standar dan tentukan dimensi media cetak.</p>
                </div>
            </div>
        </div>

        <form action="{{ route('units.store') }}" method="POST" class="p-6 md:p-8">
            @csrf
            <div class="space-y-6">
                {{-- Nama Unit --}}
                <div class="space-y-1.5">
                    <label class="text-[13px] font-bold text-slate-700 ml-1 uppercase tracking-wide">Nama Unit</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-primary-500 transition-colors">
                            <i class="fas fa-tag text-sm"></i>
                        </span>
                        <input type="text" name="unit_name" value="{{ old('unit_name') }}"
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all outline-none text-sm"
                               placeholder="Contoh: A3+ / METER / PCS" required autofocus>
                    </div>
                    @error('unit_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

            <div class="mt-8 pt-6 border-t border-slate-50 flex items-center justify-end gap-3">
                <a href="{{ route('units.index') }}" class="px-6 py-2 text-sm font-bold text-slate-500">Batal</a>
                <button type="submit" class="px-8 py-2.5 bg-[#0f172a] text-white rounded-xl text-sm font-bold shadow-lg hover:bg-slate-800 transition-all flex items-center gap-2">
                    <i class="fas fa-save opacity-50"></i> Simpan Unit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection