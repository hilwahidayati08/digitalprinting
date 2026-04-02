@extends('admin.admin')

@section('title', 'Kelola Hero Banner - Admin Panel')

@section('content')
<div class="max-full" x-data="{ selected: 0 }">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Hero Banner</h2>
            <p class="text-sm text-gray-500">Manajemen visual utama, headline, dan promosi halaman depan</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('heros.create') }}"
                class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg shadow-blue-200 transition-all font-bold text-sm gap-2">
                <i class="fas fa-plus"></i>
                <span>Tambah Banner</span>
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
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Visual & Konten</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Section</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($heros as $hero)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold text-gray-400">{{ $loop->iteration }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative flex-shrink-0">
                                        <img src="{{ $hero->photo ? asset('storage/heros/' . $hero->photo) : asset('images/no-image.png') }}"
                                             class="w-16 h-10 object-cover rounded-lg shadow-sm border border-gray-100">
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-gray-900 leading-none mb-1">{{ $hero->label }}</div>
                                        <button @click="selected = (selected === {{ $hero->hero_id }} ? 0 : {{ $hero->hero_id }})" 
                                                class="flex items-center text-[10px] font-bold text-blue-500 uppercase tracking-tighter hover:text-blue-700 transition-colors">
                                            <span x-text="selected === {{ $hero->hero_id }} ? 'Tutup Preview' : 'Lihat Detail & Headline'"></span>
                                            <i class="fas fa-chevron-down ml-1 transition-transform" :class="selected === {{ $hero->hero_id }} ? 'rotate-180' : ''"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-600 border border-blue-100 uppercase">
                                    {{ $hero->section }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black {{ $hero->is_active ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-gray-50 text-gray-400 border border-gray-100' }} uppercase tracking-wider">
                                    @if($hero->is_active) <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> @endif
                                    {{ $hero->is_active ? 'Aktif' : 'Off' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('heros.edit', $hero->hero_id) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-blue-600 hover:bg-blue-50 transition-all shadow-sm">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('heros.destroy', $hero->hero_id) }}" method="POST" onsubmit="return confirm('Hapus banner ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-red-600 hover:bg-red-50 transition-all shadow-sm">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        {{-- Dropdown Detail (Mirip Detail Produk) --}}
                        <tr x-show="selected === {{ $hero->hero_id }}" x-cloak x-collapse class="bg-gray-50/50 border-b border-gray-200">
                            <td colspan="5" class="px-8 py-6 shadow-inner">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <h4 class="text-[10px] font-black text-gray-400 uppercase mb-3 tracking-widest flex items-center">
                                            <i class="fas fa-align-left mr-2"></i> Konten Headline
                                        </h4>
                                        <div class="space-y-3">
                                            <div>
                                                <span class="text-[10px] text-gray-400 font-bold uppercase">Headline Utama:</span>
                                                <p class="text-sm font-bold text-gray-800">{{ $hero->headline }}</p>
                                            </div>
                                            <div>
                                                <span class="text-[10px] text-gray-400 font-bold uppercase">Sub-Headline:</span>
                                                <p class="text-xs text-gray-600 leading-relaxed">{{ $hero->subheadline ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-[10px] font-black text-gray-400 uppercase mb-3 tracking-widest flex items-center">
                                            <i class="fas fa-link mr-2"></i> Navigasi & Media
                                        </h4>
                                        <div class="space-y-3">
                                            <div class="flex items-center gap-2">
                                                <span class="text-[10px] text-gray-400 font-bold uppercase">Button Link:</span>
                                                <a href="{{ $hero->button_link }}" target="_blank" class="text-xs text-blue-600 font-mono hover:underline truncate">{{ $hero->button_link ?? 'Tidak ada link' }}</a>
                                            </div>
                                            <div class="mt-4">
                                                <img src="{{ $hero->photo ? asset('storage/heros/' . $hero->photo) : asset('images/no-image.png') }}" 
                                                     class="w-full max-w-xs aspect-video object-cover rounded-xl border border-gray-200 shadow-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic font-medium">
                                Belum ada data banner.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Script Alpine.js tetap dipush jika layout belum menyediakannya --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush