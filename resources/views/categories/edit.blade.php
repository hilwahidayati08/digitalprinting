@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('page-title', 'Edit Kategori')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
    <li class="breadcrumb-item active">Edit</li>
</ul>
@endsection

@section('content')
<div class="grid grid-cols-12 gap-x-6">
    <div class="col-span-12">
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <div>
                    <h5>Edit Kategori</h5>
                    <p class="text-sm text-muted">
                        Ubah data kategori
                    </p>
                </div>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            {{-- Error --}}
            @if ($errors->any())
            <div class="m-6">
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mt-2">
                        @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <div class="card-body">
                <form action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-6">
                        <label for="category_name" class="form-label">
                            Nama Kategori <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="category_name"
                            id="category_name"
                            class="form-control"
                            value="{{ old('category_name', $category->category_name) }}"
                            placeholder="Contoh: Banner"
                            required
                            autofocus
                        >
                    </div>
<div class="form-group mb-6">
            <label for="calc_type" class="form-label">Tipe Perhitungan <span class="text-danger">*</span></label>
            <select name="calc_type" id="calc_type" class="form-control" required>
                <option value="satuan" {{ old('calc_type', $category->calc_type) == 'satuan' ? 'selected' : '' }}>Satuan (Pcs)</option>
                <option value="luas" {{ old('calc_type', $category->calc_type) == 'luas' ? 'selected' : '' }}>Luas (Meter Persegi - Banner)</option>
                <option value="stiker" {{ old('calc_type', $category->calc_type) == 'stiker' ? 'selected' : '' }}>Stiker (Nesting A3+)</option>
            </select>
        </div>
                    {{-- Info slug (optional, hanya tampil) --}}
                    @if(isset($category->slug))
                    <div class="form-group mb-6">
                        <label class="form-label">Slug</label>
                        <input
                            type="text"
                            class="form-control"
                            value="{{ $category->slug }}"
                            readonly
                        >
                        <small class="text-muted">
                            Slug akan otomatis diperbarui saat nama kategori diubah.
                        </small>
                    </div>
                    @endif

                    <div class="flex gap-4 pt-4 border-t">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i> Update
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
