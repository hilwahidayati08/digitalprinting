@extends('layouts.app')

@section('title', 'Tambah Portofolio')
@section('page-title', 'Tambah Portofolio')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portofolios.index') }}">Portofolio</a></li>
    <li class="breadcrumb-item active">Tambah</li>
</ul>
@endsection

@section('content')
<div class="grid grid-cols-12 gap-x-6">
    <div class="col-span-12">
        <div class="card">

            {{-- Header --}}
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <div>
                        <h5>Tambah Portofolio</h5>
                        <p class="text-sm text-muted">Tambahkan karya atau proyek</p>
                    </div>
                    <a href="{{ route('portofolios.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            {{-- Error --}}
            @if($errors->any())
            <div class="mx-6 mt-4 alert alert-danger">
                <ul class="text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Form --}}
            <div class="card-body">
                <form action="{{ route('portofolios.store') }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="space-y-4">
                            <div class="form-group">
                                <label class="form-label">Judul Portofolio</label>
                                <input type="text" name="title"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description"
                                          rows="4"
                                          class="form-control"
                                          required></textarea>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="form-group">
                                <label class="form-label">Gambar</label>
                                <input type="file"
                                       name="photo"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="form-group flex gap-2 items-center">
                                <input type="checkbox"
                                       name="is_active"
                                       value="1"
                                       checked>
                                <label class="text-sm">Aktifkan Portofolio</label>
                            </div>
                        </div>

                    </div>

                    <div class="flex gap-3 mt-6">
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('portofolios.index') }}"
                           class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection
