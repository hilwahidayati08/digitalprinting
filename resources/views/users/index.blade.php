@extends('admin.admin')

@section('title', 'Kelola User - Admin Panel')

@section('content')
<div class="max-full">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Kelola User</h2>
            <p class="text-sm text-gray-500 font-medium italic">Manajemen akun dan status member sistem</p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('users.create') }}"
               class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl shadow-md shadow-primary-200 transition-all flex items-center gap-2 text-xs font-black uppercase">
                <i class="fas fa-plus text-sm"></i>
                <span>Tambah User</span>
            </a>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 items-center justify-between">
            <div class="relative w-full md:w-96">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                    <i class="fas fa-search text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all text-xs font-bold shadow-sm"
                       placeholder="Cari Username, Nama, atau Email...">
            </div>

            <div class="flex flex-wrap md:flex-nowrap items-center gap-2 w-full md:w-auto">
                <select name="role" onchange="this.form.submit()"
                        class="flex-1 md:w-36 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-[11px] font-black uppercase focus:ring-4 focus:ring-primary-500/10 outline-none cursor-pointer shadow-sm">
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Customer</option>
                </select>

                <select name="is_member" onchange="this.form.submit()"
                        class="flex-1 md:w-40 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-[11px] font-black uppercase focus:ring-4 focus:ring-primary-500/10 outline-none cursor-pointer shadow-sm">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_member') == '1' ? 'selected' : '' }}>Member</option>
                    <option value="0" {{ request('is_member') == '0' ? 'selected' : '' }}>Non Member</option>
                </select>

                @if(request()->anyFilled(['search', 'role', 'is_member']))
                    <a href="{{ route('users.index') }}" 
                       class="px-4 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-[11px] font-black uppercase transition-all shadow-sm flex items-center gap-2">
                        <i class="fas fa-sync-alt"></i> Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Info Pengguna</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center">Role</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Status Member</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img class="h-11 w-11 rounded-xl object-cover border-2 border-white shadow-sm ring-1 ring-gray-100"
                                         src="https://ui-avatars.com/api/?name={{ urlencode($user->username) }}&background=6366f1&color=fff&bold=true" alt="">
                                    <span class="absolute -bottom-1 -right-1 h-3 w-3 rounded-full border-2 border-white {{ $user->is_online ? 'bg-emerald-500' : 'bg-gray-300' }}"></span>
                                </div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 uppercase tracking-tight">{{ $user->username }}</div>
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter italic leading-none mb-1">{{ $user->useremail }}</div>
                                    <div class="text-[10px] font-medium text-gray-500">{{ $user->no_telp ?? 'No Phone' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider border
                                {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700 border-purple-100' : 'bg-gray-50 text-gray-600 border-gray-100' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->is_member)
                                <div class="flex flex-col gap-1.5">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase border w-fit
                                        {{ $user->member_tier === 'premium' ? 'bg-yellow-50 text-yellow-700 border-yellow-200' : 
                                           ($user->member_tier === 'plus' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-slate-50 text-slate-600 border-slate-200') }}">
                                        <i class="fas fa-crown text-[9px]"></i> {{ $user->tier_label }}
                                    </span>
                                    <div class="flex gap-3">
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">Rate</span>
                                            <span class="text-xs font-black text-gray-700 leading-none">
                                                {{ $user->active_commission_rate }}%
                                                @if($user->commission_rate_override) <span class="text-orange-500">*</span> @endif
                                            </span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[9px] font-black text-gray-400 uppercase tracking-tighter">Total Belanja</span>
                                            <span class="text-xs font-black text-gray-700 leading-none">Rp {{ number_format($user->total_spent, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-[10px] font-bold text-gray-400 italic uppercase tracking-widest">Regular Customer</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('users.show', $user->user_id) }}" 
                                   class="p-2.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all" title="Detail & Commission">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('users.edit', $user->user_id) }}" 
                                   class="p-2.5 text-gray-400 hover:text-amber-500 hover:bg-amber-50 rounded-xl transition-all" title="Edit">
                                    <i class="fas fa-pencil-alt text-sm"></i>
                                </a>
                                <button type="button" onclick="confirmDelete('{{ $user->user_id }}')"
                                        class="p-2.5 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all" title="Delete">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                                <form id="delete-form-{{ $user->user_id }}" action="{{ route('users.destroy', $user->user_id) }}" method="POST" class="hidden">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center text-gray-400 italic font-bold uppercase tracking-widest">
                            <i class="fas fa-user-slash text-3xl mb-3 block opacity-20"></i>
                            Tidak ada data pengguna ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/20">
            {{ $users->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function confirmDelete(userId) {
    Swal.fire({
        title: 'Hapus User?',
        text: "Data permanen akan hilang dan tidak bisa dipulihkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'YA, HAPUS!',
        cancelButtonText: 'BATAL',
        customClass: {
            confirmButton: 'font-black tracking-widest uppercase text-xs',
            cancelButton: 'font-black tracking-widest uppercase text-xs'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + userId).submit();
        }
    });
}
</script>
@endsection