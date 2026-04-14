@extends('admin.admin')

@section('title', 'Riwayat Stok - Admin Panel')

@section('content')
<div class="max-full">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Riwayat Stok</h2>
            <p class="text-sm text-gray-500">Log aktivitas keluar masuk barang secara real-time</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Search Form --}}
            <form action="#" method="GET" class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="pl-9 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm w-64"
                    placeholder="Cari material...">
            </form>

            <button onclick="window.location.reload()" 
                class="inline-flex items-center justify-center w-10 h-10 bg-white border border-gray-200 text-gray-400 hover:text-blue-600 rounded-xl transition-all shadow-sm">
                <i class="fas fa-sync-alt text-xs"></i>
            </button>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4 group hover:border-emerald-200 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                <i class="fas fa-arrow-down"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Aktivitas Masuk</p>
                <p class="text-xl font-black text-gray-900 leading-none">Terpantau</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4 group hover:border-rose-200 transition-colors">
            <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600 group-hover:scale-110 transition-transform">
                <i class="fas fa-arrow-up"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Aktivitas Keluar</p>
                <p class="text-xl font-black text-gray-900 leading-none">Terpantau</p>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Waktu & Tanggal</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Info Material</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Tipe Log</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Jumlah</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Stok Akhir</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="text-sm font-black text-gray-900 uppercase leading-none mb-1">{{ $log->created_at->format('d M Y') }}</div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $log->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-50 text-gray-400 rounded-lg flex items-center justify-center border border-gray-100 group-hover:text-blue-500 transition-colors">
                                    <i class="fas fa-box-open text-[10px]"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 uppercase tracking-tight">{{ $log->material->material_name ?? 'N/A' }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $log->material->unit->unit_name ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($log->type == 'in')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase border border-emerald-100">
                                    <i class="fas fa-plus-circle"></i> Masuk
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-rose-50 text-rose-600 text-[10px] font-black uppercase border border-rose-100">
                                    <i class="fas fa-minus-circle"></i> Keluar
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-black {{ $log->type == 'in' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $log->type == 'in' ? '+' : '-' }}{{ number_format($log->amount, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="inline-flex items-center px-3 py-1 bg-gray-50 border border-gray-200 rounded-lg text-sm font-black text-gray-700">
                                {{ number_format($log->last_stock, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-[11px] font-bold text-gray-400 italic leading-tight truncate max-w-[150px]" title="{{ $log->description }}">
                                {{ $log->description ?? '-' }}
                            </p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">
                            {{ request('search') ? 'Log "'.request('search').'" tidak ditemukan.' : 'Belum ada riwayat aktivitas stok.' }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    @include('partials.admin.pagination', ['paginator' => $logs->withQueryString()])

    </div>
</div>
@endsection