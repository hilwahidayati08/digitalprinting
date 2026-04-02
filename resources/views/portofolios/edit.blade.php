@extends('layouts.app')

@section('title', 'Edit Portofolio')
@section('page-title', 'Edit Portofolio')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('portofolios.index') }}">Portofolio</a></li>
    <li class="breadcrumb-item active">Edit</li>
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
                        <h5>Edit Portofolio</h5>
                        <p class="text-sm text-muted">Perbarui data portofolio</p>
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
                <form action="{{ route('portofolios.update', $portofolio->portofolio_id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Left --}}
                        <div class="space-y-4">
                            <div class="form-group">
                                <label class="form-label">Judul Portofolio</label>
                                <input type="text"
                                       name="title"
                                       value="{{ old('title', $portofolio->title) }}"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description"
                                          rows="4"
                                          class="form-control"
                                          required>{{ old('description', $portofolio->description) }}</textarea>
                            </div>
                        </div>

                        {{-- Right --}}
                        <div class="space-y-4">
                            <div class="form-group">
                                <label class="form-label">Gambar</label>

                                @if($portofolio->photo)
                                    <img src="{{ asset('storage/portofolio/'.$portofolio->photo) }}"
                                         class="w-40 h-24 object-cover rounded mb-2">
                                @endif

                                <input type="file"
                                       name="photo"
                                       class="form-control">
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
                            </div>

                            <div class="form-group flex gap-2 items-center">
                                <input type="checkbox"
                                       name="is_active"
                                       value="1"
                                       {{ $portofolio->is_active ? 'checked' : '' }}>
                                <label class="text-sm">Aktifkan Portofolio</label>
                            </div>
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3 mt-6">
                        <button class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
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
