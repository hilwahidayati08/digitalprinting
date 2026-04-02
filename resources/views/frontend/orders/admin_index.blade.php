@extends('admin.admin')

@section('title', 'Manajemen Pesanan Masuk')

@section('content')
    <div class="max-full">
{{-- 1. HEADER & SEARCH --}}
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Pesanan Masuk</h2>
        <p class="text-sm text-gray-500">Pantau dan kelola alur produksi pesanan secara real-time.</p>
    </div>
    <div class="flex items-center gap-3">
        {{-- Search Bar --}}
        <form action="{{ route('admin.orders.index') }}" method="GET" class="relative">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                <i class="fas fa-search text-xs"></i>
            </span>
            <input type="text" name="search" value="{{ request('search') }}"
                class="pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all text-sm w-64 shadow-sm"
                placeholder="No. Order / Nama...">
        </form>
        
        {{-- Tombol Tambah Pesanan --}}
        <a href="{{ route('orders.create') }}" 
            class="inline-flex items-center px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white rounded-xl shadow-lg shadow-orange-200 transition-all font-bold text-sm">
            <i class="fas fa-plus mr-2"></i> Baru
        </a>

        <button type="submit"
            class="inline-flex items-center px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl shadow-lg transition-all font-bold text-sm">
            Filter
        </button>
    </div>
