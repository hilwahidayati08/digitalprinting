@extends('admin.admin')
@section('title', 'Notifikasi - Admin Panel')

@section('content')
<div class="max-full">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Notifikasi</h2>
            <p class="text-sm text-gray-500">
                {{ $unreadCount }} belum dibaca &middot; {{ $totalCount }} total
            </p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">

            {{-- Filter --}}
            <form action="{{ route('notifications.index') }}" method="GET" class="flex items-center gap-2 flex-wrap">
                <select name="type"
                    class="px-3 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm font-semibold">
                    <option value="">Semua Tipe</option>
                    @foreach(['order' => 'Pesanan', 'payment' => 'Pembayaran', 'stock' => 'Stok', 'member' => 'Member', 'withdrawal' => 'Penarikan', 'commission' => 'Komisi', 'rating' => 'Ulasan'] as $val => $label)
                        <option value="{{ $val }}" {{ $filterType === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <select name="status"
                    class="px-3 py-2.5 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all text-sm font-semibold">
                    <option value="">Belum Dibaca</option>
    <option value="all"   {{ $filterStatus === 'all'   ? 'selected' : '' }}>Semua</option>
    <option value="read"  {{ $filterStatus === 'read'  ? 'selected' : '' }}>Sudah Dibaca</option>
                </select>

                <button type="submit"
                    class="inline-flex items-center px-4 py-2.5 bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 rounded-xl transition-all font-bold text-sm gap-2">
                    <i class="fas fa-filter text-xs"></i> Filter
                </button>

                @if($filterType || $filterStatus)
                    <a href="{{ route('notifications.index') }}"
                       class="inline-flex items-center px-4 py-2.5 bg-white hover:bg-red-50 border border-gray-200 text-red-500 rounded-xl transition-all font-bold text-sm gap-2">
                        <i class="fas fa-times text-xs"></i> Reset
                    </a>
                @endif
            </form>

            {{-- Tandai Semua --}}
            @if($unreadCount > 0)
                <button onclick="markAllRead()"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg shadow-blue-200 transition-all font-bold text-sm gap-2">
                    <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                </button>
            @endif
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total</p>
            <p class="text-3xl font-black text-gray-800">{{ $totalCount }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-5">
            <p class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-1">Belum Dibaca</p>
            <p class="text-3xl font-black text-red-500">{{ $unreadCount }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-green-100 shadow-sm p-5">
            <p class="text-[10px] font-black text-green-400 uppercase tracking-widest mb-1">Sudah Dibaca</p>
            <p class="text-3xl font-black text-green-600">{{ $readCount }}</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-16">No</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Notifikasi</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider">Waktu</th>
                        <th class="px-6 py-4 text-[11px] font-black text-gray-400 uppercase tracking-wider text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($notifications as $notif)
                        @php
                            $isUnread = !$notif->is_read;
                            $type     = $notif->type ?? 'order';
                            $cfg = [
                                'order'      => ['icon' => 'fa-shopping-cart',        'bg' => 'bg-green-100',  'text' => 'text-green-600',  'badge' => 'bg-green-100 text-green-700',   'label' => 'Pesanan'],
                                'payment'    => ['icon' => 'fa-credit-card',          'bg' => 'bg-blue-100',   'text' => 'text-blue-600',   'badge' => 'bg-blue-100 text-blue-700',     'label' => 'Pembayaran'],
                                'stock'      => ['icon' => 'fa-exclamation-triangle', 'bg' => 'bg-red-100',    'text' => 'text-red-600',    'badge' => 'bg-red-100 text-red-700',       'label' => 'Stok'],
                                'member'     => ['icon' => 'fa-user-check',           'bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'badge' => 'bg-purple-100 text-purple-700', 'label' => 'Member'],
                                'withdrawal' => ['icon' => 'fa-money-bill-wave',      'bg' => 'bg-amber-100',  'text' => 'text-amber-600',  'badge' => 'bg-amber-100 text-amber-700',   'label' => 'Penarikan'],
                                'commission' => ['icon' => 'fa-coins',                'bg' => 'bg-yellow-100', 'text' => 'text-yellow-600', 'badge' => 'bg-yellow-100 text-yellow-700', 'label' => 'Komisi'],
                                'rating'     => ['icon' => 'fa-star',                 'bg' => 'bg-orange-100', 'text' => 'text-orange-600', 'badge' => 'bg-orange-100 text-orange-700', 'label' => 'Ulasan'],
                            ];
                            $style = $cfg[$type] ?? $cfg['order'];
                            $notifId = $notif->notif_id ?? $notif->id;
                        @endphp

                        <tr class="transition-colors group {{ $isUnread ? 'bg-blue-50/40 hover:bg-blue-50/70 border-l-4 border-blue-500' : 'hover:bg-gray-50/50' }}">

                            {{-- No --}}
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold {{ $isUnread ? 'text-blue-500' : 'text-gray-400' }}">
                                    {{ ($notifications->currentPage() - 1) * $notifications->perPage() + $loop->iteration }}
                                </span>
                            </td>

                            {{-- Notifikasi --}}
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 {{ $style['bg'] }} {{ $style['text'] }} rounded-xl flex items-center justify-center border border-gray-100 shrink-0 {{ $type === 'stock' && $isUnread ? 'animate-pulse' : '' }}">
                                        <i class="fas {{ $style['icon'] }} text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-black leading-none mb-1 {{ $isUnread ? 'text-gray-900' : 'text-gray-500' }}">
                                                {{ $notif->title }}
                                            </p>
                                            @if($isUnread)
                                                <span class="w-2 h-2 bg-blue-500 rounded-full inline-block mb-1 shrink-0"></span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-gray-500 leading-relaxed">{{ $notif->message }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Tipe --}}
                            <td class="px-6 py-4">
                                <span class="text-[10px] font-black px-2.5 py-1 rounded-lg uppercase tracking-tighter {{ $style['badge'] }}">
                                    {{ $style['label'] }}
                                </span>
                            </td>

                            {{-- Waktu --}}
                            <td class="px-6 py-4">
                                <p class="text-xs font-semibold text-gray-500">{{ $notif->created_at->diffForHumans() }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">{{ $notif->created_at->format('d M Y, H:i') }}</p>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4">
                                <div class="flex justify-center items-center gap-2">
                                    @if($notif->url && $isUnread)
                                        <a href="{{ route('notifications.read', $notifId) }}"
                                           title="Lihat & Tandai Dibaca"
                                           class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-blue-600 hover:bg-blue-50 transition-all shadow-sm">
                                            <i class="fas fa-arrow-right text-xs"></i>
                                        </a>
                                    @elseif($isUnread)
                                        <form method="POST" action="{{ route('notifications.read', $notifId) }}">
                                            @csrf
                                            <button type="submit" title="Tandai Dibaca"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-green-600 hover:bg-green-50 transition-all shadow-sm">
                                                <i class="fas fa-check text-xs"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 border border-gray-100 text-gray-300" title="Sudah Dibaca">
                                            <i class="fas fa-check-double text-xs"></i>
                                        </span>
                                    @endif

                                    <form id="delete-notif-{{ $notifId }}"
                                          action="{{ route('notifications.destroy', $notifId) }}"
                                          method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button"
                                            onclick="confirmDeleteNotif('{{ $notifId }}')"
                                            title="Hapus"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-red-500 hover:bg-red-50 transition-all shadow-sm">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center mb-1">
                                        <i class="fas fa-bell-slash text-2xl text-gray-300"></i>
                                    </div>
                                    <p class="text-sm font-black text-gray-600">Tidak Ada Notifikasi</p>
                                    <p class="text-xs text-gray-400">
                                        @if($filterType || $filterStatus)
                                            Coba ubah atau reset filter
                                        @else
                                            Semua notifikasi akan muncul di sini
                                        @endif
                                    </p>
                                    @if($filterType || $filterStatus)
                                        <a href="{{ route('notifications.index') }}"
                                           class="mt-2 px-4 py-2 bg-gray-100 text-gray-600 text-xs font-bold rounded-xl hover:bg-gray-200 transition">
                                            Reset Filter
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @include('partials.admin.pagination', ['paginator' => $notifications->withQueryString()])
    </div>
</div>

<script>
    function confirmDeleteNotif(id) {
        Swal.fire({
            title: 'Hapus Notifikasi?',
            text: "Notifikasi ini akan dihapus secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'rounded-xl font-bold px-6 py-2.5',
                cancelButton: 'rounded-xl font-bold px-6 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-notif-' + id).submit();
            }
        });
    }

    function markAllRead() {
        Swal.fire({
            title: 'Tandai Semua Dibaca?',
            text: "Semua notifikasi yang belum dibaca akan ditandai sudah dibaca.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'Ya, Tandai!',
            cancelButtonText: 'Batal',
            customClass: {
                confirmButton: 'rounded-xl font-bold px-6 py-2.5',
                cancelButton: 'rounded-xl font-bold px-6 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("{{ route('notifications.readAll') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) location.reload();
                });
            }
        });
    }
</script>
@endsection