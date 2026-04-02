@extends('layouts.app')

@section('title', 'Tambah Hero Banner')
@section('page-title', 'Tambah Hero Banner')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('heros.index') }}">Hero Banner</a></li>
    <li class="breadcrumb-item active">Tambah Baru</li>
</ul>
@endsection

@section('content')
<div class="grid grid-cols-12 gap-x-6">
    <div class="col-span-12">
        <div class="card">

            {{-- Header --}}
            <div class="card-header">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h5>Tambah Hero Banner Baru</h5>
                        <p class="text-sm text-muted mt-1">Buat banner utama untuk website</p>
                    </div>

                    <a href="{{ route('heros.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>

            {{-- Error Message --}}
            @if ($errors->any())
                <div class="mx-6 mt-4">
                    <div class="alert alert-danger flex gap-3 p-4">
                        <i class="fas fa-exclamation-circle mt-1"></i>
                        <div>
                            <span class="font-medium">Terjadi kesalahan:</span>
                            <ul class="mt-1 text-sm space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-chevron-right text-xs"></i>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Form --}}
            <div class="card-body">
                <form action="{{ route('heros.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="form-group">
    <label for="section" class="form-label">
        Section <span class="text-danger">*</span>
    </label>
    <select name="section" id="section" class="form-control" required>
        <option value="">-- Pilih Section --</option>
        <option value="hero" {{ old('section') == 'hero' ? 'selected' : '' }}>Hero Utama</option>
        <option value="about" {{ old('section') == 'about' ? 'selected' : '' }}>Tentang Kami</option>
    </select>
</div>
                        {{-- Left Column --}}
                        <div class="space-y-6">
                            <div class="form-group">
                                <label for="label" class="form-label">
                                    Label <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="label" id="label"
                                       value="{{ old('label') }}"
                                       class="form-control"
                                       placeholder="Contoh: Banner Utama"
                                       required autofocus>
                            </div>

                            <div class="form-group">
                                <label for="headline" class="form-label">
                                    Headline <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="headline" id="headline"
                                       value="{{ old('headline') }}"
                                       class="form-control"
                                       placeholder="Contoh: Selamat Datang di Website Kami"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="subheadline" class="form-label">Subheadline</label>
                                <textarea name="subheadline" id="subheadline" rows="3"
                                          class="form-control"
                                          placeholder="Deskripsi singkat atau tagline">{{ old('subheadline') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="button_link" class="form-label">Link Tombol</label>
                                <input type="url" name="button_link" id="button_link"
                                       value="{{ old('button_link') }}"
                                       class="form-control"
                                       placeholder="https://contoh.com/halaman">
                            </div>


                        </div>

                        {{-- Right Column --}}
                        <div class="space-y-6">
                            <div class="form-group">
                                <label class="form-label">
                                    Gambar Hero <span class="text-danger">*</span>
                                </label>

                                <div class="relative">
                                    <div id="imageUploadArea"
                                         class="w-full h-64 border-2 border-dashed border-gray-300 rounded-xl
                                                bg-gray-50 hover:bg-gray-100 transition flex items-center
                                                justify-center cursor-pointer overflow-hidden"
                                         onclick="document.getElementById('photo').click()">

                                        <input type="file" name="photo" id="photo"
                                               accept="image/*"
                                               class="hidden"
                                               onchange="previewImage(event)">

                                        {{-- Default --}}
                                        <div id="defaultContent" class="text-center p-4">
                                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-cloud-upload-alt text-2xl text-gray-500"></i>
                                            </div>
                                            <p class="text-sm font-medium text-gray-700">Klik untuk mengunggah gambar</p>
                                            <p class="text-xs text-gray-500">JPG, PNG, GIF, WebP • Maks 2MB</p>
                                        </div>

                                        {{-- Preview --}}
                                        <div id="imagePreviewContainer" class="hidden w-full h-full">
                                            <img id="previewImage"
                                                 class="w-full h-full object-cover rounded-lg"
                                                 alt="Preview">
                                        </div>
                                    </div>

                                    {{-- Info --}}
                                    <div id="imageInfo" class="mt-3 hidden">
                                        <div class="flex justify-between text-xs">
                                            <span class="text-gray-600">
                                                <i class="fas fa-image mr-1"></i>
                                                <span id="fileName"></span>
                                            </span>
                                            <button type="button" onclick="removeImage()"
                                                    class="text-red-500 hover:text-red-700">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="form-group mt-6">
                        <div class="flex gap-3 p-4 bg-gray-50 rounded-lg">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                   class="w-4 h-4 mt-1"
                                   {{ old('is_active', 1) ? 'checked' : '' }}>
                            <div>
                                <label for="is_active" class="font-medium cursor-pointer">
                                    Aktifkan Hero Banner
                                </label>
                                <p class="text-sm text-gray-500">
                                    Jika dicentang, hero banner akan ditampilkan di website
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-4 pt-6 mt-6 border-t">
                        <button type="submit" class="btn btn-primary flex gap-2">
                            <i class="fas fa-save"></i> Simpan Hero
                        </button>
                        <a href="{{ route('heros.index') }}" class="btn btn-outline-secondary flex gap-2">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('previewImage');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const defaultContent = document.getElementById('defaultContent');
    const imageInfo = document.getElementById('imageInfo');
    const fileName = document.getElementById('fileName');
    const uploadArea = document.getElementById('imageUploadArea');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validasi ukuran file (2MB = 2 * 1024 * 1024 bytes)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB');
            input.value = '';
            return;
        }
        
        // Validasi tipe file
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('Format file harus JPG, PNG, GIF, atau WebP');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            defaultContent.classList.add('hidden');
            previewContainer.classList.remove('hidden');
            imageInfo.classList.remove('hidden');
            fileName.textContent = file.name;
            
            // Tambahkan border hijau saat ada gambar
            uploadArea.classList.remove('border-gray-300', 'border-dashed');
            uploadArea.classList.add('border-green-400', 'border-solid');
        }
        
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    const input = document.getElementById('photo');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const defaultContent = document.getElementById('defaultContent');
    const imageInfo = document.getElementById('imageInfo');
    const uploadArea = document.getElementById('imageUploadArea');
    
    input.value = '';
    previewContainer.classList.add('hidden');
    defaultContent.classList.remove('hidden');
    imageInfo.classList.add('hidden');
    
    // Kembalikan border ke semula
    uploadArea.classList.remove('border-green-400', 'border-solid');
    uploadArea.classList.add('border-gray-300', 'border-dashed');
}

// Drag and drop functionality
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('imageUploadArea');
    const input = document.getElementById('photo');
    
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    // Handle dropped files
    uploadArea.addEventListener('drop', handleDrop, false);
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    function highlight() {
        uploadArea.classList.add('border-primary', 'bg-primary-50');
    }
    
    function unhighlight() {
        uploadArea.classList.remove('border-primary', 'bg-primary-50');
    }
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            input.files = files;
            // Trigger change event manually
            const event = new Event('change', { bubbles: true });
            input.dispatchEvent(event);
        }
    }
});
</script>
@endsection