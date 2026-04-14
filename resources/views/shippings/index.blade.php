@extends('admin.member')

@section('member_content')
<div class="max-w-5xl mx-auto px-4 mb-8 space-y-6">

    {{-- Alamat Pengiriman Form --}}
    <div class="bg-white rounded-[1.5rem] shadow-sm border border-neutral-100 overflow-hidden">

        {{-- Header --}}
        <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-8 py-8 flex items-center justify-between relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-10 translate-x-10"></div>
            <div class="absolute bottom-0 left-0 w-20 h-20 bg-black/5 rounded-full translate-y-8 -translate-x-6"></div>

            <div class="relative z-10 flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-map-marked-alt text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-white text-xl font-black italic uppercase tracking-tight leading-none">Buku Alamat</h2>
                    <p class="text-white/70 text-[11px] mt-2 font-medium italic">Kelola lokasi pengiriman Anda</p>
                </div>
            </div>
        </div>

        {{-- Body dengan Scroll --}}
        <div class="overflow-y-auto" style="max-height: calc(100vh - 240px);">
            <div class="p-6 lg:p-8 space-y-6">

                {{-- Action Bar --}}
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3 bg-neutral-50 rounded-xl p-4 border border-neutral-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-1 h-5 bg-primary-600 rounded-full"></div>
                        <span class="text-[10px] font-black text-neutral-900 uppercase tracking-widest">{{ $shippings->count() }} Lokasi Tersimpan</span>
                    </div>
                    
                    <a href="{{ route('shippings.create') }}" 
                       class="w-full sm:w-auto bg-neutral-900 text-white px-5 py-2.5 rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-primary-600 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-plus text-[9px]"></i> 
                        <span>Tambah Alamat</span>
                    </a>
                </div>

                {{-- ADDRESS LIST WITH SCROLLING --}}
                <div class="space-y-3 max-h-[480px] overflow-y-auto pr-1 custom-scrollbar">
                    @forelse($shippings as $ship)
                        <div @class([
                            'group bg-white rounded-xl border transition-all duration-200',
                            'border-primary-600 ring-1 ring-primary-100' => $ship->is_default,
                            'border-neutral-200 hover:border-primary-300' => !$ship->is_default
                        ])>
                            
                            <div class="p-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                                <div class="flex gap-3 items-start w-full">
                                    {{-- Icon --}}
                                    <div @class([
                                        'w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors',
                                        'bg-primary-600 text-white' => $ship->is_default,
                                        'bg-neutral-100 text-neutral-400 group-hover:bg-primary-50 group-hover:text-primary-600' => !$ship->is_default
                                    ])>
                                        <i class="fas fa-location-dot text-sm"></i>
                                    </div>

                                    <div class="space-y-1 flex-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h4 class="font-black text-neutral-900 text-sm uppercase tracking-tight">{{ $ship->recipient_name }}</h4>
                                            
                                            <span class="px-2 py-0.5 bg-primary-50 text-primary-600 text-[9px] font-black uppercase rounded border border-primary-100">
                                                {{ $ship->label ?? 'Alamat' }}
                                            </span>

                                            @if($ship->is_default)
                                                <span class="bg-primary-600 text-white text-[9px] font-black uppercase px-2 py-0.5 rounded shadow-sm">Utama</span>
                                            @endif
                                        </div>

                                        <p class="text-[11px] text-neutral-600 font-medium leading-relaxed">
                                            {{ $ship->address }}, {{ $ship->village->name ?? '' }}, {{ $ship->district->name ?? '' }}, {{ $ship->city->name ?? '' }}
                                            <span class="text-neutral-900 font-bold ml-1">{{ $ship->postal_code }}</span>
                                        </p>

                                        <div class="flex items-center gap-2 text-[10px] text-neutral-500 font-bold">
                                            <i class="fab fa-whatsapp text-emerald-500 text-[10px]"></i>
                                            {{ $ship->recipient_phone }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex items-center gap-2 w-full md:w-auto md:pl-4 md:border-l border-neutral-100">
                                    <a href="{{ route('shippings.edit', $ship->shipping_id) }}" 
                                       class="flex-1 md:flex-none px-3 py-2 bg-neutral-50 text-neutral-500 rounded-xl hover:bg-neutral-900 hover:text-white transition-all text-center border border-neutral-100">
                                        <i class="fas fa-pen text-[11px]"></i>
                                    </a>
                                    
                                    @if(!$ship->is_default)
                                        <form action="{{ route('shippings.destroy', $ship->shipping_id) }}" method="POST" class="flex-1 md:flex-none">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus alamat ini?')" 
                                                    class="w-full px-3 py-2 bg-white text-red-400 border border-red-100 rounded-xl hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                                                <i class="fas fa-trash-can text-[11px]"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-neutral-50 rounded-xl border-2 border-dashed border-neutral-200">
                            <i class="fas fa-map-marked-alt text-neutral-300 text-3xl mb-3"></i>
                            <p class="text-neutral-400 text-[11px] font-bold uppercase italic tracking-widest">Belum ada alamat tersimpan</p>
                            <p class="text-neutral-300 text-[9px] mt-1">Klik "Tambah Alamat" untuk menambahkan</p>
                        </div>
                    @endforelse
                </div>

                {{-- Info Footer --}}
                <div class="pt-4 border-t border-neutral-100 flex items-center gap-2">
                    <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full"></div>
                    <p class="text-[9px] text-neutral-400 font-bold uppercase tracking-widest">
                        Alamat tersimpan akan tersedia saat checkout
                    </p>
                </div>

            </div>
        </div>
    </div>

    {{-- Shortcut Card Kembali ke Profil --}}
    <a href="{{ route('profile.edit') }}"
       class="block bg-white rounded-[1.5rem] shadow-sm border border-neutral-100 overflow-hidden hover:border-primary-200 transition-all group">
        <div class="p-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-primary-50 border border-primary-100 rounded-xl flex items-center justify-center group-hover:bg-primary-600 transition-all">
                    <i class="fas fa-user-gear text-primary-600 group-hover:text-white transition-all text-lg"></i>
                </div>
                <div>
                    <h4 class="text-[12px] font-black text-neutral-800 uppercase tracking-tight">Kembali ke Profil</h4>
                    <p class="text-[10px] text-neutral-400 font-medium mt-0.5 italic">Kelola identitas akun Anda</p>
                </div>
            </div>
            <div class="flex items-center gap-1.5 text-neutral-400 group-hover:text-primary-600 transition-all font-black text-[10px] uppercase tracking-widest">
                <span class="hidden md:inline">Buka</span>
                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </div>
        </div>
    </a>

</div>
@endsection

@push('styles')
<style>
    /* Styling Scrollbar Minimalis */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #2563eb;
    }
</style>
@endpush