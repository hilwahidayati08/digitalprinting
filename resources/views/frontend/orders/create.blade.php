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
        <button type="button" onclick="toggleMemberForm()" id="btn-toggle-member" class="flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all shadow-lg shadow-emerald-200">
            <i class="fas fa-user-plus"></i> <span>Daftar Member Baru</span>
        </button>
    </div>

    <form id="orderForm" onsubmit="handleFormSubmit(event)" enctype="multipart/form-data">
        @csrf
        
        {{-- Form Member Baru (Hidden by Default) --}}
        <div id="memberForm" class="hidden mb-6 bg-emerald-50 border border-emerald-100 rounded-2xl p-6 animate-fadeIn">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-emerald-800 font-bold text-sm uppercase tracking-wider flex items-center gap-2">
                    <i class="fas fa-id-card"></i> Data Member Baru
                </h3>
                <button type="button" onclick="toggleMemberForm()" class="text-emerald-400 hover:text-emerald-600"><i class="fas fa-times"></i></button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="new_customer_name" placeholder="Nama Lengkap" class="w-full px-4 py-2.5 rounded-xl border-emerald-200 focus:ring-emerald-500 text-sm">
                <input type="email" name="new_customer_email" placeholder="Email (Opsional)" class="w-full px-4 py-2.5 rounded-xl border-emerald-200 focus:ring-emerald-500 text-sm">
                <input type="text" name="new_customer_phone" placeholder="No. WhatsApp" class="w-full px-4 py-2.5 rounded-xl border-emerald-200 focus:ring-emerald-500 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">
            {{-- Bagian Kiri: Input Data --}}
            <div class="col-span-12 lg:col-span-8 space-y-6">
                
                {{-- Customer & File --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                        <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block">Pilih Pelanggan</label>
                        <select name="user_id" id="user_select" class="w-full text-sm border-gray-200 bg-gray-50 rounded-xl focus:ring-primary-500 transition-all">
                            <option value="">-- Pilih User Terdaftar --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->user_id }}">
                                    {{ $user->full_name ?? $user->username }} [{{ $user->no_telp ?? 'No HP -' }}]
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                        <label class="text-[10px] font-black text-gray-400 uppercase mb-2 block">Upload Desain</label>
                        <input type="file" name="design_file" class="w-full text-xs text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-primary-50 file:text-primary-700 file:font-bold hover:file:bg-primary-100 transition-all"/>
                    </div>
                </div>

                {{-- Tabel Produk --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/30">
                        <h3 class="font-bold text-gray-800">Item Pesanan</h3>
                        <button type="button" onclick="addProductRow()" class="text-[11px] font-bold bg-primary-600 text-white px-4 py-2 rounded-xl hover:bg-primary-700 transition-all shadow-md shadow-primary-100">
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
                                    <th class="px-6 py-3 w-10"></th>
                                </tr>
                            </thead>
                            <tbody id="product-list" class="divide-y divide-gray-50">
                                {{-- Row diisi via JS --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Ringkasan --}}
            <div class="col-span-12 lg:col-span-4">
                <div class="bg-gray-900 rounded-[2rem] p-8 text-white sticky top-6 shadow-2xl">
                    <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                        <i class="fas fa-wallet text-primary-400"></i> Pembayaran
                    </h3>
                    
                    <div class="space-y-4 mb-8">
                        <div>
                            <label class="text-[10px] font-bold text-gray-500 uppercase mb-2 block tracking-widest">Metode Bayar</label>
                            <select name="payment_method" id="payment_method" class="w-full bg-gray-800 border-none rounded-xl text-sm font-bold focus:ring-primary-500 py-3">
                                <option value="cash">Tunai / Cash</option>
                                <option value="midtrans">QRIS / E-Wallet / Transfer</option>
                            </select>
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
                    </div>

                    <div class="py-8 flex justify-between items-center">
                        <span class="text-xs font-bold text-gray-500 uppercase">Total Akhir</span>
                        <span id="display-total" class="text-3xl font-black text-primary-400 font-mono">Rp 0</span>
                    </div>

                    {{-- Hidden Inputs --}}
                    <input type="hidden" name="subtotal" id="input-subtotal" value="0">
                    <input type="hidden" name="tax" id="input-tax" value="0">
                    <input type="hidden" name="total" id="input-total" value="0">

                    <button type="submit" id="btn-submit" class="w-full py-4 bg-primary-500 hover:bg-primary-600 text-white rounded-2xl font-black transition-all transform active:scale-95 shadow-xl shadow-primary-900/40 flex items-center justify-center gap-2 text-lg">
                        KONFIRMASI
                    </button>
                    
                    <a href="{{ route('admin.orders.index') }}" class="block text-center mt-6 text-[10px] font-bold text-gray-500 hover:text-red-400 transition-colors uppercase tracking-widest">
                        Batalkan Transaksi
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Midtrans Snap JS --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>

<script>
    let rowCount = 0;
    const productsData = @json($products);

    // 1. Toggle Member Form
    function toggleMemberForm() {
        const form = document.getElementById('memberForm');
        const userSelect = document.getElementById('user_select');
        const btnToggle = document.getElementById('btn-toggle-member');
        
        form.classList.toggle('hidden');
        if(!form.classList.contains('hidden')) {
            userSelect.value = ""; 
            userSelect.disabled = true;
            userSelect.classList.add('opacity-50', 'cursor-not-allowed');
            btnToggle.innerHTML = '<i class="fas fa-user-check"></i> <span>Gunakan User Lama</span>';
            btnToggle.classList.replace('bg-emerald-500', 'bg-gray-500');
        } else {
            userSelect.disabled = false;
            userSelect.classList.remove('opacity-50', 'cursor-not-allowed');
            btnToggle.innerHTML = '<i class="fas fa-user-plus"></i> <span>Daftar Member Baru</span>';
            btnToggle.classList.replace('bg-gray-500', 'bg-emerald-500');
        }
    }

    // 2. Add Row Produk (Table Version)
    function addProductRow() {
        const rowId = rowCount++;
        const tr = document.createElement('tr');
        tr.id = `row-${rowId}`;
        tr.className = "group hover:bg-gray-50/50 transition-all animate-fadeIn";
        
        tr.innerHTML = `
            <td class="px-6 py-4">
                <select name="products[${rowId}][product_id]" onchange="handleProductChange(${rowId}, this)" required class="w-full text-sm border-none bg-transparent focus:ring-0 font-bold p-0 text-gray-700">
                    <option value="">Pilih Produk...</option>
                    ${productsData.map(p => `<option value="${p.product_id}">${p.product_name}</option>`).join('')}
                </select>
            </td>
            <td class="px-4 py-4 text-center">
                <div class="flex items-center justify-center gap-1">
                    <input type="number" step="0.1" name="products[${rowId}][width_cm]" id="width-${rowId}" placeholder="P" oninput="calculateAll()" class="w-14 text-xs text-center border-none bg-gray-100 rounded-lg focus:ring-1 focus:ring-primary-500 p-1.5 font-medium">
                    <span class="text-gray-300 text-[10px]">x</span>
                    <input type="number" step="0.1" name="products[${rowId}][height_cm]" id="height-${rowId}" placeholder="L" oninput="calculateAll()" class="w-14 text-xs text-center border-none bg-gray-100 rounded-lg focus:ring-1 focus:ring-primary-500 p-1.5 font-medium">
                </div>
            </td>
            <td class="px-4 py-4 text-center">
                <input type="number" name="products[${rowId}][qty]" value="1" min="1" oninput="calculateAll()" class="w-12 text-sm text-center border-none bg-transparent focus:ring-0 p-0 font-black text-gray-700">
            </td>
            <td class="px-6 py-4 text-right">
                <span class="text-sm font-mono font-bold text-gray-900" id="row-total-text-${rowId}">Rp 0</span>
            </td>
            <td class="px-6 py-4 text-center text-gray-300 group-hover:text-red-500">
                <button type="button" onclick="removeRow(${rowId})"><i class="fas fa-trash-alt text-xs"></i></button>
            </td>
        `;
        document.getElementById('product-list').appendChild(tr);
    }

    // 3. Handle Product Change (Auto Fill Ukuran)
    function handleProductChange(id, select) {
        const product = productsData.find(p => p.product_id == select.value);
        if (product) {
            document.getElementById(`width-${id}`).value = product.default_width_cm || 100;
            document.getElementById(`height-${id}`).value = product.default_height_cm || 100;
        }
        calculateAll();
    }

    // 4. Kalkulasi Total
    function calculateAll() {
        let subtotal = 0;
        const rows = document.querySelectorAll('#product-list tr');

        rows.forEach(row => {
            const id = row.id.split('-')[1];
            const productId = row.querySelector(`select[name*="product_id"]`).value;
            const qty = parseFloat(row.querySelector(`input[name*="qty"]`).value) || 0;
            const product = productsData.find(p => p.product_id == productId);

            if (product) {
                let rowPrice = parseFloat(product.price) * qty;
                document.getElementById(`row-total-text-${id}`).innerText = `Rp ${rowPrice.toLocaleString('id-ID')}`;
                subtotal += rowPrice;
            }
        });

        const tax = Math.round(subtotal * 0.11);
        const total = subtotal + tax;

        document.getElementById('display-subtotal').innerText = `Rp ${subtotal.toLocaleString('id-ID')}`;
        document.getElementById('display-tax').innerText = `Rp ${tax.toLocaleString('id-ID')}`;
        document.getElementById('display-total').innerText = `Rp ${total.toLocaleString('id-ID')}`;

        document.getElementById('input-subtotal').value = subtotal;
        document.getElementById('input-tax').value = tax;
        document.getElementById('input-total').value = total;
    }

    function removeRow(id) {
        document.getElementById(`row-${id}`).remove();
        calculateAll();
    }

    // 5. Submit Form AJAX
    async function handleFormSubmit(e) {
        e.preventDefault();
        const submitBtn = document.getElementById('btn-submit');
        const formData = new FormData(e.target);

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-circle-notch animate-spin"></i> MEMPROSES...';

        try {
            const response = await fetch("{{ route('orders.store') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}", "Accept": "application/json" },
                body: formData
            });
            const data = await response.json();

            if (data.status === 'success') {
                if (document.getElementById('payment_method').value === 'cash') {
                    window.location.href = "{{ route('admin.orders.index') }}?success=Pesanan Berhasil";
                } else {
                    window.snap.pay(data.snap_token, {
                        onSuccess: () => { window.location.href = "{{ route('admin.orders.index') }}"; },
                        onPending: () => { window.location.reload(); },
                        onError: () => { alert("Pembayaran Gagal"); submitBtn.disabled = false; },
                        onClose: () => { window.location.href = "{{ route('admin.orders.index') }}"; }
                    });
                }
            } else {
                alert(data.message || "Gagal menyimpan pesanan");
                submitBtn.disabled = false;
                submitBtn.innerText = 'KONFIRMASI';
            }
        } catch (error) {
            console.error(error);
            alert("Terjadi kesalahan sistem!");
            submitBtn.disabled = false;
            submitBtn.innerText = 'KONFIRMASI';
        }
    }

    // Init row pertama
    document.addEventListener('DOMContentLoaded', addProductRow);
</script>

<style>
    .animate-fadeIn { animation: fadeIn 0.3s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
</style>
@endsection