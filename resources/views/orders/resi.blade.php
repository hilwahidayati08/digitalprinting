<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resi #{{ $order->order_number }}</title>
    <style>
        /* ─── RESET ──────────────────────────────────────────── */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page {
            margin: 0;
            size: 100mm 150mm;
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica', Arial, sans-serif;
            font-size: 10px;
            color: #1a1a1a;
            background: #fff;
            width: 100mm;
        }

        /* ─── OUTER BORDER ───────────────────────────────────── */
        .resi-wrap {
            border: 1.5px solid #1a1a1a;
            width: 100%;
            min-height: 146mm;
        }

        /* ─── TOP HEADER ─────────────────────────────────────── */
        .top-header {
            display: table;
            width: 100%;
            border-bottom: 1.5px solid #1a1a1a;
        }
        .top-header-left {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
            padding: 7px 9px;
            border-right: 1px solid #1a1a1a;
        }
        .top-header-right {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
            padding: 7px 9px;
            text-align: right;
        }

        .logo-toko {
            font-size: 14px;
            font-weight: 900;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            line-height: 1;
        }
        .logo-toko span { color: #777; font-weight: 400; }
        .logo-sub {
            font-size: 7px;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }

        .kurir-name {
            font-size: 15px;
            font-weight: 900;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: -0.5px;
            line-height: 1;
        }
        .kurir-type {
            font-size: 7px;
            color: #aaa;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }

        /* ─── BARCODE SECTION ────────────────────────────────── */
        .barcode-section {
            border-bottom: 1.5px dashed #888;
            padding: 8px 9px;
            text-align: center;
        }
        .sortir-row {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }
        .sortir-cell { display: table-cell; vertical-align: middle; }
        .sortir-code {
            display: inline-block;
            border: 1px solid #1a1a1a;
            padding: 3px 10px;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 1px;
            background: #f5f5f5;
        }
        .sortir-method {
            display: table-cell;
            vertical-align: middle;
            text-align: right;
            font-size: 8px;
            font-weight: 700;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .barcode-img {
            width: 82%;
            height: 50px;
            display: block;
            margin: 0 auto 5px;
        }
        .resi-number {
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 2px;
            color: #1a1a1a;
        }

        /* ─── ADDRESS SECTION ────────────────────────────────── */
        .address-section {
            display: table;
            width: 100%;
            border-bottom: 1px solid #1a1a1a;
        }
        .addr-recipient {
            display: table-cell;
            width: 57%;
            padding: 8px 9px;
            vertical-align: top;
            border-right: 1px solid #1a1a1a;
        }
        .addr-sender {
            display: table-cell;
            width: 43%;
            padding: 8px 9px;
            vertical-align: top;
        }

        .addr-title {
            font-size: 7.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 5px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e0e0e0;
        }
        .addr-name {
            font-size: 12px;
            font-weight: 900;
            color: #1a1a1a;
            line-height: 1.1;
            margin-bottom: 3px;
        }
        .addr-phone {
            font-size: 9px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 4px;
        }
        .home-badge {
            display: inline-block;
            border: 1px solid #1a1a1a;
            padding: 1px 5px;
            font-size: 7.5px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .addr-detail {
            font-size: 8.5px;
            color: #444;
            line-height: 1.5;
        }
        .addr-city {
            font-size: 9px;
            font-weight: 700;
            color: #1a1a1a;
            margin-top: 3px;
        }

        /* ─── INFO BAR ───────────────────────────────────────── */
        .info-bar {
            display: table;
            width: 100%;
            border-bottom: 1px solid #1a1a1a;
        }
        .info-cell {
            display: table-cell;
            text-align: center;
            padding: 5px 4px;
            border-right: 1px solid #ccc;
            vertical-align: middle;
        }
        .info-cell:last-child { border-right: none; }
        .info-cell-label {
            font-size: 7px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #aaa;
            display: block;
        }
        .info-cell-value {
            font-size: 10px;
            font-weight: 900;
            color: #1a1a1a;
            display: block;
            margin-top: 2px;
        }

        /* ─── PAYMENT STRIP ──────────────────────────────────── */
        .payment-strip {
            text-align: center;
            padding: 5px 0;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 4px;
            text-transform: uppercase;
            border-bottom: 1px solid #1a1a1a;
            border-top: 1px solid #e0e0e0;
            color: #1a1a1a;
        }

        /* ─── PRODUCT TABLE ──────────────────────────────────── */
        .product-section {
            padding: 7px 9px;
            border-bottom: 1px solid #e0e0e0;
        }
        .product-title {
            font-size: 7.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 5px;
            padding-bottom: 4px;
            border-bottom: 1px solid #1a1a1a;
        }

        table.prod-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        table.prod-table th {
            padding: 3px 2px;
            text-align: left;
            border-bottom: 1px solid #ccc;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #888;
        }
        table.prod-table td {
            padding: 3px 2px;
            border-bottom: 1px dashed #e0e0e0;
            vertical-align: top;
            color: #1a1a1a;
        }
        table.prod-table td:last-child { text-align: center; }
        table.prod-table th:last-child { text-align: center; }
        .prod-name { font-weight: 700; }
        .prod-size { font-size: 7.5px; color: #888; font-weight: 700; text-transform: uppercase; }

        /* ─── FOOTER ─────────────────────────────────────────── */
        .resi-footer { padding: 6px 9px; }
        .footer-order {
            font-size: 7.5px;
            color: #777;
            line-height: 1.6;
        }
        .footer-note {
            font-size: 7.5px;
            color: #aaa;
            margin-top: 3px;
            font-style: italic;
        }
    </style>
</head>
<body>

@php
    $shipping    = $order->shipping ?? null;
    $recipientName  = $shipping?->recipient_name ?? $order->user->full_name ?? $order->user->username;
    $recipientPhone = $shipping?->recipient_phone ?? $order->user->no_telp ?? '-';

    $village    = $shipping?->village?->name  ?? '';
    $district   = $shipping?->district?->name ?? '';
    $city       = $shipping?->city?->name     ?? '';
    $province   = $shipping?->province?->name ?? '';
    $rt         = $shipping?->rt ?? '0';
    $rw         = $shipping?->rw ?? '0';
    $postalCode = $shipping?->postal_code ?? '';

    $sortirCity = strtoupper(substr($city     ?: 'BKI', 0, 3));
    $sortirDist = strtoupper(substr($district ?: 'KEC', 0, 3));
    $totalItems = $order->items->sum('qty');

    $kurirDisplay = $order->kurir_name ?? match($order->shipping_method) {
        'gojek'     => 'GOJEK/GRAB',
        'ekspedisi' => 'EKSPEDISI',
        'pickup'    => 'PICKUP',
        default     => 'ID EXPRESS',
    };

    $isCod    = ($order->payment_method === 'cod');
    $estimasi = $order->estimated_arrival
        ? \Carbon\Carbon::parse($order->estimated_arrival)->format('d-m-Y')
        : $order->created_at->addDays(3)->format('d-m-Y');
        
//akumulasi 1 pcs 100gram
    $totalWeight = $order->items->sum(fn($i) => ($i->qty ?? 1) * 100);
@endphp

<div class="resi-wrap">

    {{-- ── TOP HEADER ─────────────────────────────────────── --}}
    <div class="top-header">
        <div class="top-header-left">
            <div class="logo-toko">Cetak<span>Kilat</span></div>
        </div>
        <div class="top-header-right">
            <div class="kurir-name">{{ $kurirDisplay }}</div>
            <div class="kurir-type">
                @if($order->shipping_method === 'pickup') Ambil di Toko
                @elseif($order->shipping_method === 'gojek') Same Day / Instan
                @else Regular Express
                @endif
            </div>
        </div>
    </div>

    {{-- ── BARCODE ──────────────────────────────────────────── --}}
    <div class="barcode-section">
        <div class="sortir-row">
            <div class="sortir-cell">
                <span class="sortir-code">{{ $sortirCity }}-{{ $sortirDist }}</span>
            </div>
            <div class="sortir-method">
                @if($order->shipping_method === 'gojek') Same Day
                @elseif($order->shipping_method === 'pickup') Pickup
                @else Ekspedisi
                @endif
            </div>
        </div>

        <img class="barcode-img"
            src="https://bwipjs-api.metafloor.com/?bcid=code128&text={{ $order->order_number }}&scale=3&rotate=N&includetext=false&backgroundcolor=ffffff"
            alt="Barcode {{ $order->order_number }}">

        <div class="resi-number">{{ $order->order_number }}</div>
    </div>

    {{-- ── ALAMAT ───────────────────────────────────────────── --}}
    <div class="address-section">
        <div class="addr-recipient">
            <div class="addr-title">Penerima</div>
            <div class="addr-name">{{ $recipientName }}</div>
            <div class="addr-phone">{{ $recipientPhone }}</div>
            @if($order->shipping_method !== 'pickup')
                <span class="home-badge">HOME</span>
                <div class="addr-detail">
                    {{ $order->shipping_address }}
                    @if($rt !== '0' || $rw !== '0')
                        <br>RT.{{ $rt }}/RW.{{ $rw }}
                        @if($village), {{ $village }}@endif
                        @if($district), {{ $district }}@endif
                    @endif
                </div>
                <div class="addr-city">
                    {{ $city }}@if($province), {{ $province }}@endif
                    @if($postalCode) {{ $postalCode }}@endif
                </div>
            @else
                <div class="addr-detail" style="font-weight:700">Ambil langsung di toko</div>
            @endif
        </div>
        <div class="addr-sender">
            <div class="addr-title">Pengirim</div>
            <div class="addr-name">{{ $settings->store_name ?? 'CetakKilat Jaya' }}</div>
            <div class="addr-phone">{{ $settings->whatsapp ?? '6282111117711' }}</div>
            <div class="addr-detail">
                {{ $settings->address ?? 'Jl. Raya Printing No.88' }}<br>
                {{ $settings->city ?? 'Depok, Jawa Barat' }}
            </div>
        </div>
    </div>

    {{-- ── INFO BAR ─────────────────────────────────────────── --}}
    <div class="info-bar">
        <div class="info-cell">
            <span class="info-cell-label">Total Barang</span>
            <span class="info-cell-value">{{ $totalItems }} Pcs</span>
        </div>
        <div class="info-cell">
            <span class="info-cell-label">Est. Berat</span>
            <span class="info-cell-value">{{ $totalWeight }} gr</span>
        </div>
        <div class="info-cell">
            <span class="info-cell-label">Batas Kirim</span>
            <span class="info-cell-value">{{ $estimasi }}</span>
        </div>
    </div>

    {{-- ── PAYMENT STRIP ────────────────────────────────────── --}}
    <div class="payment-strip">
        {{ $isCod ? 'COD — BAYAR DI TEMPAT' : 'CASHLESS' }}
    </div>

    {{-- ── DAFTAR PRODUK ────────────────────────────────────── --}}
    <div class="product-section">
        <div class="product-title">Daftar Isi Paket</div>
        <table class="prod-table">
            <thead>
                <tr>
                    <th style="width:50%">Nama Produk</th>
                    <th style="width:33%">Ukuran / Spek</th>
                    <th style="width:17%">Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                @php
                    $w = $item->width_cm  > 0 ? $item->width_cm  : ($item->product->default_width_cm  ?? 0);
                    $h = $item->height_cm > 0 ? $item->height_cm : ($item->product->default_height_cm ?? 0);
                @endphp
                <tr>
                    <td>
                        <span class="prod-name">{{ Str::limit($item->product->product_name ?? 'Produk', 28) }}</span>
                    </td>
                    <td>
                        @if($w > 0 && $h > 0)
                            <span class="prod-size">{{ number_format($w,0) }} × {{ number_format($h,0) }} cm</span>
                        @else
                            <span style="color:#bbb;font-size:8px">Standar</span>
                        @endif
                        @if($item->notes)
                            <span style="display:block;font-size:7.5px;color:#aaa;font-style:italic">{{ Str::limit($item->notes, 20) }}</span>
                        @endif
                    </td>
                    <td>{{ $item->qty }} {{ $item->product->unit->unit_name ?? 'pcs' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ── FOOTER ───────────────────────────────────────────── --}}
    <div class="resi-footer">
        <div class="footer-order">
            <strong>No. Pesanan:</strong> {{ $order->order_number }}<br>
            <strong>Tgl. Order:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
            @if($order->tracking_number)
                &nbsp;|&nbsp;<strong>Tracking:</strong> {{ $order->tracking_number }}
            @endif
        </div>
        <div class="footer-note">
            Hubungi seller jika ada kendala dengan produk yang diterima.
        </div>
    </div>

</div>
</body>
</html>