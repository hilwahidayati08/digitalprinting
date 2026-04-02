@extends('admin.admin')

@section('title', 'Request Withdraw - Admin Panel')

@section('content')
<div class="max-full">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Request Withdraw</h2>
            <p class="text-sm text-gray-500">Kelola pencairan saldo para member</p>
        </div>
        
        <div class="flex items-center gap-3">
            {{-- Filter Status --}}
            <form action="{{ route('admin.withdrawals.index') }}" method="GET" id="filterForm">
                <select name="status" onchange="document.getElementById('filterForm').submit()"
                    class="pl-4 pr-10 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm font-bold text-gray-700 appearance-none shadow-sm">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                </select>
            </form>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl shadow-sm">
            <i class="fas fa-check-circle"></i>
            <p class="text-sm font-black uppercase tracking-tight">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-16">No</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Info Member</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Rekening Tujuan</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Jumlah</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Waktu</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($withdraws as $wd)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-bold text-gray-400 italic">
                                {{ ($withdraws->currentPage() - 1) * $withdraws->perPage() + $loop->iteration }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xs border border-blue-100">
                                    {{ strtoupper(substr($wd->user->username, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 uppercase tracking-tight">{{ $wd->user->username }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $wd->user->useremail }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-[11px] font-black text-gray-800 uppercase leading-none mb-1">{{ $wd->bank_name }}</div>
                            <div class="text-[10px] font-mono font-bold text-blue-600">{{ $wd->account_number }}</div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase italic">a/n {{ $wd->account_name }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-black text-gray-900 leading-none tracking-tight">
                                Rp {{ number_format($wd->amount, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($wd->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-amber-50 text-amber-600 text-[10px] font-black uppercase border border-amber-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending
                                </span>
                            @elseif($wd->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase border border-emerald-100">
                                    <i class="fas fa-check-circle"></i> Disetujui
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-rose-50 text-rose-600 text-[10px] font-black uppercase border border-rose-100">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="text-sm font-black text-gray-900 uppercase leading-none mb-1">{{ $wd->created_at->format('d M Y') }}</div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $wd->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                @if($wd->status === 'pending')
                                    <button type="button" onclick="confirmApprove({{ $wd->withdrawal_id }}, '{{ $wd->user->username }}', 'Rp {{ number_format($wd->amount, 0, ',', '.') }}')"
                                        class="h-8 px-3 flex items-center justify-center gap-1.5 rounded-lg bg-emerald-500 text-white text-[10px] font-black uppercase hover:bg-emerald-600 transition-all shadow-sm">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <form id="approve-form-{{ $wd->withdrawal_id }}" action="{{ route('admin.withdrawals.approve', $wd->withdrawal_id) }}" method="POST" class="hidden">@csrf</form>
                                    
                                    <button type="button" onclick="showRejectModal({{ $wd->withdrawal_id }})"
                                        class="h-8 px-3 flex items-center justify-center gap-1.5 rounded-lg bg-white border border-gray-200 text-red-600 text-[10px] font-black uppercase hover:bg-red-50 hover:border-red-200 transition-all shadow-sm">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                @else
                                    <span class="text-[10px] font-black text-gray-300 uppercase italic">Selesai</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400 italic font-bold uppercase tracking-widest">
                            Belum ada request withdraw.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($withdraws->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/20">
                {{ $withdraws->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

{{-- Modal Reject (Gaya Modern) --}}
<div id="rejectModal" class="fixed inset-0 z-50 hidden bg-gray-900/40 backdrop-blur-sm flex items-center justify-center transition-all">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 overflow-hidden border border-gray-100">
        <div class="p-6">
            <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight mb-1">Tolak Request</h3>
            <p class="text-sm text-gray-500 mb-4 font-bold italic">Saldo akan dikembalikan ke member.</p>
            <form id="rejectForm" method="POST">
                @csrf
                <textarea name="rejection_reason" rows="3"
                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-red-500/10 focus:border-red-400 transition-all resize-none"
                    placeholder="Alasan penolakan..."></textarea>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeRejectModal()"
                        class="px-5 py-2.5 text-xs font-black uppercase text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 text-xs font-black uppercase text-white bg-red-500 hover:bg-red-600 rounded-xl transition-all shadow-sm">Tolak Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function confirmApprove(id, user, amount) {
    Swal.fire({
        title: 'APPROVE WITHDRAW?',
        html: `<p class='text-sm font-bold text-gray-500'>Pastikan Anda sudah transfer <span class='text-emerald-600 font-black'>${amount}</span> ke member <span class='text-gray-900 font-black'>${user}</span>.</p>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'YA, SUDAH TRANSFER',
        cancelButtonText: 'BATAL'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('approve-form-' + id).submit();
        }
    });
}
function showRejectModal(id) {
    document.getElementById('rejectForm').action = `/admin/withdrawals/${id}/reject`; // Sesuaikan prefix route Anda
    document.getElementById('rejectModal').classList.remove('hidden');
}
function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection