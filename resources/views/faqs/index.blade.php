@extends('admin.admin')

@section('title', 'Kelola FAQ - Admin Panel')

@section('content')
<div class="max-full">
    {{-- 1. Header & Search --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Daftar FAQ</h2>
            <p class="text-sm text-gray-500">Kelola pertanyaan umum yang muncul di halaman depan</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Search Bar --}}
            <form action="{{ route('faqs.index') }}" method="GET" class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm w-64"
                    placeholder="Cari pertanyaan...">
            </form>
            <a href="{{ route('faqs.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg shadow-blue-200 transition-all font-bold text-sm gap-2">
                <i class="fas fa-plus"></i><span>Tambah FAQ</span>
            </a>
        </div>
    </div>

    {{-- 3. Tabel Data --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-16">No</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Informasi Pertanyaan</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Status Tampil</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($faqs as $faq)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 text-center">
                            {{-- Penomoran otomatis yang berlanjut di tiap halaman --}}
                            <span class="text-sm font-bold text-gray-400">
                                {{ ($faqs->currentPage() - 1) * $faqs->perPage() + $loop->iteration }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center border border-blue-100 text-blue-500 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                    <i class="fas fa-question text-xs"></i>
                                </div>
                                <div class="max-w-md">
                                    <div class="text-sm font-black text-gray-900 leading-tight mb-1 truncate">{{ $faq->question }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">ID: #FAQ-{{ $faq->faq_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($faq->is_active)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-black uppercase bg-green-50 text-green-600 rounded-lg border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-black uppercase bg-gray-50 text-gray-400 rounded-lg border border-gray-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </td>
<td class="px-6 py-4">
    <div class="flex justify-center items-center gap-2">
        <a href="{{ route('faqs.edit', $faq->faq_id) }}" 
           class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-blue-600 hover:bg-blue-50 transition-all shadow-sm">
            <i class="fas fa-edit text-xs"></i>
        </a>
        
        {{-- Form delete langsung --}}
        <form action="{{ route('faqs.destroy', $faq->faq_id) }}" method="POST" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-red-600 hover:bg-red-50 transition-all shadow-sm"
                    onclick="return confirm('Yakin ingin menghapus FAQ ini?')">
                <i class="fas fa-trash text-xs"></i>
            </button>
        </form>
    </div>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class="fas fa-comments text-gray-200 text-4xl"></i>
                                <p class="text-gray-400 italic text-sm font-medium">Data FAQ tidak ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
@include('partials.admin.pagination', ['paginator' => $faqs->withQueryString()])

    </div>
</div>

{{-- SweetAlert2 Script --}}
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus FAQ?',
            text: "Data ini akan dihapus permanen dari sistem.",
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

<style>
    .font-black { font-weight: 900; }
</style>
@endsection