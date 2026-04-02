@extends('admin.admin')

@section('title', 'Tambah Kategori Baru')

{{-- Isi judul dan deskripsi agar tampil di tempat yang benar sesuai layout --}}
@section('page-title', 'Tambah Kategori Baru')
@section('page-description', 'Buat kategori produk baru untuk mengatur metode perhitungan harga.')

@section('content')
<div class="max-w-4xl mx-auto px-4 pb-8">
    
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

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-6">
            
            <div class="flex items-center gap-3 border-b border-gray-50 pb-4">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                    <i class="fas fa-tags"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Detail Kategori</h3>
            </div>

            {{-- Nama Kategori --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" name="category_name" value="{{ old('category_name') }}" required autofocus
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all"
                       placeholder="Contoh: Banner, Stiker, Kartu Nama">
            </div>

            {{-- Tipe Perhitungan --}}
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Tipe Perhitungan <span class="text-red-500">*</span>
                </label>
                <select name="calc_type" required 
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                    <option value="" disabled selected>-- Pilih Metode Hitung Harga --</option>
                    <option value="satuan" {{ old('calc_type') == 'satuan' ? 'selected' : '' }}>Satuan (Pcs / Per Lembar)</option>
                    <option value="luas" {{ old('calc_type') == 'luas' ? 'selected' : '' }}>Luas (Meter Persegi - Contoh: Banner)</option>
                    <option value="stiker" {{ old('calc_type') == 'stiker' ? 'selected' : '' }}>Stiker (Nesting / Area A3+)</option>
                </select>
                <p class="mt-2 text-[11px] text-gray-400 font-medium italic">
                    * Pilihan ini menentukan rumus harga yang muncul di halaman kasir/pelanggan.
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col md:flex-row gap-3 pt-4 border-t border-gray-50">
                <button type="submit" class="flex-1 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black shadow-lg shadow-blue-200 transition-all transform active:scale-95 flex items-center justify-center gap-2 uppercase tracking-tight">
                    <i class="fas fa-save"></i>
                    SIMPAN KATEGORI
                </button>
                <a href="{{ route('categories.index') }}" class="px-8 py-4 bg-white border border-gray-200 text-gray-500 rounded-2xl text-center text-sm font-bold hover:bg-gray-50 transition-all">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection