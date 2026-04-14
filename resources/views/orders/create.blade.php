@extends('admin.admin')

@section('title', 'Buat Pesanan Baru')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Buat Pesanan</h1>
            <p class="text-sm text-gray-500">Input transaksi offline & pendaftaran member cepat.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="toggleGuestForm()" id="btn-toggle-guest"
                class="flex items-center gap-2 bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-gray-200">
                <i class="fas fa-user"></i><span>Pelanggan Umum</span>
            </button>
            <button type="button" onclick="toggleMemberForm()" id="btn-toggle-member"
                class="flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-emerald-200">
                <i class="fas fa-user-plus"></i><span id="btn-member-text">Daftar Member Baru</span>
            </button>
        </div>
    </div>

    <form id="orderForm" onsubmit="handleFormSubmit(event)" enctype="multipart/form-data">
        @csrf

        {{-- Form Pelanggan Umum --}}
        <div id="guestForm" class="hidden mb-6 bg-gray-50 border border-gray-200 rounded-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-gray-700 font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-user text-gray-500"></i> Pelanggan Umum (Tanpa Akun)
                </h3>
                <button type="button" onclick="toggleGuestForm()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="guest_name" id="guest_name" placeholder="Nama Lengkap *"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-gray-400 text-sm">
                <input type="tel" name="guest_phone" id="guest_phone" placeholder="No. HP / WhatsApp *"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-gray-400 text-sm">
                <input type="email" name="guest_email" placeholder="Email (Opsional)"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-gray-400 text-sm">
            </div>
            <p class="text-[10px] text-gray-400 font-medium mt-3 flex items-center gap-1.5">
                <i class="fas fa-info-circle"></i>
                Data ini hanya dicatat di pesanan, tidak membuat akun baru.
            </p>

            {{-- Alamat pengiriman guest — muncul kalau bukan pickup --}}
            <div id="guestAddressSection" class="hidden mt-5 pt-5 border-t border-gray-200">
                <p class="text-[10px] font-black text-gray-600 uppercase tracking-widest mb-3 flex items-center gap-2">
                    <i class="fas fa-map-marker-alt"></i> Alamat Pengiriman
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <input type="text" name="guest_recipient_name" placeholder="Nama Penerima *"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
                    <input type="tel" name="guest_recipient_phone" placeholder="No. HP Penerima *"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
                    <textarea name="guest_address" rows="2" placeholder="Alamat lengkap (jalan, no rumah, RT/RW) *"
                        class="md:col-span-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm"></textarea>
                    <select name="guest_province_id" id="guest_province_id"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
                        <option value="">Pilih Provinsi *</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->code }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                    <select name="guest_city_id" id="guest_city_id"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
                        <option value="">Pilih Kota *</option>
                    </select>
                    <select name="guest_district_id" id="guest_district_id"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
                        <option value="">Pilih Kecamatan *</option>
                    </select>
                    <select name="guest_village_id" id="guest_village_id"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
                        <option value="">Pilih Kelurahan *</option>
                    </select>
                    <input type="text" name="guest_postal_code" placeholder="Kode Pos" maxlength="5"
                        class="md:col-span-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm">
                </div>
            </div>
        </div>

        {{-- Form Member Baru --}}
        <div id="memberForm" class="hidden mb-6 bg-emerald-50 border border-emerald-100 rounded-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-emerald-800 font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-id-card"></i> Data Member Baru
                </h3>
                <button type="button" onclick="toggleMemberForm()" class="text-emerald-400 hover:text-emerald-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="new_customer_name" id="new_customer_name" placeholder="Nama Lengkap *"
                    class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 focus:ring-emerald-500 text-sm">
                <input type="email" name="new_customer_email" placeholder="Email (Opsional)"
                    class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 focus:ring-emerald-500 text-sm">
                <input type="text" name="new_customer_phone" id="new_customer_phone" placeholder="No. WhatsApp *"
                    class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 focus:ring-emerald-500 text-sm">
            </div>

            {{-- Alamat untuk member baru (muncul jika metode bukan pickup) --}}
            <div id="memberAddressSection" class="hidden mt-5 pt-5 border-t border-emerald-200">
                <p class="text-[10px] font-black text-emerald-700 uppercase tracking-widest mb-3 flex items-center gap-2">
                    <i class="fas fa-map-marker-alt"></i> Alamat Pengiriman Member Baru
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <input type="text" name="new_recipient_name" placeholder="Nama Penerima *"
                        class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-sm">
                    <input type="tel" name="new_recipient_phone" placeholder="No. HP Penerima *"
                        class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-sm">
                    <textarea name="new_address" rows="2" placeholder="Alamat lengkap (jalan, no rumah, RT/RW) *"
                        class="md:col-span-2 w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-sm"></textarea>
                    <select name="new_province_id" id="new_province_id"
                        class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-sm">
                        <option value="">Pilih Provinsi *</option>
                        @foreach($provinces as $province)
                            <option value="{{ $province->code }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                    <select name="new_city_id" id="new_city_id"
                        class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-sm">
                        <option value="">Pilih Kota *</option>
                    </select>
                    <select name="new_district_id" id="new_district_id"
                        class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-sm">
                        <option value="">Pilih Kecamatan *</option>
                    </select>
                    <select name="new_village_id" id="new_village_id"
                        class="w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-sm">
                        <option value="">Pilih Kelurahan *</option>
                    </select>
                    <input type="text" name="new_postal_code" placeholder="Kode Pos" maxlength="5"
                        class="md:col-span-2 w-full px-4 py-2.5 rounded-xl border border-emerald-200 text-sm">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">

            {{-- Kolom Kiri --}}
            <div class="col-span-12 lg:col-span-8 space-y-5">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                        <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block">Pilih Pelanggan</label>
                        <select name="user_id" id="user_select"
                            class="w-full text-sm border-gray-200 bg-gray-50 rounded-xl focus:ring-primary-500 transition-all">
                            <option value="">-- Pilih User Terdaftar --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->user_id }}">
                                    {{ $user->full_name ?? $user->username }} [{{ $user->no_telp ?? '-' }}]
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                        <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block">Upload Desain (Global)</label>
                        <input type="file" name="design_file"
                            class="w-full text-xs text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-primary-50 file:text-primary-700 file:font-bold hover:file:bg-primary-100 transition-all"/>
                        <p class="text-[9px] text-gray-400 mt-1">Upload 1 file desain untuk semua item (opsional)</p>
                    </div>
                </div>

                {{-- Alamat Pengiriman --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                        <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                            <span class="w-1 h-4 bg-primary-600 rounded-full inline-block"></span>
                            Alamat Pengiriman
                        </h3>
                        <button type="button" onclick="openAddressModal()" id="btn-tambah-alamat"
                            class="text-[11px] font-bold bg-primary-600 text-white px-4 py-2 rounded-xl hover:bg-primary-700 transition-all shadow-md shadow-primary-100">
                            <i class="fas fa-plus mr-1"></i> Tambah Alamat
                        </button>
                    </div>
                    <div class="p-5">
                        <div id="addressList" class="space-y-3 max-h-[280px] overflow-y-auto pr-1">
                            <div class="text-center py-8 border-2 border-dashed border-gray-100 rounded-xl">
                                <i class="fas fa-map-marker-alt text-gray-200 text-2xl mb-3 block"></i>
                                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">
                                    Pilih pelanggan terlebih dahulu
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Metode Pengiriman --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-50 flex items-center gap-2 bg-gray-50/30">
                        <span class="w-1 h-4 bg-primary-600 rounded-full inline-block"></span>
                        <h3 class="font-bold text-gray-800 text-sm">Metode Pengiriman</h3>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <label class="flex items-center gap-4 p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:bg-gray-50 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50/30 transition-all">
                                <input type="radio" name="shipping_method" value="pickup" class="w-4 h-4 text-primary-600 flex-shrink-0 shipping-method-radio" checked>
                                <div>
                                    <div class="font-black text-gray-700 text-sm">Ambil Sendiri</div>
                                    <div class="text-[9px] text-gray-400 font-bold mt-0.5">Gratis · Langsung ke toko</div>
                                </div>
                            </label>
                            <label id="label_gojek" class="flex items-center gap-4 p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:bg-gray-50 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50/30 transition-all">
                                <input type="radio" name="shipping_method" value="gojek" class="w-4 h-4 text-primary-600 flex-shrink-0 shipping-method-radio">
                                <div>
                                    <div class="font-black text-gray-700 text-sm">Gojek / Grab</div>
                                    <div class="text-[9px] text-primary-500 font-bold mt-0.5">Instan · Hari yang sama</div>
                                </div>
                            </label>
                            <label class="flex items-center gap-4 p-4 border-2 border-gray-100 rounded-xl cursor-pointer hover:bg-gray-50 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50/30 transition-all">
                                <input type="radio" name="shipping_method" value="ekspedisi" class="w-4 h-4 text-primary-600 flex-shrink-0 shipping-method-radio">
                                <div>
                                    <div class="font-black text-gray-700 text-sm">Ekspedisi</div>
                                    <div class="text-[9px] text-gray-400 font-bold mt-0.5">Reguler · 1–7 hari kerja</div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Catatan Pembayaran --}}
                <div class="flex items-start gap-3 p-4 bg-amber-50 border border-amber-100 rounded-2xl">
                    <i class="fas fa-circle-info text-amber-500 text-sm mt-0.5 flex-shrink-0"></i>
                    <div>
                        <p class="text-[10px] font-black text-amber-700 uppercase tracking-widest">Catatan Pembayaran</p>
                        <p class="text-[10px] text-amber-600 font-medium mt-0.5">
                            Pilih <strong>Tunai</strong> untuk transaksi langsung di toko. Pilih <strong>Midtrans</strong> untuk membuka popup pembayaran dari halaman daftar pesanan setelah order dibuat.
                        </p>
                    </div>
                </div>

                {{-- Item Pesanan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                        <h3 class="font-bold text-gray-800">Item Pesanan</h3>
                        <button type="button" onclick="addProductRow()"
                            class="text-[11px] font-bold bg-primary-600 text-white px-4 py-2 rounded-xl hover:bg-primary-700 transition-all shadow-md shadow-primary-100">
                            <i class="fas fa-plus mr-1"></i> Tambah Item
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[10px] uppercase text-gray-400 bg-gray-50/50">
                                    <th class="px-6 py-3">Produk</th>
                                    <th class="px-4 py-3 text-center">Ukuran (cm)</th>
                                    <th class="px-4 py-3 text-center">Qty</th>
                                    <th class="px-6 py-3 text-right">Subtotal</th>
                                    <th class="px-4 py-3 text-center">File Desain</th>
                                    <th class="px-4 py-3 w-10"></th>
                                </tr>
                            </thead>
                            <tbody id="product-list" class="divide-y divide-gray-50"></tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- Kolom Kanan: Payment Summary --}}
            <div class="col-span-12 lg:col-span-4">
                <div class="bg-gray-900 rounded-[2rem] p-8 text-white sticky top-6 shadow-2xl">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <i class="fas fa-wallet text-primary-400"></i> Pembayaran
                    </h3>

                    <div class="mb-6">
                        <label class="text-[10px] font-bold text-gray-500 uppercase mb-2 block tracking-widest">Metode Bayar</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex flex-col items-center gap-1 p-3 rounded-xl border-2 border-gray-700 cursor-pointer has-[:checked]:border-primary-500 has-[:checked]:bg-primary-900/30 transition-all text-center">
                                <input type="radio" name="payment_method" value="cash" class="hidden" checked>
                                <i class="fas fa-money-bill-wave text-green-400 text-lg"></i>
                                <span class="text-xs font-bold">Tunai</span>
                                <span class="text-[9px] text-gray-500">Bayar langsung</span>
                            </label>
                            <label class="flex flex-col items-center gap-1 p-3 rounded-xl border-2 border-gray-700 cursor-pointer has-[:checked]:border-primary-500 has-[:checked]:bg-primary-900/30 transition-all text-center">
                                <input type="radio" name="payment_method" value="midtrans" class="hidden">
                                <i class="fas fa-qrcode text-blue-400 text-lg"></i>
                                <span class="text-xs font-bold">Midtrans</span>
                                <span class="text-[9px] text-gray-500">Bayar di halaman order</span>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-3 py-6 border-y border-gray-800">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Subtotal Item</span>
                            <span id="display-subtotal" class="font-mono">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Pajak (11%)</span>
                            <span id="display-tax" class="font-mono">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-400">Ongkos Kirim</span>
                            <span id="display-ongkir" class="font-mono">Rp 0</span>
                        </div>
                    </div>

                    <div class="my-4 px-4 py-3 bg-gray-800 rounded-xl">
                        <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Estimasi Tiba</p>
                        <p id="display-estimasi" class="text-xs font-bold text-primary-400 mt-1">-</p>
                    </div>

                    <div class="py-4 flex justify-between items-center">
                        <span class="text-xs font-bold text-gray-500 uppercase">Total Akhir</span>
                        <span id="display-total" class="text-3xl font-black text-primary-400 font-mono">Rp 0</span>
                    </div>

                    {{-- CASH SECTION --}}
                    <div id="cash-section" class="hidden space-y-3 mb-4 pt-4 border-t border-gray-800">
                        <div>
                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-widest block mb-1.5">
                                <i class="fas fa-hand-holding-usd mr-1 text-green-400"></i> Nominal Diterima
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold">Rp</span>
                                <input type="number" id="cash-received" name="cash_amount_received"
                                    placeholder="0"
                                    min="0"
                                    oninput="calculateChange()"
                                    class="w-full pl-10 pr-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white text-sm font-mono focus:border-green-500 focus:ring-0 outline-none transition-all">
                            </div>
                        </div>
                        <div class="flex justify-between items-center px-4 py-3 bg-gray-800 rounded-xl border border-gray-700">
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Kembalian</span>
                            <span id="display-change" class="text-lg font-black text-green-400 font-mono">Rp 0</span>
                        </div>
                        <p id="change-warning" class="hidden text-[10px] text-red-400 font-bold flex items-center gap-1">
                            <i class="fas fa-exclamation-triangle"></i> Nominal kurang dari total!
                        </p>
                    </div>

                    {{-- Hidden Inputs --}}
                    <input type="hidden" name="subtotal" id="input-subtotal" value="0">
                    <input type="hidden" name="tax" id="input-tax" value="0">
                    <input type="hidden" name="shipping_cost" id="input-ongkir" value="0">
                    <input type="hidden" name="total" id="input-total" value="0">

                    {{-- Error display --}}
                    <div id="form-error" class="hidden mb-4 p-3 bg-red-900/50 border border-red-700 rounded-xl text-red-300 text-xs font-medium"></div>

                    <button type="submit" id="submit-btn"
                        class="w-full py-4 bg-primary-500 hover:bg-primary-600 text-white rounded-2xl font-black transition-all transform active:scale-95 shadow-xl shadow-primary-900/40 flex items-center justify-center gap-2 text-lg">
                        KONFIRMASI
                    </button>

                    <a href="{{ route('admin.orders.index') }}"
                        class="block text-center mt-6 text-[10px] font-bold text-gray-500 hover:text-red-400 transition-colors uppercase tracking-widest">
                        Batalkan Transaksi
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Modal Tambah Alamat (untuk user terdaftar) --}}
<div id="modalTambahAlamat" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeAddressModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">
        <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-8 py-6 flex items-center justify-between flex-shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 border border-white/30 rounded-xl flex items-center justify-center">
                    <i class="fas fa-map-marker-alt text-white"></i>
                </div>
                <div>
                    <h2 class="text-white text-base font-black uppercase tracking-widest">Tambah Alamat Baru</h2>
                    <p class="text-white/70 text-[10px] mt-1">Lengkapi detail lokasi pengiriman</p>
                </div>
            </div>
            <button type="button" onclick="closeAddressModal()" class="text-white/60 hover:text-white transition-colors">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div class="overflow-y-auto flex-1 p-8">
            <form id="modalShippingForm" class="space-y-6">
                @csrf
                <input type="hidden" name="user_id" id="modal_user_id" value="">
                <div>
                    <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-wider block mb-1.5">Label Alamat</label>
                    <input type="text" name="label" maxlength="30" placeholder="cth: Rumah, Kantor, Gudang..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:border-primary-600 focus:bg-white outline-none transition-all font-bold text-gray-700 text-sm">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-wider block mb-1.5">Nama Penerima *</label>
                        <input type="text" name="recipient_name" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:border-primary-600 outline-none transition-all font-bold text-gray-700 text-sm">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-wider block mb-1.5">No. HP Penerima *</label>
                        <input type="tel" name="recipient_phone" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:border-primary-600 outline-none transition-all font-bold text-gray-700 text-sm">
                    </div>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-wider block mb-1.5">Alamat Lengkap *</label>
                    <textarea name="address" rows="3" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:border-primary-600 outline-none transition-all font-bold text-gray-700 text-sm"
                        placeholder="Nama jalan, nomor rumah, RT/RW..."></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-wider block mb-1.5">Provinsi *</label>
                        <select name="province_id" id="modal_province_id" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:border-primary-600 outline-none font-bold text-gray-700 text-sm">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->code }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-wider block mb-1.5">Kota/Kabupaten *</label>
                        <select name="city_id" id="modal_city_id" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:border-primary-600 outline-none font-bold text-gray-700 text-sm">
                            <option value="">Pilih Kota</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-wider block mb-1.5">Kecamatan *</label>
                        <select name="district_id" id="modal_district_id" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:border-primary-600 outline-none font-bold text-gray-700 text-sm">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-wider block mb-1.5">Kelurahan/Desa *</label>
                        <select name="village_id" id="modal_village_id" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:border-primary-600 outline-none font-bold text-gray-700 text-sm">
                            <option value="">Pilih Kelurahan</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase ml-1 tracking-wider block mb-1.5">Kode Pos</label>
                        <input type="text" name="postal_code" maxlength="5"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl focus:border-primary-600 outline-none font-bold text-gray-700 text-sm">
                    </div>
                </div>
                <div class="p-4 bg-primary-50/50 rounded-xl border border-primary-100">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_default" value="1" class="w-4 h-4 text-primary-600 rounded border-primary-200">
                        <div>
                            <span class="block text-[10px] font-black text-primary-700 uppercase tracking-widest">Jadikan Alamat Utama</span>
                            <span class="text-[10px] text-primary-400 italic">Otomatis terpilih saat checkout</span>
                        </div>
                    </label>
                </div>
                <div id="modalAddressError" class="hidden p-4 bg-red-50 border border-red-100 rounded-xl text-sm text-red-500 font-medium"></div>
            </form>
        </div>

        <div class="px-8 py-5 border-t border-gray-100 flex items-center justify-between flex-shrink-0 bg-gray-50/50">
            <button type="button" onclick="closeAddressModal()"
                class="text-[10px] font-black text-gray-400 uppercase tracking-widest hover:text-gray-700 transition-all">
                Batal
            </button>
            <button type="button" onclick="submitAddressModal()" id="modalSubmitBtn"
                class="px-10 py-3 bg-gray-900 text-white font-black rounded-xl hover:bg-primary-600 transition-all shadow-lg text-[10px] uppercase tracking-widest">
                Simpan Alamat
            </button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// ─── Data dari server ─────────────────────────────────────────────────────────
