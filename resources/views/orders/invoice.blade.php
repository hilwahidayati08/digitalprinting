<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        /* ─── RESET & BASE ─────────────────────────────────── */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { margin: 0; size: A4 portrait; }

        body {
            font-family: 'DejaVu Sans', 'Helvetica', Arial, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #fff;
            width: 210mm;
        }

        /* ─── HEADER ─────────────────────────────────────────── */
        .inv-head {
            padding: 32px 40px 24px;
            border-bottom: 1px solid #e0e0e0;
            display: table;
            width: 100%;
        }
        .inv-head-left  { display: table-cell; vertical-align: bottom; width: 55%; }
        .inv-head-right { display: table-cell; vertical-align: bottom; text-align: right; width: 45%; }

        .brand-name {
            font-size: 22px;
            font-weight: 900;
            color: #1a1a1a;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        .brand-name span { color: #666; font-weight: 400; }
        .brand-tagline {
            font-size: 9px;
            color: #999;
            margin-top: 4px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .inv-label {
            font-size: 10px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .inv-number {
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
            margin-top: 3px;
            letter-spacing: 0.5px;
        }

        /* ─── META ROW ───────────────────────────────────────── */
        .meta-row {
            display: table;
            width: 100%;
            padding: 18px 40px;
            border-bottom: 1px solid #e0e0e0;
            background: #fafafa;
        }
        .meta-col {
            display: table-cell;
            vertical-align: top;
            width: 25%;
            padding-right: 12px;
        }
        .meta-label {
            font-size: 8px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .meta-value {
            font-size: 11px;
            font-weight: 700;
            color: #1a1a1a;
        }
        .status-pill {
            display: inline-block;
            padding: 2px 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #555;
        }

        /* ─── PARTIES ────────────────────────────────────────── */
        .parties-row {
            display: table;
            width: 100%;
            padding: 22px 40px;
            border-bottom: 1px solid #e0e0e0;
        }
        .party-col { display: table-cell; vertical-align: top; width: 50%; }
        .party-col.right { padding-left: 28px; }

        .party-title {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #999;
            font-weight: 700;
            margin-bottom: 10px;
            padding-bottom: 7px;
            border-bottom: 1px solid #e0e0e0;
        }
        .party-name {
            font-size: 13px;
            font-weight: 900;
            color: #1a1a1a;
            margin-bottom: 5px;
        }
        .party-detail {
            font-size: 10px;
            color: #666;
            line-height: 1.7;
        }

        /* ─── TABLE ──────────────────────────────────────────── */
        .table-wrap {
            padding: 0 40px;
            margin-bottom: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead tr { background: #1a1a1a; }
        thead th {
            padding: 10px 10px;
            font-size: 8.5px;
            font-weight: 700;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
        }
        thead th.right  { text-align: right; }
        thead th.center { text-align: center; }

        tbody tr { border-bottom: 1px solid #f0f0f0; }
        tbody tr:nth-child(even) { background: #fafafa; }
        tbody td {
            padding: 11px 10px;
            vertical-align: top;
        }
        tbody td.right  { text-align: right; }
        tbody td.center { text-align: center; }

        .item-name  { font-size: 11px; font-weight: 700; color: #1a1a1a; display: block; }
        .item-size  { font-size: 9px; color: #888; display: block; margin-top: 2px; }
        .item-notes { font-size: 9px; color: #aaa; font-style: italic; display: block; margin-top: 2px; }

        /* ─── TOTALS ─────────────────────────────────────────── */
        .totals-section {
            display: table;
            width: 100%;
            padding: 22px 40px 28px;
            border-top: 1px solid #e0e0e0;
        }
        .totals-left  { display: table-cell; vertical-align: top; width: 52%; padding-right: 28px; }
        .totals-right { display: table-cell; vertical-align: top; width: 48%; }

        .terbilang-box {
            border-left: 2px solid #ccc;
            padding-left: 14px;
            margin-bottom: 16px;
        }
        .terbilang-label {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #999;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .terbilang-text {
            font-size: 11px;
            color: #444;
            font-style: italic;
            font-weight: 600;
            line-height: 1.6;
        }

        .payment-info {
            border: 1px solid #e0e0e0;
            padding: 10px 14px;
            margin-top: 12px;
        }
        .payment-label {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #999;
            font-weight: 700;
            margin-bottom: 7px;
        }
        .payment-row { display: table; width: 100%; margin-bottom: 3px; }
        .payment-row-label { display: table-cell; font-size: 10px; color: #666; }
        .payment-row-value { display: table-cell; font-size: 10px; font-weight: 700; color: #1a1a1a; text-align: right; }

        .totals-table { width: 100%; border-collapse: collapse; }
        .totals-table td { padding: 5px 0; font-size: 11px; }
        .totals-table td.label { color: #666; }
        .totals-table td.amount { text-align: right; font-weight: 700; color: #1a1a1a; }
        .totals-table tr.sep td { border-top: 1px solid #e0e0e0; padding-top: 10px; margin-top: 4px; }
        .totals-table tr.total td {
            font-size: 14px;
            font-weight: 900;
            color: #1a1a1a;
            padding-top: 6px;
        }

        /* ─── FOOTER ─────────────────────────────────────────── */
        .footer-bar {
            margin: 0 40px 28px;
            padding-top: 16px;
            border-top: 1px solid #e0e0e0;
            display: table;
            width: calc(100% - 80px);
        }
        .footer-left  { display: table-cell; vertical-align: top; width: 60%; }
        .footer-right { display: table-cell; vertical-align: top; text-align: right; width: 40%; }
        .footer-note  { font-size: 9px; color: #aaa; line-height: 1.8; }
        .footer-note strong { color: #888; }

        .ttd-box { display: inline-block; text-align: center; }
        .ttd-line {
            width: 130px;
            border-bottom: 1px solid #ccc;
            margin: 44px 0 7px;
        }
        .ttd-label {
            font-size: 9px;
            color: #aaa;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ─── WATERMARK ──────────────────────────────────────── */
        .watermark {
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%) rotate(-35deg);
            font-size: 90px;
            font-weight: 900;
            color: rgba(0,0,0,0.04);
            text-transform: uppercase;
            letter-spacing: 8px;
            pointer-events: none;
            z-index: 0;
        }
    </style>
</head>
<body>

@php
    /* ── Fungsi Terbilang ─────────────────────────────── */
    function terbilang($n) {
        $n = (int) abs($n);
        $kata = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima',
                 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        if ($n < 12)         return $kata[$n];
        if ($n < 20)         return terbilang($n - 10) . ' Belas';
        if ($n < 100)        return terbilang(intdiv($n, 10)) . ' Puluh' . ($n % 10 ? ' ' . terbilang($n % 10) : '');
        if ($n < 200)        return 'Seratus' . ($n - 100 > 0 ? ' ' . terbilang($n - 100) : '');
        if ($n < 1000)       return terbilang(intdiv($n, 100)) . ' Ratus' . ($n % 100 ? ' ' . terbilang($n % 100) : '');
        if ($n < 2000)       return 'Seribu' . ($n - 1000 > 0 ? ' ' . terbilang($n - 1000) : '');
        if ($n < 1000000)    return terbilang(intdiv($n, 1000)) . ' Ribu' . ($n % 1000 ? ' ' . terbilang($n % 1000) : '');
        if ($n < 1000000000) return terbilang(intdiv($n, 1000000)) . ' Juta' . ($n % 1000000 ? ' ' . terbilang($n % 1000000) : '');
        return terbilang(intdiv($n, 1000000000)) . ' Miliar' . ($n % 1000000000 ? ' ' . terbilang($n % 1000000000) : '');
    }

    $statusLabels = [
        'paid'         => 'Lunas',
        'pending'      => 'Belum Bayar',
        'processing'   => 'Diproses',
        'ready_pickup' => 'Siap Ambil',
        'shipped'      => 'Dikirim',
        'delivered'    => 'Diterima',
        'completed'    => 'Selesai',
        'cancelled'    => 'Dibatalkan',
    ];
    $badgeLabel = $statusLabels[$order->status] ?? strtoupper($order->status);

    $subtotal     = $order->subtotal      ?? 0;
    $tax          = $order->tax           ?? 0;
    $shippingCost = $order->shipping_cost ?? 0;
    $total        = $order->total         ?? 0;

    $metode = [
        'pickup'    => 'Ambil di Toko',
        'gojek'     => 'Gojek / Grab',
        'ekspedisi' => 'Ekspedisi',
    ];
@endphp

{{-- Watermark LUNAS --}}
@if(in_array($order->status, ['paid','delivered','completed']))
<div class="watermark">LUNAS</div>
@endif

{{-- ── HEADER ─────────────────────────────────────────── --}}
<div class="inv-head">
    <div class="inv-head-left">
        <div class="brand-name">Cetak<span>Kilat</span></div>
        <div class="brand-tagline">Professional Printing Solutions</div>
    </div>
    <div class="inv-head-right">
        <div class="inv-label">Invoice</div>
        <div class="inv-number">{{ $order->order_number }}</div>
    </div>
</div>

{{-- ── META ROW ─────────────────────────────────────────── --}}
<div class="meta-row">
    <div class="meta-col">
        <div class="meta-label">Tanggal Invoice</div>
        <div class="meta-value">{{ $order->created_at->format('d M Y') }}</div>
    </div>
    <div class="meta-col">
        <div class="meta-label">Metode Pembayaran</div>
        <div class="meta-value">{{ strtoupper($order->payment_method ?? '-') }}</div>
    </div>
    <div class="meta-col">
        <div class="meta-label">Metode Pengiriman</div>
        <div class="meta-value">{{ $metode[$order->shipping_method] ?? strtoupper($order->shipping_method ?? '-') }}</div>
    </div>
    <div class="meta-col">
        <div class="meta-label">Status</div>
        <div class="meta-value">
            <span class="status-pill">{{ $badgeLabel }}</span>
        </div>
    </div>
</div>

{{-- ── PARTIES ─────────────────────────────────────────── --}}
<div class="parties-row">
    <div class="party-col">
        <div class="party-title">Dari (Penjual)</div>
        <div class="party-name">CetakKilat Jaya</div>
        <div class="party-detail">
                {{ $settings->address ?? 'Jl. Raya Printing No.88' }}<br>
                {{ $settings->city ?? 'Depok, Jawa Barat' }}
        </div>
    </div>
    <div class="party-col right">
        <div class="party-title">Kepada (Pembeli)</div>
        <div class="party-name">{{ $order->user->full_name ?? $order->user->username ?? 'Pelanggan' }}</div>
        <div class="party-detail">
            @if($order->user->no_telp ?? false)
                {{ $order->user->no_telp }}<br>
            @endif
            @if($order->user->useremail ?? false)
                {{ $order->user->useremail }}<br>
            @endif
            @if($order->shipping_address && $order->shipping_method !== 'pickup')
                {{ $order->shipping_address }}
            @else
                Ambil di Toko (Pickup)
            @endif
        </div>
    </div>
</div>

{{-- ── ITEMS TABLE ─────────────────────────────────────── --}}
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:38%">Nama Produk / Deskripsi</th>
                <th class="center" style="width:14%">Ukuran</th>
                <th class="center" style="width:8%">Qty</th>
                <th class="center" style="width:10%">Satuan</th>
                <th class="right" style="width:12%">Harga</th>
                <th class="right" style="width:13%">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $idx => $item)
            @php
                $w = $item->width_cm  > 0 ? $item->width_cm  : ($item->product->default_width_cm  ?? 0);
                $h = $item->height_cm > 0 ? $item->height_cm : ($item->product->default_height_cm ?? 0);
            @endphp
            <tr>
                <td class="center">{{ $idx + 1 }}</td>
                <td>
                    <span class="item-name">{{ $item->product->product_name ?? 'Produk' }}</span>
                    @if($item->notes)
                        <span class="item-notes">Catatan: {{ $item->notes }}</span>
                    @endif
                    @if($item->design_file)
                        <span class="item-notes">File desain tersedia</span>
                    @endif
                </td>
                <td class="center">
                    @if($w > 0 && $h > 0)
                        <span class="item-size">{{ number_format($w,0) }} × {{ number_format($h,0) }} cm</span>
                        @if($item->used_material_qty > 0)
                            <span class="item-size">{{ $item->used_material_qty }} meter</span>
                        @endif
                    @else
                        <span class="item-size">Standar</span>
                    @endif
                </td>
                <td class="center" style="font-weight:700">{{ $item->qty }}</td>
                <td class="center" style="color:#888">{{ $item->product->unit->unit_name ?? 'Pcs' }}</td>
                <td class="right">Rp {{ number_format($item->unit_price ?? $item->price, 0, ',', '.') }}</td>
                <td class="right" style="font-weight:700">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach

            {{-- Baris kosong jika item sedikit --}}
            @if($order->items->count() < 4)
                @for($i = 0; $i < (4 - $order->items->count()); $i++)
                <tr style="height:28px">
                    <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                </tr>
                @endfor
            @endif
        </tbody>
    </table>
</div>

{{-- ── TOTALS & TERBILANG ──────────────────────────────── --}}
<div class="totals-section">
    <div class="totals-left">

        <div class="terbilang-box">
            <div class="terbilang-label">Terbilang</div>
            <div class="terbilang-text">"{{ terbilang($total) }} Rupiah"</div>
        </div>

        {{-- Info Cash --}}
        @if($order->payment_method === 'cash' && ($order->cash_amount_received ?? 0) > 0)
        <div class="payment-info">
            <div class="payment-label">Detail Pembayaran Tunai</div>
            <div class="payment-row">
                <span class="payment-row-label">Total Tagihan</span>
                <span class="payment-row-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div class="payment-row">
                <span class="payment-row-label">Uang Diterima</span>
                <span class="payment-row-value">Rp {{ number_format($order->cash_amount_received, 0, ',', '.') }}</span>
            </div>
            <div class="payment-row" style="border-top:1px dashed #e0e0e0;padding-top:6px;margin-top:4px">
                <span class="payment-row-label" style="font-weight:700">Kembalian</span>
                <span class="payment-row-value" style="font-size:12px">Rp {{ number_format($order->cash_change ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>
        @endif

        {{-- Tracking --}}
        @if($order->tracking_number ?? false)
        <div class="payment-info">
            <div class="payment-label">Info Pengiriman</div>
            <div class="payment-row">
                <span class="payment-row-label">Kurir</span>
                <span class="payment-row-value">{{ $order->kurir_name ?? '-' }}</span>
            </div>
            <div class="payment-row">
                <span class="payment-row-label">No. Resi</span>
                <span class="payment-row-value" style="font-family:monospace">{{ $order->tracking_number }}</span>
            </div>
        </div>
        @endif

    </div>

    <div class="totals-right">
        <table class="totals-table">
            <tr>
                <td class="label">Subtotal Produk</td>
                <td class="amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">PPN ({{ $tax > 0 ? round(($tax / max($subtotal,1)) * 100) : 0 }}%)</td>
                <td class="amount">Rp {{ number_format($tax, 0, ',', '.') }}</td>
            </tr>
            @if($shippingCost > 0)
            <tr>
                <td class="label">Ongkos Kirim</td>
                <td class="amount">Rp {{ number_format($shippingCost, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="sep total">
                <td class="label">Total Bayar</td>
                <td class="amount">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </table>

        @if($order->paid_at ?? false)
        <div style="text-align:right;margin-top:8px;font-size:9px;color:#aaa">
            Dibayar pada: <strong>{{ \Carbon\Carbon::parse($order->paid_at)->format('d M Y, H:i') }}</strong>
        </div>
        @endif
    </div>
</div>

{{-- ── FOOTER ─────────────────────────────────────────── --}}
<div class="footer-bar">
    <div class="footer-left">
        <div class="footer-note">
            <strong>Catatan:</strong><br>
            • Dokumen ini merupakan bukti transaksi yang sah.<br>
            • Barang yang sudah dibeli tidak dapat dikembalikan kecuali terdapat cacat produksi.<br>
            • Hubungi kami maks. 2×24 jam setelah barang diterima jika ada kendala.<br>
            • Terima kasih telah mempercayai layanan <strong>CetakKilat Jaya</strong>.
        </div>
    </div>
    <div class="footer-right">
        <div class="ttd-box">
            <div class="ttd-line"></div>
            <div class="ttd-label">Hormat Kami,<br>CetakKilat Jaya</div>
        </div>
    </div>
</div>

</body>
</html>