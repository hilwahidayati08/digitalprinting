@extends('admin.admin')

@section('title', 'Hero Banner - Admin Panel')
@section('page-title', 'Hero Banner')

@section('breadcrumbs')
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="/" class="text-sm text-gray-500 hover:text-primary-600">Dashboard</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                    <span class="text-sm font-medium text-gray-900">Hero Banner</span>
                </div>
            </li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="space-y-6">

    @if($errors->any())
    <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl text-sm font-medium">
        <i class="fas fa-exclamation-circle text-red-500"></i>
        <div>
            <p class="font-semibold mb-1">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- TAB NAVIGATION --}}
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex gap-0" aria-label="Tabs">
            <button type="button"
                    id="tabBtnHero"
                    class="px-5 py-2.5 text-sm font-medium border-b-2 text-blue-600 border-blue-600">
                <i class="fas fa-image mr-2"></i> Hero
            </button>
            <button type="button"
                    id="tabBtnAbout"
                    class="px-5 py-2.5 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                <i class="fas fa-info-circle mr-2"></i> About
            </button>
        </nav>
    </div>

    {{-- ========================== TAB: HERO ========================== --}}
    <div id="heroTabContent">
        @if($hero)
        <form action="{{ route('heros.update', $hero->hero_id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="active_tab" value="hero">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-5 border-b border-gray-50">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-align-left text-blue-600 text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900">Informasi Hero</h3>
                                    <p class="text-xs text-gray-400">Teks utama yang tampil di banner</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-5 space-y-4">

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Label <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="label"
                                       value="{{ old('label', $hero->label) }}"
                                       placeholder="Contoh: Banner Utama" required
                                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all">
                                @error('label') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Headline <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="headline"
                                       value="{{ old('headline', $hero->headline) }}"
                                       placeholder="Contoh: Selamat Datang di Website Kami" required
                                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all">
                                @error('headline') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Subheadline</label>
                                <textarea name="subheadline" rows="3"
                                          placeholder="Deskripsi singkat atau tagline"
                                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all resize-none">{{ old('subheadline', $hero->subheadline) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Link Tombol</label>
                                <input type="url" name="button_link"
                                       value="{{ old('button_link', $hero->button_link) }}"
                                       placeholder="https://contoh.com/halaman"
                                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Section</label>
                                <input type="text" value="{{ strtoupper($hero->section) }}" readonly
                                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-500 bg-gray-50 cursor-not-allowed">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-5 border-b border-gray-50">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-pink-100 flex items-center justify-center">
                                    <i class="fas fa-image text-pink-600 text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900">Gambar Hero</h3>
                                    <p class="text-xs text-gray-400">JPG, PNG, WebP · Maks 2MB</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-5 space-y-3">

                            @if($hero->photo)
                            <div class="w-full h-36 rounded-xl overflow-hidden border border-gray-200">
                                <img src="{{ asset('storage/heros/' . $hero->photo) }}"
                                     alt="{{ $hero->label }}" class="w-full h-full object-cover">
                            </div>
                            <p class="text-xs text-gray-400 text-center">Gambar saat ini</p>
                            @endif

                            <div id="heroUploadArea"
                                 class="w-full h-40 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors flex flex-col items-center justify-center cursor-pointer overflow-hidden"
                                 onclick="document.getElementById('hero_photo').click()">
                                <input type="file" name="photo" id="hero_photo" accept="image/*" class="hidden"
                                       onchange="previewHeroImage(event)">
                                <div id="heroDefaultContent" class="text-center px-4">
                                    <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt text-xl text-gray-400"></i>
                                    </div>
                                    <p class="text-xs font-medium text-gray-600 mb-1">Klik untuk upload gambar baru</p>
                                    <p class="text-xs text-gray-400">Biarkan kosong jika tidak ingin mengubah</p>
                                </div>
                                <div id="heroPreviewContainer" class="hidden w-full h-full">
                                    <div class="relative w-full h-full">
                                        <img id="heroPreviewImage" class="w-full h-full object-cover rounded-xl" alt="Preview">
                                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                            <span class="bg-white/90 text-xs font-medium text-gray-700 px-3 py-1.5 rounded-lg">Klik untuk mengganti</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="heroImageInfo" class="hidden flex items-center justify-between text-xs text-gray-500">
                                <span><i class="fas fa-image mr-1"></i><span id="heroFileName"></span></span>
                                <button type="button" onclick="removeHeroImage()" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl">
                            <input type="checkbox" name="is_active" id="hero_is_active" value="1"
                                   class="w-4 h-4 accent-blue-600"
                                   {{ old('is_active', $hero->is_active) ? 'checked' : '' }}>
                            <label for="hero_is_active" class="cursor-pointer">
                                <p class="text-sm font-bold text-gray-900">Aktifkan Hero Banner</p>
                                <p class="text-xs text-gray-400">Tampilkan di halaman utama website</p>
                            </label>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Info Record</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p><span class="font-medium text-gray-800">Dibuat:</span> {{ $hero->created_at->format('d M Y H:i') }}</p>
                            <p><span class="font-medium text-gray-800">Diperbarui:</span> {{ $hero->updated_at->format('d M Y H:i') }}</p>
                            @if($hero->photo)
                            <p class="truncate"><span class="font-medium text-gray-800">File:</span> {{ $hero->photo }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-bold px-8 py-3 rounded-xl transition-all shadow-sm hover:shadow-md">
                    <i class="fas fa-save"></i> Simpan Hero
                </button>
            </div>
        </form>
        @else
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-5 py-4 rounded-2xl text-sm">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Data Hero belum ada. Pastikan ada record dengan <code>section = 'hero'</code> di tabel heros.
        </div>
        @endif
    </div>

    {{-- ========================== TAB: ABOUT ========================== --}}
    <div id="aboutTabContent" style="display:none;">
        @if($about)
        <form action="{{ route('heros.update', $about->hero_id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="active_tab" value="about">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-5 border-b border-gray-50">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-info-circle text-green-600 text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900">Informasi About</h3>
                                    <p class="text-xs text-gray-400">Teks yang tampil di section about</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-5 space-y-4">

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Label <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="label"
                                       value="{{ old('label', $about->label) }}"
                                       placeholder="Contoh: Tentang Kami" required
                                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-300 focus:border-green-400 transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Headline <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="headline"
                                       value="{{ old('headline', $about->headline) }}"
                                       placeholder="Contoh: Kenalan Yuk" required
                                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-300 focus:border-green-400 transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Subheadline</label>
                                <textarea name="subheadline" rows="3"
                                          placeholder="Deskripsi singkat tentang bisnis Anda"
                                          class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-300 focus:border-green-400 transition-all resize-none">{{ old('subheadline', $about->subheadline) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Link Tombol</label>
                                <input type="url" name="button_link"
                                       value="{{ old('button_link', $about->button_link) }}"
                                       placeholder="https://contoh.com/tentang"
                                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-300 focus:border-green-400 transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Section</label>
                                <input type="text" value="{{ strtoupper($about->section) }}" readonly
                                       class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-500 bg-gray-50 cursor-not-allowed">
                            </div>

                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-5 border-b border-gray-50">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center">
                                    <i class="fas fa-image text-amber-600 text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900">Gambar About</h3>
                                    <p class="text-xs text-gray-400">JPG, PNG, WebP · Maks 2MB</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-5 space-y-3">

                            @if($about->photo)
                            <div class="w-full h-36 rounded-xl overflow-hidden border border-gray-200">
                                <img src="{{ asset('storage/heros/' . $about->photo) }}"
                                     alt="{{ $about->label }}" class="w-full h-full object-cover">
                            </div>
                            <p class="text-xs text-gray-400 text-center">Gambar saat ini</p>
                            @endif

                            <div id="aboutUploadArea"
                                 class="w-full h-40 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors flex flex-col items-center justify-center cursor-pointer overflow-hidden"
                                 onclick="document.getElementById('about_photo').click()">
                                <input type="file" name="photo" id="about_photo" accept="image/*" class="hidden"
                                       onchange="previewAboutImage(event)">
                                <div id="aboutDefaultContent" class="text-center px-4">
                                    <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt text-xl text-gray-400"></i>
                                    </div>
                                    <p class="text-xs font-medium text-gray-600 mb-1">Klik untuk upload gambar baru</p>
                                    <p class="text-xs text-gray-400">Biarkan kosong jika tidak ingin mengubah</p>
                                </div>
                                <div id="aboutPreviewContainer" class="hidden w-full h-full">
                                    <div class="relative w-full h-full">
                                        <img id="aboutPreviewImage" class="w-full h-full object-cover rounded-xl" alt="Preview">
                                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                                            <span class="bg-white/90 text-xs font-medium text-gray-700 px-3 py-1.5 rounded-lg">Klik untuk mengganti</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="aboutImageInfo" class="hidden flex items-center justify-between text-xs text-gray-500">
                                <span><i class="fas fa-image mr-1"></i><span id="aboutFileName"></span></span>
                                <button type="button" onclick="removeAboutImage()" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-xl">
                            <input type="checkbox" name="is_active" id="about_is_active" value="1"
                                   class="w-4 h-4 accent-blue-600"
                                   {{ old('is_active', $about->is_active) ? 'checked' : '' }}>
                            <label for="about_is_active" class="cursor-pointer">
                                <p class="text-sm font-bold text-gray-900">Aktifkan About</p>
                                <p class="text-xs text-gray-400">Tampilkan di halaman website</p>
                            </label>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Info Record</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p><span class="font-medium text-gray-800">Dibuat:</span> {{ $about->created_at->format('d M Y H:i') }}</p>
                            <p><span class="font-medium text-gray-800">Diperbarui:</span> {{ $about->updated_at->format('d M Y H:i') }}</p>
                            @if($about->photo)
                            <p class="truncate"><span class="font-medium text-gray-800">File:</span> {{ $about->photo }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-bold px-8 py-3 rounded-xl transition-all shadow-sm hover:shadow-md">
                    <i class="fas fa-save"></i> Simpan About
                </button>
            </div>
        </form>
        @else
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-5 py-4 rounded-2xl text-sm">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            Data About belum ada. Pastikan ada record dengan <code>section = 'about'</code> di tabel heros.
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    function showHeroTab() {
        document.getElementById('heroTabContent').style.display  = 'block';
        document.getElementById('aboutTabContent').style.display = 'none';
        document.getElementById('tabBtnHero').className  = 'px-5 py-2.5 text-sm font-medium border-b-2 text-blue-600 border-blue-600';
        document.getElementById('tabBtnAbout').className = 'px-5 py-2.5 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300';
        history.replaceState(null, '', '#hero');
    }

    function showAboutTab() {
        document.getElementById('heroTabContent').style.display  = 'none';
        document.getElementById('aboutTabContent').style.display = 'block';
        document.getElementById('tabBtnAbout').className = 'px-5 py-2.5 text-sm font-medium border-b-2 text-blue-600 border-blue-600';
        document.getElementById('tabBtnHero').className  = 'px-5 py-2.5 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300';
        history.replaceState(null, '', '#about');
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('tabBtnHero').addEventListener('click', showHeroTab);
        document.getElementById('tabBtnAbout').addEventListener('click', showAboutTab);

        const activeTab = '{{ session("active_tab", "") }}';
        const hash = window.location.hash;

        if (activeTab === 'about' || hash === '#about') {
            showAboutTab();
        } else {
            showHeroTab();
        }
    });

    function previewHeroImage(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('heroPreviewImage').src = e.target.result;
            document.getElementById('heroDefaultContent').classList.add('hidden');
            document.getElementById('heroPreviewContainer').classList.remove('hidden');
            document.getElementById('heroImageInfo').classList.remove('hidden');
            document.getElementById('heroFileName').textContent = file.name;
        };
        reader.readAsDataURL(file);
    }

    function removeHeroImage() {
        document.getElementById('hero_photo').value = '';
        document.getElementById('heroPreviewContainer').classList.add('hidden');
        document.getElementById('heroDefaultContent').classList.remove('hidden');
        document.getElementById('heroImageInfo').classList.add('hidden');
    }

    function previewAboutImage(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('aboutPreviewImage').src = e.target.result;
            document.getElementById('aboutDefaultContent').classList.add('hidden');
            document.getElementById('aboutPreviewContainer').classList.remove('hidden');
            document.getElementById('aboutImageInfo').classList.remove('hidden');
            document.getElementById('aboutFileName').textContent = file.name;
        };
        reader.readAsDataURL(file);
    }

    function removeAboutImage() {
        document.getElementById('about_photo').value = '';
        document.getElementById('aboutPreviewContainer').classList.add('hidden');
        document.getElementById('aboutDefaultContent').classList.remove('hidden');
        document.getElementById('aboutImageInfo').classList.add('hidden');
    }
</script>
@endpush