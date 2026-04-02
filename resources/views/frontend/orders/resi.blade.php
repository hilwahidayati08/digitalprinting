<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        /* Ukuran thermal 100x150mm */
        @page { margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Helvetica', 'Arial', sans-serif; }
        
        body { 
            width: 100mm; 
            padding: 4mm; 
            background: #fff;
            color: #000;
        }

        .border-main {
            border: 2px solid #000;
            padding: 1px;
            min-height: 140mm;
        }

        /* HEADER */
        .header {
            display: table;
            width: 100%;
            border-bottom: 2px solid #000;
            padding: 5px 0;
        }
        .header-left { display: table-cell; width: 45%; vertical-align: middle; padding-left: 5px; }
        .header-right { display: table-cell; width: 55%; text-align: right; vertical-align: middle; padding-right: 5px; }
        
        .logo-shop { font-size: 16px; font-weight: bold; color: #ee4d2d; text-transform: uppercase; }
        .logo-expres { font-size: 20px; font-weight: 900; font-style: italic; color: #000; }

        /* BARCODE AREA */
        .barcode-box {
            text-align: center;
            padding: 8px 0;
            border-bottom: 2px dashed #000;
        }
        .sortir-info {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }
        .sortir-code { 
            display: table-cell; 
            font-size: 14px; 
            font-weight: bold; 
            padding: 5px;
            text-align: center;
            border: 1.5px solid #000;
            background: #f0f0f0;
        }
        .barcode-img {
            margin: 8px 0;
            width: 85%;
            height: 60px;
        }
        .resi-number { font-size: 14px; font-weight: bold; letter-spacing: 1.5px; margin-top: 2px; }

        /* ALAMAT */
        .address-section {
            display: table;
            width: 100%;
            border-bottom: 1.5px solid #000;
        }
        .addr-col {
            display: table-cell;
            width: 55%;
            padding: 8px 5px;
            vertical-align: top;
            font-size: 11px;
            line-height: 1.3;
        }
        .addr-col.sender { width: 45%; border-left: 1.5px solid #000; }
        .label { font-weight: bold; font-size: 12px; display: block; margin-bottom: 3px; }
        .badge-home {
            display: inline-block;
            border: 1px solid #000;
            padding: 1px 4px;
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 4px;
        }

        /* INFO BAR */
        .info-bar {
            display: table;
            width: 100%;
            border-bottom: 1.5px solid #000;
            font-size: 11px;
        }
        .info-item {
            display: table-cell;
            padding: 6px;
            border-right: 1px solid #000;
            text-align: center;
            vertical-align: middle;
        }

        /* CASHLESS SECTION */
        .cashless-row {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 5px;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 3px;
        }

        /* TABLE PRODUK */
        .product-list {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-top: 5px;
        }
        .product-list th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding: 5px 2px;
            text-transform: uppercase;
        }
        .product-list td {
            padding: 5px 2px;
            border-bottom: 1px dashed #ccc;
            vertical-align: top;
        }

        .footer {
            font-size: 9px;
            margin-top: 8px;
            padding: 5px;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>

<div class="border-main">
    <div class="header">
        <div class="header-left">
            <span class="logo-shop">S Shopee</span>
        </div>
        <div class="header-right">
            <span class="logo-expres">ID EXPRESS</span>
        </div>
    </div>

    <div class="barcode-box">
        <div class="sortir-info">
            <div class="sortir-code">
                {{-- Logika Kode Sortir: Ambil 3 Huruf Depan Kota & Kecamatan --}}
                {{ strtoupper(substr($order->shipping?->city?->name ?? 'BKI', 0, 3)) }}-{{ strtoupper(substr($order->shipping?->district?->name ?? 'KEC', 0, 3)) }}
            </div>
        </div>
        
        {{-- API Barcode menggunakan Order Number --}}
        <img class="barcode-img" src="https://bwipjs-api.metafloor.com/?bcid=code128&text={{ $order->order_number }}&scale=3&rotate=N&includetext=false" alt="Barcode">
        
        <p class="resi-number">{{ $order->order_number }}</p>
    </div>

    <div class="address-section">
        <div class="addr-col">
            <span class="label">Penerima: {{ $order->shipping?->recipient_name ?? $order->user->username }}</span>
            <div class="badge-home">HOME</div>
            <p><strong>{{ $order->user->whatsapp ?? $order->user->userphone ?? '-' }}</strong></p>
            <p>{{ $order->shipping_address }}</p>
            <p>RT.{{ $order->shipping?->rt ?? '0' }}/RW.{{ $order->shipping?->rw ?? '0' }}, 
               {{ $order->shipping?->village?->name ?? '' }}, 
               {{ $order->shipping?->district?->name ?? '' }}</p>
            <p>{{ $order->shipping?->city?->name ?? '' }}, {{ $order->shipping?->province?->name ?? '' }}</p>
        </div>
        <div class="addr-col sender">
            <span class="label">Pengirim:</span>
            <p><strong>{{ $settings->shop_name ?? 'Choki' }}</strong></p>
            <p>{{ $settings->whatsapp ?? '6282111117711' }}</p>
            <p>{{ $settings->city ?? 'JAKARTA SELATAN' }}</p>
        </div>
    </div>

    <div class="info-bar">
        <div class="info-item"><strong>Berat:</strong><br>100 gr</div>
        <div class="info-item"><strong>COD:</strong><br>Rp 0</div>
        <div class="info-item" style="border-right:none;">
            <strong>Batas Kirim:</strong><br>
            {{-- Menggunakan logic created_at + 2 hari dari controller --}}
            {{ $order->created_at->addDays(2)->format('d-m-Y') }}
        </div>
    </div>

    <div class="cashless-row">CASHLESS</div>

    <table class="product-list">
        <thead>
            <tr>
                <th width="60%">Nama Produk</th>
                <th width="25%">Variasi</th>
                <th width="15%" style="text-align: center;">Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->product_name ?? 'Produk' }}</td>
                <td>{{ $item->notes ?? 'Default' }}</td>
                <td style="text-align: center;">{{ $item->qty }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <strong>Pesan:</strong> ({{ $order->order_number }}) Silakan hubungi seller jika ada kendala produk.
    </div>
</div>

</body>
</html>