</div>

        {{-- 2. STATS CARDS (Agar sama dengan Produk) --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Pesanan</p>
                <p class="text-2xl font-black text-gray-900">{{ $orders->total() }} <span
                        class="text-xs font-bold text-gray-400">Order</span></p>
            </div>
            {{-- Menunggu Bayar --}}
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 [border-left:4px_solid_#f59e0b]">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Menunggu Bayar</p>
                <p class="text-2xl font-black text-amber-600">{{ $orders->where('status', 'pending')->count() }}</p>
            </div>

            {{-- Sedang Diproses --}}
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 [border-left:4px_solid_#3b82f6]">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Sedang Diproses</p>
                <p class="text-2xl font-black text-blue-600">{{ $orders->where('status', 'processing')->count() }}</p>
            </div>

            {{-- Selesai --}}
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 [border-left:4px_solid_#22c55e]">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Selesai</p>
                <p class="text-2xl font-black text-green-600">{{ $orders->where('status', 'delivered')->count() }}</p>
            </div>
        </div>

        {{-- 3. TABEL DATA --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th
                                class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-16">
                                #</th>
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Pelanggan
                            </th>
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Informasi
                                Produk</th>
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Total
                                Pembayaran</th>
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Status Alur
                            </th>
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($orders as $order)
                            {{-- Row Utama --}}
                            <tr class="hover:bg-gray-50/50 transition-colors group cursor-pointer"
                                onclick="toggleDetail({{ $order->order_id }})">
                                <td class="px-6 py-4 text-center">
                                    <div id="icon-bg-{{ $order->order_id }}"
                                        class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center transition-colors group-hover:bg-orange-100 text-gray-400 group-hover:text-orange-600">
                                        <i id="icon-{{ $order->order_id }}"
                                            class="fas fa-chevron-right text-[10px] transition-transform duration-300"></i>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-[10px] font-black text-orange-600 bg-orange-50 px-2 py-0.5 rounded-md w-fit mb-1 uppercase italic border border-orange-100">
                                            {{ $order->order_number }}
                                        </span>
                                        <span class="text-sm font-black text-gray-900">{{ $order->user->username }}</span>
                                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-tight mt-0.5">
                                            <i class="far fa-clock mr-1"></i> {{ $order->created_at->format('d M, H:i') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-800 leading-tight">
                                        {{ Str::limit($order->items->first()?->product->product_name, 35) }}
                                    </div>
                                    @if ($order->items->count() > 1)
                                        <span
                                            class="text-orange-600 font-black text-[9px] uppercase bg-orange-50 px-1.5 py-0.5 rounded border border-orange-100 mt-1 inline-block">
                                            +{{ $order->items->count() - 1 }} Item Lainnya
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-black text-gray-900">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </div>
                                    @if ($order->discount_member > 0)
                                        <span
                                            class="text-[9px] text-emerald-600 font-black flex items-center gap-1 uppercase tracking-tighter">
                                            <i class="fas fa-certificate"></i> Member Disc.
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4" onclick="event.stopPropagation()">
                                    @php
                                        $hasMissingFiles = $order->items->contains(
                                            fn($item) => empty($item->design_file) && empty($item->design_link),
                                        );
                                        $statusConfig = [
                                            'pending' => [
                                                'next' => 'paid',
                                                'label' => 'Konfirmasi',
                                                'btn' => 'bg-amber-500 shadow-amber-100',
                                                'icon' => 'fa-wallet',
                                            ],
                                            'paid' => [
                                                'next' => 'processing',
                                                'label' => 'Produksi',
                                                'btn' => 'bg-emerald-500 shadow-emerald-100',
                                                'icon' => 'fa-hammer',
                                            ],
                                            'processing' => [
                                                'next' => 'shipped',
                                                'label' => 'Kirim',
                                                'btn' => 'bg-blue-500 shadow-blue-100',
                                                'icon' => 'fa-truck-fast',
                                            ],
                                            'shipped' => [
                                                'next' => 'delivered',
                                                'label' => 'Selesai',
                                                'btn' => 'bg-indigo-500 shadow-indigo-100',
                                                'icon' => 'fa-check-double',
                                            ],
                                        ];
                                        $current = $statusConfig[$order->status] ?? null;
                                    @endphp

                                    <div class="flex items-center gap-2">
                                        @if ($current)
                                            @if ($order->status == 'paid' && $hasMissingFiles)
                                                <div
                                                    class="bg-gray-100 text-gray-400 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase border border-gray-200 flex items-center gap-1.5">
                                                    <i class="fas fa-lock"></i> File Kosong
                                                </div>
                                            @else
                                                <button
                                                    onclick="confirmStatusUpdate('{{ $order->order_id }}', '{{ $current['next'] }}', '{{ route('admin.orders.updateStatus', $order->order_id) }}')"
                                                    class="{{ $current['btn'] }} text-white px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-wider shadow-lg transition-all hover:scale-105 flex items-center gap-1.5">
                                                    <i class="fas {{ $current['icon'] }}"></i> {{ $current['label'] }}
                                                </button>
                                            @endif
                                        @elseif($order->status == 'delivered')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 text-[9px] font-black uppercase bg-green-50 text-green-600 rounded-lg border border-green-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                Selesai
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-[9px] font-black uppercase bg-gray-50 text-gray-400 rounded-lg border border-gray-100">
                                                {{ $order->status }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center" onclick="event.stopPropagation()">
                                    <a href="{{ route('orders.invoice', $order->order_number) }}"
                                        class="w-8 h-8 inline-flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-orange-50 hover:text-orange-600 transition-all shadow-sm">
                                        <i class="fas fa-file-invoice text-xs"></i>
                                    </a>

                                    {{-- Tombol Resi — hanya muncul jika sudah dikirim --}}
                                    @if (in_array($order->status, ['shipped', 'delivered']))
                                        <a href="{{ route('orders.resi', $order->order_number) }}" target="_blank"
                                            class="w-8 h-8 inline-flex items-center justify-center bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition-all shadow-sm ml-1"
                                            title="Download Resi">
                                            <i class="fas fa-truck text-xs"></i>
                                        </a>
                                    @endif
                                </td>

                            </tr>

                            {{-- Row Detail (Material Style) --}}
                            <tr id="detail-{{ $order->order_id }}" class="hidden">
                                <td colspan="6" class="px-6 py-4 bg-gray-50/30">
                                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 animate-fadeIn">
                                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                            {{-- Kolom 1: Pengiriman --}}
                                            <div>
                                                <h4
                                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                                                    <i class="fas fa-map-marker-alt text-orange-500"></i> Pengiriman
                                                </h4>
                                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                                    <p class="text-xs font-black text-gray-800">
                                                        {{ $order->user->username }}</p>
                                                    <p class="text-[11px] text-gray-500 mb-2">{{ $order->user->useremail }}
                                                    </p>
                                                    <div class="pt-2 border-t border-gray-200">
                                                        <p class="text-[11px] text-gray-600 leading-relaxed italic">
                                                            {{ $order->shipping_address ?? 'Ambil di Toko (Pickup)' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Kolom 2: Items --}}
                                            <div>
                                                <h4
                                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                                                    <i class="fas fa-box text-orange-500"></i> Item Pesanan
                                                </h4>
                                                <div class="space-y-2">
                                                    @foreach ($order->items as $item)
                                                        <div
                                                            class="flex items-center justify-between bg-gray-50 p-3 rounded-xl border border-gray-100">
                                                            <div class="flex-1 min-w-0 pr-2">
                                                                <p class="text-xs font-black text-gray-800 truncate">
                                                                    {{ $item->product->product_name }}</p>
                                                                @php
                                                                    $w =
                                                                        $item->width_cm > 0
                                                                            ? $item->width_cm
                                                                            : $item->product->default_width_cm ?? 0;
                                                                    $h =
                                                                        $item->height_cm > 0
                                                                            ? $item->height_cm
                                                                            : $item->product->default_height_cm ?? 0;
                                                                @endphp

                                                                <p class="text-[9px] text-orange-600 font-bold uppercase">
                                                                    @if ($w > 0 && $h > 0)
                                                                        {{ number_format($w, 2) }}x{{ number_format($h, 2) }}
                                                                        cm
                                                                        @if ($item->used_material_qty > 0)
                                                                            • {{ $item->used_material_qty }} METER
                                                                        @endif
                                                                    @else
                                                                        Ukuran Standar
                                                                    @endif
                                                                    • {{ $item->qty }}
                                                                    {{ $item->product->unit->unit_name ?? 'pcs' }}
                                                                </p>
                                                            </div>
                                                            <div class="flex gap-1.5">
                                                                @if ($item->design_file)
                                                                    <a href="{{ asset('storage/' . $item->design_file) }}"
                                                                        target="_blank"
                                                                        class="w-7 h-7 flex items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all"><i
                                                                            class="fas fa-file-download text-[10px]"></i></a>
                                                                @endif
                                                                @if ($item->design_link)
                                                                    <a href="{{ $item->design_link }}" target="_blank"
                                                                        class="w-7 h-7 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-all"><i
                                                                            class="fas fa-link text-[10px]"></i></a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            {{-- Kolom 3: Billing --}}
                                            <div>
                                                <h4
                                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                                                    <i class="fas fa-receipt text-orange-500"></i> Ringkasan
                                                </h4>
                                                <div class="bg-slate-900 text-white p-5 rounded-2xl shadow-md">
                                                    <div class="flex justify-between text-[10px] opacity-60 mb-1">
                                                        <span>Subtotal</span>
                                                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                                                    </div>
                                                    @if ($order->discount_member > 0)
                                                        <div
                                                            class="flex justify-between text-[10px] text-emerald-400 mb-1">
                                                            <span>Diskon</span>
                                                            <span>-Rp
                                                                {{ number_format($order->discount_member, 0, ',', '.') }}</span>
                                                        </div>
                                                    @endif
                                                    <div
                                                        class="mt-2 pt-2 border-t border-white/10 flex justify-between items-end">
                                                        <div>
                                                            <p class="text-[8px] uppercase opacity-50 font-black">Total
                                                                Akhir</p>
                                                            <p class="text-lg font-black tracking-tight">Rp
                                                                {{ number_format($order->total, 0, ',', '.') }}</p>
                                                        </div>
                                                        <i class="fas fa-check-circle text-emerald-400"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <i class="fas fa-inbox text-gray-200 text-4xl mb-3"></i>
                                    <p class="text-gray-400 italic text-sm font-bold">Belum ada pesanan masuk.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 4. PAGINATION (Simplified Style) --}}
            @if ($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/20 simple-pagination">
                    {{ $orders->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
    <style>
        .font-black {
            font-weight: 900;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Pagination Styling agar satu tema */
        .simple-pagination nav div:first-child {
            display: none;
        }

        .simple-pagination nav div:last-child {
            justify-content: center;
        }

        .simple-pagination nav span[aria-current="page"] span {
            background-color: #f97316 !important;
            /* Orange */
            color: white !important;
            border: none !important;
            border-radius: 10px;
            margin: 0 3px;
        }

        .simple-pagination nav a,
        .simple-pagination nav span {
            border: none !important;
            color: #64748b !important;
            font-weight: 800;
            font-size: 12px;
            padding: 8px 12px !important;
            border-radius: 10px;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ===== TOGGLE DETAIL =====
        const openRows = new Set();

        function toggleDetail(orderId) {
            const row = document.getElementById('detail-' + orderId);
            const icon = document.getElementById('icon-' + orderId);

            if (openRows.has(orderId)) {
                row.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
                openRows.delete(orderId);
            } else {
                row.classList.remove('hidden');
                icon.style.transform = 'rotate(90deg)';
                openRows.add(orderId);
            }
        }

        // ===== UPDATE STATUS =====
        function confirmStatusUpdate(orderId, nextStatus, url) {
            const statusLabels = {
                'paid': 'Menandai pesanan sudah DIBAYAR?',
                'processing': 'Mulai PROSES PRODUKSI pesanan ini?',
                'shipped': 'Pesanan sudah SIAP KIRIM?',
                'delivered': 'Selesaikan pesanan (Sudah Diterima)?',
                'cancelled': 'BATALKAN pesanan ini?'
            };

            Swal.fire({
                title: 'Konfirmasi Perubahan',
                text: statusLabels[nextStatus],
                icon: nextStatus === 'cancelled' ? 'error' : 'question',
                showCancelButton: true,
                confirmButtonColor: nextStatus === 'cancelled' ? '#d33' : '#2563eb',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Lanjut!',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan Loading
                    Swal.showLoading();

                    // Kirim request ke server
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                status: nextStatus
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                Swal.fire('Berhasil!', 'Status pesanan diperbarui.', 'success')
                                    .then(() => location.reload()); // Refresh halaman
                            } else {
                                Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error!', 'Koneksi bermasalah.', 'error');
                        });
                }
            });
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 2000,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-3xl'
                }
            });
        @endif
    </script>
@endpush
