@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<h2>Edit Profile</h2>

@if ($errors->any())
<ul style="color:red;">
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>
@endif

<form action="{{ route('profiles.update', $profile->profile_id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- User --}}
    <label>User</label><br>
    <select name="user_id">
        <option value="">-- Pilih User --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ $profile->user_id == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select><br><br>

    {{-- Alamat --}}
    <label>Alamat Lengkap</label><br>
    <textarea name="alamat" rows="3">{{ $profile->alamat }}</textarea><br><br>

    {{-- Provinsi --}}
    <label>Provinsi</label><br>
    <select name="province_id" id="province">
        <option value="">-- Pilih Provinsi --</option>
        @foreach ($provinces as $province)
            <option value="{{ $province->id }}" {{ $profile->province_id == $province->id ? 'selected' : '' }}>
                {{ $province->name }}
            </option>
        @endforeach
    </select><br><br>

    {{-- Kota --}}
    <label>Kota / Kabupaten</label><br>
    <select name="city_id" id="city">
        <option value="{{ $profile->city_id }}">{{ $profile->city ? $profile->city->name : '-- Pilih Kota --' }}</option>
    </select><br><br>

    {{-- Kecamatan --}}
    <label>Kecamatan</label><br>
    <select name="district_id" id="district">
        <option value="{{ $profile->district_id }}">{{ $profile->district ? $profile->district->name : '-- Pilih Kecamatan --' }}</option>
    </select><br><br>

    {{-- Desa --}}
    <label>Desa / Kelurahan</label><br>
    <select name="village_id" id="village">
        <option value="{{ $profile->village_id }}">{{ $profile->village ? $profile->village->name : '-- Pilih Desa --' }}</option>
    </select><br><br>

    <button type="submit">Simpan</button>
    <a href="{{ route('profiles.index') }}">Kembali</a>
</form>

{{-- Jquery AJAX sama seperti create --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    // sama seperti create.js
    $('#province').change(function() {
        let provinceId = $(this).val();
        $('#city').html('<option>Memuat...</option>');
        $('#district').html('<option value="">-- Pilih Kecamatan --</option>');
        $('#village').html('<option value="">-- Pilih Desa --</option>');

        if(provinceId){
            $.get('/indoregion/regencies/' + provinceId, function(data){
                $('#city').empty().append('<option value="">-- Pilih Kota --</option>');
                $.each(data, function(i, item){
                    $('#city').append('<option value="'+item.id+'">'+item.name+'</option>');
                });
            });
        }
    });

    $('#city').change(function(){
        let cityId = $(this).val();
        $('#district').html('<option>Memuat...</option>');
        $('#village').html('<option value="">-- Pilih Desa --</option>');

        if(cityId){
            $.get('/indoregion/districts/' + cityId, function(data){
                $('#district').empty().append('<option value="">-- Pilih Kecamatan --</option>');
                $.each(data, function(i, item){
                    $('#district').append('<option value="'+item.id+'">'+item.name+'</option>');
                });
            });
        }
    });

    $('#district').change(function(){
        let districtId = $(this).val();
        $('#village').html('<option>Memuat...</option>');

        if(districtId){
            $.get('/indoregion/villages/' + districtId, function(data){
                $('#village').empty().append('<option value="">-- Pilih Desa --</option>');
                $.each(data, function(i, item){
                    $('#village').append('<option value="'+item.id+'">'+item.name+'</option>');
                });
            });
        }
    });
});
</script>
@endsection
