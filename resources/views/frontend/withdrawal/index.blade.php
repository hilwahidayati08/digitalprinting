@extends('layouts.member') {{-- sesuaikan dengan layout frontend kamu --}}

@section('title', 'Saldo Komisi & Withdraw')

@section('member_content')
<div class="max-w-4xl mx-auto px-4 py-8 space-y-6">

    {{-- Alert --}}
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm flex items-center gap-2">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm flex items-center gap-2">
            <i class="fas fa-times-circle"></i> {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
            @foreach($errors->all() as $error)
                <p class="flex items-center gap-2"><i class="fas fa-exclamation-circle"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Saldo Card --}}
    <div class="bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl p-6 text-white shadow-lg shadow-primary-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-primary-200 text-sm font-medium">Saldo Komisi Kamu</p>
                <p class="text-3xl font-bold mt-1">{{ $user->saldo_komisi_formatted }}</p>
                <p class="text-primary-200 text-xs mt-2">Minimum withdraw Rp 10.000</p>
            </div>
            <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center">
                <i class="fas fa-wallet text-3xl text-white/80"></i>
            </div>
        </div>
        @if(!$user->is_member)
            <div class="mt-4 p-3 bg-white/10 rounded-xl text-xs text-primary-100">
                <i class="fas fa-info-circle mr-1"></i>
                Kamu belum menjadi member. Jadilah member untuk mendapatkan komisi dari setiap pembelian!
            </div>
        @endif
    </div>

    {{-- Form Withdraw --}}
    @if($user->is_member && $user->saldo_komisi >= 10000)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h2 class="text-base font-bold text-gray-900">Ajukan Withdraw</h2>
            <p class="text-sm text-gray-500 mt-0.5">Transfer saldo komisi ke rekening kamu</p>
        </div>
        <div class="p-6">
            <form action="{{ route('withdrawal.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Jumlah --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Jumlah Withdraw <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 text-sm font-medium">Rp</span>
                            <input type="number" name="amount" value="{{ old('amount') }}"
                                   min="10000" max="{{ $user->saldo_komisi }}" step="1000"
                                   class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all"
                                   placeholder="Contoh: 50000">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Maksimal: {{ $user->saldo_komisi_formatted }}</p>
                    </div>

                    {{-- Nama Bank --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Bank <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="bank_name" value="{{ old('bank_name') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all"
                               placeholder="Contoh: BCA, BNI, Mandiri">
                    </div>

                    {{-- Nomor Rekening --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nomor Rekening <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="account_number" value="{{ old('account_number') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all font-mono"
                               placeholder="Contoh: 1234567890">
                    </div>

                    {{-- Nama Pemilik --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nama Pemilik Rekening <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="account_name" value="{{ old('account_name') }}"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all"
                               placeholder="Sesuai nama di buku tabungan">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl shadow-md shadow-primary-200 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Ajukan Withdraw
                    </button>
                </div>
            </form>
        </div>
    </div>
    @elseif($user->is_member && $user->saldo_komisi < 10000)
        <div class="p-4 bg-amber-50 border border-amber-200 text-amber-700 rounded-xl text-sm flex items-center gap-2">
            <i class="fas fa-exclamation-triangle"></i>
            Saldo komisimu belum mencapai minimum withdraw (Rp 10.000).
        </div>
    @endif

    {{-- Riwayat Withdraw --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50">
            <h2 class="text-base font-bold text-gray-900">Riwayat Withdraw</h2>
        </div>

        @if($withdraws->count())
        <div class="divide-y divide-gray-50">
            @foreach($withdraws as $wd)
            <div class="px-6 py-4 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl
                        {{ $wd->status === 'approved' ? 'bg-emerald-50 text-emerald-600' : ($wd->status === 'rejected' ? 'bg-red-50 text-red-500' : 'bg-amber-50 text-amber-500') }}
                        flex items-center justify-center">
                        <i class="fas {{ $wd->status === 'approved' ? 'fa-check' : ($wd->status === 'rejected' ? 'fa-times' : 'fa-clock') }} text-sm"></i>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $wd->bank_name }} — {{ $wd->account_number }}
                        </p>
                        <p class="text-xs text-gray-400">{{ $wd->created_at->format('d M Y, H:i') }}</p>
                        @if($wd->rejection_reason)
                            <p class="text-xs text-red-400 mt-0.5">{{ $wd->rejection_reason }}</p>
                        @endif
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-gray-900">{{ $wd->amount_formatted }}</p>
                    @if($wd->status === 'pending')
                        <span class="text-xs font-bold text-amber-500 bg-amber-50 px-2 py-0.5 rounded-full">⏳ Menunggu</span>
                    @elseif($wd->status === 'approved')
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">✅ Selesai</span>
                    @else
                        <span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded-full">❌ Ditolak</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @if($withdraws->hasPages())
        <div class="px-6 py-4 border-t border-gray-50">
            {{ $withdraws->links() }}
        </div>
        @endif
        @else
        <div class="px-6 py-12 text-center text-gray-400">
            <i class="fas fa-inbox text-3xl text-gray-200 mb-2 block"></i>
            <p class="text-sm">Belum ada riwayat withdraw.</p>
        </div>
        @endif
    </div>

</div>
@endsection