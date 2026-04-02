{{-- File: resources/views/frontend/orders/report_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #1a1a2e;
            background: #fff;
        }

        /* ── HEADER ── */
        .header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
            color: #fff;
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }
        .header .company-name {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .header .report-title {
            font-size: 11px;
            opacity: 0.8;
            margin-top: 3px;
        }
        .header .period {
            text-align: right;
            font-size: 9px;
            opacity: 0.85;
        }
        .header .period strong {
            font-size: 11px;
            display: block;
            margin-bottom: 2px;
        }

        /* ── SUMMARY CARDS ── */
        .summary-row {
            display: flex;
            gap: 10px;
            margin: 0 24px 18px;
        }
        .summary-card {
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 12px;
            background: #f8faff;
        }
        .summary-card .label {
            font-size: 8px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .summary-card .value {
            font-size: 14px;
            font-weight: 700;
            color: #1a1a2e;
        }
        .summary-card .value.revenue { color: #16a34a; }
        .summary-card .icon {
            font-size: 18px;
            margin-bottom: 4px;
        }

        /* ── FILTER INFO ── */
        .filter-info {
            margin: 0 24px 14px;
            padding: 8px 12px;
            background: #fff7ed;
            border-left: 3px solid #f97316;
            border-radius: 0 6px 6px 0;
            font-size: 9px;
            color: #7c3aed;
        }

        /* ── SECTION TITLE ── */
        .section-title {
            font-size: 11px;
            font-weight: 700;
            margin: 0 24px 8px;
            color: #1a1a2e;
            padding-bottom: 4px;
            border-bottom: 2px solid #0f3460;
        }

        /* ── TABLE ── */
        .table-wrap { margin: 0 24px 20px; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }
        thead tr {
            background: #0f3460;
            color: #fff;
        }
        thead th {
            padding: 6px 8px;
            text-align: left;
            font-weight: 600;
            white-space: nowrap;
        }
        thead th.right { text-align: right; }
        thead th.center { text-align: center; }

        tbody tr { border-bottom: 1px solid #e2e8f0; }
        tbody tr:nth-child(even) { background: #f8faff; }
        tbody td { padding: 5px 8px; vertical-align: middle; }
        tbody td.right { text-align: right; }
        tbody td.center { text-align: center; }

        /* ── BADGE ── */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-pending    { background: #e2e8f0; color: #475569; }
        .badge-confirmed  { background: #cffafe; color: #0891b2; }
        .badge-processing { background: #fef9c3; color: #a16207; }
        .badge-shipped    { background: #dbeafe; color: #1d4ed8; }
        .badge-delivered  { background: #dcfce7; color: #15803d; }
        .badge-cancelled  { background: #fee2e2; color: #b91c1c; }

        /* ── TFOOT TOTAL ── */
        tfoot tr { background: #1a1a2e !important; color: #fff; }
        tfoot td { padding: 6px 8px; font-weight: 700; font-size: 9.5px; }

        /* ── FOOTER ── */
        .footer {
            margin: 0 24px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            font-size: 8px;
            color: #94a3b8;
        }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>

    {{-- ── HEADER ────────────────────────────────────────── --}}
    <div class="header">
        <div>
            <div class="company-name">{{ $settings->store_name ?? 'Nama Toko' }}</div>
            <div class="report-title">LAPORAN PENJUALAN</div>
        </div>
        <div class="period">
            <strong>Periode Laporan</strong>
            {{ $dateFrom->format('d M Y') }} &mdash; {{ $dateTo->format('d M Y') }}<br>
            Dicetak: {{ now()->format('d M Y, H:i') }}
        </div>
    </div>

    {{-- ── FILTER INFO ─────────────────────────────────── --}}
    @if($status)
    <div class="filter-info">
        Filter aktif &mdash; Status: <strong>{{ ucfirst($status) }}</strong>
    </div>
    @endif

    {{-- ── SUMMARY CARDS ─────────────────────────────── --}}
    <div class="summary-row">
        <div class="summary-card">
            <div class="label">Total Order</div>
            <div class="value">{{ number_format($summary['total_orders']) }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Total Pendapatan</div>
            <div class="value revenue">Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Total Item Terjual</div>
            <div class="value">{{ number_format($summary['total_items']) }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Rata-rata Per Order</div>
            <div class="value">Rp {{ number_format($summary['avg_order'], 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- ── TABEL DETAIL ORDER ──────────────────────────── --}}
    <div class="section-title">Detail Order</div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:5%">No</th>
                    <th style="width:16%">No. Order</th>
                    <th style="width:12%">Tanggal</th>
                    <th style="width:18%">Customer</th>
                    <th style="width:22%">Produk</th>
                    <th class="center" style="width:7%">Qty</th>
                    <th class="right" style="width:14%">Total</th>
                    <th class="center" style="width:6%">Status</th>
                </tr>
            </thead>
            <tbody>
                @php $grandTotal = 0; $grandQty = 0; $no = 1; @endphp
                @forelse($orders as $order)
                @php
                    $qty = $order->items->sum('qty');
                    $grandTotal += $order->total_price;
                    $grandQty   += $qty;
                    $badgeClass  = 'badge-' . $order->status;
                    $products    = $order->items->pluck('product.product_name')->filter()->implode(', ');
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td><strong>{{ $order->order_number }}</strong></td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>
                        {{ $order->user->username ?? '-' }}<br>
                        <span style="color:#94a3b8">{{ $order->user->useremail ?? '' }}</span>
                    </td>
                    <td style="max-width:120px; word-break:break-word">
                        {{ \Illuminate\Support\Str::limit($products, 60) }}
                    </td>
                    <td class="center">{{ number_format($qty) }}</td>
                    <td class="right"><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                    <td class="center">
                        <span class="badge {{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="center" style="padding:20px; color:#94a3b8">
                        Tidak ada data order pada periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($orders->count())
            <tfoot>
                <tr>
                    <td colspan="5" class="right">TOTAL KESELURUHAN</td>
                    <td class="center">{{ number_format($grandQty) }}</td>
                    <td class="right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

    {{-- ── FOOTER ──────────────────────────────────────── --}}
    <div class="footer">
        <div>{{ $settings->store_name ?? '' }} &mdash; Laporan digenerate otomatis oleh sistem</div>
        <div>Halaman 1</div>
    </div>

</body>
</html>