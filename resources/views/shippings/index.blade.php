@extends('layouts.member')

@section('member_content')
    {{-- Container Utama: Lebih ramping (max-w-5xl) --}}
    <div class="max-w-5xl mx-auto px-4 mb-6">
        <div class="bg-white rounded-[1.25rem] shadow-sm border border-neutral-100 overflow-hidden">
            
            {{-- Header: Compact Version --}}
            <div class="bg-gradient-to-br from-primary-600 to-secondary-600 px-6 py-5 flex items-center justify-between relative">
                <div class="relative z-10">
                    <h2 class="text-white text-lg font-black italic uppercase tracking-tight">Buku Alamat</h2>
                    <p class="text-white/70 text-[10px] mt-0.5 font-medium italic">Kelola lokasi pengiriman Anda</p>
                </div>
                <div class="w-9 h-9 bg-white/10 backdrop-blur-md border border-white/20 rounded-lg flex items-center justify-center relative z-10">
                    <i class="fas fa-map-marked-alt text-white text-sm"></i>
                </div>
            </div>

            <div class="p-4 lg:p-5 space-y-4">

                {{-- Action Bar: Ultra Thin --}}
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3 bg-neutral-50 rounded-xl p-3 border border-neutral-100">
                    <div class="flex items-center gap-2.5">
                        <div class="w-1 h-5 bg-primary-600 rounded-full"></div>
                        <span class="text-[10px] font-black text-neutral-900 uppercase tracking-widest">{{ $shippings->count() }} Lokasi Tersimpan</span>
                    </div>
                    
                    <a href="{{ route('shippings.create') }}" class="w-full sm:w-auto bg-neutral-900 text-white px-4 py-2 rounded-lg font-black uppercase tracking-widest text-[9px] hover:bg-primary-600 transition-all flex items-center justify-center gap-2">
                        <i class="fas fa-plus text-[8px]"></i> Tambah
                    </a>
                </div>

                {{-- ADDRESS LIST WITH SCROLLING --}}
                {{-- Set max-h (misal 450px) dan overflow-y-auto untuk scroll internal --}}
                <div class="pr-1 space-y-2.5 max-h-[450px] overflow-y-auto custom-scrollbar">
                    @forelse($shippings as $ship)
                        <div @class([
                            'group bg-white rounded-xl border transition-all duration-200',
                            'border-primary-600 ring-1 ring-primary-50' => $ship->is_default,
                            'border-neutral-100 hover:border-neutral-300' => !$ship->is_default
                        ])>
                            
                            <div class="p-3 flex flex-col md:flex-row justify-between items-center gap-3">
                                <div class="flex gap-3 items-start w-full">
                                    {{-- Icon: Small --}}
                                    <div @class([
                                        'w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 transition-colors',
                                        'bg-primary-600 text-white' => $ship->is_default,
                                        'bg-neutral-100 text-neutral-400 group-hover:bg-primary-50 group-hover:text-primary-600' => !$ship->is_default
                                    ])>
                                        <i class="fas fa-location-dot text-xs"></i>
                                    </div>

                                    <div class="space-y-0.5 flex-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <h4 class="font-black text-neutral-900 text-[12px] uppercase tracking-tight">{{ $ship->recipient_name }}</h4>
                                            
                                            <span class="px-1.5 py-0.5 bg-primary-50 text-primary-600 text-[8px] font-black uppercase rounded border border-primary-100">
                                                {{ $ship->label ?? 'Alamat' }}
                                            </span>

                                            @if($ship->is_default)
                                                <span class="bg-primary-600 text-white text-[8px] font-black uppercase px-1.5 py-0.5 rounded shadow-sm italic">Utama</span>
                                            @endif
                                        </div>

                                        <p class="text-[10px] text-neutral-500 font-medium leading-normal line-clamp-1 group-hover:line-clamp-none transition-all">
                                            {{ $ship->address }}, {{ $ship->village->name ?? '' }}, {{ $ship->district->name ?? '' }}, {{ $ship->city->name ?? '' }} 
                                            <span class="text-neutral-900 font-bold ml-1">{{ $ship->postal_code }}</span>
                                        </p>

                                        <div class="flex items-center gap-2 text-[9px] text-neutral-400 font-bold">
                                            <i class="fab fa-whatsapp text-emerald-500"></i>
                                            {{ $ship->recipient_phone }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Action Buttons: Row Layout --}}
                                <div class="flex items-center gap-1.5 w-full md:w-auto md:pl-4 md:border-l border-neutral-100">
                                    <a href="{{ route('shippings.edit', $ship->shipping_id) }}" 
                                       class="flex-1 md:flex-none p-2 bg-neutral-50 text-neutral-400 rounded-lg hover:bg-neutral-900 hover:text-white transition-all text-center border border-neutral-100">
                                        <i class="fas fa-pen text-[10px]"></i>
                                    </a>
                                    
                                    @if(!$ship->is_default)
                                        <form action="{{ route('shippings.destroy', $ship->shipping_id) }}" method="POST" class="flex-1 md:flex-none">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Hapus?')" 
                                                    class="w-full p-2 bg-white text-red-300 border border-red-50 rounded-lg hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                                                <i class="fas fa-trash-can text-[10px]"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-neutral-50 rounded-xl border-2 border-dashed border-neutral-100">
                            <i class="fas fa-map-marked-alt text-neutral-200 text-xl mb-2"></i>
                            <p class="text-neutral-400 text-[10px] font-bold uppercase italic tracking-widest">Kosong</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Styling Scrollbar agar Minimalis */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0; /* neutral-200 */
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #2563eb; /* primary-600 */
    }
</style>
@endpush