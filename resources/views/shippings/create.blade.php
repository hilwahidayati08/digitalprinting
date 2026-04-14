@extends('admin.member')

@section('member_content')
<div class="max-w-5xl mx-auto px-4 mb-8 space-y-6">

    {{-- Tambah Alamat Form --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-neutral-100 overflow-hidden">

        {{-- Header --}}
        <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-8 py-8 flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
            <div class="absolute bottom-0 left-0 w-20 h-20 bg-black/5 rounded-full translate-y-8 -translate-x-6"></div>

            <div class="relative z-10 flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-map-location-dot text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-white text-xl font-black italic uppercase tracking-tight leading-none">Tambah Alamat</h2>
                    <p class="text-white/70 text-[11px] mt-2 font-medium italic">Lengkapi lokasi pengiriman Anda</p>
                </div>
            </div>
        </div>

        {{-- Form Body dengan Scroll --}}
        <div class="overflow-y-auto" style="max-height: calc(100vh - 240px);">
            <form action="{{ route('shippings.store') }}" method="POST" id="shippingForm" class="p-6 lg:p-8">
                @csrf
                <input type="hidden" name="redirect_back" value="{{ url()->previous() }}">

                <div class="space-y-8">

                    {{-- Bagian 01: Identitas Penerima --}}
                    <div class="space-y-5">
                        <div class="flex items-center gap-2 border-b border-neutral-100 pb-2">
                            <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                            <h3 class="text-[11px] font-black text-neutral-800 uppercase tracking-widest">Identitas Penerima</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Label Alamat</label>
                                <div class="relative">
                                    <i class="fas fa-tag absolute left-4 top-1/2 -translate-y-1/2 text-neutral-300 text-xs"></i>
                                    <input type="text" name="label" value="{{ old('label') }}" maxlength="30"
                                           placeholder="Rumah, Kantor, dll..."
                                           class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-sm">
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">No. WhatsApp</label>
                                <div class="relative">
                                    <i class="fab fa-whatsapp absolute left-4 top-1/2 -translate-y-1/2 text-neutral-300 text-sm"></i>
                                    <input type="tel" name="recipient_phone" value="{{ old('recipient_phone', auth()->user()->no_telp) }}" 
                                           class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-sm" required>
                                </div>
                            </div>
                            <div class="space-y-1.5 md:col-span-2">
                                <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Nama Penerima</label>
                                <div class="relative">
                                    <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-neutral-300 text-xs"></i>
                                    <input type="text" name="recipient_name" value="{{ old('recipient_name', auth()->user()->username) }}" 
                                           class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-sm" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bagian 02: Detail Lokasi --}}
                    <div class="space-y-5">
                        <div class="flex items-center gap-2 border-b border-neutral-100 pb-2">
                            <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                            <h3 class="text-[11px] font-black text-neutral-800 uppercase tracking-widest">Detail Lokasi</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Alamat Lengkap</label>
                                <div class="relative">
                                    <i class="fas fa-location-dot absolute left-4 top-4 text-neutral-300 text-xs"></i>
                                    <textarea name="address" rows="3" class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-sm" placeholder="Nama jalan, nomor rumah, RT/RW..." required>{{ old('address') }}</textarea>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Provinsi</label>
                                    <div class="relative">
                                        <i class="fas fa-map absolute left-4 top-1/2 -translate-y-1/2 text-neutral-300 text-xs"></i>
                                        <select name="province_id" id="province_id" class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 outline-none transition-all font-bold text-neutral-700 text-sm appearance-none cursor-pointer" required>
                                            <option value="">Pilih Provinsi</option>
                                            @foreach($provinces as $province)
                                                <option value="{{ $province->code }}" {{ old('province_id') == $province->code ? 'selected' : '' }}>{{ $province->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Kota/Kabupaten</label>
                                    <div class="relative">
                                        <i class="fas fa-city absolute left-4 top-1/2 -translate-y-1/2 text-neutral-300 text-xs"></i>
                                        <select name="city_id" id="city_id" class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 outline-none transition-all font-bold text-neutral-700 text-sm appearance-none cursor-pointer" required>
                                            <option value="">Pilih Kota</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Kecamatan</label>
                                    <div class="relative">
                                        <i class="fas fa-building absolute left-4 top-1/2 -translate-y-1/2 text-neutral-300 text-xs"></i>
                                        <select name="district_id" id="district_id" class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 outline-none transition-all font-bold text-neutral-700 text-sm appearance-none cursor-pointer" required>
                                            <option value="">Pilih Kecamatan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Desa & Kode Pos</label>
                                    <div class="flex gap-2">
                                        <div class="relative flex-1">
                                            <i class="fas fa-home absolute left-4 top-1/2 -translate-y-1/2 text-neutral-300 text-xs"></i>
                                            <select name="village_id" id="village_id" class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 outline-none transition-all font-bold text-neutral-700 text-sm appearance-none cursor-pointer" required>
                                                <option value="">Pilih Desa</option>
                                            </select>
                                        </div>
                                        <input type="text" name="postal_code" placeholder="Kode Pos" value="{{ old('postal_code') }}" 
                                               class="w-28 px-3 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 text-center font-bold text-neutral-700 text-sm" maxlength="5">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Default Checkbox --}}
                    <div class="p-4 bg-neutral-50 rounded-xl border border-neutral-100">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="is_default" value="1" class="w-4 h-4 text-primary-600 rounded border-neutral-300 focus:ring-primary-500" {{ old('is_default') ? 'checked' : '' }}>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-neutral-800 uppercase tracking-widest">Jadikan Alamat Utama</span>
                                <span class="text-[9px] text-neutral-400 italic font-medium">Gunakan untuk pesanan secara otomatis.</span>
                            </div>
                        </label>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-6 border-t border-neutral-100 flex flex-col md:flex-row items-center justify-between gap-4">
                        <a href="{{ route('shippings.index') }}" class="text-[10px] font-black text-neutral-400 uppercase tracking-widest hover:text-primary-600 transition-all flex items-center gap-2">
                            <i class="fas fa-arrow-left text-[9px]"></i> 
                            <span>Kembali</span>
                        </a>
                        <button type="submit" class="w-full md:w-auto px-10 py-3.5 bg-neutral-900 text-white font-black rounded-xl hover:bg-primary-600 transition-all shadow-lg hover:shadow-primary-600/20 uppercase tracking-widest text-[10px] flex items-center justify-center gap-2">
                            <i class="fas fa-save text-[11px]"></i>
                            <span>Simpan Alamat</span>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Shortcut Card Kembali ke Alamat --}}
    <a href="{{ route('shippings.index') }}"
       class="block bg-white rounded-[1.5rem] shadow-sm border border-neutral-100 overflow-hidden hover:border-primary-200 transition-all group">
        <div class="p-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-primary-50 border border-primary-100 rounded-xl flex items-center justify-center group-hover:bg-primary-600 transition-all">
                    <i class="fas fa-map-marked-alt text-primary-600 group-hover:text-white transition-all text-lg"></i>
                </div>
                <div>
                    <h4 class="text-[12px] font-black text-neutral-800 uppercase tracking-tight">Lihat Semua Alamat</h4>
                    <p class="text-[10px] text-neutral-400 font-medium mt-0.5 italic">Kelola daftar alamat pengiriman Anda</p>
                </div>
            </div>
            <div class="flex items-center gap-1.5 text-neutral-400 group-hover:text-primary-600 transition-all font-black text-[10px] uppercase tracking-widest">
                <span class="hidden md:inline">Buka</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </div>
        </div>
    </a>

</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const resetSelect = (ids) => ids.forEach(id => $(id).html(`<option value="">Pilih ${$(id).prev().text()}</option>`));

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