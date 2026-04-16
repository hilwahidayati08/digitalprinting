@extends('admin.member')

@section('title', 'Saldo Komisi & Withdraw')

@section('member_content')
    <div class="max-w-5xl mx-auto px-4 mb-8 space-y-6">
        <div class="bg-white rounded-[1.5rem] shadow-sm border border-neutral-100 overflow-hidden">

            {{-- Header dengan Gradient (Sesuai Desain Riwayat Pesanan) --}}
            <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-8 py-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-wallet text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-white text-xl font-black italic uppercase tracking-tight leading-none">Saldo
                                Komisi</h2>
                            <p class="text-white/70 text-[11px] mt-2 font-medium italic">Tarik penghasilan referral Anda di
                                sini</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-white/60 text-[10px] uppercase font-black tracking-widest leading-none mb-1">Total
                            Saldo</p>
                        <p class="text-white text-2xl font-black italic">{{ $user->saldo_komisi_formatted }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6 lg:p-8 space-y-8">
                {{-- Alert Messages --}}
                @if (session('success'))
                    <div
                        class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-[11px] font-bold flex items-center gap-2">
                        <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
                    </div>
                @endif
                @if (session('error') || $errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-[11px] font-bold">
                        @foreach ($errors->all() as $error)
                            <p class="flex items-center gap-2"><i class="fas fa-times-circle text-red-500"></i>
                                {{ $error }}</p>
                        @endforeach
                        @if (session('error'))
                            <p class="flex items-center gap-2"><i class="fas fa-times-circle text-red-500"></i>
                                {{ session('error') }}</p>
                        @endif
                    </div>
                @endif

                {{-- Info Non-Member --}}
                @if (!$user->is_member)
                    <div class="p-4 bg-neutral-50 border border-neutral-100 rounded-2xl flex items-center gap-4">
                        <div
                            class="w-10 h-10 bg-primary-100 text-primary-600 rounded-xl flex items-center justify-center flex-shrink-0 text-sm">
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="text-[11px] font-bold text-neutral-600 italic">Kamu belum menjadi member. Jadilah member
                            untuk mendapatkan komisi dari setiap pembelian!</p>
                    </div>
                @endif

                {{-- Form Withdraw --}}
                @if ($user->is_member && $user->saldo_komisi >= 10000)
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 border-b border-neutral-50 pb-2">
                            <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                            <h3 class="text-[11px] font-black text-neutral-800 uppercase tracking-widest">Ajukan Penarikan
                            </h3>
                        </div>

                        <form action="{{ route('withdrawal.store') }}" method="POST"
                            class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @csrf
                            <div class="md:col-span-2">
                                <label
                                    class="text-[10px] font-black text-neutral-400 uppercase tracking-widest mb-1.5 block">Jumlah
                                    Withdraw (Min. Rp 10.000)</label>
                                <div class="relative">
                                    <span
                                        class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400 font-black text-[11px]">RP</span>
                                    <input type="number" name="amount" min="10000" max="{{ $user->saldo_komisi }}"
                                        step="1000"
                                        class="w-full pl-10 pr-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl text-[11px] font-bold text-neutral-700 outline-none focus:border-primary-600 focus:bg-white transition-all"
                                        placeholder="0">
                                </div>
                            </div>

                            <div>
                                <label
                                    class="text-[10px] font-black text-neutral-400 uppercase tracking-widest mb-1.5 block">Nama
                                    Bank</label>
                                <input type="text" name="bank_name" placeholder="Contoh: BCA / Mandiri"
                                    class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl text-[11px] font-bold text-neutral-700 outline-none focus:border-primary-600 focus:bg-white transition-all">
                            </div>

                            <div>
                                <label
                                    class="text-[10px] font-black text-neutral-400 uppercase tracking-widest mb-1.5 block">Nomor
                                    Rekening</label>
                                <input type="text" name="account_number" placeholder="Masukkan No. Rekening"
                                    class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl text-[11px] font-bold text-neutral-700 outline-none focus:border-primary-600 focus:bg-white transition-all">
                            </div>

                            <div class="md:col-span-2">
                                <label
                                    class="text-[10px] font-black text-neutral-400 uppercase tracking-widest mb-1.5 block">Nama
                                    Pemilik Rekening</label>
                                <input type="text" name="account_name" placeholder="Sesuai nama di buku tabungan"
                                    class="w-full px-4 py-3 bg-neutral-50 border border-neutral-100 rounded-xl text-[11px] font-bold text-neutral-700 outline-none focus:border-primary-600 focus:bg-white transition-all">
                            </div>
                            <div class="md:col-span-2 pt-2">
                                <button type="submit"
                                    class="group  md:w-auto px-8 py-3 bg-neutral-900 text-white rounded-xl hover:bg-primary-600 transition-all shadow-md flex items-center justify-center gap-2">
                                    <span class="text-[10px] font-black uppercase tracking-widest">Ajukan Withdraw
                                        Sekarang</span>
                                    <i
                                        class="fas fa-arrow-right text-[9px] group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                @elseif($user->is_member && $user->saldo_komisi < 10000)
                    <div class="p-4 bg-amber-50 border border-amber-100 rounded-2xl flex items-center gap-3">
                        <i class="fas fa-exclamation-triangle text-amber-500 text-xs"></i>
                        <p class="text-[10px] font-bold text-amber-700 uppercase tracking-tight">Saldo belum mencukupi batas
                            minimum penarikan (Rp 10.000)</p>
                    </div>
                @endif

                {{-- RIWAYAT WITHDRAW (Sesuai List Pesanan) --}}
                <div class="space-y-4 pt-4">
                    <div class="flex items-center justify-between border-b border-neutral-50 pb-2">
                        <div class="flex items-center gap-2">
                            <div class="w-1 h-4 bg-primary-600 rounded-full"></div>
                            <h3 class="text-[11px] font-black text-neutral-800 uppercase tracking-widest">Riwayat Penarikan
                            </h3>
                        </div>
                        <div class="text-[9px] text-neutral-400 uppercase font-black">
                            Total: <span class="text-primary-600">{{ $withdraws->total() }}</span> Record
                        </div>
                    </div>

                    <div class="space-y-3">
                        @forelse($withdraws as $wd)
                            <div
                                class="bg-white rounded-2xl border border-neutral-100 p-4 flex items-center justify-between hover:border-primary-200 transition-all">
                                <div class="flex items-center gap-4">
                                    <div @class([
                                        'w-10 h-10 rounded-xl flex items-center justify-center text-xs shadow-sm',
                                        'bg-emerald-50 text-emerald-600' => $wd->status === 'approved',
                                        'bg-red-50 text-red-500' => $wd->status === 'rejected',
                                        'bg-amber-50 text-amber-500' => $wd->status === 'pending',
                                    ])>
                                        <i
                                            class="fas {{ $wd->status === 'approved' ? 'fa-check' : ($wd->status === 'rejected' ? 'fa-times' : 'fa-clock') }}"></i>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-black text-neutral-800 uppercase tracking-tight">
                                            {{ $wd->bank_name }} — {{ $wd->account_number }}</p>
                                        <p class="text-[10px] text-neutral-400 font-bold italic">
                                            {{ $wd->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-[12px] font-black text-neutral-900 leading-none mb-1.5">
                                        {{ $wd->amount_formatted }}</p>
                                    @if ($wd->status === 'pending')
                                        <span
                                            class="px-2 py-0.5 bg-amber-50 text-amber-500 border border-amber-100 rounded-md text-[8px] font-black uppercase tracking-widest">⏳
                                            Pending</span>
                                    @elseif($wd->status === 'approved')
                                        <span
                                            class="px-2 py-0.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-md text-[8px] font-black uppercase tracking-widest">✅
                                            Selesai</span>
                                    @else
                                        <span
                                            class="px-2 py-0.5 bg-red-50 text-red-500 border border-red-100 rounded-md text-[8px] font-black uppercase tracking-widest">❌
                                            Ditolak</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center">
                                <i class="fas fa-inbox text-neutral-200 text-3xl mb-3 block"></i>
                                <p class="text-[11px] font-bold text-neutral-400 uppercase tracking-widest">Belum ada
                                    riwayat withdraw</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($withdraws->hasPages())
                        <div class="pt-4 border-t border-neutral-50">
                            {{ $withdraws->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
