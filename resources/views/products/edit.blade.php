@extends('admin.admin')

@section('title', 'Edit Produk - Admin Panel')
@section('page-title', 'Edit Produk')

@section('breadcrumbs')
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="/" class="text-sm text-gray-500 hover:text-primary-600">Dashboard</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                    <a href="{{ route('products.index') }}" class="text-sm text-gray-500 hover:text-primary-600">Produk</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                    <span class="text-sm font-medium text-gray-900">Edit: {{ $product->product_name }}</span>
                </div>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="max-w-6xl">

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl">
            <ul class="text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->product_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-12 gap-6">

            {{-- KIRI --}}
            <div class="col-span-12 lg:col-span-8 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-primary-600"></i> Informasi Umum
                    </h3>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                        <input type="text" name="product_name"
                               value="{{ old('product_name', $product->product_name) }}" required
                               class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all text-sm">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                            <select name="category_id" required class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-500/10 text-sm appearance-none">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->category_id }}" {{ $product->category_id == $cat->category_id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Satuan Jual</label>
                            <select name="unit_id" required class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-500/10 text-sm appearance-none">
                                @foreach($units as $u)
                                    <option value="{{ $u->unit_id }}" {{ $product->unit_id == $u->unit_id ? 'selected' : '' }}>
                                        {{ $u->unit_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Inventaris --}}
                    <div class="p-5 bg-blue-50/50 rounded-2xl border border-blue-100 space-y-4">
                        <div class="flex items-center gap-2 text-blue-700 font-black text-xs uppercase tracking-widest">
                            <i class="fas fa-calculator"></i> Link Stok Bahan Baku
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Bahan yang Digunakan</label>
                            <select name="material_id" required class="w-full px-4 py-2.5 bg-white border border-blue-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 text-sm shadow-sm">
                                @foreach($materials as $m)
                                    <option value="{{ $m->material_id }}" {{ $product->material_id == $m->material_id ? 'selected' : '' }}>
                                        {{ $m->material_name }} (Sisa: {{ number_format($m->stock, 2) }} {{ $m->unit->unit_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Panjang Bahan (m)</label>
<input type="number" step="0.01" name="default_width_cm"
       value="{{ old('default_width_cm', $product->default_width_cm 
           ? $product->default_width_cm / 100 
           : '') }}" required
       class="w-full px-4 py-2.5 border border-blue-200 rounded-xl text-sm font-bold">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Lebar Bahan (m)</label>
