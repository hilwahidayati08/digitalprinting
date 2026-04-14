@extends('layouts.app')

@section('title', 'Edit Portofolio')
@section('page-title', 'Edit Portofolio')

@section('content')

<div class="max-w-full">

    {{-- ===== HEADER ===== --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Edit Portofolio</h2>
            <p class="text-sm text-gray-500 font-medium italic">Perbarui informasi portofolio yang sudah ada</p>
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
        <div class="h-1.5 bg-gradient-to-r from-amber-400 via-orange-400 to-amber-500"></div>

        <div class="p-6 md:p-8">
            <form action="{{ route('portofolios.update', $portofolio->portofolio_id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

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
                                   value="{{ old('title', $portofolio->title) }}"
                                   placeholder="Contoh: Desain Packaging Premium..."
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl
                                          text-sm font-bold text-gray-800 placeholder:font-normal placeholder:text-gray-400
                                          focus:ring-4 focus:ring-amber-400/20 focus:border-amber-400 outline-none transition-all"
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
                                             focus:ring-4 focus:ring-amber-400/20 focus:border-amber-400 outline-none transition-all resize-none"
                                      required>{{ old('description', $portofolio->description) }}</textarea>
                        </div>

                        {{-- Status --}}
                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl border border-gray-200 cursor-pointer"
                             onclick="toggleStatus()"
                             id="status-toggle">
                            <input type="checkbox"
                                   id="is_active_edit"
                                   name="is_active"
                                   value="1"
                                   {{ $portofolio->is_active ? 'checked' : '' }}
                                   class="w-4 h-4 accent-blue-600 cursor-pointer"
                                   onclick="event.stopPropagation(); updateStatusBadge()">
                            <div>
                                <p class="text-xs font-black text-gray-800 uppercase tracking-wider">Status Portofolio</p>
                                <p class="text-[10px] text-gray-400 font-medium">Centang untuk menampilkan di halaman publik</p>
                            </div>
                            <span id="status-badge" class="ml-auto inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider border
                                {{ $portofolio->is_active
                                    ? 'bg-emerald-50 text-emerald-700 border-emerald-100'
                                    : 'bg-gray-100 text-gray-500 border-gray-200' }}">
                                <span id="status-dot" class="w-1.5 h-1.5 rounded-full {{ $portofolio->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                <span id="status-text">{{ $portofolio->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                            </span>
                        </div>

                        {{-- Meta info --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">ID Portofolio</p>
                                <p class="text-xs font-black text-gray-700">#{{ $portofolio->portofolio_id }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl border border-gray-100">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Slug</p>
                                <p class="text-xs font-bold text-gray-600 truncate">{{ $portofolio->slug ?? '-' }}</p>
                            </div>
                        </div>

                    </div>

                    {{-- ===== RIGHT COL ===== --}}
                    <div class="space-y-6">

                        {{-- Current Photo --}}
                        @if($portofolio->photo)
                        <div>
                            <label class="block text-[11px] font-black text-gray-500 uppercase tracking-widest mb-2">
                                Gambar Saat Ini
                            </label>
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

                        {{-- New Photo Upload --}}
                        <div>
                            <label class="block text-[11px] font-black text-gray-500 uppercase tracking-widest mb-2">
                                {{ $portofolio->photo ? 'Ganti Gambar' : 'Upload Gambar' }}
                                @if(!$portofolio->photo)<span class="text-rose-500">*</span>@endif
                            </label>

                            <label for="photo_edit"
                                   class="group relative flex flex-col items-center justify-center w-full h-44
                                          border-2 border-dashed border-gray-200 rounded-2xl cursor-pointer
                                          bg-gray-50 hover:bg-amber-50 hover:border-amber-400 transition-all duration-200"
                                   id="dropzone-edit">

                                <img id="preview-edit"
                                     src="#"
                                     alt="preview"
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

                                <input type="file"
                                       id="photo_edit"
                                       name="photo"
                                       accept="image/jpg,image/jpeg,image/png"
                                       class="hidden"
                                       onchange="previewImage(this, 'preview-edit', 'placeholder-edit', 'file-info-edit')">
                            </label>

                            <div id="file-info-edit" class="hidden mt-2 flex items-center justify-between
                                 px-3 py-2 bg-amber-50 border border-amber-100 rounded-xl">
                                <span class="text-[10px] font-black text-amber-700 truncate" id="file-name-edit">-</span>
                                <button type="button" onclick="clearImage('photo_edit','preview-edit','placeholder-edit','file-info-edit')"
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
                </div>

                {{-- ===== ACTIONS ===== --}}
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-100">
                    <div class="flex items-center gap-3">
                        <button type="submit"
                                class="px-7 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-xl
                                       text-xs font-black uppercase tracking-widest transition-all
                                       shadow-md shadow-amber-200 flex items-center gap-2">
                            <i class="fas fa-save"></i> Update Portofolio
                        </button>
                        <a href="{{ route('portofolios.index') }}"
                           class="px-5 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl
                                  text-xs font-black uppercase tracking-widest transition-all">
                            Batal
                        </a>
                    </div>

                    {{-- Danger zone --}}
                    <form action="{{ route('portofolios.destroy', $portofolio->portofolio_id) }}"
                          method="POST"
                          onsubmit="return confirmDelete(event, this)">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-5 py-3 bg-rose-50 hover:bg-rose-100 text-rose-600 border border-rose-100
                                       rounded-xl text-xs font-black uppercase tracking-wider transition-all flex items-center gap-2">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </form>
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
        const fileName = document.getElementById('file-name-edit');

        preview.src = e.target.result;
        preview.classList.remove('hidden');
        placeholder.classList.add('hidden');
        fileInfo.classList.remove('hidden');
        fileInfo.classList.add('flex');
        if (fileName) fileName.textContent = file.name;

        // Also update current photo display
        const currentPhoto = document.getElementById('current-photo');
        if (currentPhoto) currentPhoto.src = e.target.result;
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

function toggleStatus() {
    const cb = document.getElementById('is_active_edit');
    cb.checked = !cb.checked;
    updateStatusBadge();
}

function updateStatusBadge() {
    const cb = document.getElementById('is_active_edit');
    const badge = document.getElementById('status-badge');
    const dot = document.getElementById('status-dot');
    const text = document.getElementById('status-text');

    if (cb.checked) {
        badge.className = 'ml-auto inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider border bg-emerald-50 text-emerald-700 border-emerald-100';
        dot.className = 'w-1.5 h-1.5 rounded-full bg-emerald-500';
        text.textContent = 'Aktif';
    } else {
        badge.className = 'ml-auto inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider border bg-gray-100 text-gray-500 border-gray-200';
        dot.className = 'w-1.5 h-1.5 rounded-full bg-gray-400';
        text.textContent = 'Nonaktif';
    }
}

function confirmDelete(e, form) {
    e.preventDefault();
    if (typeof Swal !== 'undefined') {
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
        }).then(result => { if (result.isConfirmed) form.submit(); });
    } else {
        if (confirm('Yakin ingin menghapus portofolio ini?')) form.submit();
    }
    return false;
}
</script>

@endsection