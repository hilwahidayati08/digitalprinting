@extends('admin.guest')

@section('title', 'Checkout - PrintDigital')

@section('content')

{{-- Page Header --}}
<div class="bg-gradient-to-br from-primary-600 to-secondary-600 py-8 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
    <div class="absolute bottom-0 left-0 w-24 h-24 bg-black/5 rounded-full translate-y-10 -translate-x-8"></div>
    <div class="container mx-auto px-4 max-w-6xl relative z-10">
        <p class="text-white/60 text-[10px] font-black uppercase tracking-[0.2em] mb-1">Langkah Terakhir</p>
        <h1 class="text-white text-2xl font-black tracking-tight italic">Konfirmasi Pesanan</h1>
    </div>
</div>

{{-- Progress Steps --}}
<div class="bg-white border-b border-neutral-100">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="flex items-center py-4 gap-2">
            <div class="flex items-center gap-2 text-neutral-400">
                <div class="w-5 h-5 rounded-full bg-neutral-100 flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-[8px]"></i>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest hidden sm:inline">Keranjang</span>
            </div>
            <div class="h-[1px] w-8 bg-neutral-200"></div>
            <div class="flex items-center gap-2 text-primary-600">
                <div class="w-5 h-5 rounded-full bg-primary-600 flex items-center justify-center">
                    <i class="fas fa-clipboard-check text-[8px] text-white"></i>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest hidden sm:inline">Konfirmasi</span>
            </div>
            <div class="h-[1px] w-8 bg-neutral-200"></div>
            <div class="flex items-center gap-2 text-neutral-300">
                <div class="w-5 h-5 rounded-full bg-neutral-100 flex items-center justify-center">
                    <i class="fas fa-credit-card text-[8px]"></i>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest hidden sm:inline">Pembayaran</span>
            </div>
        </div>
    </div>
</div>

