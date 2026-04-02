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
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-16">No</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Info Material</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Ketersediaan</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($materials as $material)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-bold text-gray-400">{{ ($materials->currentPage() - 1) * $materials->perPage() + $loop->iteration }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center border border-gray-100 text-gray-400 group-hover:text-blue-500 transition-colors">
                                    <i class="fas fa-box-open text-xs"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 uppercase leading-none mb-1">{{ $material->material_name }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">ID: #{{ $material->material_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-base font-black {{ $material->stock <= 10 ? 'text-red-600 animate-pulse' : 'text-gray-900' }}">
                                    {{ $material->stock }}
                                </span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $material->unit->unit_name ?? 'Unit' }}</span>
                                @if($material->stock <= 10)
                                    <span class="ml-2 text-[9px] font-black bg-red-50 text-red-500 px-2 py-0.5 rounded border border-red-100 uppercase">Limit</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                <a href="{{ route('materials.edit', $material->material_id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-blue-600 hover:bg-blue-50 transition-all shadow-sm">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <form action="{{ route('materials.destroy', $material->material_id) }}" method="POST" onsubmit="return confirm('Hapus material?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-red-600 hover:bg-red-50 transition-all shadow-sm">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">Material tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($materials->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/20">{{ $materials->links() }}</div>
        @endif
    </div>
</div>

<style>
    .animate-fade-in-down { animation: fadeInDown 0.4s ease-out; }
    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>

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