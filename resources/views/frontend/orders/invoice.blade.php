<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Faktur #{{ $order->order_number }}</title>
    <style>
        @page { margin: 20px; }
        body { 
            font-family: 'Courier', monospace; 
            font-size: 11px; color: #000; line-height: 1.4; 
        }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .line { border-top: 2px solid #000; margin: 5px 0; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        
        /* Table Items */
        .item-table th { 
            border-top: 2px solid #000; border-bottom: 2px solid #000; 
            padding: 8px 5px; text-align: left; 
        }
        .item-table td { padding: 8px 5px; vertical-align: top; border-bottom: 0.5px solid #eee; }
        
        /* Styling Ukuran Orange */
        .product-name { font-weight: bold; font-size: 12px; display: block; }
        .product-size { color: #ea580c; font-weight: bold; font-size: 9px; text-transform: uppercase; }
        
        .footer-container { margin-top: 20px; }
        .terbilang-box { float: left; width: 55%; border: 1px solid #000; padding: 10px; font-style: italic; }
        .total-box { float: right; width: 40%; }
        .total-box td { padding: 2px 5px; }
    </style>
</head>
<body>
    <table>
        <tr>
            <td class="bold" style="font-size: 16px;">FAKTUR</td>
            <td class="text-right bold" style="font-size: 14px;">PT. PRINTPRO JAYA</td>
        </tr>
    </table>
    <div class="line"></div>

    <table style="margin-bottom: 20px;">
        <tr>
            <td width="15%">Nomor</td><td width="35%">: {{ $order->order_number }}</td>
            <td width="15%">Tanggal</td><td width="35%">: {{ $order->created_at->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Kepada</td><td>: {{ $order->user->username ?? 'Pelanggan' }}</td>
            <td>Metode</td><td>: {{ strtoupper($order->payment_method) }}</td>
        </tr>
    </table>

    <table class="item-table">
        <thead>
            <tr>
                <th>Nama Barang / Pesanan</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Satuan</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Sub Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    <span class="product-name">{{ $item->product->product_name ?? 'Produk' }}</span>
                    
                    <div class="product-size">
                        @php
                            // LOGIKA FALLBACK: Ambil dari item, kalau kosong ambil dari master produk
                            $w = $item->width_cm > 0 ? $item->width_cm : ($item->product->default_width_cm ?? 0);
                            $h = $item->height_cm > 0 ? $item->height_cm : ($item->product->default_height_cm ?? 0);
                        @endphp

                        @if($w > 0 && $h > 0)
                            {{ number_format($w, 2) }}X{{ number_format($h, 2) }} CM
                            @if($item->used_material_qty > 0)
                                • {{ $item->used_material_qty }} METER
                            @endif
                        @else
                            UKURAN STANDAR
                        @endif
                    </div>
                </td>
                <td class="text-center">{{ $item->qty }}</td>
                <td class="text-center">{{ $item->product->unit->unit_name ?? 'Pcs' }}</td>
                <td class="text-right">{{ number_format($item->unit_price ?? $item->price, 2) }}</td>
                <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-container">
        <div class="terbilang-box">
            {{-- Fungsi terbilang singkat --}}
            @php
                function kurensi($n) {
                    $b = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
                    if ($n < 12) return " " . $b[$n];
                    elseif ($n < 20) return kurensi($n - 10) . " Belas";
                    elseif ($n < 100) return kurensi($n / 10) . " Puluh" . kurensi($n % 10);
                    elseif ($n < 200) return " Seratus" . kurensi($n - 100);
                    elseif ($n < 1000) return kurensi($n / 100) . " Ratus" . kurensi($n % 100);
                    elseif ($n < 2000) return " Seribu" . kurensi($n - 1000);
                    elseif ($n < 1000000) return kurensi($n / 1000) . " Ribu" . kurensi($n % 1000);
                    elseif ($n < 1000000000) return kurensi($n / 1000000) . " Juta" . kurensi($n % 1000000);
                    return "";
                }
            @endphp
            {{ kurensi($order->total) }} Rupiah
        </div>

        <table class="total-box">
            <tr><td>Pajak (PPN) :</td><td class="text-right">{{ number_format($order->tax, 2) }}</td></tr>
            <tr><td>Biaya Kirim :</td><td class="text-right">{{ number_format($order->shipping_cost, 2) }}</td></tr>
            <tr class="bold">
                <td style="border-top:1px solid #000">Total :</td>
                <td class="text-right" style="border-top:1px solid #000; font-size:14px;">Rp {{ number_format($order->total, 2) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>