<section class="py-10 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 max-w-6xl">

        <form id="checkoutForm">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-5">

                    {{-- 1. PILIH ALAMAT --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-neutral-50 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                                <h3 class="text-[11px] font-black text-neutral-800 uppercase tracking-widest">Alamat Pengiriman</h3>
                            </div>
                            <button type="button" onclick="openAddressModal()" class="text-[10px] font-black text-primary-600 hover:text-primary-700 flex items-center gap-1 uppercase tracking-widest transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Alamat
                            </button>
                        </div>

                        <div class="p-5">
                            <div id="addressList" class="space-y-3 max-h-[280px] overflow-y-auto pr-1" style="scrollbar-width: thin; scrollbar-color: #e5e7eb transparent;">
                                @forelse($shippings as $shipping)
                                    <label class="relative flex items-start p-4 border-2 border-neutral-100 rounded-xl cursor-pointer transition-all hover:bg-neutral-50 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50/30">
                                        <input type="radio" name="shipping_id" value="{{ $shipping->shipping_id }}"
                                            class="mt-1 text-primary-600 shipping-address-radio"
                                            data-city-id="{{ $shipping->city_id }}"
                                            data-distance="{{ $shipping->distance ?? 5 }}"
                                            {{ $loop->first ? 'checked' : '' }}>
                                        <div class="ml-4 flex-1">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span class="font-black text-neutral-800 text-sm">{{ $shipping->recipient_name }}</span>
                                                @if($shipping->label)
                                                    <span class="px-2 py-0.5 text-[9px] bg-primary-50 text-primary-600 border border-primary-100 rounded-md font-black uppercase tracking-wider">{{ $shipping->label }}</span>
                                                @endif
                                                @if ($shipping->is_default)
                                                    <span class="px-2 py-0.5 text-[9px] bg-neutral-100 text-neutral-500 rounded-md uppercase font-black tracking-wider">Utama</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-neutral-500 font-medium mt-1">{{ $shipping->address }}</p>
                                            <p class="text-[10px] text-neutral-400 mt-0.5 italic">
                                                {{ $shipping->village?->name }}, {{ $shipping->district?->name }}, {{ $shipping->city?->name }}
                                            </p>
                                        </div>
                                    </label>
                                @empty
                                    <div class="text-center py-8 border-2 border-dashed border-neutral-100 rounded-xl">
                                        <i class="fas fa-map-marker-alt text-neutral-200 text-2xl mb-3 block"></i>
                                        <p class="text-[10px] text-neutral-400 font-black uppercase tracking-widest">Belum ada alamat pengiriman.</p>
                                        <button type="button" onclick="openAddressModal()" class="mt-3 text-[10px] font-black text-primary-600 uppercase tracking-widest hover:underline">+ Tambah Sekarang</button>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- 2. METODE PENGIRIMAN --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-neutral-50 flex items-center gap-2">
                            <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                            <h3 class="text-[11px] font-black text-neutral-800 uppercase tracking-widest">Metode Pengiriman</h3>
                        </div>
                        <div class="p-5">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <label class="flex items-center gap-4 p-4 border-2 border-neutral-100 rounded-xl cursor-pointer hover:bg-neutral-50 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50/30 transition-all">
                                    <input type="radio" name="shipping_method" value="pickup" class="w-4 h-4 text-primary-600 flex-shrink-0" checked>
                                    <div>
                                        <div class="font-black text-neutral-700 text-sm">Ambil Sendiri</div>
                                        <div class="text-[9px] text-neutral-400 font-bold mt-0.5">Gratis · Langsung ke toko</div>
                                    </div>
                                </label>
                                <label id="label_gojek" class="flex items-center gap-4 p-4 border-2 border-neutral-100 rounded-xl cursor-pointer hover:bg-neutral-50 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50/30 transition-all">
                                    <input type="radio" name="shipping_method" value="gojek" class="w-4 h-4 text-primary-600 flex-shrink-0">
                                    <div>
                                        <div class="font-black text-neutral-700 text-sm">Gojek / Grab</div>
                                        <div class="text-[9px] text-primary-500 font-bold mt-0.5">Instan · Hari yang sama</div>
                                    </div>
                                </label>
                                <label class="flex items-center gap-4 p-4 border-2 border-neutral-100 rounded-xl cursor-pointer hover:bg-neutral-50 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50/30 transition-all">
                                    <input type="radio" name="shipping_method" value="ekspedisi" class="w-4 h-4 text-primary-600 flex-shrink-0">
                                    <div>
                                        <div class="font-black text-neutral-700 text-sm">Ekspedisi</div>
                                        <div class="text-[9px] text-neutral-400 font-bold mt-0.5">Reguler · 1–7 hari kerja</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- INFO: Pembayaran dilanjutkan setelah order dibuat --}}
                    <div class="flex items-start gap-3 p-4 bg-amber-50 border border-amber-100 rounded-2xl">
                        <i class="fas fa-circle-info text-amber-500 text-sm mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-[10px] font-black text-amber-700 uppercase tracking-widest">Pembayaran di Langkah Berikutnya</p>
                            <p class="text-[10px] text-amber-600 font-medium mt-0.5">Setelah pesanan dikonfirmasi, kamu akan diarahkan ke halaman pembayaran untuk memilih metode (QRIS, Transfer Bank, atau E-Wallet).</p>
                        </div>
                    </div>

                </div>

                {{-- SIDEBAR RINGKASAN --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-neutral-100 overflow-hidden sticky top-6">

                        {{-- Summary Header --}}
                        <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-6 py-5 flex items-center gap-3 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-6 translate-x-6"></div>
                            <div class="w-8 h-8 bg-white/20 border border-white/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-receipt text-white text-xs"></i>
                            </div>
                            <span class="text-white font-black text-sm uppercase tracking-wider relative z-10">Ringkasan Pesanan</span>
                        </div>

                        <div class="p-6 space-y-4">
                            <div class="space-y-3">
                                <div class="flex justify-between text-xs">
                                    <span class="text-neutral-400 font-medium">Subtotal Items</span>
                                    <span class="font-bold text-neutral-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-neutral-400 font-medium">Pajak (11%)</span>
                                    <span class="font-bold text-neutral-800">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                </div>
                                @if(isset($discountMember) && $discountMember > 0)
                                <div class="flex justify-between text-xs">
                                    <span class="text-green-600 font-medium">Diskon Member</span>
                                    <span class="font-bold text-green-600">- Rp {{ number_format($discountMember, 0, ',', '.') }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between text-xs pb-3 border-b border-neutral-50">
                                    <span class="text-neutral-400 font-medium">Ongkos Kirim</span>
                                    <span id="display_ongkir" class="font-bold text-neutral-800">Rp 0</span>
                                </div>
                            </div>

                            <div class="p-3 bg-primary-50 rounded-xl border border-primary-100">
                                <div class="flex justify-between items-center text-primary-700">
                                    <span class="text-[9px] uppercase font-black tracking-widest">Estimasi Tiba</span>
                                    <span id="display_estimasi" class="text-[10px] font-black">-</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-end pt-1 border-t border-neutral-50">
                                <span class="text-[10px] font-black text-neutral-800 uppercase tracking-widest">Total Tagihan</span>
                                <span id="display_total" class="text-xl font-black text-primary-600 tracking-tighter">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <button type="submit" id="submitBtn"
                                class="w-full py-3.5 bg-neutral-900 hover:bg-primary-600 text-white font-black rounded-xl transition-all shadow-md text-[10px] uppercase tracking-widest flex items-center justify-center gap-2 mt-2">
                                <i class="fas fa-arrow-right"></i>
                                <span>Buat Pesanan</span>
                            </button>

                            <p class="text-center text-[9px] text-neutral-400 font-medium">
                                Kamu akan memilih metode pembayaran di langkah berikutnya
                            </p>

                            <div class="flex items-center justify-center gap-2 text-[9px] text-neutral-300 font-bold uppercase tracking-widest pt-1">
                                <i class="fas fa-lock text-green-400 text-[10px]"></i> Transaksi Aman & Terenkripsi
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>

{{-- ===== MODAL TAMBAH ALAMAT ===== --}}
<div id="modalTambahAlamat" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeAddressModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">

        {{-- Modal Header --}}
        <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-8 py-6 flex items-center justify-between flex-shrink-0 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="flex items-center gap-3 relative z-10">
                <div class="w-10 h-10 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl flex items-center justify-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-white text-base font-black uppercase tracking-widest italic leading-none">Tambah Alamat Baru</h2>
                    <p class="text-white/70 text-[10px] mt-1 font-medium italic">Lengkapi detail lokasi pengiriman</p>
                </div>
            </div>
            <button type="button" onclick="closeAddressModal()" class="text-white/60 hover:text-white transition-colors p-1 relative z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="overflow-y-auto flex-1 p-8">
            <form id="modalShippingForm" class="space-y-6">
                @csrf

                {{-- Label Alamat --}}
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Label Alamat</label>
                    <input type="text" name="label" maxlength="30"
                           placeholder="cth: Rumah, Kos, Kantor, Gudang, Studio..."
                           class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-sm">
                    <p class="text-[10px] text-neutral-400 italic ml-1">Opsional · Untuk membedakan alamat satu sama lain</p>
                </div>

                {{-- Nama & HP --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Nama Penerima</label>
                        <input type="text" name="recipient_name" value="{{ auth()->user()->full_name }}"
                               class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-sm" required>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">No. HP Penerima</label>
                        <input type="tel" name="recipient_phone" value="{{ auth()->user()->no_telp }}"
                               class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-sm" required>
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Alamat Lengkap</label>
                    <textarea name="address" rows="3"
                              class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-neutral-700 text-sm"
                              placeholder="Nama jalan, nomor rumah, RT/RW, dsb" required></textarea>
                </div>

                {{-- Wilayah --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Provinsi</label>
                        <select name="province_id" id="modal_province_id"
                                class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 outline-none font-bold text-neutral-700 text-sm appearance-none cursor-pointer" required>
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->code }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Kota/Kabupaten</label>
                        <select name="city_id" id="modal_city_id"
                                class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 outline-none font-bold text-neutral-700 text-sm appearance-none cursor-pointer" required>
                            <option value="">Pilih Kota</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Kecamatan</label>
                        <select name="district_id" id="modal_district_id"
                                class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 outline-none font-bold text-neutral-700 text-sm appearance-none cursor-pointer" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Kelurahan/Desa</label>
                        <select name="village_id" id="modal_village_id"
                                class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 outline-none font-bold text-neutral-700 text-sm appearance-none cursor-pointer" required>
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                    <div class="space-y-1.5 md:col-span-2">
                        <label class="text-[10px] font-bold text-neutral-400 uppercase ml-1 tracking-wider">Kode Pos</label>
                        <input type="text" name="postal_code" maxlength="5"
                               class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl focus:border-primary-600 outline-none font-bold text-neutral-700 text-sm">
                    </div>
                </div>

                {{-- Set Default --}}
                <div class="p-4 bg-primary-50/50 rounded-xl border border-primary-100">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_default" value="1" class="w-4 h-4 text-primary-600 rounded border-primary-200">
                        <div>
                            <span class="block text-[10px] font-black text-primary-700 uppercase tracking-widest">Jadikan Alamat Utama</span>
                            <span class="text-[10px] text-primary-400 italic">Otomatis terpilih saat checkout</span>
                        </div>
                    </label>
                </div>

                {{-- Error --}}
                <div id="modalAddressError" class="hidden p-4 bg-red-50 border border-red-100 rounded-xl text-sm text-red-500 font-medium"></div>
            </form>
        </div>

        {{-- Modal Footer --}}
        <div class="px-8 py-5 border-t border-neutral-100 flex items-center justify-between flex-shrink-0 bg-neutral-50/50">
            <button type="button" onclick="closeAddressModal()" class="text-[10px] font-black text-neutral-400 uppercase tracking-widest hover:text-neutral-700 transition-all">
                Batal
            </button>
            <button type="button" onclick="submitAddressModal()" id="modalSubmitBtn"
                    class="px-10 py-3 bg-neutral-900 text-white font-black rounded-xl hover:bg-primary-600 transition-all shadow-lg text-[10px] uppercase tracking-widest">
                Simpan Alamat
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    const MY_CITY_ID = {{ $myCityId }};
    const TARIF_PER_KM = 3500;
    const MAX_PRODUCTION_DAYS = {{ $maxProductionDays }};
    const CUT_OFF_HOUR = 16;

    let subtotal = {{ $subtotal }};
    let tax = {{ $tax }};
    let discountMember = {{ $discountMember ?? 0 }};

    function getEstimateDate(daysToAdd) {
        let date = new Date();
        if (date.getHours() >= CUT_OFF_HOUR) daysToAdd += 1;
        date.setDate(date.getDate() + daysToAdd);
        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
    }

    function updatePricing() {
        const selectedAddress = document.querySelector('input[name="shipping_id"]:checked');
        const methodInput = document.querySelector('input[name="shipping_method"]:checked');
        const gojekRadio = document.querySelector('input[value="gojek"]');
        const gojekLabel = gojekRadio.closest('label');
        const ekspedisiRadio = document.querySelector('input[value="ekspedisi"]');

        let shippingCost = 0;
        let estimasiTeks = "-";

        if (selectedAddress) {
            const cityId = parseInt(selectedAddress.dataset.cityId);

            if (cityId === MY_CITY_ID) {
                gojekRadio.disabled = false;
                gojekLabel.classList.remove('opacity-40', 'bg-neutral-100', 'cursor-not-allowed');
                gojekLabel.style.pointerEvents = 'auto';
            } else {
                gojekRadio.disabled = true;
                gojekLabel.classList.add('opacity-40', 'bg-neutral-100', 'cursor-not-allowed');
                gojekLabel.style.pointerEvents = 'none';
                if (methodInput && methodInput.value === 'gojek') {
                    ekspedisiRadio.checked = true;
                }
            }

            const currentMethod = document.querySelector('input[name="shipping_method"]:checked').value;

            if (currentMethod === 'pickup') {
                shippingCost = 0;
                estimasiTeks = "Siap diambil: " + getEstimateDate(MAX_PRODUCTION_DAYS);
            } else if (currentMethod === 'gojek') {
                let dist = parseFloat(selectedAddress.dataset.distance || 5);
                shippingCost = Math.max(10000, Math.ceil(dist * TARIF_PER_KM));
                estimasiTeks = "Tiba: " + getEstimateDate(MAX_PRODUCTION_DAYS + 1);
            } else if (currentMethod === 'ekspedisi') {
                if (cityId !== MY_CITY_ID) {
                    shippingCost = 200000;
                    estimasiTeks = "Tiba: " + getEstimateDate(MAX_PRODUCTION_DAYS + 3) + " - " + getEstimateDate(MAX_PRODUCTION_DAYS + 6);
                } else {
                    shippingCost = 25000;
                    estimasiTeks = "Tiba: " + getEstimateDate(MAX_PRODUCTION_DAYS + 1) + " - " + getEstimateDate(MAX_PRODUCTION_DAYS + 2);
                }
            }
        }

        const totalTagihan = (subtotal - discountMember) + tax + shippingCost;
        document.getElementById('display_ongkir').innerText = 'Rp ' + shippingCost.toLocaleString('id-ID');
        document.getElementById('display_estimasi').innerText = estimasiTeks;
        document.getElementById('display_total').innerText = 'Rp ' + totalTagihan.toLocaleString('id-ID');
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input[name="shipping_method"], .shipping-address-radio').forEach(input => {
            input.addEventListener('change', updatePricing);
        });
        updatePricing();
    });

    // ===== SUBMIT CHECKOUT =====
    document.getElementById('checkoutForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const btn = document.getElementById('submitBtn');
        const selectedAddress = document.querySelector('input[name="shipping_id"]:checked');

        if (!selectedAddress) {
            alert("Silakan pilih alamat pengiriman terlebih dahulu.");
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner animate-spin"></i><span>Membuat Pesanan...</span>';

        const payload = {
            shipping_id: selectedAddress.value,
            shipping_method: document.querySelector('input[name="shipping_method"]:checked').value,
            distance: selectedAddress.dataset.distance || 5
        };

        fetch("{{ route('checkout.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            },
            body: JSON.stringify(payload)
        })
        .then(async res => {
            const data = await res.json();
            if (!res.ok) throw new Error(data.message || 'Terjadi kesalahan server');
            return data;
        })
        .then(data => {
            if (data.status === 'success') {
                // Tampilkan Snap untuk bayar langsung
                if (data.snap_token) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: () => window.location.href = "{{ route('checkout.success') }}?order_id=" + data.order_number,
                        onPending: () => window.location.href = "{{ route('orders.index') }}",
                        onError: () => {
                            alert("Pembayaran gagal. Silakan coba lagi dari halaman pesanan.");
                            window.location.href = "{{ route('orders.index') }}";
                        },
                        onClose: () => {
                            // User tutup popup — order sudah dibuat, arahkan ke orders
                            window.location.href = "{{ route('orders.index') }}";
                        }
                    });
                } else {
                    window.location.href = "{{ route('orders.index') }}";
                }
            }
        })
        .catch(err => {
            alert(err.message);
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-arrow-right"></i><span>Buat Pesanan</span>';
        });
    });

    // ===== MODAL =====
    function openAddressModal() {
        const modal = document.getElementById('modalTambahAlamat');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeAddressModal() {
        const modal = document.getElementById('modalTambahAlamat');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
        document.getElementById('modalShippingForm').reset();
        document.getElementById('modalAddressError').classList.add('hidden');
        $('#modal_city_id').html('<option value="">Pilih Kota</option>');
        $('#modal_district_id').html('<option value="">Pilih Kecamatan</option>');
        $('#modal_village_id').html('<option value="">Pilih Kelurahan</option>');
    }

    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeAddressModal(); });

    // ===== CASCADE DROPDOWN =====
    $('#modal_province_id').on('change', function () {
        const code = $(this).val();
        $('#modal_city_id, #modal_district_id, #modal_village_id').html('<option value="">Memuat...</option>');
        if (!code) return;
        $.get(`/api/cities/${code}`).done(data => {
            let opts = '<option value="">Pilih Kota</option>';
            data.forEach(i => opts += `<option value="${i.code}">${i.name}</option>`);
            $('#modal_city_id').html(opts);
            $('#modal_district_id').html('<option value="">Pilih Kecamatan</option>');
            $('#modal_village_id').html('<option value="">Pilih Kelurahan</option>');
        });
    });

    $('#modal_city_id').on('change', function () {
        const code = $(this).val();
        if (!code) return;
        $('#modal_district_id').html('<option value="">Memuat...</option>');
        $.get(`/api/districts/${code}`).done(data => {
            let opts = '<option value="">Pilih Kecamatan</option>';
            data.forEach(i => opts += `<option value="${i.code}">${i.name}</option>`);
            $('#modal_district_id').html(opts);
            $('#modal_village_id').html('<option value="">Pilih Kelurahan</option>');
        });
    });

    $('#modal_district_id').on('change', function () {
        const code = $(this).val();
        if (!code) return;
        $('#modal_village_id').html('<option value="">Memuat...</option>');
        $.get(`/api/villages/${code}`).done(data => {
            let opts = '<option value="">Pilih Kelurahan</option>';
            data.forEach(i => opts += `<option value="${i.code}">${i.name}</option>`);
            $('#modal_village_id').html(opts);
        });
    });

    // ===== SUBMIT MODAL ALAMAT =====
    function submitAddressModal() {
        const btn = document.getElementById('modalSubmitBtn');
        const errorBox = document.getElementById('modalAddressError');
        const form = document.getElementById('modalShippingForm');

        errorBox.classList.add('hidden');
        btn.disabled = true;
        btn.innerHTML = '<span class="animate-pulse">Menyimpan...</span>';

        fetch("{{ route('shippings.store') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: new FormData(form)
        })
        .then(async res => {
            const text = await res.text();
            let data = {};
            try { data = JSON.parse(text); } catch (e) {}

            if (!res.ok) {
                const messages = data.errors
                    ? Object.values(data.errors).flat().join('<br>')
                    : (data.message || 'Terjadi kesalahan.');
                errorBox.innerHTML = messages;
                errorBox.classList.remove('hidden');
                btn.disabled = false;
                btn.innerText = 'Simpan Alamat';
                return;
            }

            btn.innerHTML = '✓ Tersimpan!';
            btn.classList.remove('bg-neutral-900', 'hover:bg-primary-600');
            btn.classList.add('bg-green-600');
            setTimeout(() => { closeAddressModal(); window.location.reload(); }, 600);
        })
        .catch(() => {
            errorBox.innerHTML = 'Gagal menyimpan alamat. Silakan coba lagi.';
            errorBox.classList.remove('hidden');
            btn.disabled = false;
            btn.innerText = 'Simpan Alamat';
        });
    }
</script>
@endpush