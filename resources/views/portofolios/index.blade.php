@extends('admin.admin')

@section('title', 'Kelola Portofolio - Admin Panel')

@section('content')
<div class="max-full">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Kelola Portofolio</h2>
            <p class="text-sm text-gray-500 font-medium italic">Manajemen karya dan proyek yang telah diselesaikan</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('portofolios.create') }}"
               class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl shadow-md shadow-primary-200 transition-all flex items-center gap-2 text-xs font-black uppercase">
                <i class="fas fa-plus text-sm"></i>
                <span>Tambah Portofolio</span>
            </a>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form action="{{ route('portofolio.index') }}" method="GET"
              class="flex flex-col md:flex-row gap-3 items-center justify-between">

            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari judul atau deskripsi portofolio..."
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                              focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500
                              transition-all text-xs font-bold shadow-sm outline-none">
            </div>

            <div class="flex flex-wrap md:flex-nowrap items-center gap-2 w-full md:w-auto">
                <select name="sort" onchange="this.form.submit()"
                        class="flex-1 md:w-44 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl
                               text-[11px] font-black uppercase focus:ring-4 focus:ring-primary-500/10
                               outline-none cursor-pointer shadow-sm">
                    <option value="newest" {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    <option value="az"     {{ request('sort') == 'az' ? 'selected' : '' }}>A – Z</option>
                    <option value="za"     {{ request('sort') == 'za' ? 'selected' : '' }}>Z – A</option>
                </select>

                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl
                               text-[11px] font-black uppercase tracking-wider transition-all
                               shadow-md shadow-blue-200 flex items-center gap-2">
                    <i class="fas fa-filter text-xs"></i> Filter
                </button>

                @if(request()->anyFilled(['search', 'sort']))
                    <a href="{{ route('portofolio.index') }}"
                       class="px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl
                              text-[11px] font-black uppercase transition-all shadow-sm flex items-center gap-2">
                        <i class="fas fa-sync-alt"></i> Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Portofolio</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($portofolios as $item)
                    <tr class="hover:bg-blue-50/30 transition-colors group">

                        {{-- Portofolio Info --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="relative flex-shrink-0">
                                    @if($item->photo)
                                        <img src="{{ asset('storage/portofolios/' . $item->photo) }}"
                                             alt="{{ $item->title }}"
                                             class="h-12 w-16 rounded-xl object-cover border-2 border-white shadow-sm ring-1 ring-gray-100">
                                    @else
                                        <div class="h-12 w-16 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100
                                                    flex items-center justify-center border-2 border-white shadow-sm ring-1 ring-gray-100">
                                            <i class="fas fa-image text-blue-300 text-sm"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 uppercase tracking-tight max-w-[180px] truncate">
                                        {{ $item->title }}
                                    </div>
                                    <div class="text-[10px] font-bold text-gray-400 italic tracking-tighter leading-none mt-0.5">
                                        /{{ $item->slug }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Deskripsi --}}
                        <td class="px-6 py-4">
                            <p class="text-xs text-gray-500 font-medium max-w-[240px] line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($item->description), 80) }}
                            </p>
                        </td>

                        {{-- Status --}}
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg
                                         text-[10px] font-black uppercase tracking-wider border
                                         bg-emerald-50 text-emerald-700 border-emerald-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Aktif
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-0.5">
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">Dibuat</span>
                                <span class="text-xs font-bold text-gray-700">
                                    {{ $item->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('portfolio.show', $item->slug) }}"
                                   target="_blank"
                                   class="p-2.5 text-gray-400 hover:text-blue-500 hover:bg-blue-50 rounded-xl transition-all"
                                   title="Lihat">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('portofolios.edit', $item->portofolio_id) }}"
                                   class="p-2.5 text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-xl transition-all"
                                   title="Edit">
                                    <i class="fas fa-pencil-alt text-sm"></i>
                                </a>
                                <button type="button" onclick="confirmDelete('{{ $item->portofolio_id }}')"
                                        class="p-2.5 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all"
                                        title="Hapus">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                                <form id="delete-form-{{ $item->portofolio_id }}"
                                      action="{{ route('portofolios.destroy', $item->portofolio_id) }}"
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-gray-400 italic font-bold uppercase tracking-widest">
                            <i class="fas fa-image text-3xl mb-3 block opacity-20"></i>
                            Tidak ada data portofolio ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('partials.admin.pagination', ['paginator' => $portofolios->withQueryString()])
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Portofolio?',
        text: "Data permanen akan hilang dan tidak bisa dipulihkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'YA, HAPUS!',
        cancelButtonText: 'BATAL',
        customClass: {
            confirmButton: 'font-black tracking-widest uppercase text-xs',
            cancelButton: 'font-black tracking-widest uppercase text-xs'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection