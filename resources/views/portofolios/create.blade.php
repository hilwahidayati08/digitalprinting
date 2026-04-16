@extends('admin.admin')

@section('title', 'Tambah Portofolio - Admin Panel')

@section('content')
<div class="max-full mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Tambah Portofolio</h1>
            <p class="text-sm text-gray-500 font-medium italic">Tambahkan karya atau proyek baru ke daftar portofolio</p>
        </div>
        <a href="{{ route('portofolio.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700
                  rounded-xl text-xs font-black uppercase tracking-wider transition-all shadow-sm w-fit">
            <i class="fas fa-arrow-left text-sm"></i> Kembali
        </a>
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

    <form action="{{ route('portofolios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-12 gap-8">

            {{-- KOLOM KIRI --}}
            <div class="col-span-12 lg:col-span-8 space-y-6">

                {{-- Info Portofolio --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 space-y-6">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-4">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
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
                               value="{{ old('title') }}"
                               placeholder="Contoh: Desain Packaging Premium..."
                               required
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-2xl
                                      text-sm font-bold text-gray-800 placeholder:font-normal placeholder:text-gray-400
                                      focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
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
                                         focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all resize-none">{{ old('description') }}</textarea>
                    </div>
                </div>

                {{-- Upload Gambar --}}
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center gap-3 border-b border-gray-50 pb-4 mb-6">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <i class="fas fa-image"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Gambar Portofolio</h3>
                    </div>

                    <label for="photo_create"
                           class="group relative flex flex-col items-center justify-center w-full h-56
                                  border-2 border-dashed border-gray-200 rounded-2xl cursor-pointer
                                  bg-gray-50 hover:bg-blue-50 hover:border-blue-400 transition-all duration-200"
                           id="dropzone-create">

                        <img id="preview-create" src="#" alt="preview"
                             class="hidden w-full h-full object-cover rounded-2xl absolute inset-0">

                        <div id="placeholder-create" class="flex flex-col items-center gap-3 text-center px-6">
                            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center
                                        group-hover:bg-blue-200 group-hover:scale-110 transition-all duration-200">
                                <i class="fas fa-cloud-upload-alt text-2xl text-blue-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-black text-gray-700">Klik atau drag & drop gambar</p>
                                <p class="text-[10px] text-gray-400 font-medium mt-0.5">JPG, JPEG, PNG — Maks. 2MB</p>
                            </div>
                        </div>

                        <input type="file" id="photo_create" name="photo"
                               accept="image/jpg,image/jpeg,image/png"
                               class="hidden" required
                               onchange="previewImage(this, 'preview-create', 'placeholder-create', 'file-info-create', 'file-name-create')">
                    </label>

                    <div id="file-info-create" class="hidden mt-3 items-center justify-between
                         px-3 py-2 bg-blue-50 border border-blue-100 rounded-xl">
                        <span class="text-[10px] font-black text-blue-700 truncate" id="file-name-create">-</span>
                        <button type="button"
                                onclick="clearImage('photo_create','preview-create','placeholder-create','file-info-create')"
                                class="text-rose-500 hover:text-rose-700 ml-2 text-xs font-black shrink-0">
                            <i class="fas fa-times"></i> Hapus
                        </button>
                    </div>

                    {{-- Tips --}}
                    <div class="mt-4 p-4 bg-amber-50 border border-amber-100 rounded-2xl">
                        <p class="text-[10px] font-black text-amber-700 uppercase tracking-widest mb-2">
                            <i class="fas fa-lightbulb mr-1"></i> Tips
                        </p>
                        <ul class="text-[11px] text-amber-700 font-medium space-y-1">
                            <li>• Gunakan gambar rasio 16:9 untuk tampilan terbaik</li>
                            <li>• Resolusi minimal 800×450 px</li>
                            <li>• Judul singkat dan deskriptif lebih menarik</li>
                        </ul>
                    </div>
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
                            <input type="checkbox" id="is_active_create" name="is_active" value="1"
                                   class="sr-only peer" checked>
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
                        <i class="fas fa-save text-blue-500"></i> Simpan
                    </h3>
                    <button type="submit"
                            class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl
                                   font-black shadow-lg shadow-blue-200 transition-all transform active:scale-95
                                   text-sm uppercase tracking-widest">
                        <i class="fas fa-save mr-2"></i> Simpan Portofolio
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
function previewImage(input, previewId, placeholderId, fileInfoId, fileNameId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById(previewId);
        const placeholder = document.getElementById(placeholderId);
        const fileInfo = document.getElementById(fileInfoId);
        const fileName = document.getElementById(fileNameId);
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        fileInfo.classList.remove('hidden');
        fileInfo.classList.add('flex');
        if (fileName) fileName.textContent = file.name;
    };
    reader.readAsDataURL(file);
}

function clearImage(inputId, previewId, placeholderId, fileInfoId) {
    document.getElementById(inputId).value = '';
    document.getElementById(previewId).src = '#';
    document.getElementById(previewId).classList.add('hidden');
    document.getElementById(placeholderId).classList.remove('hidden');
    document.getElementById(fileInfoId).classList.add('hidden');
    document.getElementById(fileInfoId).classList.remove('flex');
}
</script>
@endsection