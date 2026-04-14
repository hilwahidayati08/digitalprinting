@extends('admin.admin')
@section('title', 'Kelola Stok - Admin Panel')

@section('content')
    <div class="max-full">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Stok Bahan Baku</h2>
                <p class="text-sm text-gray-500">Pantau inventori material untuk kebutuhan produksi</p>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('materials.index') }}" method="GET" class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-search text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm w-64"
                        placeholder="Cari material...">
                </form>
                <a href="{{ route('materials.create') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg shadow-blue-200 transition-all font-bold text-sm gap-2">
                    <i class="fas fa-plus"></i><span>Tambah Stok</span>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th
                                class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-16">
                                No</th>
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Info
                                Material</th>
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Ketersediaan
                            </th>
                            <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Restock
                            </th>
                            <th
                                class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-32">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($materials as $m)
                            @php
                                // Cek stok berdasarkan min_stock dari database
                                $isLowStock = $m->stock <= $m->min_stock;
                            @endphp

                            {{-- Logic Baris Merah: Jika low stock, tambahkan class bg-red-50 dan border merah --}}
                            <tr
                                class="transition-colors group {{ $isLowStock ? 'bg-red-50/80 hover:bg-red-100/80 border-l-4 border-red-500' : 'hover:bg-gray-50/50' }}">
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-bold {{ $isLowStock ? 'text-red-600' : 'text-gray-400' }}">
                                        {{ ($materials->currentPage() - 1) * $materials->perPage() + $loop->iteration }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 {{ $isLowStock ? 'bg-red-100 text-red-600' : 'bg-gray-50 text-gray-400 group-hover:text-blue-500' }} rounded-xl flex items-center justify-center border border-gray-100 transition-colors">
                                            <i class="fas fa-box-open text-xs"></i>
                                        </div>
                                        <div>
                                            <div
                                                class="text-sm font-black uppercase leading-none mb-1 {{ $isLowStock ? 'text-red-800' : 'text-gray-900' }}">
                                                {{ $m->material_name }}
                                            </div>
                                            <div
                                                class="text-[10px] font-bold uppercase tracking-tighter {{ $isLowStock ? 'text-red-400' : 'text-gray-400' }}">
                                                ID: #{{ $m->material_id }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-baseline gap-1.5">
                                        <span
                                            class="text-base font-black {{ $isLowStock ? 'text-red-600 animate-pulse' : 'text-gray-900' }}">
                                            {{ $m->stock }}
                                        </span>
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-widest {{ $isLowStock ? 'text-red-400' : 'text-gray-400' }}">
                                            {{ $m->unit->unit_name ?? 'Unit' }}
                                        </span>

                                        @if ($isLowStock)
                                            <span
                                                class="ml-2 text-[9px] font-black bg-red-600 text-white px-2 py-0.5 rounded shadow-sm shadow-red-200 uppercase tracking-tighter">
                                                Stok Kritis
                                            </span>
                                        @endif
                                    </div>
                                    @if ($isLowStock)
                                        <p class="text-[9px] font-bold text-red-400 mt-1 uppercase italic">* Dibawah batas
                                            min: {{ $m->min_stock }}</p>
                                    @endif
                                </td>
                                                        <td class="px-6 py-4">
                            <form action="{{ route('materials.updateStock', $m->material_id) }}" method="POST" class="flex items-center justify-center gap-2">
                                @csrf
                                <input type="number" name="add_stock" step="0.01" required
                                       class="w-24 px-3 py-1.5 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 text-sm font-bold"
                                       placeholder="+ Jml">
                                <button type="submit" class="p-2 bg-gray-900 hover:bg-black text-white rounded-lg transition-all">
                                    <i class="fas fa-arrow-up text-xs"></i>
                                </button>
                            </form>
                        </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center gap-2">
                                        <a href="{{ route('materials.edit', $m->material_id) }}"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-blue-600 hover:bg-blue-50 transition-all shadow-sm">
                                            <i class="fas fa-edit text-xs"></i>
                                        </a>
                                        <form id="delete-form-{{ $m->material_id }}"
                                            action="{{ route('materials.destroy', $m->material_id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete('{{ $m->material_id }}')"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-red-600 hover:bg-red-50 transition-all shadow-sm">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">Material tidak
                                    ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

@include('partials.admin.pagination', ['paginator' => $materials->withQueryString()])

        </div>
    </div>

    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Hapus Bahan Baku?',
                text: "Data stok dan riwayat bahan ini akan hilang secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5',
                    cancelButton: 'rounded-xl font-bold px-6 py-2.5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection
