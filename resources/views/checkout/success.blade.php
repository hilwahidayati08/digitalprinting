@extends('admin.guest')

@section('title', 'Pesanan Berhasil - PrintDigital')

@section('content')
<section class="py-16 bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen flex items-center">
    <div class="container mx-auto px-4 max-w-2xl">
        
        {{-- Success Card --}}
        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-white">
            
            {{-- Header Dekoratif --}}
            <div class="h-3 bg-blue-600"></div>

            <div class="p-8 md:p-12 text-center">
                {{-- Icon Checkmark Animated --}}
                <div class="relative w-24 h-24 mx-auto mb-8">
                    <div class="absolute inset-0 bg-blue-100 rounded-full animate-ping opacity-25"></div>
                    <div class="relative w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center shadow-lg shadow-blue-200">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                
                {{-- Title --}}
                <h1 class="text-3xl md:text-4xl font-black text-gray-900 mb-3 tracking-tight">
                    Yeay! Pesanan Diterima
                </h1>
                <p class="text-gray-500 mb-8 px-4">
                    Pesanan Anda sedang kami proses. Detail transaksi telah kami kirimkan ke email Anda.
                </p>

                {{-- Order Summary Box --}}
                <div class="bg-gray-50 rounded-3xl p-6 mb-10 border border-gray-100">
                    <div class="grid grid-cols-2 gap-y-4 text-left">
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">No. Invoice</p>
                            <p class="font-mono font-bold text-gray-800">#{{ $order->order_number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Metode</p>
                            <p class="font-bold text-gray-800 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                        </div>
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Status</p>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[11px] font-black uppercase italic">
                                Paid / Terverifikasi
                            </span>
                        </div>
                        <div class="text-right pt-4 border-t border-gray-200">
                            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-1">Total Bayar</p>
                            <p class="font-black text-blue-600 text-xl">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                {{-- Action Buttons --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('orders.index') }}" 
                       class="flex items-center justify-center gap-2 px-8 py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-black transition-all shadow-lg active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Lihat Pesanan
                    </a>
                    <a href="{{ route('home') }}" 
                       class="flex items-center justify-center gap-2 px-8 py-4 bg-white border-2 border-gray-200 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 transition-all active:scale-95">
                        Kembali Beranda
                    </a>
                </div>
                
                {{-- Customer Support --}}
                <div class="mt-12 pt-8 border-t border-gray-100">
                    <p class="text-sm text-gray-400 mb-4">Butuh bantuan cepat terkait pesanan ini?</p>
                    <div class="flex justify-center gap-6">
                        <a href="https://wa.me/6281234567890" class="flex items-center gap-2 text-sm font-bold text-green-600 hover:text-green-700">
                            <i class="fab fa-whatsapp text-lg"></i> WhatsApp
                        </a>
                        <a href="mailto:support@printdigital.com" class="flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-700">
                            <i class="far fa-envelope text-lg"></i> Email Support
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Note --}}
        <p class="text-center text-gray-400 text-xs mt-8">
            &copy; 2026 PrintDigital. Semua transaksi dilindungi dan dienkripsi secara aman.
        </p>
    </div>
</section>
@endsection