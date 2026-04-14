{{-- File: resources/views/frontend/orders/report_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
@page { 
    margin: 10mm 8mm 15mm 8mm; 
    size: A4 landscape; 
}

body {
    font-family: 'DejaVu Sans', Arial, sans-serif;
    font-size: 8px; /* turunkan dari 9px */
    color: #2d3748;
    background: #fff;
    width: 100%;
}

        /* ─── HEADER ─── */
        .page-header { background: #1a202c; }
        .header-inner { display: table; width: 100%; }
        .header-brand {
            display: table-cell; width: 38%; vertical-align: middle;
            padding: 16px 24px; border-right: 1px solid rgba(255,255,255,0.06);
        }
        .header-center {
            display: table-cell; width: 30%; vertical-align: middle;
            text-align: center; padding: 16px 0;
        }
        .header-right {
            display: table-cell; width: 32%; vertical-align: middle;
            text-align: right; padding: 16px 24px;
            border-left: 1px solid rgba(255,255,255,0.06);
        }
        .brand-name { font-size: 17px; font-weight: 900; color: #fff; text-transform: uppercase; }
        .brand-name span { color: #e07b39; }
        .brand-sub { font-size: 7px; color: rgba(255,255,255,0.3); text-transform: uppercase; letter-spacing: 2px; margin-top: 3px; }
        .report-title-center { font-size: 12px; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 3px; }
        .report-subtitle { font-size: 7.5px; color: rgba(255,255,255,0.3); margin-top: 5px; text-transform: uppercase; letter-spacing: 1.5px; }
        .period-label { font-size: 7px; color: rgba(255,255,255,0.35); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 3px; }
        .period-date { font-size: 11px; font-weight: 700; color: #e07b39; }
        .print-time { font-size: 7px; color: rgba(255,255,255,0.2); margin-top: 5px; }
        .accent-bar { height: 2px; background: #e07b39; }

        /* ─── FILTER ─── */
        .filter-badges { padding: 6px 24px; background: #fffbf7; border-bottom: 1px solid #f0d9c8; }
        .filter-label { font-size: 7.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #c06020; display: inline-block; margin-right: 8px; }
        .fbadge { display: inline-block; background: #e07b39; color: #fff; font-size: 7.5px; font-weight: 700; padding: 2px 7px; border-radius: 2px; margin-right: 5px; }

        /* ─── SUMMARY CARDS ─── */
        .summary-section { padding: 12px 24px 10px; background: #f7f8fa; border-bottom: 1px solid #e8eaed; }
        .summary-grid { display: table; width: 100%; border-collapse: separate; border-spacing: 6px 0; }
        .summary-card { display: table-cell; vertical-align: top; background: #fff; border: 1px solid #e8eaed; border-radius: 4px; padding: 10px 12px; }
        .summary-card.primary { background: #1a202c; border-color: #1a202c; }
        .sc-label { font-size: 7px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #a0aec0; margin-bottom: 5px; }
        .summary-card.primary .sc-label { color: rgba(255,255,255,0.4); }
        .sc-value { font-size: 13px; font-weight: 900; color: #1a202c; line-height: 1; }
        .sc-value.accent { color: #e07b39; }
        .sc-value.green  { color: #2f855a; }
        .sc-value.purple { color: #6b46c1; }
        .summary-card.primary .sc-value { color: #e07b39; }
        .sc-sub { font-size: 7px; color: #cbd5e0; margin-top: 4px; }
        .summary-card.primary .sc-sub { color: rgba(255,255,255,0.2); }

        /* ─── STATUS BREAKDOWN ─── */
        .breakdown-section { padding: 8px 24px 10px; border-bottom: 1px solid #e8eaed; }
        .breakdown-grid { display: table; width: 100%; border-collapse: separate; border-spacing: 6px 0; }
        .breakdown-cell { display: table-cell; vertical-align: top; }
        .breakdown-item { background: #fff; border: 1px solid #e8eaed; border-radius: 3px; padding: 6px 10px; display: table; width: 100%; }
        .bi-label { display: table-cell; font-size: 7.5px; font-weight: 700; vertical-align: middle; }
        .bi-count { display: table-cell; text-align: right; font-size: 13px; font-weight: 900; vertical-align: middle; }

        /* ─── SECTION HEADER ─── */
        .section-header { display: table; width: 100%; padding: 8px 24px 5px; }
        .section-title { display: table-cell; font-size: 8.5px; font-weight: 800; color: #1a202c; text-transform: uppercase; letter-spacing: 1.5px; vertical-align: middle; }
        .section-title::before { content: ''; display: inline-block; width: 2px; height: 10px; background: #e07b39; border-radius: 1px; margin-right: 7px; vertical-align: middle; }
        .section-count { display: table-cell; text-align: right; font-size: 7.5px; color: #a0aec0; vertical-align: middle; }

        /* ─── MAIN TABLE ─── */
.table-wrap { 
    padding: 0 8px; /* kurangi padding */
    margin-bottom: 20px; 
}
        table.main-table { width: 100%; border-collapse: collapse; }

        /* Table head */
        table.main-table thead tr { background: #2d3748; }
        table.main-table thead th {
            padding: 7px 8px;
            font-size: 7.5px; font-weight: 700;
            color: rgba(255,255,255,0.75);
            text-transform: uppercase; letter-spacing: 0.8px;
            white-space: nowrap;
        }
        table.main-table thead th.right  { text-align: right; }
        table.main-table thead th.center { text-align: center; }

        .right  { text-align: right; }
        .center { text-align: center; }

        /* Order header row */
        table.main-table tr.order-header-row { background: #f7f8fa; border-top: 2px solid #e2e8f0; }
        table.main-table tr.order-header-row td { padding: 6px 8px; vertical-align: middle; }

        /* Item rows */
        table.main-table tr.item-row { border-bottom: 1px solid #f0f4f8; }
        table.main-table tr.item-row td { padding: 5px 8px 5px 14px; vertical-align: top; background: #fdfdfd; }

        /* Grand total foot */
        table.main-table tfoot tr { background: #2d3748; }
        table.main-table tfoot td {
            padding: 8px; font-size: 8.5px; font-weight: 800;
            color: rgba(255,255,255,0.7);
        }
        table.main-table tfoot .highlight-total { color: #e07b39; font-size: 10px; }

        /* ─── INLINE ELEMENTS ─── */
        .order-num { font-size: 8.5px; font-weight: 800; color: #e07b39; }
        .order-date { font-size: 7.5px; color: #a0aec0; }
        .customer-name { font-weight: 700; font-size: 8.5px; color: #2d3748; }
        .customer-email { font-size: 7px; color: #a0aec0; }

        .customer-badge {
            display: inline-block; font-size: 6.5px; font-weight: 800;
            padding: 1px 5px; border-radius: 2px; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .badge-member { background: #f0fff4; color: #276749; border: 1px solid #c6f6d5; }
        .badge-guest  { background: #f7fafc; color: #718096; border: 1px solid #e2e8f0; }

        .member-tier {
            display: inline-block; font-size: 6.5px; font-weight: 800;
            padding: 1px 5px; border-radius: 2px;
            background: #faf5ff; color: #6b46c1; border: 1px solid #e9d8fd; margin-left: 3px;
        }

        .status-badge {
            display: inline-block; padding: 2px 6px; border-radius: 2px;
            font-size: 7px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .s-pending    { background: #fffff0; color: #975a16; border: 1px solid #faf089; }
        .s-paid       { background: #f0fff4; color: #276749; border: 1px solid #c6f6d5; }
        .s-processing { background: #ebf8ff; color: #2b6cb0; border: 1px solid #bee3f8; }
        .s-shipped    { background: #faf5ff; color: #553c9a; border: 1px solid #e9d8fd; }
        .s-delivered  { background: #f0fff4; color: #276749; border: 1px solid #c6f6d5; }
        .s-completed  { background: #f0fff4; color: #22543d; border: 1px solid #c6f6d5; }
        .s-cancelled  { background: #fff5f5; color: #9b2335; border: 1px solid #fed7d7; }

        .payment-badge {
            display: inline-block; font-size: 7px; font-weight: 700;
            padding: 1px 5px; border-radius: 2px; text-transform: uppercase;
        }
        .pm-cash     { background: #fffbeb; color: #b7791f; border: 1px solid #fef3c7; }
        .pm-midtrans { background: #ebf8ff; color: #2b6cb0; border: 1px solid #bee3f8; }

        .metode-text { font-size: 7.5px; color: #718096; }

        .item-product-name { font-size: 8px; font-weight: 700; color: #2d3748; }
        .item-detail { font-size: 7px; color: #718096; margin-top: 1px; }

        .item-size {
            display: inline-block; font-size: 7px; font-weight: 700;
            background: #ebf8ff; color: #2b6cb0; border: 1px solid #bee3f8;
            padding: 1px 5px; border-radius: 2px; margin-top: 2px;
        }
        .item-custom-size {
            display: inline-block; font-size: 7px; font-weight: 700;
            background: #faf5ff; color: #6b46c1; border: 1px solid #e9d8fd;
            padding: 1px 5px; border-radius: 2px; margin-top: 2px;
        }
        .finishing-badge {
            display: inline-block; font-size: 7px; font-weight: 600;
            background: #fffbeb; color: #92400e; border: 1px solid #fde68a;
            padding: 1px 5px; border-radius: 2px; margin-top: 2px; margin-left: 3px;
        }
        .item-notes { font-size: 7px; color: #a0aec0; font-style: italic; margin-top: 2px; }

        .amount-value { font-size: 8.5px; font-weight: 800; color: #2d3748; }
        .amount-value.revenue { color: #276749; }
        .amount-cancelled { font-size: 7px; color: #fc8181; margin-top: 1px; }
        .commission-text { font-size: 7px; color: #6b46c1; font-weight: 700; }
        .tracking-num { font-size: 7px; color: #805ad5; margin-top: 2px; font-family: monospace; }
        .row-no { color: #cbd5e0; font-size: 7.5px; }

        /* ─── FOOTER ─── */
        .page-footer {
            position: fixed; bottom: 0; left: 0; right: 0;
            padding: 5px 24px; background: #f7f8fa; border-top: 1px solid #e8eaed;
            display: table; width: 100%;
        }
        .footer-left { display: table-cell; font-size: 7px; color: #a0aec0; vertical-align: middle; }
        .footer-right { display: table-cell; text-align: right; font-size: 7px; color: #a0aec0; vertical-align: middle; }
        .footer-confidential {
            display: inline-block; font-size: 6.5px; font-weight: 800; color: #c06020;
            text-transform: uppercase; letter-spacing: 1px; margin-left: 8px;
            background: #fff8f0; border: 1px solid #fbd38d; padding: 1px 5px; border-radius: 2px;
        }

        .empty-state { text-align: center; padding: 20px; color: #a0aec0; font-style: italic; }
        .page-break { page-break-after: always; }
        table.main-table td {
    word-wrap: break-word;
    overflow-wrap: break-word;
    max-width: 0; /* penting untuk word-wrap di tabel */
}

.page-footer {
    position: fixed; 
    bottom: 0; left: 0; right: 0;
    padding: 4px 8px;
    background: #f7f8fa; 
    border-top: 1px solid #e8eaed;
    display: table; 
    width: 100%;
}

/* Fix summary cards agar tidak overflow */
.summary-section { padding: 8px 8px 8px; }
.summary-grid { border-spacing: 4px 0; }
.sc-value { font-size: 11px; }

/* Fix header */
.header-brand { padding: 12px 12px; }
.header-right { padding: 12px 12px; }
.breakdown-section { padding: 6px 8px 8px; }
    </style>
</head>
<body>

@php
    $grandTotal      = 0;
    $grandQty        = 0;
    $grandCommission = 0;
    $no              = 1;

    $statusLabels = [
        'pending'      => 'Pending',
        'paid'         => 'Lunas',
        'processing'   => 'Proses',
        'ready_pickup' => 'Siap Ambil',
        'shipped'      => 'Dikirim',
        'delivered'    => 'Diterima',
        'completed'    => 'Selesai',
        'cancelled'    => 'Dibatalkan',
    ];
    $statusClass = [
        'pending'      => 's-pending',
        'paid'         => 's-paid',
        'processing'   => 's-processing',
        'ready_pickup' => 's-shipped',
        'shipped'      => 's-shipped',
        'delivered'    => 's-delivered',
        'completed'    => 's-completed',
        'cancelled'    => 's-cancelled',
    ];

    $totalRevenue = $summary['total_revenue'] ?? 0;
    $totalOrders  = $summary['total_orders']  ?? 0;
    $totalItems   = $summary['total_items']   ?? 0;
    $avgOrder     = $summary['avg_order']     ?? 0;
    $totalComm    = $orders->sum('commission_earned');

    $countPending    = $orders->where('status','pending')->count();
    $countProcessing = $orders->where('status','processing')->count();
    $countShipped    = $orders->where('status','shipped')->count();
    $countDelivered  = $orders->where('status','delivered')->count();
    $countCompleted  = $orders->where('status','completed')->count();
    $countCancelled  = $orders->where('status','cancelled')->count();

    $metodeLabel = ['pickup' => 'Pickup', 'gojek' => 'Gojek', 'ekspedisi' => 'Ekspedisi'];
@endphp

{{-- ══════ HEADER ══════ --}}
<div class="page-header">
    <div class="header-inner">
        <div class="header-brand">
            <div class="brand-name">Cetak<span>Kilat</span></div>
            <div class="brand-sub">Professional Printing Solutions</div>
        </div>
        <div class="header-center">
            <div class="report-title-center">Laporan Penjualan</div>
            <div class="report-subtitle">Sales Report &mdash; Rekap Periode</div>
        </div>
        <div class="header-right">
            <div class="period-label">Periode Laporan</div>
            <div class="period-date">{{ $dateFrom->format('d M Y') }} &mdash; {{ $dateTo->format('d M Y') }}</div>
            <div class="print-time">Dicetak: {{ now()->format('d M Y · H:i') }} WIB</div>
        </div>
    </div>
</div>
<div class="accent-bar"></div>

{{-- Filter --}}
@if($status || (isset($search) && $search))
<div class="filter-badges">
    <span class="filter-label">Filter:</span>
    @if($status)<span class="fbadge">Status: {{ $statusLabels[$status] ?? strtoupper($status) }}</span>@endif
    @if(isset($search) && $search)<span class="fbadge">Cari: "{{ $search }}"</span>@endif
    <span style="font-size:7.5px;color:#c06020;margin-left:4px">— {{ $orders->count() }} data ditampilkan</span>
</div>
@endif

{{-- ══════ SUMMARY CARDS ══════ --}}
<div class="summary-section">
    <div class="summary-grid">
        <div class="summary-card primary">
            <div class="sc-label">Total Pendapatan</div>
            <div class="sc-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="sc-sub">Dari order berhasil</div>
        </div>
        <div class="summary-card">
            <div class="sc-label">Total Order</div>
            <div class="sc-value accent">{{ number_format($totalOrders) }}</div>
            <div class="sc-sub">Semua status</div>
        </div>
        <div class="summary-card">
            <div class="sc-label">Total Item Terjual</div>
            <div class="sc-value">{{ number_format($totalItems) }}</div>
            <div class="sc-sub">Qty keseluruhan</div>
        </div>
        <div class="summary-card">
            <div class="sc-label">Rata-rata Per Order</div>
            <div class="sc-value green">Rp {{ number_format($avgOrder, 0, ',', '.') }}</div>
            <div class="sc-sub">Dari order berhasil</div>
        </div>
        <div class="summary-card">
            <div class="sc-label">Total Komisi Member</div>
            <div class="sc-value purple">Rp {{ number_format($totalComm, 0, ',', '.') }}</div>
            <div class="sc-sub">Semua member aktif</div>
        </div>
        <div class="summary-card">
            <div class="sc-label">Order Selesai</div>
            <div class="sc-value">{{ $countDelivered + $countCompleted }}</div>
            <div class="sc-sub">Delivered + Completed</div>
        </div>
    </div>
</div>

{{-- ══════ STATUS BREAKDOWN ══════ --}}
<div class="breakdown-section">
    <div class="breakdown-grid">
        @foreach([
            ['Pending',    $countPending,    '#b7791f'],
            ['Produksi',   $countProcessing, '#2b6cb0'],
            ['Dikirim',    $countShipped,    '#553c9a'],
            ['Diterima',   $countDelivered,  '#276749'],
            ['Selesai',    $countCompleted,  '#22543d'],
            ['Dibatalkan', $countCancelled,  '#9b2335'],
        ] as [$lbl, $cnt, $clr])
        <div class="breakdown-cell">
            <div class="breakdown-item">
                <div class="bi-label" style="color:{{ $clr }}">{{ $lbl }}</div>
                <div class="bi-count" style="color:{{ $clr }}">{{ $cnt }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- ══════ MAIN TABLE ══════ --}}
<div class="section-header">
    <div class="section-title">Detail Transaksi</div>
    <div class="section-count">{{ $orders->count() }} order &mdash; item detail lengkap</div>
</div>

<div class="table-wrap">
    <table class="main-table">
        <thead>
            <tr>
/* Ganti width kolom thead */
<th style="width:2%">No</th>
<th style="width:10%">No. Order</th>
<th style="width:12%">Pelanggan</th>
<th style="width:22%">Produk & Spesifikasi</th>
<th class="center" style="width:7%">Ukuran</th>
<th class="center" style="width:3%">Qty</th>
<th class="center" style="width:6%">Metode</th>
<th class="center" style="width:6%">Bayar</th>
<th class="right"  style="width:8%">Komisi</th>
<th class="right"  style="width:8%">Subtotal</th>
<th class="right"  style="width:8%">Total</th>
<th class="center" style="width:8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            @php
                $isMember  = $order->user && $order->user->role !== 'guest';
                $hasComm   = $order->commission_earned > 0;
                $isRevenue = in_array($order->status, ['paid','processing','shipped','delivered','completed']);
                if ($isRevenue) $grandTotal += $order->total;
                if ($hasComm)   $grandCommission += $order->commission_earned;

                $orderQty  = $order->items->sum('qty');
                $grandQty += $orderQty;

                $stClass   = $statusClass[$order->status]  ?? 's-pending';
                $stLabel   = $statusLabels[$order->status] ?? $order->status;
                $itemCount = $order->items->count();
            @endphp

            {{-- ── ORDER HEADER ROW ── --}}
            <tr class="order-header-row">
                <td class="center row-no">{{ $no++ }}</td>
                <td>
                    <div class="order-num">{{ $order->order_number }}</div>
                    <div class="order-date">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                    @if($order->tracking_number)
                        <div class="tracking-num">{{ Str::limit($order->tracking_number, 16) }}</div>
                    @endif
                </td>
                <td>
                    <div class="customer-name">{{ $order->user->full_name ?? $order->user->username ?? '-' }}</div>
                    <div class="customer-email">{{ $order->user->useremail ?? $order->user->email ?? '' }}</div>
                    <div style="margin-top:2px">
                        @if(!$isMember)
                            <span class="customer-badge badge-guest">Tamu</span>
                        @else
                            <span class="customer-badge badge-member">Member</span>
                            @if(!empty($order->user->member_tier))
                                <span class="member-tier">{{ strtoupper($order->user->member_tier) }}</span>
                            @endif
                        @endif
                    </div>
                </td>
                <td style="font-size:7.5px;color:#a0aec0;font-style:italic">
                    {{ $itemCount }} item &mdash; lihat detail di bawah
                </td>
                <td class="center" style="color:#cbd5e0;font-size:8px">&mdash;</td>
                <td class="center" style="font-weight:800;font-size:8.5px">{{ number_format($orderQty) }}</td>
                <td class="center">
                    <span class="metode-text">{{ $metodeLabel[$order->shipping_method] ?? $order->shipping_method }}</span>
                    @if($order->shipping_cost > 0)
                        <div style="font-size:6.5px;color:#a0aec0;margin-top:1px">Ongkir: Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</div>
                    @endif
                </td>
                <td class="center">
                    <span class="payment-badge {{ $order->payment_method === 'cash' ? 'pm-cash' : 'pm-midtrans' }}">
                        {{ strtoupper($order->payment_method ?? '-') }}
                    </span>
                    @if($order->paid_at)
                        <div style="font-size:6.5px;color:#a0aec0;margin-top:1px">{{ \Carbon\Carbon::parse($order->paid_at)->format('d/m H:i') }}</div>
                    @endif
                </td>
                <td class="right">
                    @if($hasComm)
                        <div class="commission-text">Rp {{ number_format($order->commission_earned, 0, ',', '.') }}</div>
                        @if($order->discount_member > 0)
                            <div style="font-size:6.5px;color:#a0aec0;margin-top:1px">Disc: Rp {{ number_format($order->discount_member, 0, ',', '.') }}</div>
                        @endif
                        @if($order->komisi_digunakan > 0)
                            <div style="font-size:6.5px;color:#e07b39;margin-top:1px">Dipakai: Rp {{ number_format($order->komisi_digunakan, 0, ',', '.') }}</div>
                        @endif
                    @else
                        <span style="color:#e2e8f0;font-size:8px">&mdash;</span>
                    @endif
                </td>
                <td class="right" style="color:#a0aec0;font-size:7.5px">
                    @if($order->subtotal != $order->total)
                        Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                        @if($order->tax > 0)
                            <div style="font-size:6.5px;color:#a0aec0">Pajak: Rp {{ number_format($order->tax, 0, ',', '.') }}</div>
                        @endif
                    @else
                        &mdash;
                    @endif
                </td>
                <td class="right">
                    <span class="amount-value {{ $isRevenue ? 'revenue' : '' }}">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </span>
                    @if($order->status === 'cancelled')
                        <div class="amount-cancelled">Tidak dihitung</div>
                    @endif
                </td>
                <td class="center">
                    <span class="status-badge {{ $stClass }}">{{ $stLabel }}</span>
                </td>
            </tr>

            {{-- ── ITEM ROWS (semua item ditampilkan) ── --}}
            @foreach($order->items as $item)
            @php
                $product   = $item->product;
                $finishing = $item->finishing;

                $hasCustomSize  = $item->width_cm && $item->height_cm;
                $hasDefaultSize = $product && ($product->default_width_cm || $product->default_height_cm);
                $allowCustom    = $product && $product->allow_custom_size;

                if ($hasCustomSize) {
                    $sizeLabel    = number_format($item->width_cm, 1) . ' × ' . number_format($item->height_cm, 1) . ' cm';
                    $sizeIsCustom = $allowCustom;
                } elseif ($hasDefaultSize) {
                    $sizeLabel    = number_format($product->default_width_cm, 1) . ' × ' . number_format($product->default_height_cm, 1) . ' cm';
                    $sizeIsCustom = false;
                } else {
                    $sizeLabel    = null;
                    $sizeIsCustom = false;
                }

                $unitName = optional(optional($product)->unit)->unit_name ?? '';
                $matName  = optional(optional($product)->material)->material_name ?? '';
                $catName  = optional(optional($product)->category)->category_name ?? '';
            @endphp
            <tr class="item-row">
                {{-- indent indicator --}}
                <td class="center" style="color:#e2e8f0;font-size:8px;padding-left:8px">&#9492;</td>
                <td style="font-size:7px;color:#cbd5e0">Item&nbsp;{{ $loop->iteration }}</td>
                <td></td>

                {{-- Product & Spec --}}
                <td>
                    <div class="item-product-name">{{ $product->product_name ?? '(Produk dihapus)' }}</div>
                    @if($catName || $matName)
                    <div class="item-detail">
                        @if($catName){{ $catName }}@endif
                        @if($catName && $matName) &middot; @endif
                        @if($matName){{ $matName }}@endif
                    </div>
                    @endif
                    <div style="margin-top:3px">
                        @if($sizeLabel)
                            @if($sizeIsCustom)
                                <span class="item-custom-size">Custom: {{ $sizeLabel }}</span>
                            @else
                                <span class="item-size">{{ $sizeLabel }}</span>
                            @endif
                        @endif
                        @if($finishing)
                            <span class="finishing-badge">{{ $finishing->finishing_name ?? $finishing->name ?? 'Finishing' }}</span>
                        @endif
                    </div>
                    @if($item->notes)
                        <div class="item-notes">&ldquo;{{ Str::limit($item->notes, 65) }}&rdquo;</div>
                    @endif
                    @if($item->design_link)
                        <div style="font-size:6.5px;color:#63b3ed;margin-top:1px">Ada link desain</div>
                    @endif
                    @if($item->design_file)
                        <div style="font-size:6.5px;color:#68d391;margin-top:1px">File desain terupload</div>
                    @endif
                </td>

                {{-- Ukuran / Yield --}}
                <td class="center">
                    @if($item->total_yield_pcs)
                        <div style="font-size:7.5px;font-weight:700;color:#2b6cb0">{{ number_format($item->total_yield_pcs) }} pcs</div>
                        <div style="font-size:6.5px;color:#a0aec0">yield</div>
                    @elseif($sizeLabel)
                        <div style="font-size:7px;color:#718096">{{ $sizeLabel }}</div>
                    @else
                        <span style="color:#e2e8f0">&mdash;</span>
                    @endif
                    @if($item->used_material_qty)
                        <div style="font-size:6.5px;color:#a0aec0;margin-top:1px">Mat: {{ number_format($item->used_material_qty, 2) }}</div>
                    @endif
                </td>

                {{-- Qty --}}
                <td class="center" style="font-weight:700;font-size:8px">
                    {{ number_format($item->qty) }}
                    @if($unitName)<div style="font-size:6.5px;color:#a0aec0">{{ $unitName }}</div>@endif
                </td>

                <td></td>
                <td></td>

                {{-- Harga satuan --}}
                <td class="right" style="font-size:7.5px;color:#718096">
                    @if($item->unit_price)
                        Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                        <div style="font-size:6.5px;color:#a0aec0">/unit</div>
                    @else
                        <span style="color:#e2e8f0">&mdash;</span>
                    @endif
                </td>

                {{-- Subtotal item --}}
                <td class="right">
                    <span style="font-size:8px;font-weight:800;color:#4a5568">
                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                    </span>
                </td>

                <td></td>
                <td></td>
            </tr>
            @endforeach

            @empty
            <tr>
                <td colspan="12" class="empty-state">Tidak ada data order pada periode yang dipilih.</td>
            </tr>
            @endforelse
        </tbody>

        @if($orders->count() > 0)
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:right;font-size:7.5px;opacity:0.6;letter-spacing:1px;text-transform:uppercase">Grand Total</td>
                <td class="center" style="color:#fff;font-size:9px">{{ number_format($grandQty) }}</td>
                <td></td>
                <td></td>
                <td class="right" style="color:#c4b5fd;font-size:8.5px;font-weight:800">Rp {{ number_format($grandCommission, 0, ',', '.') }}</td>
                <td></td>
                <td class="right highlight-total">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>

{{-- ══════ FOOTER ══════ --}}
<div class="page-footer">
    <div class="footer-left">
        {{ $settings->store_name ?? 'CetakKilat Jaya' }} &mdash;
        Digenerate otomatis {{ now()->format('d M Y, H:i') }} WIB.
        <span class="footer-confidential">Rahasia</span>
    </div>
    <div class="footer-right">
        &copy; {{ date('Y') }} CetakKilat Jaya &nbsp;|&nbsp; Hal. 1
    </div>
</div>

</body>
</html>