<input type="number" step="0.01" name="default_height_cm"
       value="{{ old('default_height_cm', $product->default_height_cm 
           ? $product->default_height_cm / 100 
           : '') }}" required
       class="w-full px-4 py-2.5 border border-blue-200 rounded-xl text-sm font-bold">
                            </div>
                        </div>
                        <p class="text-[10px] text-blue-500 italic font-medium leading-relaxed">
                            *Setiap 1 unit produk terjual, stok bahan baku akan otomatis berkurang sebanyak <b>(Panjang x Lebar)</b>.
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Harga Jual (Rp)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold text-sm">Rp</span>
                            <input type="number" name="price"
                                   value="{{ old('price', $product->price) }}" required
                                   class="w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-500/10 text-sm font-bold">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Produk</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"
                                  placeholder="Detail produk...">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- KANAN --}}
            <div class="col-span-12 lg:col-span-4 space-y-6">

                {{-- Manajemen Foto --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-1">Foto Produk</h3>
                    <p class="text-[10px] text-gray-400 mb-4">Centang foto lama untuk dihapus • Tambah foto baru di bawah</p>

                    {{-- Foto lama --}}
                    @if($product->images->count() > 0)
                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-2">Foto Tersimpan</p>
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            @foreach($product->images as $img)
                                <div class="relative aspect-square rounded-xl overflow-hidden border-2 {{ $img->is_primary ? 'border-amber-400' : 'border-gray-200' }} shadow-sm">
                                    <img src="{{ asset('storage/' . $img->photo) }}"
                                         class="w-full h-full object-cover">

                                    {{-- Badge primary --}}
                                    @if($img->is_primary)
                                        <div class="absolute bottom-0 left-0 right-0 bg-amber-400/90 text-white text-[10px] font-bold text-center py-0.5">
                                            ★ Primary
                                        </div>
                                    @endif

                                    {{-- Checkbox hapus --}}
                                    <label class="absolute top-1.5 right-1.5 cursor-pointer"
                                           title="Centang untuk hapus foto ini">
                                        <input type="checkbox" name="delete_photos[]"
                                               value="{{ $img->image_id }}"
                                               class="sr-only peer">
                                        <div class="w-5 h-5 rounded bg-white/80 border-2 border-gray-300 flex items-center justify-center
                                                    peer-checked:bg-red-500 peer-checked:border-red-500 transition-all">
                                            <i class="fas fa-trash text-[8px] text-white opacity-0 peer-checked:opacity-100"></i>
                                        </div>
                                    </label>

                                    {{-- Overlay hapus --}}
                                    <div class="absolute inset-0 bg-red-500/20 opacity-0 peer-checked:opacity-100 transition-all pointer-events-none"></div>
                                </div>
                            @endforeach
                        </div>
                        <p class="text-[10px] text-red-400 italic mb-4">*Centang foto di atas untuk menghapusnya</p>
                    @endif

                    {{-- Tambah foto baru --}}
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mb-2">Tambah Foto Baru</p>
                    <div class="relative group border-2 border-dashed border-gray-200 rounded-2xl p-4 transition-all hover:bg-gray-50 hover:border-primary-300 text-center cursor-pointer">
                        <input type="file" name="photos[]" id="file-upload"
                               class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                               multiple accept="image/*">
                        <div class="space-y-1 pointer-events-none">
                            <i class="fas fa-cloud-upload-alt text-xl text-gray-300 group-hover:text-primary-500 transition-colors"></i>
                            <p class="text-xs font-bold text-gray-500">Klik atau seret foto</p>
                            <p class="text-[10px] text-gray-400">JPG, PNG, WEBP • Maks 2MB/foto</p>
                        </div>
                    </div>

                    <p id="foto-info" class="text-[10px] text-gray-400 mt-2 text-center min-h-[16px]"></p>
                    <div id="image-preview" class="grid grid-cols-2 gap-2 mt-2"></div>
                    <input type="hidden" name="primary_photo" id="primary_photo" value="0">

                    @error('photos') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    @error('photos.*') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Status --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-900">Status Produk</p>
                            <p class="text-[10px] text-gray-500">Tampilkan di website</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                   class="sr-only peer" {{ $product->is_active ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                        </label>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex flex-col gap-2">
                    <button type="submit" class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-2xl shadow-lg shadow-primary-200 font-bold transition-all">
                        <i class="fas fa-save mr-1"></i> Update Produk
                    </button>
                    <a href="{{ route('products.index') }}" class="w-full py-3 bg-white border border-gray-200 text-gray-600 rounded-2xl text-center font-bold hover:bg-gray-50 transition-all">
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
(function () {
    var allFiles     = [];
    var input        = document.getElementById('file-upload');
    var grid         = document.getElementById('image-preview');
    var primaryInput = document.getElementById('primary_photo');
    var fotoInfo     = document.getElementById('foto-info');
    var MAX_PHOTOS   = 5;

    input.addEventListener('change', function () {
        Array.from(this.files).forEach(function (newFile) {
            var isDuplicate = allFiles.some(function (f) {
                return f.name === newFile.name && f.size === newFile.size;
            });
            if (!isDuplicate) allFiles.push(newFile);
        });

        if (allFiles.length > MAX_PHOTOS) {
            alert('Maksimal ' + MAX_PHOTOS + ' foto baru!');
            allFiles = allFiles.slice(0, MAX_PHOTOS);
        }

        syncToInput();
        renderPreviews();
    });

    function syncToInput() {
        var dt = new DataTransfer();
        allFiles.forEach(function (f) { dt.items.add(f); });
        input.files = dt.files;
    }

    function renderPreviews() {
        grid.innerHTML = '';
        if (allFiles.length === 0) { fotoInfo.textContent = ''; return; }

        fotoInfo.textContent = allFiles.length + ' foto baru ditambahkan';
        var currentPrimary = parseInt(primaryInput.value) || 0;

        allFiles.forEach(function (file, index) {
            var reader = new FileReader();
            reader.onload = function (ev) {
                var isPrimary = (index === currentPrimary);

                var wrapper = document.createElement('div');
                wrapper.className = 'relative aspect-square rounded-xl overflow-hidden shadow-sm cursor-pointer';
                wrapper.style.border = '2px solid ' + (isPrimary ? '#f59e0b' : '#e5e7eb');

                var img = document.createElement('img');
                img.src = ev.target.result;
                img.className = 'w-full h-full object-cover';

                var badge = document.createElement('div');
                badge.textContent = '★ Primary';
                badge.style.cssText =
                    'position:absolute;bottom:0;left:0;right:0;' +
                    'background:rgba(245,158,11,0.9);color:#fff;' +
                    'font-size:10px;font-weight:700;text-align:center;padding:3px 0;' +
                    'display:' + (isPrimary ? 'block' : 'none') + ';';

                var btnDel = document.createElement('button');
                btnDel.type = 'button';
                btnDel.innerHTML = '&times;';
                btnDel.style.cssText =
                    'position:absolute;top:4px;right:4px;' +
                    'background:rgba(0,0,0,0.6);color:#fff;border:none;border-radius:50%;' +
                    'width:20px;height:20px;font-size:14px;line-height:1;cursor:pointer;' +
                    'display:flex;align-items:center;justify-content:center;padding:0;';

                wrapper.addEventListener('click', function (e) {
                    if (e.target === btnDel) return;
                    primaryInput.value = index;
                    renderPreviews();
                });

                btnDel.addEventListener('click', function () {
                    allFiles.splice(index, 1);
                    var p = parseInt(primaryInput.value) || 0;
                    if (index < p) p = Math.max(0, p - 1);
                    else if (index === p) p = 0;
                    primaryInput.value = allFiles.length > 0 ? p : 0;
                    syncToInput();
                    renderPreviews();
                });

                wrapper.appendChild(img);
                wrapper.appendChild(badge);
                wrapper.appendChild(btnDel);
                grid.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }

    // Visual overlay merah saat centang hapus foto lama
    document.querySelectorAll('input[name="delete_photos[]"]').forEach(function (cb) {
        cb.addEventListener('change', function () {
            var card = cb.closest('.relative.aspect-square');
            if (card) {
                card.style.opacity = cb.checked ? '0.5' : '1';
                card.style.outline = cb.checked ? '2px solid #ef4444' : '';
            }
        });
    });
})();
</script>
@endsection