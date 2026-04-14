@extends('admin.admin') {{-- sesuaikan dengan layout frontend kamu --}}

@section('title', 'Riwayat Saldo Komisi')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8 space-y-6">

    {{-- Saldo Card --}}
    <div class="bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl p-6 text-white shadow-lg shadow-primary-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-200 text-sm font-medium">Total Saldo Komisi</p>
                <p class="text-3xl font-bold mt-1">{{ $user->saldo_komisi_formatted }}</p>
            </div>
            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center">
                <i class="fas fa-coins text-2xl text-white/80"></i>
            </div>
        </div>
        <div class="flex gap-3 mt-4">
            <a href="{{ route('withdrawal.index') }}"
               class="flex-1 py-2 bg-white/20 hover:bg-white/30 text-white text-sm font-semibold rounded-xl text-center transition-all">
                <i class="fas fa-paper-plane mr-1"></i> Withdraw
            </a>
            <a href="{{ route('orders.index') }}"
               class="flex-1 py-2 bg-white/10 hover:bg-white/20 text-white/80 text-sm font-semibold rounded-xl text-center transition-all">
                <i class="fas fa-shopping-bag mr-1"></i> Order Saya
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <form action="{{ route('saldo.logs') }}" method="GET" class="flex gap-3">
            <select name="type" onchange="this.form.submit()"
                    class="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all">
                <option value="">Semua Transaksi</option>
                <option value="credit" {{ request('type') === 'credit' ? 'selected' : '' }}>➕ Komisi Masuk</option>
                <option value="debit"  {{ request('type') === 'debit'  ? 'selected' : '' }}>➖ Saldo Keluar</option>
            </select>
            @if(request('type'))
                <a href="{{ route('saldo.logs') }}"
                   class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-sm transition-all flex items-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Log List --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h2 class="text-base font-bold text-gray-900">Riwayat Transaksi Komisi</h2>
        </div>

        @if($logs->count())
        <div class="divide-y divide-gray-50">
            @foreach($logs as $log)
            <div class="px-6 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    {{-- Icon --}}
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
                        {{ $log->type === 'credit' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-500' }}">
                        <i class="fas {{ $log->type === 'credit' ? 'fa-arrow-down' : 'fa-arrow-up' }} text-sm"></i>
                    </div>
                    {{-- Info --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $log->description ?? ($log->type === 'credit' ? 'Komisi diterima' : 'Saldo digunakan') }}
                        </p>
                        <p class="text-xs text-gray-400">{{ $log->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
                {{-- Nominal & Saldo --}}
                <div class="text-right flex-shrink-0">
                    <p class="text-sm font-bold {{ $log->type === 'credit' ? 'text-emerald-600' : 'text-red-500' }}">
                        {{ $log->amount_formatted }}
                    </p>
                    <p class="text-xs text-gray-400 font-mono">
                        Saldo: Rp {{ number_format($log->saldo_after, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>

        @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">
            {{ $logs->withQueryString()->links() }}
        </div>
        @endif

        @else
        <div class="px-6 py-16 text-center text-gray-400">
            <i class="fas fa-history text-4xl text-gray-200 mb-3 block"></i>
            <p class="text-sm font-medium text-gray-500">Belum ada riwayat komisi.</p>
            <p class="text-xs text-gray-400 mt-1">Komisi akan masuk setelah order kamu selesai dibayar.</p>
        </div>
        @endif
    </div>

</div>
@endsection