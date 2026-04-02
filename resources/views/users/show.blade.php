@extends('admin.admin')

@section('title', 'Detail User - Admin Panel')
@section('page-title', 'Detail User')

@section('breadcrumbs')
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li><a href="/" class="text-sm text-gray-500 hover:text-primary-600">Dashboard</a></li>
            <li><div class="flex items-center"><i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i><a href="{{ route('users.index') }}" class="text-sm text-gray-500 hover:text-primary-600">Kelola User</a></div></li>
            <li><div class="flex items-center"><i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i><span class="text-sm font-medium text-gray-900">{{ $user->username }}</span></div></li>
        </ol>
    </nav>
@endsection

@section('content')
<div class="space-y-6">

    @if(session('success'))
    <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl text-sm font-medium">
        <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ============================================================
            KOLOM KIRI — Profil + Status Member
        ============================================================ --}}
        <div class="space-y-6">

            {{-- Profil --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 text-center border-b border-gray-50">
                    <img class="h-20 w-20 rounded-full mx-auto border-4 border-white shadow-md ring-2 ring-gray-100"
                         src="https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&background=6366f1&color=fff&bold=true&size=200"
                         alt="">
                    <h3 class="mt-3 text-base font-bold text-gray-900">{{ $user->username }}</h3>
                    <p class="text-sm text-gray-400">{{ $user->useremail }}</p>
                    <p class="text-sm text-gray-400 mt-0.5">{{ $user->no_telp ?? 'No. Telp belum diisi' }}</p>
                    <div class="mt-3 flex items-center justify-center gap-2">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold ring-1 ring-inset
                            {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700 ring-purple-100' : 'bg-gray-50 text-gray-600 ring-gray-100' }}">
                            {{ strtoupper($user->role) }}
                        </span>
                        @if($user->is_member)
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold ring-1 ring-inset
                                {{ $user->member_tier === 'premium' ? 'bg-yellow-50 text-yellow-700 ring-yellow-100' :
                                  ($user->member_tier === 'plus' ? 'bg-blue-50 text-blue-700 ring-blue-100' :
                                   'bg-gray-50 text-gray-600 ring-gray-100') }}">
                                {{ $user->tier_label }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Saldo Komisi</span>
                        <span class="font-bold text-gray-900">{{ $user->saldo_komisi_formatted }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total Belanja</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($user->total_spent, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Rate Aktif</span>
                        <span class="font-bold text-green-600">
                            {{ $user->active_commission_rate }}%
                            @if($user->commission_rate_override)
                                <span class="text-[10px] text-orange-500 font-normal">(override)</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Override Rate Komisi --}}
            @if($user->is_member)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-orange-100 flex items-center justify-center">
                            <i class="fas fa-sliders-h text-orange-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Override Rate Komisi</h3>
                            <p class="text-xs text-gray-400">Set rate khusus untuk member ini</p>
                        </div>
                    </div>
                </div>
                <div class="p-5">
                    <form action="{{ route('users.set-commission-rate', $user->user_id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                Rate Khusus (%)
                            </label>
                            <div class="relative">
                                <input type="number" name="commission_rate_override"
                                    value="{{ $user->commission_rate_override }}"
                                    min="0" max="100" step="0.5"
                                    placeholder="Kosongkan = ikut tier"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 pr-8 text-sm font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400 transition-all">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">%</span>
                            </div>
                            <p class="mt-1.5 text-xs text-gray-400">Kosongkan untuk mengikuti rate tier ({{ $user->tier_label }}: {{ $user->active_commission_rate }}%)</p>
                        </div>
                        <button type="submit"
                            class="w-full py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold rounded-xl transition-all">
                            Simpan Rate
                        </button>
                    </form>
                </div>
            </div>
            @endif

            {{-- Toggle Member --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5">
                    <form action="{{ route('users.toggle-member', $user->user_id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full py-2.5 text-sm font-bold rounded-xl transition-all
                                {{ $user->is_member
                                    ? 'bg-red-50 text-red-600 hover:bg-red-100 border border-red-200'
                                    : 'bg-green-50 text-green-600 hover:bg-green-100 border border-green-200' }}">
                            <i class="fas {{ $user->is_member ? 'fa-user-times' : 'fa-user-check' }} mr-2"></i>
                            {{ $user->is_member ? 'Nonaktifkan Member' : 'Aktifkan sebagai Member' }}
                        </button>
                    </form>
                </div>
            </div>

        </div>

        {{-- ============================================================
            KOLOM KANAN — Riwayat Order + Saldo
        ============================================================ --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Riwayat Saldo --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-green-100 flex items-center justify-center">
                            <i class="fas fa-wallet text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Riwayat Saldo Komisi</h3>
                            <p class="text-xs text-gray-400">10 transaksi terakhir</p>
                        </div>
                    </div>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($user->saldoLogs->take(10) as $log)
                    <div class="px-5 py-3 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-800">{{ $log->description ?? '-' }}</p>
                            <p class="text-xs text-gray-400">{{ $log->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="text-sm font-bold {{ $log->type === 'credit' ? 'text-green-600' : 'text-red-500' }}">
                            {{ $log->amount_formatted }}
                        </span>
                    </div>
                    @empty
                    <div class="px-5 py-10 text-center text-sm text-gray-400 italic">
                        Belum ada riwayat saldo.
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Riwayat Withdraw --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-university text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Riwayat Tarik Dana</h3>
                            <p class="text-xs text-gray-400">Semua pengajuan withdrawal</p>
                        </div>
                    </div>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($user->withdrawalRequests as $wd)
                    <div class="px-5 py-3 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold text-gray-800">{{ $wd->bank_name }} — {{ $wd->account_number }}</p>
                            <p class="text-xs text-gray-400">{{ $wd->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-900">{{ $wd->amount_formatted }}</p>
                            <span class="text-[10px] font-black px-2 py-0.5 rounded-md
                                {{ $wd->status === 'approved' ? 'bg-green-100 text-green-700' :
                                  ($wd->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ $wd->status_label }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="px-5 py-10 text-center text-sm text-gray-400 italic">
                        Belum ada pengajuan tarik dana.
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection