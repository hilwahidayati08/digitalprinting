@extends('admin.admin')

@section('title', 'Pengajuan Member - Admin Panel')

@section('content')
<div class="max-full">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pengajuan Member</h2>
            <p class="text-sm text-gray-500">Kelola permintaan status keanggotaan customer</p>
        </div>
        
        <div class="flex items-center gap-3">
            {{-- Filter Status --}}
            <form action="{{ route('member-requests.index') }}" method="GET" id="filterForm">
                <select name="status" onchange="document.getElementById('filterForm').submit()"
                    class="pl-4 pr-10 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm font-bold text-gray-700 appearance-none">
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
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Info User</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Alasan Pengajuan</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Status</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Waktu</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($requests as $req)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-bold text-gray-400 italic">
                                {{ ($requests->currentPage() - 1) * $requests->perPage() + $loop->iteration }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-black text-xs border border-blue-100">
                                    {{ strtoupper(substr($req->user->username, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 uppercase tracking-tight">{{ $req->user->username }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $req->user->useremail }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-[11px] font-bold text-gray-500 leading-relaxed max-w-xs italic">
                                "{{ $req->rejection_reason ?? 'Tidak mencantumkan alasan' }}"
                            </p>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($req->status === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-amber-50 text-amber-600 text-[10px] font-black uppercase border border-amber-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Menunggu
                                </span>
                            @elseif($req->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase border border-emerald-100">
                                    <i class="fas fa-check-circle"></i> Disetujui
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-gray-50 text-gray-400 text-[10px] font-black uppercase border border-gray-100">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="text-sm font-black text-gray-900 uppercase leading-none mb-1">{{ $req->created_at->format('d M Y') }}</div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $req->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center gap-2">
                                @if($req->status === 'pending')
                                    <form action="{{ route('member-requests.approve', $req->request_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-emerald-600 hover:bg-emerald-50 hover:border-emerald-200 transition-all shadow-sm">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('member-requests.reject', $req->request_id) }}" method="POST">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Tolak pengajuan ini?')" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-red-600 hover:bg-red-50 hover:border-red-200 transition-all shadow-sm">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[10px] font-black text-gray-300 uppercase italic">Processed</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400 italic">
                            Belum ada pengajuan member yang masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($requests->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/20">
                {{ $requests->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection