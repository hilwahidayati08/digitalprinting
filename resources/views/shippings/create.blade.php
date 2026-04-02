@extends('layouts.member')

@section('member_content')
<div class="max-w-5xl mx-auto px-4 mb-8">
    <div class="bg-white rounded-[1.25rem] shadow-sm border border-neutral-100 overflow-hidden">
        
        {{-- Header: Identik dengan Halaman Index --}}
        <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-6 py-6 flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-6 translate-x-6"></div>
            
            <div class="relative z-10 flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-map-location-dot text-white text-base"></i>
                </div>
                <div>
                    <h2 class="text-white text-lg font-black italic uppercase tracking-tight leading-none">Tambah Alamat</h2>
                    <p class="text-white/70 text-[10px] mt-1 font-medium italic">Lengkapi lokasi pengiriman Anda</p>
                </div>
            </div>
        </div>
        
        {{-- Form Body --}}
        <form action="{{ route('shippings.store') }}" method="POST" id="shippingForm" class="p-5 lg:p-6">
            @csrf
            <input type="hidden" name="redirect_back" value="{{ url()->previous() }}">

            <div class="space-y-8">
                {{-- Bagian 01: Identitas --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-2 border-b border-neutral-50 pb-2">
                        <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                        <h3 class="text-[10px] font-black text-neutral-800 uppercase tracking-widest">Identitas Penerima</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black text-neutral-400 uppercase ml-1 tracking-widest">Label Alamat</label>
                            <input type="text" name="label" value="{{ old('label') }}" maxlength="30"
                                   placeholder="Rumah, Kantor, dll..."
                                   class="w-full px-4 py-2.5 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-[12px]">
                        </div>
                        <div class="space-y-1.5 md:col-span-1">
                            <label class="text-[9px] font-black text-neutral-400 uppercase ml-1 tracking-widest">No. WhatsApp</label>
                            <input type="tel" name="recipient_phone" value="{{ old('recipient_phone', auth()->user()->no_telp) }}" 
                                   class="w-full px-4 py-2.5 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-[12px]" required>
                        </div>
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="text-[9px] font-black text-neutral-400 uppercase ml-1 tracking-widest">Nama Penerima</label>
                            <input type="text" name="recipient_name" value="{{ old('recipient_name', auth()->user()->username) }}" 
                                   class="w-full px-4 py-2.5 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-[12px]" required>
                        </div>
                    </div>
                </div>

                {{-- Bagian 02: Alamat --}}
                <div class="space-y-4">
                    <div class="flex items-center gap-2 border-b border-neutral-50 pb-2">
                        <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                        <h3 class="text-[10px] font-black text-neutral-800 uppercase tracking-widest">Detail Lokasi</h3>
                    </div>

                    <div class="space-y-3">
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black text-neutral-400 uppercase ml-1 tracking-widest">Alamat Lengkap</label>
                            <textarea name="address" rows="2" class="w-full px-4 py-2.5 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-[12px]" placeholder="Nama jalan, nomor rumah, RT/RW..." required>{{ old('address') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black text-neutral-400 uppercase ml-1 tracking-widest">Provinsi</label>
                                <select name="province_id" id="province_id" class="w-full px-4 py-2.5 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 outline-none font-bold text-neutral-700 text-[11px] appearance-none cursor-pointer" required>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->code }}" {{ old('province_id') == $province->code ? 'selected' : '' }}>{{ $province->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black text-neutral-400 uppercase ml-1 tracking-widest">Kota/Kabupaten</label>
                                <select name="city_id" id="city_id" class="w-full px-4 py-2.5 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 outline-none font-bold text-neutral-700 text-[11px] appearance-none cursor-pointer" required>
                                    <option value="">Pilih Kota</option>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black text-neutral-400 uppercase ml-1 tracking-widest">Kecamatan</label>
                                <select name="district_id" id="district_id" class="w-full px-4 py-2.5 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 outline-none font-bold text-neutral-700 text-[11px] appearance-none cursor-pointer" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-black text-neutral-400 uppercase ml-1 tracking-widest">Desa & Kode Pos</label>
                                <div class="flex gap-2">
                                    <select name="village_id" id="village_id" class="flex-1 px-4 py-2.5 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 outline-none font-bold text-neutral-700 text-[11px] appearance-none cursor-pointer" required>
                                        <option value="">Desa</option>
                                    </select>
                                    <input type="text" name="postal_code" placeholder="Pos" value="{{ old('postal_code') }}" class="w-16 px-1 py-2.5 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 text-center font-bold text-neutral-700 text-[11px]" maxlength="5">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Default Checkbox Minimalis --}}
                <div class="p-3.5 bg-neutral-50 rounded-xl border border-neutral-100">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="is_default" value="1" class="w-4 h-4 text-primary-600 rounded border-neutral-300 focus:ring-primary-500" {{ old('is_default') ? 'checked' : '' }}>
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-neutral-800 uppercase tracking-widest">Alamat Utama</span>
                            <span class="text-[8px] text-neutral-400 italic font-medium">Gunakan untuk pesanan otomatis.</span>
                        </div>
                    </label>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-5 border-t border-neutral-50 flex flex-col md:flex-row items-center justify-between gap-4">
                    <a href="{{ route('shippings.index') }}" class="text-[9px] font-black text-neutral-400 uppercase tracking-widest hover:text-primary-600 transition-all flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="w-full md:w-auto px-8 py-3 bg-neutral-900 text-white font-black rounded-xl hover:bg-primary-600 transition-all shadow-sm uppercase tracking-widest text-[9px]">
                        Simpan Alamat
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const resetSelect = (ids) => ids.forEach(id => $(id).html(`<option value="">Pilih ${$(id).prev().text()}</option>`));

        // Logic API Wilayah (Tetap sama agar fungsional)
        $('#province_id').on('change', function () {
            const code = $(this).val();
            resetSelect(['#city_id', '#district_id', '#village_id']);
            if (!code) return;
            $.get(`/api/cities/${code}`).done(function (data) {
                let options = '<option value="">Pilih Kota</option>';
                data.forEach(item => options += `<option value="${item.code}">${item.name}</option>`);
                $('#city_id').html(options);
            });
        });

        $('#city_id').on('change', function () {
            const code = $(this).val();
            resetSelect(['#district_id', '#village_id']);
            if (!code) return;
            $.get(`/api/districts/${code}`).done(function (data) {
                let options = '<option value="">Pilih Kecamatan</option>';
                data.forEach(item => options += `<option value="${item.code}">${item.name}</option>`);
                $('#district_id').html(options);
            });
        });

        $('#district_id').on('change', function () {
            const code = $(this).val();
            resetSelect(['#village_id']);
            if (!code) return;
            $.get(`/api/villages/${code}`).done(function (data) {
                let options = '<option value="">Pilih Desa</option>';
                data.forEach(item => options += `<option value="${item.code}">${item.name}</option>`);
                $('#village_id').html(options);
            });
        });
    });
</script>
@endpush