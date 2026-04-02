@extends('layouts.member')

@section('member_content')
<div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="bg-[#1E293B] px-10 py-7">
        <h2 class="text-white text-xl font-black italic uppercase tracking-widest">Informasi Profil & Alamat</h2>
        <p class="text-slate-400 text-xs mt-1 normal-case italic font-medium">Lengkapi data diri untuk memudahkan proses pengiriman pesanan Anda</p>
    </div>
    
    <form action="{{ route('profiles.store') }}" method="POST" class="p-8 lg:p-10">
        @csrf
        
        <div class="space-y-10">
            <div class="space-y-6">
                <div class="flex items-center gap-2 border-b border-gray-50 pb-2">
                    <i class="fas fa-user text-blue-600 text-sm"></i>
                    <h3 class="text-sm font-black text-slate-700 uppercase tracking-tighter">Data Personal</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-gray-400 uppercase ml-1">Username</label>
                        <input type="text" name="username" value="{{ old('username', Auth::user()->username) }}" 
                               class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-gray-400 uppercase ml-1">Nama Lengkap</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $profile->full_name ?? '') }}" 
                               class="w-full p-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 outline-none transition-all">
                    </div>
                </div>

                <div class="p-6 bg-blue-50 rounded-[1.5rem] border border-blue-100">
                    <label class="text-[11px] font-bold text-blue-700 uppercase ml-1">Ubah Kata Sandi (Opsional)</label>
                    <input type="password" name="password" 
                           class="w-full mt-2 p-4 bg-white border border-blue-100 rounded-xl text-sm outline-none focus:border-blue-600 transition-all shadow-sm" 
                           placeholder="Biarkan kosong jika tidak ingin mengubah password">
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex items-center gap-2 border-b border-gray-50 pb-2">
                    <i class="fas fa-map-marker-alt text-blue-600 text-sm"></i>
                    <h3 class="text-sm font-black text-slate-700 uppercase tracking-tighter">Alamat Pengiriman</h3>
                </div>

                <div class="space-y-4">
                    <textarea name="alamat" rows="3" class="w-full p-5 bg-gray-50 border border-gray-100 rounded-[1.5rem] text-sm focus:ring-2 focus:ring-blue-500/20 outline-none" 
                              placeholder="Tuliskan alamat lengkap Anda (Nama Jalan, No. Rumah, RT/RW)">{{ old('alamat', $profile->alamat ?? '') }}</textarea>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase ml-2">Provinsi</label>
                            <select name="province_id" id="province_id" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-xl text-sm outline-none focus:border-blue-600">
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinces as $p)
                                    <option value="{{ $p->code }}" {{ (old('province_id', $profile->province->code ?? '') == $p->code) ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase ml-2">Kota/Kabupaten</label>
                            <select name="city_id" id="city_id" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-xl text-sm outline-none focus:border-blue-600">
                                <option value="">Pilih Kota</option>
                                @foreach($regencies as $r)
                                    <option value="{{ $r->code }}" {{ (old('city_id', $profile->city->code ?? '') == $r->code) ? 'selected' : '' }}>{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase ml-2">Kecamatan</label>
                            <select name="district_id" id="district_id" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-xl text-sm outline-none focus:border-blue-600">
                                <option value="">Pilih Kecamatan</option>
                                @foreach($districts as $d)
                                    <option value="{{ $d->code }}" {{ (old('district_id', $profile->district->code ?? '') == $d->code) ? 'selected' : '' }}>{{ $d->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-gray-400 uppercase ml-2">Desa/Kelurahan</label>
                            <select name="village_id" id="village_id" class="w-full p-4 bg-gray-50 border border-gray-100 rounded-xl text-sm outline-none focus:border-blue-600">
                                <option value="">Pilih Desa</option>
                                @foreach($villages as $v)
                                    <option value="{{ $v->code }}" {{ (old('village_id', $profile->village->code ?? '') == $v->code) ? 'selected' : '' }}>{{ $v->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full md:w-auto px-12 py-4 bg-[#1E293B] text-white font-black rounded-xl hover:bg-blue-900 transition-all shadow-lg shadow-blue-100 uppercase tracking-widest text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Fungsi pembantu untuk memuat data dari API
    function loadOptions(url, targetSelector, placeholder) {
        $(targetSelector).html('<option value="">Memuat...</option>');
        
        $.get(url)
            .done(function (data) {
                let options = `<option value="">${placeholder}</option>`;
                // Ganti $.each lama dengan forEach untuk menangani Array of Objects
                data.forEach(function (item) {
                    // item.code dan item.name harus sesuai dengan JSON dari API
                    options += `<option value="${item.code}">${item.name}</option>`;
                });
                $(targetSelector).html(options);
            })
            .fail(function (xhr) {
                console.error('Gagal memuat data dari ' + url, xhr.responseText);
                $(targetSelector).html(`<option value="">Gagal memuat data</option>`);
            });
    }

    // Event saat Provinsi berubah
    $('#province_id').on('change', function () {
        const code = $(this).val();
        if (code) {
            loadOptions("{{ url('/api/cities') }}/" + code, '#city_id', 'Pilih Kota');
        }
        $('#city_id, #district_id, #village_id').html('<option value="">Pilih...</option>');
    });

    // Event saat Kota berubah
    $('#city_id').on('change', function () {
        const code = $(this).val();
        if (code) {
            loadOptions("{{ url('/api/districts') }}/" + code, '#district_id', 'Pilih Kecamatan');
        }
        $('#district_id, #village_id').html('<option value="">Pilih...</option>');
    });

    // Event saat Kecamatan berubah
    $('#district_id').on('change', function () {
        const code = $(this).val();
        if (code) {
            loadOptions("{{ url('/api/villages') }}/" + code, '#village_id', 'Pilih Desa');
        }
        $('#village_id').html('<option value="">Pilih...</option>');
    });
});
</script>
@endpush