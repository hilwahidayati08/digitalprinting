@extends('admin.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="max-full mx-auto px-4 py-8">
    
    {{-- Header & Breadcrumbs --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Produk Baru</h1>
        <p class="text-sm text-gray-500">Kelola informasi produk dan hubungkan dengan stok bahan baku.</p>
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

    @if (session('error'))
        <div class="mb-6 p-4 bg-orange-50 border-l-4 border-orange-500 text-orange-700 rounded-r-xl">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf
        <div class="grid grid-cols-12 gap-8">

            {{-- KOLOM KIRI: Form Utama --}}
            <div class="col-span-12 lg:col-span-8 space-y-6">
                
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-6">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-4">
                        <div class="w-10 h-10 bg-primary-50 rounded-xl flex items-center justify-center text-primary-600">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Informasi Umum</h3>
                    </div>

                    {{-- Nama Produk --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="product_name" value="{{ old('product_name') }}" required
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 outline-none transition-all"
                               placeholder="Contoh: Cetak Banner Flexy 280gr">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Kategori --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                            <select name="category_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:ring-4 focus:ring-primary-500/10 outline-none">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->category_id }}" {{ old('category_id') == $cat->category_id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Satuan Jual --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Satuan Jual</label>
                            <select name="unit_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:ring-4 focus:ring-primary-500/10 outline-none">
                                <option value="">Pilih Satuan</option>
                                @foreach($units as $u)
                                    <option value="{{ $u->unit_id }}" {{ old('unit_id') == $u->unit_id ? 'selected' : '' }}>
                                        {{ $u->unit_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- BAGIAN LINK STOK (GURU UTAMA) --}}
                    <div class="p-6 bg-blue-50/50 rounded-3xl border border-blue-100 space-y-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-blue-700 font-bold text-sm italic">
                                <i class="fas fa-link"></i> Link Stok Bahan Baku
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Bahan Baku Utama</label>
                            <select name="material_id" required class="w-full px-4 py-3 bg-white border border-blue-200 rounded-2xl text-sm shadow-sm focus:ring-4 focus:ring-blue-500/10 outline-none">
                                <option value="">-- Pilih Material untuk Dipotong Stoknya --</option>
                                @foreach($materials as $m)
                                    <option value="{{ $m->material_id }}" {{ old('material_id') == $m->material_id ? 'selected' : '' }}>
                                        {{ $m->material_name }} (Tersedia: {{ number_format($m->stock, 2) }} {{ $m->unit->unit_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-2">Panjang Default (cm)</label>
                                <input type="number" step="0.01" name="default_width_cm" value="{{ old('default_width_cm') }}" 
                                       class="w-full px-4 py-3 bg-white border border-blue-200 rounded-2xl text-sm font-bold">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-2">Lebar Default (m)</label>
                                <input type="number" step="0.01" name="default_height_cm" value="{{ old('default_height_cm') }}" 
                                       class="w-full px-4 py-3 bg-white border border-blue-200 rounded-2xl text-sm font-bold">
                            </div>
                        </div>

                        <div class="flex items-center gap-3 p-3 bg-white/50 rounded-xl">
                            <input type="checkbox" name="allow_custom_size" value="1" id="allow_custom" {{ old('allow_custom_size') ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="allow_custom" class="text-xs font-bold text-blue-800 uppercase tracking-tighter">Izinkan Pelanggan Input Ukuran Sendiri (Kustom)</label>
                        </div>
                    </div>

                    {{-- Harga --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Harga Jual (Rp)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 font-bold">Rp</span>
                            <input type="number" name="price" value="{{ old('price') }}" required
                                   class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-primary-500/10 outline-none font-black text-primary-600"
                                   placeholder="0">
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Produk</label>
                        <textarea name="description" rows="4" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl text-sm outline-none" placeholder="Jelaskan detail produk, keunggulan, dll...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Media & Status --}}
            <div class="col-span-12 lg:col-span-4 space-y-6">
                
                {{-- Upload Foto --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center justify-between">
                        Foto Produk 
                        <span class="text-[10px] bg-gray-100 px-2 py-1 rounded-lg text-gray-500 uppercase">Maks 5</span>
                    </h3>

                    <div id="dropzone" class="relative group border-2 border-dashed border-gray-200 rounded-2xl p-8 transition-all hover:bg-gray-50 hover:border-primary-400 text-center cursor-pointer">
                        <input type="file" name="photos[]" id="file-input" multiple accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer">
                        <div class="space-y-2 pointer-events-none">
                            <div class="w-12 h-12 bg-primary-50 text-primary-500 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                <i class="fas fa-cloud-upload-alt text-xl"></i>
                            </div>
                            <p class="text-xs font-bold text-gray-600">Klik atau Seret Gambar</p>
                            <p class="text-[10px] text-gray-400">PNG, JPG, WEBP (Maks 2MB)</p>
                        </div>
                    </div>

                    {{-- Preview Container --}}
                    <div id="preview-container" class="grid grid-cols-2 gap-3 mt-6">
                        {{-- JS akan mengisi preview di sini --}}
                    </div>

                    {{-- Hidden input untuk menyimpan index foto utama --}}
                    <input type="hidden" name="primary_photo" id="primary_index" value="0">
                </div>

                {{-- Status & Publish --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-700">Status Aktif</span>
                            <span class="text-[10px] text-gray-400">Tampil di katalog</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </label>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button type="submit" class="w-full py-4 bg-primary-600 hover:bg-primary-700 text-white rounded-2xl font-black shadow-lg shadow-primary-200 transition-all transform active:scale-95">
                            SIMPAN PRODUK
                        </button>
                        <a href="{{ route('products.index') }}" class="w-full py-4 bg-white border border-gray-200 text-gray-500 rounded-2xl text-center text-sm font-bold hover:bg-gray-50 transition-all">
                            Batal & Kembali
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

{{-- SCRIPT JAVASCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('file-input');
    const previewContainer = document.getElementById('preview-container');
    const primaryIndexInput = document.getElementById('primary_index');
    let selectedFiles = [];

    fileInput.addEventListener('change', function (e) {
        const files = Array.from(e.target.files);
        
        // Gabungkan file baru dengan yang lama (maksimal 5)
        files.forEach(file => {
            if (selectedFiles.length < 5) {
                selectedFiles.push(file);
            }
        });

        // Sync input file aseli (opsional jika menggunakan AJAX, tapi penting untuk form submit biasa)
        syncFileInput();
        renderPreviews();
    });

    function renderPreviews() {
        previewContainer.innerHTML = '';
        
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const isPrimary = (index == primaryIndexInput.value);
                
                const div = document.createElement('div');
                div.className = `relative aspect-square rounded-2xl overflow-hidden border-2 transition-all cursor-pointer group ${isPrimary ? 'border-primary-500 ring-2 ring-primary-500/20' : 'border-gray-100'}`;
                
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                         <p class="text-[10px] text-white font-bold uppercase">Set Utama</p>
                    </div>
                    ${isPrimary ? '<div class="absolute top-2 left-2 bg-primary-500 text-white text-[8px] px-2 py-1 rounded-md font-bold uppercase shadow-sm">Utama</div>' : ''}
                    <button type="button" class="btn-delete absolute top-2 right-2 w-6 h-6 bg-white/90 hover:bg-red-500 hover:text-white rounded-full flex items-center justify-center text-gray-600 transition-all shadow-sm" data-index="${index}">
                        <i class="fas fa-times text-xs pointer-events-none"></i>
                    </button>
                `;

                // Set Primary on Click
                div.onclick = (event) => {
                    if(!event.target.classList.contains('btn-delete')) {
                        primaryIndexInput.value = index;
                        renderPreviews();
                    }
                };

                // Delete Photo
                div.querySelector('.btn-delete').onclick = (event) => {
                    event.stopPropagation();
                    selectedFiles.splice(index, 1);
                    // Reset primary if the primary image was deleted
                    if (primaryIndexInput.value >= selectedFiles.length) {
                        primaryIndexInput.value = 0;
                    }
                    syncFileInput();
                    renderPreviews();
                };

                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    function syncFileInput() {
        // Karena input file bersifat read-only untuk alasan keamanan,
        // Kita menggunakan DataTransfer API untuk mengupdate file listnya
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }
});
</script>

<style>
    /* Styling khusus jika diperlukan */
    .bg-primary-600 { background-color: #2563eb; } /* Ganti dengan hex warna brand kamu */
    .text-primary-600 { color: #2563eb; }
    .focus-ring-primary-500 { --tw-ring-color: #3b82f6; }
</style>
@endsection