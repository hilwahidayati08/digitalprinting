@extends('admin.admin')

@section('title', 'Riwayat Saldo Komisi - Admin Panel')

@section('content')
<div class="max-full">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Riwayat Saldo Komisi</h2>
            <p class="text-sm text-gray-500 font-medium italic">Semua mutasi saldo komisi seluruh member</p>
        </div>
        
        <div class="flex items-center gap-3">
            {{-- Filter Form --}}
            <form action="{{ route('admin.saldo-logs.index') }}" method="GET" class="flex flex-wrap md:flex-nowrap gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari Username..."
                       class="px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all w-40 shadow-sm">
                
                <select name="type" onchange="this.form.submit()"
                        class="pl-4 pr-10 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-700 appearance-none shadow-sm focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500">
                    <option value="">Semua Tipe</option>
                    <option value="credit" {{ request('type') === 'credit' ? 'selected' : '' }}>➕ Kredit (Masuk)</option>
                    <option value="debit" {{ request('type') === 'debit' ? 'selected' : '' }}>➖ Debit (Keluar)</option>
                </select>

                @if(request()->hasAny(['search', 'type']))
                    <a href="{{ route('admin.saldo-logs.index') }}" 
                       class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-black uppercase transition-all flex items-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-16">No</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Tipe</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-right">Nominal</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-right">Saldo Akhir</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Keterangan</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/30 transition-colors group">
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-bold text-gray-400 italic">
                                {{ ($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xs border border-blue-100">
                                    {{ strtoupper(substr($log->user->username, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 uppercase tracking-tight">{{ $log->user->username }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter italic">ID: #{{ $log->user->user_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($log->type === 'credit')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase border border-emerald-100">
                                    <i class="fas fa-plus-circle text-[9px]"></i> Kredit
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-rose-50 text-rose-600 text-[10px] font-black uppercase border border-rose-100">
                                    <i class="fas fa-minus-circle text-[9px]"></i> Debit
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-black tracking-tight {{ $log->type === 'credit' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $log->type === 'credit' ? '+' : '-' }} Rp {{ number_format($log->amount, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="text-[10px] font-bold text-gray-400 leading-none mb-1 uppercase tracking-tighter">After Transaksi</div>
                            <div class="text-sm font-black text-gray-800 font-mono tracking-tighter">
                                Rp {{ number_format($log->saldo_after, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-[250px] whitespace-normal">
                                <span class="text-[11px] font-bold text-gray-600 leading-relaxed italic">
                                    "{{ $log->description ?? '-' }}"
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="text-[11px] font-black text-gray-900 uppercase leading-none mb-1">{{ $log->created_at->format('d M Y') }}</div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $log->created_at->format('H:i') }} WIB</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center text-gray-400 italic font-bold uppercase tracking-widest">
                            <i class="fas fa-history text-3xl mb-3 block opacity-20"></i>
                            Belum ada riwayat transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/20">
            {{ $logs->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection