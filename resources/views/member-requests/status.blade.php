{{--
    Blade ini untuk ditampilkan di halaman profil user
    Contoh pemakaian di profil: @include('frontend.member-request.status')
--}}

@php $user = auth()->user(); @endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-50">
        <h2 class="text-base font-bold text-gray-900">Status Member</h2>
        <p class="text-sm text-gray-500 mt-0.5">Dapatkan diskon & komisi di setiap pembelian</p>
    </div>
    <div class="p-6">
        @if($user->is_member)
            {{-- Sudah Member --}}
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center">
                    <i class="fas fa-crown text-emerald-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-emerald-700">Kamu adalah Member! 🎉</p>
                    <p class="text-xs text-gray-500 mt-0.5">Nikmati harga spesial & kumpulkan komisi dari setiap order.</p>
                </div>
            </div>
            <div class="mt-4 grid grid-cols-2 gap-3">
                <a href="{{ route('saldo.logs') }}"
                   class="flex items-center justify-center gap-2 py-2.5 bg-primary-50 hover:bg-primary-100 text-primary-700 text-sm font-semibold rounded-xl transition-all">
                    <i class="fas fa-history text-xs"></i> Riwayat Komisi
                </a>
                <a href="{{ route('withdrawal.index') }}"
                   class="flex items-center justify-center gap-2 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 text-sm font-semibold rounded-xl transition-all">
                    <i class="fas fa-wallet text-xs"></i>
                    Saldo: {{ $user->saldo_komisi_formatted }}
                </a>
            </div>

        @else
            {{-- Belum Member --}}
            @php
                $latestRequest = $user->memberRequest;
            @endphp

            @if($latestRequest && $latestRequest->status === 'pending')
                {{-- Sedang menunggu --}}
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center">
                        <i class="fas fa-clock text-amber-500 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-amber-700">Pengajuan Sedang Diproses</p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            Diajukan {{ $latestRequest->created_at->diffForHumans() }}. Tunggu konfirmasi admin ya!
                        </p>
                    </div>
                </div>

            @elseif($latestRequest && $latestRequest->status === 'rejected')
                {{-- Ditolak — bisa ajukan ulang --}}
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-400 text-xl"></i>
                    </div>
                </div>
                <form action="{{ route('member.request') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl shadow-md shadow-primary-200 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-redo text-sm"></i> Ajukan Ulang
                    </button>
                </form>

            @else
                {{-- Belum pernah ajukan --}}
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center">
                        <i class="fas fa-user-plus text-gray-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-700">Belum Jadi Member</p>
                        <p class="text-xs text-gray-500 mt-0.5">Daftar sekarang untuk dapat harga spesial & komisi!</p>
                    </div>
                </div>

                {{-- Info keuntungan member --}}
                <div class="mb-4 p-4 bg-primary-50 rounded-xl space-y-2">
                    <p class="text-xs font-bold text-primary-700 uppercase tracking-wider">Keuntungan Member:</p>
                    <div class="flex items-center gap-2 text-xs text-primary-700">
                        <i class="fas fa-tag text-primary-400"></i> Harga lebih murah di setiap pembelian
                    </div>
                    <div class="flex items-center gap-2 text-xs text-primary-700">
                        <i class="fas fa-coins text-primary-400"></i> Dapat komisi yang bisa dicairkan
                    </div>
                    <div class="flex items-center gap-2 text-xs text-primary-700">
                        <i class="fas fa-shopping-cart text-primary-400"></i> Bisa pakai komisi untuk bayar order
                    </div>
                </div>

                <form action="{{ route('member.request') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl shadow-md shadow-primary-200 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-crown text-sm"></i> Ajukan Jadi Member
                    </button>
                </form>
            @endif
        @endif
    </div>
</div>