// ─── Data dari server ─────────────────────────────────────────────────────────
const productsData   = @json($products);
let   allShippings   = @json($allShippings);
const MY_CITY_ID     = {{ $myCityId }};
const MY_PROVINCE_ID = {{ $myProvinceId ?? 32 }};
const TARIF_PER_KM   = 3500;
const MAX_PROD_DAYS  = {{ $maxProductionDays ?? 3 }};
const CUT_OFF_HOUR   = {{ $cutOffHour ?? 16 }};
const CSRF_TOKEN     = '{{ csrf_token() }}';
const STORE_URL      = '{{ route("orders.store") }}';
const INDEX_URL      = '{{ route("admin.orders.index") }}';

let rowCount         = 0;
let currentUserId    = null;
let isMemberFormOpen = false;
let isGuestFormOpen  = false;

// ─── Helper ──────────────────────────────────────────────────────────────────
function fmt(n) {
    return 'Rp ' + Math.round(n).toLocaleString('id-ID');
}

function getEstDate(days) {
    const d = new Date();
    if (d.getHours() >= CUT_OFF_HOUR) days += 1;
    d.setDate(d.getDate() + days);
    return d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ─── Cash Section Toggle ─────────────────────────────────────────────────────
function toggleCashSection() {
    const payMethod   = document.querySelector('input[name="payment_method"]:checked')?.value;
    const cashSection = document.getElementById('cash-section');
    if (!cashSection) return;
    cashSection.classList.toggle('hidden', payMethod !== 'cash');
    if (payMethod !== 'cash') {
        const cashInput = document.getElementById('cash-received');
        if (cashInput) cashInput.value = '';
        document.getElementById('display-change').innerText = 'Rp 0';
        document.getElementById('change-warning')?.classList.add('hidden');
    }
}

function calculateChange() {
    const total    = parseFloat(document.getElementById('input-total').value) || 0;
    const received = parseFloat(document.getElementById('cash-received').value) || 0;
    const change   = received - total;
    const warning  = document.getElementById('change-warning');
    const display  = document.getElementById('display-change');

    if (received > 0 && change < 0) {
        display.innerText = 'Rp 0';
        display.classList.remove('text-green-400');
        display.classList.add('text-red-400');
        warning?.classList.remove('hidden');
    } else {
        display.innerText = fmt(Math.max(0, Math.round(change)));
        display.classList.remove('text-red-400');
        display.classList.add('text-green-400');
        warning?.classList.add('hidden');
    }
}

// ─── Toggle Form Member Baru ──────────────────────────────────────────────────
function toggleMemberForm() {
    if (isGuestFormOpen) {
        isGuestFormOpen = false;
        document.getElementById('guestForm').classList.add('hidden');
        const sel = document.getElementById('user_select');
        sel.disabled = false;
        sel.classList.remove('opacity-50', 'cursor-not-allowed');
    }

    const form    = document.getElementById('memberForm');
    const sel     = document.getElementById('user_select');
    const btnText = document.getElementById('btn-member-text');

    isMemberFormOpen = !isMemberFormOpen;
    form.classList.toggle('hidden', !isMemberFormOpen);

    sel.disabled = isMemberFormOpen;
    sel.classList.toggle('opacity-50', isMemberFormOpen);
    sel.classList.toggle('cursor-not-allowed', isMemberFormOpen);

    btnText.textContent = isMemberFormOpen ? 'Gunakan User Lama' : 'Daftar Member Baru';

    if (isMemberFormOpen) {
        currentUserId = null;
        sel.value = '';
        document.getElementById('addressList').innerHTML = buildEmptyAddress(
            'fa-user-plus', 'Isi data member baru di atas'
        );
    } else {
        sel.value = '';
        currentUserId = null;
        document.getElementById('addressList').innerHTML = buildEmptyAddress(
            'fa-map-marker-alt', 'Pilih pelanggan terlebih dahulu'
        );
    }

    syncAddressSections();
    updatePricing();
}

// ─── Toggle Form Guest ────────────────────────────────────────────────────────
function toggleGuestForm() {
    if (isMemberFormOpen) {
        isMemberFormOpen = false;
        document.getElementById('memberForm').classList.add('hidden');
        document.getElementById('btn-member-text').textContent = 'Daftar Member Baru';
        const sel = document.getElementById('user_select');
        sel.disabled = false;
        sel.classList.remove('opacity-50', 'cursor-not-allowed');
    }

    isGuestFormOpen = !isGuestFormOpen;
    document.getElementById('guestForm').classList.toggle('hidden', !isGuestFormOpen);

    const sel = document.getElementById('user_select');
    sel.disabled = isGuestFormOpen;
    sel.classList.toggle('opacity-50', isGuestFormOpen);
    sel.classList.toggle('cursor-not-allowed', isGuestFormOpen);

    if (isGuestFormOpen) {
        currentUserId = null;
        sel.value = '';
        document.getElementById('addressList').innerHTML = buildEmptyAddress(
            'fa-user', 'Mode pelanggan umum — alamat langsung diisi di form atas'
        );
    } else {
        sel.value = '';
        currentUserId = null;
        document.getElementById('addressList').innerHTML = buildEmptyAddress(
            'fa-map-marker-alt', 'Pilih pelanggan terlebih dahulu'
        );
    }

    syncAddressSections();
    updatePricing();
}

// ─── Sinkronisasi semua section alamat ───────────────────────────────────────
function syncAddressSections() {
    const method   = document.querySelector('input[name="shipping_method"]:checked')?.value || 'pickup';
    const isPickup = method === 'pickup';

    const memberSection = document.getElementById('memberAddressSection');
    if (memberSection) {
        memberSection.classList.toggle('hidden', !(isMemberFormOpen && !isPickup));
    }

    const guestSection = document.getElementById('guestAddressSection');
    if (guestSection) {
        guestSection.classList.toggle('hidden', !(isGuestFormOpen && !isPickup));
    }

    const btnTambahAlamat = document.getElementById('btn-tambah-alamat');
    if (btnTambahAlamat) {
        btnTambahAlamat.classList.toggle('hidden', isGuestFormOpen || isMemberFormOpen);
    }
}

// ─── Render placeholder alamat kosong ────────────────────────────────────────
function buildEmptyAddress(icon, msg) {
    return `
        <div class="text-center py-8 border-2 border-dashed border-gray-100 rounded-xl">
            <i class="fas ${icon} text-gray-200 text-2xl mb-3 block"></i>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">${msg}</p>
        </div>`;
}

// ─── Tampilkan daftar alamat berdasarkan user ─────────────────────────────────
function displayAddressesByUser(userId) {
    const container = document.getElementById('addressList');

    if (!userId) {
        container.innerHTML = buildEmptyAddress('fa-map-marker-alt', 'Pilih pelanggan terlebih dahulu');
        updatePricing();
        return;
    }

    const addresses = allShippings.filter(a => String(a.user_id) === String(userId));

    if (addresses.length === 0) {
        container.innerHTML = `
            <div class="text-center py-8 border-2 border-dashed border-gray-100 rounded-xl">
                <i class="fas fa-map-marker-alt text-gray-200 text-2xl mb-3 block"></i>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Belum ada alamat</p>
                <button type="button" onclick="openAddressModal()"
                    class="mt-3 text-[10px] font-black text-primary-600 uppercase tracking-widest hover:underline">
                    + Tambah Alamat Sekarang
                </button>
            </div>`;
        updatePricing();
        return;
    }

    let html = '';
    addresses.forEach((addr, idx) => {
        const isSameCity  = (parseInt(addr.city_id) === MY_CITY_ID);
        const cityWarning = !isSameCity
            ? '<span class="ml-2 px-2 py-0.5 text-[8px] bg-red-50 text-red-500 rounded-md">Luar Kota (Gojek tidak tersedia)</span>'
            : '<span class="ml-2 px-2 py-0.5 text-[8px] bg-green-50 text-green-500 rounded-md">Dalam Kota</span>';

        html += `
            <label class="relative flex items-start p-4 border-2 border-gray-100 rounded-xl cursor-pointer transition-all hover:bg-gray-50 has-[:checked]:border-primary-600 has-[:checked]:bg-primary-50/30">
                <input type="radio" name="shipping_id"
                    value="${addr.shipping_id}"
                    class="mt-1 text-primary-600 shipping-address-radio"
                    data-city-id="${addr.city_id}"
                    data-province-id="${addr.province_id}"
                    data-distance="5"
                    ${idx === 0 ? 'checked' : ''}>
                <div class="ml-4 flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-black text-gray-800 text-sm">${escapeHtml(addr.recipient_name)}</span>
                        ${addr.label ? `<span class="px-2 py-0.5 text-[9px] bg-primary-50 text-primary-600 border border-primary-100 rounded-md font-black uppercase">${escapeHtml(addr.label)}</span>` : ''}
                        ${addr.is_default ? `<span class="px-2 py-0.5 text-[9px] bg-gray-100 text-gray-500 rounded-md uppercase font-black">Utama</span>` : ''}
                        ${cityWarning}
                    </div>
                    <p class="text-xs text-gray-500 font-medium mt-1">${escapeHtml(addr.address)}</p>
                    <p class="text-[10px] text-gray-400 mt-0.5 italic">
                        ${escapeHtml(addr.village?.name || '-')},
                        ${escapeHtml(addr.district?.name || '-')},
                        ${escapeHtml(addr.city?.name || '-')}
                    </p>
                    <p class="text-[9px] text-gray-300 mt-1">📞 ${escapeHtml(addr.recipient_phone)}</p>
                </div>
            </label>`;
    });

    container.innerHTML = html;

    document.querySelectorAll('input[name="shipping_id"]').forEach(el => {
        el.addEventListener('change', () => {
            validateShippingMethodByAddress();
            updatePricing();
        });
    });

    validateShippingMethodByAddress();
    updatePricing();
}

// ─── Kalkulasi yield stiker ───────────────────────────────────────────────────
function hitungYield(product, stickerW, stickerH) {
    const matW    = parseFloat(product.material?.width_cm)  || 0;
    const matH    = parseFloat(product.material?.height_cm) || 0;
    const spacing = (parseFloat(product.material?.spacing_mm) || 0) / 10;

    if (!stickerW || !stickerH || matW <= 0 || matH <= 0) return null;

    const finalW = stickerW + spacing;
    const finalH = stickerH + spacing;

    const cols1  = Math.floor(matW / finalW);
    const rows1  = Math.floor(matH / finalH);
    const total1 = cols1 * rows1;

    const cols2  = Math.floor(matW / finalH);
    const rows2  = Math.floor(matH / finalW);
    const total2 = cols2 * rows2;

    return total1 >= total2
        ? { total: total1, cols: cols1, rows: rows1 }
        : { total: total2, cols: cols2, rows: rows2 };
}

function calculateItemPrice(product, widthCm, heightCm, qty) {
    const basePrice = parseFloat(product.price);
    const calcType  = product.category?.calc_type ?? 'satuan';
    const matW      = parseFloat(product.material?.width_cm)  || 0;
    const matH      = parseFloat(product.material?.height_cm) || 0;

    if (calcType === 'stiker') {
        if (matW <= 0 || matH <= 0) return basePrice * qty;
        if (widthCm > matW || heightCm > matH) return basePrice * qty;
        const hasil = hitungYield(product, widthCm, heightCm);
        if (hasil && hasil.total > 0) return basePrice * qty;
        return basePrice * qty;
    } else if (calcType === 'luas') {
        let luasMeter = (widthCm * heightCm) / 10000;
        if (luasMeter < 1) luasMeter = 1;
        return luasMeter * basePrice * qty;
    } else {
        if (product.allow_custom_size && widthCm && heightCm) {
            const defaultArea = (parseFloat(product.default_width_cm) || 1) * (parseFloat(product.default_height_cm) || 1);
            const customArea  = widthCm * heightCm;
            if (defaultArea > 0) return (basePrice / defaultArea) * customArea * qty;
        }
        return basePrice * qty;
    }
}

// ─── Update Pricing ───────────────────────────────────────────────────────────
function updatePricing() {
    let subtotal = 0;

    document.querySelectorAll('#product-list tr').forEach(tr => {
        const id            = tr.id.split('-')[1];
        const productSelect = tr.querySelector(`select[name*="product_id"]`);
        const widthInput    = document.getElementById(`width-${id}`);
        const heightInput   = document.getElementById(`height-${id}`);
        const qtyInput      = document.getElementById(`qty-${id}`);

        if (productSelect && productSelect.value) {
            const product = productsData.find(p => p.product_id == productSelect.value);
            if (product) {
                const width  = parseFloat(widthInput?.value)  || parseFloat(product.default_width_cm)  || 1;
                const height = parseFloat(heightInput?.value) || parseFloat(product.default_height_cm) || 1;
                const qty    = parseInt(qtyInput?.value) || 0;

                const itemTotal  = calculateItemPrice(product, width, height, qty);
                const rowTotalEl = document.getElementById(`row-total-${id}`);
                const rowYieldEl = document.getElementById(`row-yield-${id}`);

                if (rowTotalEl) rowTotalEl.innerText = fmt(itemTotal);

                if (rowYieldEl) {
                    const calcType = product.category?.calc_type ?? 'satuan';
                    const matW     = parseFloat(product.material?.width_cm)  || 0;
                    const matH     = parseFloat(product.material?.height_cm) || 0;

                    if (calcType === 'stiker' && matW > 0 && matH > 0) {
                        if (width > matW || height > matH) {
                            rowYieldEl.innerText = `${qty} lembar (1 pcs/lembar)`;
                        } else {
                            const hasil = hitungYield(product, width, height);
                            if (hasil && hasil.total > 0) {
                                rowYieldEl.innerText = `${Math.ceil(qty / hasil.total)} lembar × ${hasil.total} pcs/lembar`;
                            } else {
                                rowYieldEl.innerText = '';
                            }
                        }
                    } else if (calcType === 'luas') {
                        let luas = (width * height) / 10000;
                        if (luas < 1) luas = 1;
                        rowYieldEl.innerText = `${luas.toFixed(2)} m² × ${qty}`;
                    } else {
                        rowYieldEl.innerText = '';
                    }
                }

                subtotal += itemTotal;
            }
        }
    });

    document.getElementById('input-subtotal').value = subtotal;

    const tax    = Math.round(subtotal * 0.11);
    const method = document.querySelector('input[name="shipping_method"]:checked')?.value || 'pickup';

    if (method === 'pickup') {
        renderPricing(subtotal, tax, 0, 'Siap diambil: ' + getEstDate(MAX_PROD_DAYS));
        enableAllShippingMethods();
        return;
    }

    const addrEl = document.querySelector('input[name="shipping_id"]:checked');

    let cityId     = MY_CITY_ID;
    let provinceId = MY_PROVINCE_ID;
    let dist       = 5;

    if (isGuestFormOpen) {
        const guestCity = document.getElementById('guest_city_id')?.value;
        if (guestCity) cityId = parseInt(guestCity);
        const guestProv = document.getElementById('guest_province_id')?.value;
        if (guestProv) provinceId = parseInt(guestProv);
    } else if (isMemberFormOpen) {
        const newCity = document.getElementById('new_city_id')?.value;
        if (newCity) cityId = parseInt(newCity);
        const newProv = document.getElementById('new_province_id')?.value;
        if (newProv) provinceId = parseInt(newProv);
    } else if (addrEl) {
        cityId     = parseInt(addrEl.dataset.cityId);
        provinceId = parseInt(addrEl.dataset.provinceId);
        dist       = parseFloat(addrEl.dataset.distance) || 5;
    } else {
        renderPricing(subtotal, tax, 0, 'Pilih alamat terlebih dahulu');
        disableNonPickupShipping();
        return;
    }

    enableAllShippingMethods();

    const isSameCity     = cityId === MY_CITY_ID;
    const isSameProvince = provinceId === MY_PROVINCE_ID;

    const gojekRadio = document.querySelector('input[name="shipping_method"][value="gojek"]');
    const gojekLabel = document.getElementById('label_gojek');

    if (gojekRadio) {
        if (!isSameCity) {
            gojekRadio.disabled = true;
            gojekLabel?.classList.add('opacity-40', 'cursor-not-allowed');
            if (gojekRadio.checked) {
                const ekspedisiRadio = document.querySelector('input[name="shipping_method"][value="ekspedisi"]');
                if (ekspedisiRadio) ekspedisiRadio.checked = true;
            }
        } else {
            gojekRadio.disabled = false;
            gojekLabel?.classList.remove('opacity-40', 'cursor-not-allowed');
        }
    }

    const finalMethod = document.querySelector('input[name="shipping_method"]:checked')?.value || 'pickup';
    let ongkir   = 0;
    let estimasi = '-';

    if (finalMethod === 'gojek') {
        ongkir   = Math.max(15000, Math.ceil(dist * TARIF_PER_KM));
        estimasi = 'Tiba hari ini: ' + getEstDate(MAX_PROD_DAYS);
    } else if (finalMethod === 'ekspedisi') {
        if (isSameCity) {
            ongkir   = 15000;
            estimasi = 'Tiba: ' + getEstDate(MAX_PROD_DAYS + 1) + ' – ' + getEstDate(MAX_PROD_DAYS + 2);
        } else if (isSameProvince) {
            ongkir   = 30000;
            estimasi = 'Tiba: ' + getEstDate(MAX_PROD_DAYS + 2) + ' – ' + getEstDate(MAX_PROD_DAYS + 4);
        } else {
            ongkir   = 50000;
            estimasi = 'Tiba: ' + getEstDate(MAX_PROD_DAYS + 3) + ' – ' + getEstDate(MAX_PROD_DAYS + 7);
        }
    }

    renderPricing(subtotal, tax, ongkir, estimasi);
}

function renderPricing(sub, tax, ongkir, estimasi) {
    const total = sub + tax + ongkir;
    document.getElementById('display-subtotal').innerText = fmt(sub);
    document.getElementById('display-tax').innerText      = fmt(tax);
    document.getElementById('display-ongkir').innerText   = fmt(ongkir);
    document.getElementById('display-estimasi').innerText = estimasi;
    document.getElementById('display-total').innerText    = fmt(total);
    document.getElementById('input-tax').value            = tax;
    document.getElementById('input-ongkir').value         = ongkir;
    document.getElementById('input-total').value          = total;
    calculateChange();
}

function enableAllShippingMethods() {
    document.querySelectorAll('input[name="shipping_method"]').forEach(r => r.disabled = false);
    document.getElementById('label_gojek')?.classList.remove('opacity-40', 'cursor-not-allowed');
}

function disableNonPickupShipping() {
    document.querySelectorAll('input[name="shipping_method"]').forEach(r => {
        if (r.value !== 'pickup') r.disabled = true;
    });
    document.getElementById('label_gojek')?.classList.add('opacity-40', 'cursor-not-allowed');
}

function validateShippingMethodByAddress() {
    const addrEl     = document.querySelector('input[name="shipping_id"]:checked');
    const gojekRadio = document.querySelector('input[name="shipping_method"][value="gojek"]');
    const gojekLabel = document.getElementById('label_gojek');

    let cityId = MY_CITY_ID;

    if (isMemberFormOpen) {
        const v = document.getElementById('new_city_id')?.value;
        if (v) cityId = parseInt(v);
    } else if (isGuestFormOpen) {
        const v = document.getElementById('guest_city_id')?.value;
        if (v) cityId = parseInt(v);
    } else if (addrEl) {
        cityId = parseInt(addrEl.dataset.cityId);
    } else {
        if (gojekRadio) gojekRadio.disabled = true;
        gojekLabel?.classList.add('opacity-40', 'cursor-not-allowed');
        return;
    }

    const isSameCity = cityId === MY_CITY_ID;
    if (gojekRadio) {
        gojekRadio.disabled = !isSameCity;
        if (!isSameCity) {
            gojekLabel?.classList.add('opacity-40', 'cursor-not-allowed');
            if (gojekRadio.checked) {
                const e = document.querySelector('input[name="shipping_method"][value="ekspedisi"]');
                if (e) { e.checked = true; updatePricing(); }
            }
        } else {
            gojekLabel?.classList.remove('opacity-40', 'cursor-not-allowed');
        }
    }
}

// ─── Produk Rows ──────────────────────────────────────────────────────────────
function addProductRow() {
    const id = rowCount++;
    const tr = document.createElement('tr');
    tr.id        = `row-${id}`;
    tr.className = 'group hover:bg-gray-50/50 transition-all';

    const options = productsData.map(p =>
        `<option value="${p.product_id}"
            data-allow-custom="${p.allow_custom_size}"
            data-default-w="${p.default_width_cm || 1}"
            data-default-h="${p.default_height_cm || 1}"
            data-price="${p.price}">${escapeHtml(p.product_name)}</option>`
    ).join('');

    tr.innerHTML = `
        <td class="px-6 py-4">
            <select name="products[${id}][product_id]" onchange="handleProductChange(${id}, this)" required
                class="w-full text-sm border-none bg-transparent focus:ring-0 font-bold p-0 text-gray-700">
                <option value="">Pilih Produk...</option>
                ${options}
            </select>
        </td>
        <input type="hidden" name="products[${id}][notes]" id="notes-${id}" value="">
        <td class="px-4 py-4 text-center">
            <div class="flex items-center justify-center gap-1">
                <input type="number" step="0.1" name="products[${id}][width_cm]" id="width-${id}"
                    placeholder="P" oninput="updatePricing()"
                    class="w-14 text-xs text-center border-none bg-gray-100 rounded-lg focus:ring-1 focus:ring-primary-500 p-1.5 font-medium">
                <span class="text-gray-300 text-[10px]">x</span>
                <input type="number" step="0.1" name="products[${id}][height_cm]" id="height-${id}"
                    placeholder="L" oninput="updatePricing()"
                    class="w-14 text-xs text-center border-none bg-gray-100 rounded-lg focus:ring-1 focus:ring-primary-500 p-1.5 font-medium">
            </div>
        </td>
        <td class="px-4 py-4 text-center">
            <input type="number" name="products[${id}][qty]" id="qty-${id}" value="1" min="1"
                oninput="updatePricing()"
                class="w-12 text-sm text-center border-none bg-transparent focus:ring-0 p-0 font-black text-gray-700">
        </td>
        <td class="px-6 py-4 text-right">
            <span class="text-sm font-mono font-bold text-gray-900" id="row-total-${id}">Rp 0</span>
            <span class="block text-[9px] text-gray-400 font-bold mt-0.5" id="row-yield-${id}"></span>
        </td>
        <td class="px-4 py-4 text-center">
            <input type="file" name="products[${id}][design_file]" accept="image/*,application/pdf,application/zip"
                class="text-[10px] w-24 file:mr-2 file:py-1 file:px-2 file:rounded-lg file:text-[8px] file:font-bold">
        </td>
        <td class="px-6 py-4 text-center text-gray-300 group-hover:text-red-500">
            <button type="button" onclick="removeRow(${id})">
                <i class="fas fa-trash-alt text-xs"></i>
            </button>
        </td>`;

    document.getElementById('product-list').appendChild(tr);
}

function handleProductChange(id, sel) {
    const product = productsData.find(x => x.product_id == sel.value);
    if (!product) return;

    const widthInput  = document.getElementById(`width-${id}`);
    const heightInput = document.getElementById(`height-${id}`);

    if (widthInput)  widthInput.value  = product.default_width_cm  || 1;
    if (heightInput) heightInput.value = product.default_height_cm || 1;

    const isAllowCustom = !!product.allow_custom_size;
    if (widthInput) {
        widthInput.readOnly = !isAllowCustom;
        widthInput.classList.toggle('bg-gray-100', !isAllowCustom);
        widthInput.classList.toggle('bg-white', isAllowCustom);
        widthInput.style.cursor = isAllowCustom ? '' : 'not-allowed';
    }
    if (heightInput) {
        heightInput.readOnly = !isAllowCustom;
        heightInput.classList.toggle('bg-gray-100', !isAllowCustom);
        heightInput.classList.toggle('bg-white', isAllowCustom);
        heightInput.style.cursor = isAllowCustom ? '' : 'not-allowed';
    }

    updatePricing();
}

function removeRow(id) {
    document.getElementById(`row-${id}`)?.remove();
    updatePricing();
}

// ─── Modal Tambah Alamat ──────────────────────────────────────────────────────
function openAddressModal() {
    if (isMemberFormOpen || isGuestFormOpen) {
        alert('Fitur tambah alamat hanya tersedia untuk user terdaftar.');
        return;
    }

    const userId = document.getElementById('user_select').value;
    if (!userId) {
        alert('Pilih pelanggan terlebih dahulu sebelum menambah alamat.');
        return;
    }

    const modalForm = document.getElementById('modalShippingForm');
    if (modalForm) modalForm.reset();

    document.getElementById('modal_user_id').value = userId;

    const errorBox = document.getElementById('modalAddressError');
    if (errorBox) { errorBox.classList.add('hidden'); errorBox.innerHTML = ''; }

    document.getElementById('modal_city_id').innerHTML     = '<option value="">Pilih Kota</option>';
    document.getElementById('modal_district_id').innerHTML = '<option value="">Pilih Kecamatan</option>';
    document.getElementById('modal_village_id').innerHTML  = '<option value="">Pilih Kelurahan</option>';

    const btn = document.getElementById('modalSubmitBtn');
    if (btn) {
        btn.disabled  = false;
        btn.innerHTML = 'Simpan Alamat';
        btn.classList.remove('bg-green-600');
        btn.classList.add('bg-gray-900');
    }

    const modal = document.getElementById('modalTambahAlamat');
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeAddressModal() {
    const modal = document.getElementById('modalTambahAlamat');
    modal.classList.add('hidden');
    modal.style.display = '';
    document.body.style.overflow = '';

    const modalForm = document.getElementById('modalShippingForm');
    if (modalForm) modalForm.reset();

    const errorBox = document.getElementById('modalAddressError');
    if (errorBox) { errorBox.classList.add('hidden'); errorBox.innerHTML = ''; }
}

async function submitAddressModal() {
    const btn      = document.getElementById('modalSubmitBtn');
    const errorBox = document.getElementById('modalAddressError');

    if (errorBox) { errorBox.classList.add('hidden'); errorBox.innerHTML = ''; }

    const userId = document.getElementById('user_select')?.value;
    if (!userId) {
        if (errorBox) { errorBox.innerHTML = 'Pilih pelanggan terlebih dahulu.'; errorBox.classList.remove('hidden'); }
        return;
    }
    document.getElementById('modal_user_id').value = userId;

    const form     = document.getElementById('modalShippingForm');
    const formData = new FormData(form);

    const required = ['recipient_name', 'recipient_phone', 'address', 'province_id', 'city_id', 'district_id', 'village_id'];
    for (const field of required) {
        if (!formData.get(field)?.trim()) {
            if (errorBox) {
                errorBox.innerHTML = `Field "${field.replace(/_/g, ' ')}" wajib diisi.`;
                errorBox.classList.remove('hidden');
            }
            return;
        }
    }

    if (btn) { btn.disabled = true; btn.innerHTML = '<span class="animate-pulse">Menyimpan...</span>'; }

    const payload = {
        user_id:         userId,
        recipient_name:  formData.get('recipient_name'),
        recipient_phone: formData.get('recipient_phone'),
        address:         formData.get('address'),
        province_id:     formData.get('province_id'),
        city_id:         formData.get('city_id'),
        district_id:     formData.get('district_id'),
        village_id:      formData.get('village_id'),
        label:           formData.get('label') || '',
        is_default:      formData.get('is_default') === '1',
        postal_code:     formData.get('postal_code') || '',
    };

    try {
        const res  = await fetch('/shippings', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN':  CSRF_TOKEN,
                'Accept':        'application/json',
                'Content-Type':  'application/json',
            },
            body: JSON.stringify(payload),
        });
        const data = await res.json();

        if (!res.ok || !data.success) {
            let msg = data.message || 'Gagal menyimpan alamat.';
            if (data.errors) msg = Object.values(data.errors).flat().join('<br>');
            throw new Error(msg);
        }

        if (data.shipping) allShippings.push(data.shipping);

        if (btn) {
            btn.innerHTML = '✓ Tersimpan!';
            btn.classList.replace('bg-gray-900', 'bg-green-600');
        }

        setTimeout(() => {
            closeAddressModal();
            displayAddressesByUser(userId);
        }, 800);

    } catch (err) {
        if (errorBox) { errorBox.innerHTML = err.message || 'Gagal menyimpan. Coba lagi.'; errorBox.classList.remove('hidden'); }
        if (btn) { btn.disabled = false; btn.innerHTML = 'Simpan Alamat'; }
    }
}

// ─── Submit Pesanan ───────────────────────────────────────────────────────────
// Karena controller return redirect() bukan JSON,
// kita pakai form submit biasa tapi intercept response-nya via iframe trick,
// atau lebih simpel: tambahkan hidden input lalu submit normal,
// dan controller akan redirect ke index otomatis.
// Solusi: override submit → buat form tersembunyi → submit normal (non-AJAX)
// supaya Laravel redirect berjalan.

async function handleFormSubmit(event) {
    event.preventDefault();

    const submitBtn = document.getElementById('submit-btn');
    const errorBox  = document.getElementById('form-error');

    errorBox.classList.add('hidden');
    errorBox.innerHTML = '';

    // Validasi minimal ada 1 item dengan produk dipilih
    const rows = document.querySelectorAll('#product-list tr');
    if (rows.length === 0) {
        errorBox.innerHTML = 'Tambahkan minimal 1 item pesanan.';
        errorBox.classList.remove('hidden');
        return;
    }

    let hasProduct = false;
    rows.forEach(tr => {
        const sel = tr.querySelector('select[name*="product_id"]');
        if (sel && sel.value) hasProduct = true;
    });

    if (!hasProduct) {
        errorBox.innerHTML = 'Pilih produk untuk setiap item pesanan.';
        errorBox.classList.remove('hidden');
        return;
    }

    // Validasi pelanggan
    const userId      = document.getElementById('user_select').value;
    const guestName   = document.getElementById('guest_name')?.value?.trim();
    const guestPhone  = document.getElementById('guest_phone')?.value?.trim();
    const memberName  = document.getElementById('new_customer_name')?.value?.trim();
    const memberPhone = document.getElementById('new_customer_phone')?.value?.trim();

    if (!isGuestFormOpen && !isMemberFormOpen && !userId) {
        errorBox.innerHTML = 'Pilih pelanggan, atau gunakan mode Pelanggan Umum / Member Baru.';
        errorBox.classList.remove('hidden');
        return;
    }

    if (isGuestFormOpen && (!guestName || !guestPhone)) {
        errorBox.innerHTML = 'Nama dan nomor HP pelanggan umum wajib diisi.';
        errorBox.classList.remove('hidden');
        return;
    }

    if (isMemberFormOpen && (!memberName || !memberPhone)) {
        errorBox.innerHTML = 'Nama dan nomor WhatsApp member baru wajib diisi.';
        errorBox.classList.remove('hidden');
        return;
    }

    // Loading state
    submitBtn.disabled  = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';

    // ── Coba via fetch dulu, jika controller return JSON pakai itu.
    // Jika controller return redirect, fetch akan follow redirect
    // dan kita tidak bisa detect JSON vs HTML — fallback ke form submit biasa.
    try {
        const form     = document.getElementById('orderForm');
        const formData = new FormData(form);

        const res = await fetch(STORE_URL, {
            method:  'POST',
            body:    formData,
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept':       'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            redirect: 'follow',
        });

        const contentType = res.headers.get('content-type') || '';

        // Jika controller return JSON
        if (contentType.includes('application/json')) {
            const data = await res.json();

            if (res.ok && (data.success || data.order_id || data.order)) {
                submitBtn.innerHTML = '<i class="fas fa-check mr-2"></i> Berhasil!';
                window.location.href = INDEX_URL;
                return;
            }

            let msg = data.message || 'Gagal membuat pesanan.';
            if (data.errors) msg = Object.values(data.errors).flat().join('<br>');
            throw new Error(msg);
        }

        // Controller return redirect (HTML) — artinya sukses, ikuti redirect
        if (res.ok || res.redirected) {
            submitBtn.innerHTML = '<i class="fas fa-check mr-2"></i> Berhasil!';
            window.location.href = res.url && res.url !== STORE_URL ? res.url : INDEX_URL;
            return;
        }

        throw new Error('Terjadi kesalahan saat menyimpan pesanan.');

    } catch (err) {
        // Network error atau validasi error
        if (err.name === 'TypeError') {
            // Network error — coba submit form biasa sebagai fallback
            submitBtn.disabled  = false;
            submitBtn.innerHTML = 'KONFIRMASI';
            errorBox.innerHTML  = 'Koneksi bermasalah. Coba lagi.';
            errorBox.classList.remove('hidden');
            return;
        }

        errorBox.innerHTML = err.message || 'Terjadi kesalahan. Coba lagi.';
        errorBox.classList.remove('hidden');
        submitBtn.disabled  = false;
        submitBtn.innerHTML = 'KONFIRMASI';
        errorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

// ─── Dropdown Wilayah: Modal ──────────────────────────────────────────────────
$('#modal_province_id').on('change', function () {
    const code = $(this).val();
    $('#modal_city_id').html('<option value="">Memuat...</option>');
    $('#modal_district_id').html('<option value="">Pilih Kecamatan</option>');
    $('#modal_village_id').html('<option value="">Pilih Kelurahan</option>');
    if (!code) { $('#modal_city_id').html('<option value="">Pilih Kota</option>'); return; }
    $.get(`/api/cities/${code}`)
        .done(d => {
            let o = '<option value="">Pilih Kota</option>';
            d.forEach(i => o += `<option value="${i.code}">${i.name}</option>`);
            $('#modal_city_id').html(o);
        })
        .fail(() => $('#modal_city_id').html('<option value="">Gagal memuat</option>'));
});
$('#modal_city_id').on('change', function () {
    const code = $(this).val();
    $('#modal_district_id').html('<option value="">Memuat...</option>');
    $('#modal_village_id').html('<option value="">Pilih Kelurahan</option>');
    if (!code) { $('#modal_district_id').html('<option value="">Pilih Kecamatan</option>'); return; }
    $.get(`/api/districts/${code}`)
        .done(d => {
            let o = '<option value="">Pilih Kecamatan</option>';
            d.forEach(i => o += `<option value="${i.code}">${i.name}</option>`);
            $('#modal_district_id').html(o);
        })
        .fail(() => $('#modal_district_id').html('<option value="">Gagal memuat</option>'));
});
$('#modal_district_id').on('change', function () {
    const code = $(this).val();
    $('#modal_village_id').html('<option value="">Memuat...</option>');
    if (!code) { $('#modal_village_id').html('<option value="">Pilih Kelurahan</option>'); return; }
    $.get(`/api/villages/${code}`)
        .done(d => {
            let o = '<option value="">Pilih Kelurahan</option>';
            d.forEach(i => o += `<option value="${i.code}">${i.name}</option>`);
            $('#modal_village_id').html(o);
        })
        .fail(() => $('#modal_village_id').html('<option value="">Gagal memuat</option>'));
});

// ─── Dropdown Wilayah: Member Baru ───────────────────────────────────────────
$('#new_province_id').on('change', function () {
    const code = $(this).val();
    $('#new_city_id').html('<option value="">Memuat...</option>');
    $('#new_district_id').html('<option value="">Pilih Kecamatan</option>');
    $('#new_village_id').html('<option value="">Pilih Kelurahan</option>');
    if (!code) { $('#new_city_id').html('<option value="">Pilih Kota</option>'); return; }
    $.get(`/api/cities/${code}`)
        .done(d => {
            let o = '<option value="">Pilih Kota</option>';
            d.forEach(i => o += `<option value="${i.code}">${i.name}</option>`);
            $('#new_city_id').html(o);
        });
});
$('#new_city_id').on('change', function () {
    const code = $(this).val();
    $('#new_district_id').html('<option value="">Memuat...</option>');
    $('#new_village_id').html('<option value="">Pilih Kelurahan</option>');
    if (!code) { $('#new_district_id').html('<option value="">Pilih Kecamatan</option>'); return; }
    $.get(`/api/districts/${code}`)
        .done(d => {
            let o = '<option value="">Pilih Kecamatan</option>';
            d.forEach(i => o += `<option value="${i.code}">${i.name}</option>`);
            $('#new_district_id').html(o);
        });
    validateShippingMethodByAddress();
    updatePricing();
});
$('#new_district_id').on('change', function () {
    const code = $(this).val();
    $('#new_village_id').html('<option value="">Memuat...</option>');
    if (!code) { $('#new_village_id').html('<option value="">Pilih Kelurahan</option>'); return; }
    $.get(`/api/villages/${code}`)
        .done(d => {
            let o = '<option value="">Pilih Kelurahan</option>';
            d.forEach(i => o += `<option value="${i.code}">${i.name}</option>`);
            $('#new_village_id').html(o);
        });
});

// ─── Dropdown Wilayah: Guest ──────────────────────────────────────────────────
$('#guest_province_id').on('change', function () {
    const code = $(this).val();
    $('#guest_city_id').html('<option value="">Memuat...</option>');
    $('#guest_district_id').html('<option value="">Pilih Kecamatan</option>');
    $('#guest_village_id').html('<option value="">Pilih Kelurahan</option>');
    if (!code) { $('#guest_city_id').html('<option value="">Pilih Kota</option>'); return; }
    $.get(`/api/cities/${code}`)
        .done(d => {
            let o = '<option value="">Pilih Kota</option>';
            d.forEach(i => o += `<option value="${i.code}">${i.name}</option>`);
            $('#guest_city_id').html(o);
        });
    updatePricing();
});
$('#guest_city_id').on('change', function () {
    const code = $(this).val();
    $('#guest_district_id').html('<option value="">Memuat...</option>');
    $('#guest_village_id').html('<option value="">Pilih Kelurahan</option>');
    if (!code) { $('#guest_district_id').html('<option value="">Pilih Kecamatan</option>'); return; }
    $.get(`/api/districts/${code}`)
        .done(d => {
            let o = '<option value="">Pilih Kecamatan</option>';
            d.forEach(i => o += `<option value="${i.code}">${i.name}</option>`);
            $('#guest_district_id').html(o);
        });
    validateShippingMethodByAddress();
    updatePricing();
});
$('#guest_district_id').on('change', function () {
    const code = $(this).val();
    $('#guest_village_id').html('<option value="">Memuat...</option>');
    if (!code) { $('#guest_village_id').html('<option value="">Pilih Kelurahan</option>'); return; }
    $.get(`/api/villages/${code}`)
        .done(d => {
            let o = '<option value="">Pilih Kelurahan</option>';
            d.forEach(i => o += `<option value="${i.code}">${i.name}</option>`);
            $('#guest_village_id').html(o);
        });
});

// ─── Init ─────────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    addProductRow();
    updatePricing();
    toggleCashSection();

    document.getElementById('user_select').addEventListener('change', function () {
        currentUserId = this.value || null;
        if (currentUserId) {
            displayAddressesByUser(currentUserId);
        } else {
            document.getElementById('addressList').innerHTML = buildEmptyAddress(
                'fa-map-marker-alt', 'Pilih pelanggan terlebih dahulu'
            );
            updatePricing();
        }
    });

    document.querySelectorAll('input[name="shipping_method"]').forEach(el => {
        el.addEventListener('change', () => {
            syncAddressSections();
            updatePricing();
        });
    });

    document.querySelectorAll('input[name="payment_method"]').forEach(el => {
        el.addEventListener('change', toggleCashSection);
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeAddressModal();
    });
});
</script>

<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    input[readonly] { background-color: #f3f4f6; cursor: not-allowed; }

    #modalTambahAlamat:not(.hidden) {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #modalTambahAlamat {
        display: none;
    }
</style>
@endsection