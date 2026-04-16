@extends('admin.admin')

@section('title', 'Edit Portofolio - Admin Panel')

@section('content')
<div class="max-full mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Portofolio</h1>
            <p class="text-sm text-gray-500 font-medium italic">Perbarui informasi portofolio yang sudah ada</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-4 py-2 bg-gray-100 rounded-2xl text-xs font-bold text-gray-600 uppercase tracking-widest">
                ID: #{{ $portofolio->portofolio_id }}
            </span>
            <a href="{{ route('portofolio.index') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700
                      rounded-xl text-xs font-black uppercase tracking-wider transition-all shadow-sm">
                <i class="fas fa-arrow-left text-sm"></i> Kembali
            </a>
        </div>
    </div>

    {{-- Error Alert --}}
    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
        <p class="font-bold mb-1 italic text-sm">Ada kesalahan input:</p>
        <ul class="text-xs list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('portofolios.update', $portofolio->portofolio_id) }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-12 gap-8">

            {{-- KOLOM KIRI --}}
            <div class="col-span-12 lg:col-span-8 space-y-6">

                {{-- Info Portofolio --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-6">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-4">
                        <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Informasi Portofolio</h3>
                    </div>

                    {{-- Judul --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Judul Portofolio <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               value="{{ old('title', $portofolio->title) }}"
                               placeholder="Contoh: Desain Packaging Premium..."
                               required
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl
                                      text-sm font-bold text-gray-800 placeholder:font-normal placeholder:text-gray-400
                                      focus:ring-4 focus:ring-amber-400/20 focus:border-amber-400 outline-none transition-all">
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description"
                                  rows="6"
                                  placeholder="Deskripsikan proyek ini secara singkat dan menarik..."
                                  required
                                  class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl
                                         text-sm font-medium text-gray-800 placeholder:font-normal placeholder:text-gray-400
                                         focus:ring-4 focus:ring-amber-400/20 focus:border-amber-400 outline-none transition-all resize-none">{{ old('description', $portofolio->description) }}</textarea>
                    </div>

                    {{-- Meta Info --}}
                    <div class="grid grid-cols-2 gap-3 pt-2">
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Slug</p>
                            <p class="text-xs font-bold text-gray-600 truncate">{{ $portofolio->slug ?? '-' }}</p>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Dibuat</p>
                            <p class="text-xs font-bold text-gray-600">{{ $portofolio->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Gambar --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-4 mb-6">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <i class="fas fa-image"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Gambar Portofolio</h3>
                    </div>

                    {{-- Preview gambar saat ini --}}
                    @if($portofolio->photo)
                    <div class="mb-4">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Gambar Saat Ini</p>
                        <div class="relative rounded-2xl overflow-hidden border border-gray-200 bg-gray-50">
                            <img src="{{ asset('storage/portofolios/' . $portofolio->photo) }}"
                                 alt="{{ $portofolio->title }}"
                                 id="current-photo"
                                 class="w-full h-48 object-cover">
                            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/60 to-transparent p-3">
                                <p class="text-[10px] font-black text-white/80 uppercase tracking-widest">
                                    <i class="fas fa-image mr-1"></i> {{ $portofolio->photo }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Upload baru --}}
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        {{ $portofolio->photo ? 'Ganti Gambar' : 'Upload Gambar' }}
                        @if(!$portofolio->photo)<span class="text-red-500">*</span>@endif
                    </p>

                    <label for="photo_edit"
                           class="group relative flex flex-col items-center justify-center w-full h-44
                                  border-2 border-dashed border-gray-200 rounded-2xl cursor-pointer
                                  bg-gray-50 hover:bg-amber-50 hover:border-amber-400 transition-all duration-200">

                        <img id="preview-edit" src="#" alt="preview"
                             class="hidden w-full h-full object-cover rounded-2xl absolute inset-0">

                        <div id="placeholder-edit" class="flex flex-col items-center gap-3 text-center px-6">
                            <div class="w-12 h-12 rounded-2xl bg-amber-100 flex items-center justify-center
                                        group-hover:bg-amber-200 group-hover:scale-110 transition-all duration-200">
                                <i class="fas fa-cloud-upload-alt text-xl text-amber-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-gray-700">Klik untuk ganti gambar</p>
                                <p class="text-[10px] text-gray-400 font-medium mt-0.5">JPG, JPEG, PNG — Maks. 2MB</p>
                            </div>
                        </div>

                        <input type="file" id="photo_edit" name="photo"
                               accept="image/jpg,image/jpeg,image/png"
                               class="hidden"
                               onchange="previewImage(this)">
                    </label>

                    <div id="file-info-edit" class="hidden mt-3 items-center justify-between
                         px-3 py-2 bg-amber-50 border border-amber-100 rounded-xl">
                        <span class="text-[10px] font-black text-amber-700 truncate" id="file-name-edit">-</span>
                        <button type="button"
                                onclick="clearImage()"
                                class="text-rose-500 hover:text-rose-700 ml-2 text-xs font-black shrink-0">
                            <i class="fas fa-times"></i> Hapus
                        </button>
                    </div>

                    @if($portofolio->photo)
                    <p class="text-[10px] text-gray-400 font-medium mt-2 flex items-center gap-1">
                        <i class="fas fa-info-circle text-blue-400"></i>
                        Kosongkan jika tidak ingin mengganti gambar
                    </p>
                    @endif
                </div>

            </div>

            {{-- KOLOM KANAN --}}
            <div class="col-span-12 lg:col-span-4 space-y-6">

                {{-- Status --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-toggle-on text-emerald-500"></i> Status Portofolio
                    </h3>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-700 uppercase">Tampilkan di Publik</span>
                            <span class="text-[10px] text-gray-400">Aktifkan agar terlihat pengunjung</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" id="is_active_edit" name="is_active" value="1"
                                   class="sr-only peer" {{ $portofolio->is_active ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer
                                        peer-checked:after:translate-x-full peer-checked:after:border-white
                                        after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                        after:bg-white after:border-gray-300 after:border after:rounded-full
                                        after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 space-y-3">
                    <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-save text-amber-500"></i> Simpan Perubahan
                    </h3>
                    <button type="submit"
                            class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl
                                   font-black shadow-lg shadow-blue-200 transition-all transform active:scale-95
                                   text-sm uppercase tracking-widest">
                        <i class="fas fa-save mr-2"></i> Update Portofolio
                    </button>
                    <a href="{{ route('portofolios.index') }}"
                       class="w-full block py-4 bg-white border border-gray-200 text-gray-500 rounded-2xl
                              text-center text-sm font-bold hover:bg-gray-50 transition-all">
                        Batal & Kembali
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('preview-edit');
        const placeholder = document.getElementById('placeholder-edit');
        const fileInfo = document.getElementById('file-info-edit');
        const fileName = document.getElementById('file-name-edit');
        const currentPhoto = document.getElementById('current-photo');

        preview.src = e.target.result;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        fileInfo.classList.remove('hidden');
        fileInfo.classList.add('flex');
        fileName.textContent = file.name;
        if (currentPhoto) currentPhoto.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function clearImage() {
    document.getElementById('photo_edit').value = '';
    document.getElementById('preview-edit').src = '#';
    document.getElementById('preview-edit').classList.add('hidden');
    document.getElementById('placeholder-edit').classList.remove('hidden');
    document.getElementById('file-info-edit').classList.add('hidden');
    document.getElementById('file-info-edit').classList.remove('flex');
}

function confirmDelete() {
    Swal.fire({
        title: 'Hapus Portofolio?',
        text: "Data akan terhapus permanen dan tidak bisa dipulihkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'YA, HAPUS!',
        cancelButtonText: 'BATAL',
        customClass: {
            confirmButton: 'font-black tracking-widest uppercase text-xs',
            cancelButton: 'font-black tracking-widest uppercase text-xs'
        }
    }).then(result => {
        if (result.isConfirmed) {
            document.getElementById('delete-porto-form').submit();
        }
    });
}
</script>
@endsection