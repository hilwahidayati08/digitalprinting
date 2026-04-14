@extends('layouts.app')

@section('title', 'Tambah Portofolio')
@section('page-title', 'Tambah Portofolio')

@section('content')

<div class="max-w-full">

    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Tambah Portofolio</h2>
            <p class="text-sm text-gray-500 font-medium italic">Tambahkan karya atau proyek baru ke daftar portofolio</p>
        </div>
        <a href="{{ route('portofolios.index') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700
                  rounded-xl text-xs font-black uppercase tracking-wider transition-all shadow-sm">
            <i class="fas fa-arrow-left text-sm"></i> Kembali
        </a>
    </div>

    {{-- ===== ERROR ALERT ===== --}}
    @if($errors->any())
    <div class="mb-6 flex items-start gap-3 p-4 bg-rose-50 border border-rose-200 rounded-2xl text-rose-700">
        <i class="fas fa-exclamation-circle mt-0.5 text-rose-500"></i>
        <ul class="text-xs font-bold space-y-1">
            @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- ===== FORM CARD ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Card top accent --}}
        <div class="h-1.5 bg-gradient-to-r from-blue-500 via-indigo-500 to-blue-400"></div>

        <div class="p-6 md:p-8">
            <form action="{{ route('portofolios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- ===== LEFT COL ===== --}}
                    <div class="space-y-6">

                        {{-- Title --}}
                        <div>
                            <label class="block text-[11px] font-black text-gray-500 uppercase tracking-widest mb-2">
                                Judul Portofolio <span class="text-rose-500">*</span>
                            </label>
                            <input type="text"
                                   name="title"
                                   value="{{ old('title') }}"
                                   placeholder="Contoh: Desain Packaging Premium..."
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                                          text-sm font-bold text-gray-800 placeholder:font-normal placeholder:text-gray-400
                                          focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all"
                                   required>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block text-[11px] font-black text-gray-500 uppercase tracking-widest mb-2">
                                Deskripsi <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="description"
                                      rows="6"
                                      placeholder="Deskripsikan proyek ini secara singkat dan menarik..."
                                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                                             text-sm font-medium text-gray-800 placeholder:font-normal placeholder:text-gray-400
                                             focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all resize-none"
                                      required>{{ old('description') }}</textarea>
                        </div>

                        {{-- Status --}}
                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200 cursor-pointer"
                             onclick="document.getElementById('is_active_create').click()">
                            <input type="checkbox"
                                   id="is_active_create"
                                   name="is_active"
                                   value="1"
                                   checked
                                   class="w-4 h-4 accent-blue-600 cursor-pointer">
                            <div>
                                <p class="text-xs font-black text-gray-800 uppercase tracking-wider">Aktifkan Portofolio</p>
                                <p class="text-[10px] text-gray-400 font-medium">Portofolio akan tampil di halaman publik</p>
                            </div>
                            <span class="ml-auto inline-flex items-center gap-1 px-2 py-1 bg-emerald-50 text-emerald-700
                                         rounded-lg text-[9px] font-black uppercase tracking-wider border border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                            </span>
                        </div>

                    </div>

                    {{-- ===== RIGHT COL ===== --}}
                    <div class="space-y-6">

                        {{-- Photo Upload --}}
                        <div>
                            <label class="block text-[11px] font-black text-gray-500 uppercase tracking-widest mb-2">
                                Gambar Portofolio <span class="text-rose-500">*</span>
                            </label>

                            {{-- Drop zone --}}
                            <label for="photo_create"
                                   class="group relative flex flex-col items-center justify-center w-full h-56
                                          border-2 border-dashed border-gray-200 rounded-2xl cursor-pointer
                                          bg-gray-50 hover:bg-blue-50 hover:border-blue-400 transition-all duration-200"
                                   id="dropzone-create">

                                {{-- Preview --}}
                                <img id="preview-create"
                                     src="#"
                                     alt="preview"
                                     class="hidden w-full h-full object-cover rounded-2xl absolute inset-0">

                                {{-- Placeholder --}}
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

                                <input type="file"
                                       id="photo_create"
                                       name="photo"
                                       accept="image/jpg,image/jpeg,image/png"
                                       class="hidden"
                                       required
                                       onchange="previewImage(this, 'preview-create', 'placeholder-create', 'file-info-create')">
                            </label>

                            {{-- File info --}}
                            <div id="file-info-create" class="hidden mt-2 flex items-center justify-between
                                 px-3 py-2 bg-blue-50 border border-blue-100 rounded-xl">
                                <span class="text-[10px] font-black text-blue-700 truncate" id="file-name-create">-</span>
                                <button type="button" onclick="clearImage('photo_create','preview-create','placeholder-create','file-info-create')"
                                        class="text-rose-500 hover:text-rose-700 ml-2 text-xs font-black shrink-0">
                                    <i class="fas fa-times"></i> Hapus
                                </button>
                            </div>
                        </div>

                        {{-- Tips --}}
                        <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl">
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

                {{-- ===== ACTIONS ===== --}}
                <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-100">
                    <button type="submit"
                            class="px-7 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl
                                   text-xs font-black uppercase tracking-widest transition-all
                                   shadow-md shadow-blue-200 flex items-center gap-2">
                        <i class="fas fa-save"></i> Simpan Portofolio
                    </button>
                    <a href="{{ route('portofolios.index') }}"
                       class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl
                              text-xs font-black uppercase tracking-widest transition-all">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input, previewId, placeholderId, fileInfoId) {
    const file = input.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById(previewId);
        const placeholder = document.getElementById(placeholderId);
        const fileInfo = document.getElementById(fileInfoId);
        const fileName = document.getElementById(fileInfoId.replace('file-info', 'file-name'));

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
    const preview = document.getElementById(previewId);
    const placeholder = document.getElementById(placeholderId);
    const fileInfo = document.getElementById(fileInfoId);

    preview.src = '#';
    preview.classList.add('hidden');
    placeholder.classList.remove('hidden');
    fileInfo.classList.add('hidden');
    fileInfo.classList.remove('flex');
}
</script>

@endsection