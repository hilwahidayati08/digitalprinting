@extends('admin.admin')

@section('title', 'Kelola Produk - Admin Panel')

@section('content')
<div class="max-full" x-data="{ selected: 0 }">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Daftar Produk</h2>
            <p class="text-sm text-gray-500">Manajemen katalog, harga, dan rincian teknis produksi</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Form Pencarian --}}
            <form action="{{ route('products.index') }}" method="GET" class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm w-64"
                    placeholder="Cari produk atau kategori...">
            </form>

            <a href="{{ route('products.create') }}"
                class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg shadow-blue-200 transition-all font-bold text-sm gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Produk</span>
            </a>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-6 animate-fade-in-down">
            <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl shadow-sm">
                <div class="flex-shrink-0 w-8 h-8 bg-emerald-500 text-white rounded-full flex items-center justify-center shadow-sm">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <p class="text-sm font-bold">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-16">No</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Info Produk</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Harga/Satuan</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($products as $product)
                        {{-- Baris Produk (Sesuai kode asli Anda) --}}
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold text-gray-400">
                                    {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative flex-shrink-0">
                                        @php
                                            $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
                                        @endphp
                                        @if($primaryImage)
                                            <img src="{{ asset('storage/' . $primaryImage->photo) }}"
                                                 class="w-12 h-12 object-cover rounded-xl shadow-sm border border-gray-100">
                                        @else
                                            <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center border border-dashed border-gray-200">
                                                <i class="fas fa-image text-gray-300"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-gray-900 leading-none mb-1">{{ $product->product_name }}</div>
                                        <button @click="selected = (selected === {{ $product->product_id }} ? 0 : {{ $product->product_id }})" 
        class="flex items-center text-[10px] font-bold text-blue-500 uppercase tracking-tighter hover:text-blue-700 transition-colors">
    <span x-text="selected === {{ $product->product_id }} ? 'Tutup Detail' : 'Lihat Detail Produk'"></span>
    <i class="fas fa-chevron-down ml-1 transition-transform" :class="selected === {{ $product->product_id }} ? 'rotate-180' : ''"></i>
</button>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-gray-100 text-gray-600">
                                    {{ $product->category->category_name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-black text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <div class="text-[10px] font-bold text-gray-400 uppercase mt-1">per {{ $product->unit->unit_name ?? 'Unit' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black {{ $product->is_active ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-gray-50 text-gray-400 border border-gray-100' }} uppercase tracking-wider">
                                    @if($product->is_active) <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> @endif
                                    {{ $product->is_active ? 'Aktif' : 'Off' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('products.edit', $product->product_id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-blue-600 hover:bg-blue-50 transition-all shadow-sm">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->product_id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-red-600 hover:bg-red-50 transition-all shadow-sm">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Dropdown Detail --}}
                        <tr x-show="selected === {{ $product->product_id }}" 
    x-cloak 
    x-collapse
    class="bg-gray-50/50 border-b border-gray-200">
    <td colspan="6" class="px-8 py-6 shadow-inner">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                    <div>
                                        <h4 class="text-[10px] font-black text-gray-400 uppercase mb-3 tracking-widest flex items-center">
                                            <i class="fas fa-info-circle mr-2"></i> Detail Umum
                                        </h4>
                                        <div class="space-y-2">
                                            <p class="text-xs text-gray-500">Slug: <span class="text-gray-700 font-mono">{{ $product->slug }}</span></p>
                                            <p class="text-sm text-gray-600 leading-relaxed italic">"{{ $product->description ?? 'Tidak ada deskripsi' }}"</p>
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <div>
                                            <h4 class="text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Kaitan Material Stok</h4>
                                            <div class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 border border-blue-100">
                                                <i class="fas fa-cube text-[10px] mr-2"></i>
                                                <span class="text-xs font-bold">{{ $product->material->material_name ?? 'Tidak terhubung' }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Ukuran Default</h4>
                                            <p class="text-xs font-bold text-gray-700">
                                                {{ $product->default_width_cm / 100 }}m x {{ $product->default_height_cm / 100 }}m
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-[10px] font-black text-gray-400 uppercase mb-3 tracking-widest flex items-center">
                                            <i class="fas fa-images mr-2"></i> Galeri ({{ $product->images->count() }})
                                        </h4>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($product->images as $img)
                                                <img src="{{ asset('storage/' . $img->photo) }}" class="w-12 h-12 object-cover rounded-lg border border-gray-200 {{ $img->is_primary ? 'ring-2 ring-blue-500' : '' }}">
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic font-medium">
                                @if(request('search'))
                                    Produk "{{ request('search') }}" tidak ditemukan.
                                @else
                                    Belum ada data produk.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/20">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush