@extends('admin.guest')

@section('content')
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-xl shadow-sm border p-6">
            <h2 class="text-xl font-bold mb-6 border-b pb-4">Rincian Transaksi</h2>
            
            @foreach($order->items as $item)
            <div class="flex justify-between items-center py-4 border-b last:border-0">
                <div class="flex gap-4">
                    <div class="w-16 h-16 bg-gray-100 rounded"></div>
                    <div>
                        <h4 class="font-bold text-gray-900">{{ $item->product->product_name }}</h4>
                        {{-- Info Dimensi Penting untuk Percetakan --}}
                        @if($item->width && $item->height)
                            <p class="text-xs text-gray-500 italic">Custom Size: {{ $item->width }} x {{ $item->height }} cm</p>
                        @endif
                        <p class="text-sm text-gray-600">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                </div>
                <p class="font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
            </div>
            @endforeach

            <div class="mt-8 bg-gray-50 p-6 rounded-xl space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-extrabold border-t pt-3">
                    <span>Total Bayar</span>
                    <span class="text-orange-600">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Script Snap Midtrans --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@endsection