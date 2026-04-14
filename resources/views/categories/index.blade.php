@extends('admin.admin')
@section('title', 'Kelola Kategori - Admin Panel')

@section('content')
<div class="max-full">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kategori Produk</h2>
            <p class="text-sm text-gray-500">Total {{ $categories->total() }} kategori terdaftar dalam katalog</p>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('categories.index') }}" method="GET" class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm w-64"
                    placeholder="Cari kategori...">
            </form>
            <a href="{{ route('categories.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg shadow-blue-200 transition-all font-bold text-sm gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Kategori</span>
            </a>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-16">No</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Status Item</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($categories as $category)
                    <tr class="hover:bg-gray-50/50 transition-colors group">

                        {{-- Nomor Urut --}}
                        <td class="px-6 py-3 text-center">
                            <span class="text-sm font-bold text-gray-400 italic">
                                {{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}
                            </span>
                        </td>

                        {{-- Nama Kategori --}}
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center border border-blue-100 group-hover:scale-110 transition-transform flex-shrink-0">
                                    <i class="fas fa-tag text-[10px]"></i>
                                </div>
                                <span class="text-sm font-black text-gray-900 uppercase tracking-tight">
                                    {{ $category->category_name }}
                                </span>
                            </div>
                        </td>

                        {{-- Jumlah Produk --}}
                        <td class="px-6 py-3 text-center">
                            <span class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black border border-emerald-100 uppercase tracking-wider">
                                {{ $category->products_count }} Produk
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-3">
                            <div class="flex justify-center items-center gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('categories.edit', $category->category_id) }}"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-blue-600 hover:bg-blue-50 transition-all shadow-sm"
                                    title="Edit Kategori">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>

                                {{-- Tombol Hapus (SweetAlert) --}}
                                <button type="button"
                                    onclick="confirmDelete({{ $category->category_id }}, '{{ addslashes($category->category_name) }}')"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-red-600 hover:bg-red-50 transition-all shadow-sm"
                                    title="Hapus Kategori">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>

                                {{-- Hidden Form untuk DELETE --}}
                                <form id="delete-form-{{ $category->category_id }}"
                                    action="{{ route('categories.destroy', $category->category_id) }}"
                                    method="POST"
                                    class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic font-medium">
                            @if(request('search'))
                                Kategori "{{ request('search') }}" tidak ditemukan.
                            @else
                                Belum ada data kategori.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

@include('partials.admin.pagination', ['paginator' => $categories->withQueryString()])

    </div>
</div>
@endsection

@push('styles')
<style>
    .animate-fade-in-down {
        animation: fadeInDown 0.4s ease-out;
    }
    @keyframes fadeInDown {
        0%   { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Hapus Kategori?',
            html: `Kategori <strong>${name}</strong> akan dihapus.<br><span style="font-size:13px;color:#6b7280;">Tindakan ini mungkin mempengaruhi produk terkait.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl font-bold px-6 py-2.5 text-sm',
                cancelButton: 'rounded-xl font-bold px-6 py-2.5 text-sm',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush