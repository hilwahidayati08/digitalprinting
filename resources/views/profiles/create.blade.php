@extends('layouts.app')

@section('title', 'Tambah Profile')
@section('page-title', 'Tambah Profile')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('profiles.index') }}">Profile</a></li>
    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
</ul>
@endsection

@section('content')
<div class="grid grid-cols-12 gap-x-6">
    <div class="col-span-12">
        <div class="card">
            <div class="card-header">
                <h5>Tambah Data Profile</h5>
                <p class="text-sm text-muted mt-1">Lengkapi data profile pengguna</p>
            </div>

            <div class="card-body">

                {{-- Error Validation --}}
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profiles.store') }}" method="POST">
                    @csrf

                    {{-- User --}}
                    <div class="form-group mb-4">
                        <label>User</label>
                        <select name="user_id" class="form-control">
                            <option value="">-- Pilih User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group mb-4">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="form-control">{{ old('alamat') }}</textarea>
                    </div>

                    {{-- Province --}}
                    <div class="form-group mb-4">
                        <label>Provinsi</label>
                        <select name="province_id" id="province_id" class="form-control">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $code => $name)
                                <option value="{{ $code }}"
                                    {{ old('province_id') == $code ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- City --}}
                    <div class="form-group mb-4">
                        <label>Kota / Kabupaten</label>
                        <select name="city_id" id="city_id" class="form-control">
                            <option value="">Pilih Kota / Kabupaten</option>
                        </select>
                    </div>

                    {{-- District --}}
                    <div class="form-group mb-4">
                        <label>Kecamatan</label>
                        <select name="district_id" id="district_id" class="form-control">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>

                    {{-- Village --}}
                    <div class="form-group mb-4">
                        <label>Kelurahan / Desa</label>
                        <select name="village_id" id="village_id" class="form-control">
                            <option value="">Pilih Kelurahan / Desa</option>
                        </select>
                    </div>

                    {{-- Action --}}
                    <div class="flex gap-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan
                        </button>
                        <a href="{{ route('profiles.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {

    // Provinsi → Kota
    $('#province_id').on('change', function () {
        let provinceCode = $(this).val();
        $('#city_id').html('<option>Memuat...</option>');
        $('#district_id').html('<option>Pilih Kecamatan</option>');
        $('#village_id').html('<option>Pilih Kelurahan / Desa</option>');

        if (provinceCode) {
            $.get(`/api/cities/${provinceCode}`, function (data) {
                $('#city_id').empty().append('<option value="">Pilih Kota / Kabupaten</option>');
                $.each(data, function (code, name) {
                    $('#city_id').append(`<option value="${code}">${name}</option>`);
                });
            });
        }
    });

    // Kota → Kecamatan
    $('#city_id').on('change', function () {
        let cityCode = $(this).val();
        $('#district_id').html('<option>Memuat...</option>');
        $('#village_id').html('<option>Pilih Kelurahan / Desa</option>');

        if (cityCode) {
            $.get(`/api/districts/${cityCode}`, function (data) {
                $('#district_id').empty().append('<option value="">Pilih Kecamatan</option>');
                $.each(data, function (code, name) {
                    $('#district_id').append(`<option value="${code}">${name}</option>`);
                });
            });
        }
    });

    // Kecamatan → Desa
    $('#district_id').on('change', function () {
        let districtCode = $(this).val();
        $('#village_id').html('<option>Memuat...</option>');

        if (districtCode) {
            $.get(`/api/villages/${districtCode}`, function (data) {
                $('#village_id').empty().append('<option value="">Pilih Kelurahan / Desa</option>');
                $.each(data, function (code, name) {
                    $('#village_id').append(`<option value="${code}">${name}</option>`);
                });
            });
        }
    });

});
</script>
@endsection