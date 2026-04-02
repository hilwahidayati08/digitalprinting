@extends('admin.admin')

@section('title', 'Tambah Bahan Baku - Admin Panel')
@section('page-title', 'Tambah Bahan Baku')

@section('breadcrumbs')
<nav class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="/" class="text-sm text-gray-500 hover:text-primary-600">Dashboard</a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                <a href="{{ route('materials.index') }}" class="text-sm text-gray-500 hover:text-primary-600">Bahan Baku</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                <span class="text-sm font-medium text-gray-900">Tambah Baru</span>
            </div>
        </li>
    </ol>
</nav>
@endsection

@section('content')
<div class="max-full">
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

<div class="p-6 border-b border-gray-50">
<h2 class="text-lg font-bold text-gray-900">Form Bahan Baku Baru</h2>
<p class="text-sm text-gray-500">Masukkan detail bahan baku untuk keperluan inventaris cetak</p>
</div>

<form action="{{ route('materials.store') }}" method="POST" class="p-6 space-y-6">
@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

{{-- Nama Bahan --}}
<div class="md:col-span-2">
<label class="block text-sm font-bold text-gray-700 mb-2">Nama Bahan Baku</label>
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
<i class="fas fa-box text-sm"></i>
</span>
<input type="text" name="material_name" value="{{ old('material_name') }}" required
class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all text-sm"
placeholder="Contoh: Flexy China 280gr, Art Paper A3">
</div>
</div>

{{-- Jenis Material --}}
<div>
<label class="block text-sm font-bold text-gray-700 mb-2">Jenis Material</label>
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
<i class="fas fa-layer-group text-sm"></i>
</span>
<select name="material_type" required
class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 text-sm appearance-none">
<option value="">-- Pilih Jenis --</option>
<option value="roll">Roll</option>
<option value="sheet">Sheet / Lembar</option>
<option value="pcs">Pcs</option>
</select>
</div>
</div>

{{-- Satuan Unit --}}
<div>
<label class="block text-sm font-bold text-gray-700 mb-2">Satuan Utama</label>
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
<i class="fas fa-ruler-combined text-sm"></i>
</span>
<select name="unit_id" required
class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 text-sm appearance-none">
<option value="">-- Pilih Satuan --</option>
@foreach($units as $unit)
<option value="{{ $unit->unit_id }}">{{ $unit->unit_name }}</option>
@endforeach
</select>
</div>
</div>

{{-- Lebar --}}
<div>
<label class="block text-sm font-bold text-gray-700 mb-2">Lebar Material (cm)</label>
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
<i class="fas fa-arrows-alt-h text-sm"></i>
</span>
<input type="number" step="0.01" name="width_cm"
class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm"
placeholder="Contoh: 160">
</div>
</div>

{{-- Tinggi --}}
<div>
<label class="block text-sm font-bold text-gray-700 mb-2">Tinggi Material (cm)</label>
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
<i class="fas fa-arrows-alt-v text-sm"></i>
</span>
<input type="number" step="0.01" name="height_cm"
class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm"
placeholder="Contoh: 100">
</div>
</div>

{{-- Spacing --}}
<div class="md:col-span-2">
<label class="block text-sm font-bold text-gray-700 mb-2">Spacing (mm)</label>
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
<i class="fas fa-grip-lines text-sm"></i>
</span>
<input type="number" step="0.01" name="spacing_mm" value="0"
class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm">
</div>
</div>

{{-- Stok Awal --}}
<div class="md:col-span-2">
<label class="block text-sm font-bold text-gray-700 mb-2">
Stok Awal
<span class="text-gray-400 font-normal text-xs ml-1">(akan otomatis tercatat di riwayat stok)</span>
</label>
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
<i class="fas fa-warehouse text-sm"></i>
</span>
<input type="number" step="0.01" name="stock" value="0" required
class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm">
</div>
</div>

</div>

<div class="pt-4 flex items-center gap-3 border-t border-gray-50">
<button type="submit"
class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl shadow-md transition-all font-bold text-sm flex items-center gap-2">
<i class="fas fa-save"></i>
<span>Simpan Bahan</span>
</button>

<a href="{{ route('materials.index') }}"
class="px-6 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 transition-all font-bold text-sm">
Batal
</a>
</div>

</form>
</div>
</div>
@endsection