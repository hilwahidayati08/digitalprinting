@extends('layouts.app')

@section('title', 'Tambah Service')
@section('page-title', 'Tambah Service')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Service</a></li>
    <li class="breadcrumb-item active">Tambah</li>
</ul>
@endsection

@section('content')
<div class="grid grid-cols-12 gap-x-6">
    <div class="col-span-12">
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <div>
                    <h5>Tambah Service Baru</h5>
                    <p class="text-sm text-muted">Buat data service baru</p>
                </div>
                <a href="{{ route('services.index') }}" class="btn btn-outline-primary">
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
                <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">                    @csrf

                    <div class="form-group mb-6">
                        <label class="form-label">
                            Nama Service <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="service_name"
                               class="form-control"
                               value="{{ old('service_name') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label>Icon</label>
                        <input type="file"
                            name="icon"
                            class="form-control"
                            accept="image/*">
                    </div>

                    <div class="form-group mb-6">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description"
                                  class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-check mb-6">
                        <input type="checkbox"
                               name="is_active"
                               value="1"
                               class="form-check-input"
                               checked>
                        <label class="form-check-label">Aktif</label>
                    </div>

                    <div class="flex gap-4 pt-4 border-t">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>
                        <a href="{{ route('services.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection