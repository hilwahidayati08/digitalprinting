
@extends('admin.admin')

@section('title', 'Dashboard - Admin Panel')
@section('page-title', 'Dashboard')

@section('breadcrumbs')
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <span class="text-sm font-medium text-gray-900">Dashboard</span>
            </li>
        </ol>
    </nav>
@endsection

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;0,9..40,900&family=DM+Mono:wght@400;500&display=swap');

:root {
    --blue:     #2563eb;
    --blue-l:   #eff6ff;
    --blue-m:   #dbeafe;
    --green:    #16a34a;
    --green-l:  #f0fdf4;
    --amber:    #d97706;
    --amber-l:  #fffbeb;
    --red:      #dc2626;
    --red-l:    #fef2f2;
    --purple:   #7c3aed;
    --purple-l: #f5f3ff;
    --ink:      #0f172a;
    --muted:    #64748b;
    --border:   #e2e8f0;
    --surface:  #f8fafc;
    --card:     #ffffff;
    --r:        16px;
    --rs:       10px;
}

.dash * { font-family: 'DM Sans', sans-serif; box-sizing: border-box; }
.mono    { font-family: 'DM Mono', monospace !important; }

/* ── PAGE HEADER ── */
.dash-hdr {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 24px;
}
.dash-title { font-size: 24px; font-weight: 900; color: var(--ink); letter-spacing: -.03em; line-height: 1; }
.dash-sub   { font-size: 12px; color: var(--muted); margin-top: 4px; }
.dash-date  {
    display: inline-flex; align-items: center; gap: 6px;
    background: white; border: 1.5px solid var(--border);
    border-radius: var(--rs); padding: 7px 14px;
    font-size: 12px; font-weight: 600; color: var(--muted);
}

/* ── ALERTS ── */
.alert-strip { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 22px; }
.apill {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 6px 14px; border-radius: 999px; font-size: 11px;
    font-weight: 700; text-decoration: none; border: 1.5px solid;
    transition: transform .15s, box-shadow .15s;
}
.apill:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(0,0,0,.08); }
.apill.am  { background: var(--amber-l); color: #92400e; border-color: #fde68a; }
.apill.rd  { background: var(--red-l);   color: #991b1b; border-color: #fecaca; }
.apill.bl  { background: var(--blue-l);  color: #1e40af; border-color: var(--blue-m); }
.adot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; animation: blink 1.4s ease-in-out infinite; }
.adot.am { background: var(--amber); }
.adot.rd { background: var(--red); }
.adot.bl { background: var(--blue); }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }

/* ── SECTION DIVIDER ── */
.sec-div {
    font-size: 10px; font-weight: 800; text-transform: uppercase;
    letter-spacing: .12em; color: #94a3b8;
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 14px; margin-top: 8px;
}
.sec-div::after { content:''; flex:1; height:1px; background: var(--border); }

/* ── KPI GRID ── */
.kpi-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 22px; }
@media(max-width:1100px){ .kpi-grid{ grid-template-columns: repeat(2,1fr); } }
@media(max-width:640px) { .kpi-grid{ grid-template-columns: 1fr; } }

.kpi {
    background: white;
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    padding: 18px 20px;
    position: relative; overflow: hidden;
    transition: transform .2s, box-shadow .2s, border-color .2s;
}
.kpi:hover { transform: translateY(-3px); box-shadow: 0 14px 40px -10px rgba(0,0,0,.11); border-color: #c7d2fe; }
.kpi::before { content:''; position:absolute; left:0;top:0;bottom:0; width:4px; border-radius:4px 0 0 4px; }
.kpi.bl::before { background:var(--blue); }    .kpi.am::before { background:var(--amber); }
.kpi.pu::before { background:var(--purple); }  .kpi.gr::before { background:var(--green); }
.kpi.bl { background: linear-gradient(135deg,#eef5ff,#fff 55%); }
.kpi.am { background: linear-gradient(135deg,#fffdf0,#fff 55%); }
.kpi.pu { background: linear-gradient(135deg,#faf5ff,#fff 55%); }
.kpi.gr { background: linear-gradient(135deg,#f0fdf7,#fff 55%); }

.kpi-top { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:14px; }
.kpi-ico { width:38px;height:38px;border-radius:11px;display:flex;align-items:center;justify-content:center;font-size:15px; }
.kpi-ico.bl { background:#dbeafe; color:var(--blue); }
.kpi-ico.am { background:#fef3c7; color:var(--amber); }
.kpi-ico.pu { background:#ede9fe; color:var(--purple); }
.kpi-ico.gr { background:#dcfce7; color:var(--green); }

.kbadge { display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border-radius:999px;font-size:10px;font-weight:800; }
.kbadge.up   { background:#dcfce7; color:#166534; }
.kbadge.dn   { background:#fee2e2; color:#991b1b; }
.kbadge.neu  { background:#fef3c7; color:#92400e; }

.kpi-lbl  { font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:var(--muted);margin-bottom:3px; }
.kpi-val  { font-size:21px;font-weight:900;color:var(--ink);letter-spacing:-.02em;line-height:1;margin-bottom:4px; }
.kpi-hint { font-size:11px;color:#94a3b8; }
.kpi-hint b { color:#475569; }

/* ── PANEL ── */
.panel { background:white;border:1.5px solid var(--border);border-radius:var(--r);overflow:hidden; }
.ph {
    display:flex;align-items:center;justify-content:space-between;
    padding:16px 20px; border-bottom:1px solid #f1f5f9;
}
.ph-l { display:flex;align-items:center;gap:11px; }
.pico { width:34px;height:34px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0; }
.pico.bl  { background:#dbeafe;color:var(--blue); }   .pico.am  { background:#fef3c7;color:var(--amber); }
.pico.gr  { background:#dcfce7;color:var(--green); }  .pico.pu  { background:#ede9fe;color:var(--purple); }
.pico.rd  { background:#fee2e2;color:var(--red); }

.ptitle { font-size:13px;font-weight:800;color:var(--ink); }
.pdesc  { font-size:11px;color:#94a3b8;margin-top:1px; }
.plink  { font-size:11px;font-weight:700;color:var(--blue);text-decoration:none;padding:4px 11px;background:var(--blue-l);border-radius:999px;transition:background .15s;white-space:nowrap; }
.plink:hover { background:var(--blue-m); }
.pbody  { padding:18px 20px; }

/* ── GRIDS ── */
.g2 { display:grid;grid-template-columns:1fr 320px;gap:14px;margin-bottom:22px; }
.g3 { display:grid;grid-template-columns:1fr 1fr 320px;gap:14px;margin-bottom:22px; }
@media(max-width:1100px){ .g2,.g3{ grid-template-columns:1fr; } }

/* ── CHART ── */
.chart-outer { display:flex;align-items:flex-end;gap:8px;height:155px;padding:0 2px; }
.chart-col   { flex:1;display:flex;flex-direction:column;align-items:center;gap:5px;height:100%;justify-content:flex-end; }
.chart-bw    { width:100%;flex:1;display:flex;align-items:flex-end;justify-content:center; }
.chart-bar   {
    width:100%;max-width:40px;border-radius:7px 7px 0 0;
    background:linear-gradient(180deg,#60a5fa,#2563eb);
    transition:all .25s; cursor:pointer; position:relative; min-height:4px;
}
.chart-bar:hover { background:linear-gradient(180deg,#93c5fd,#3b82f6); }
.ctt {
    position:absolute;bottom:calc(100% + 6px);left:50%;transform:translateX(-50%);
    background:var(--ink);color:white;font-size:10px;font-weight:700;
    padding:3px 8px;border-radius:5px;white-space:nowrap;
    opacity:0;pointer-events:none;transition:opacity .15s;
}
.chart-bar:hover .ctt { opacity:1; }
.chart-mo  { font-size:10px;font-weight:700;color:#94a3b8; }
.chart-cnt { font-size:9px;color:#cbd5e1; }

/* ── STATUS BARS ── */
.srow { display:flex;align-items:center;gap:10px;margin-bottom:12px; }
.slabel { display:flex;align-items:center;gap:5px;font-size:11px;font-weight:700;color:#475569;width:76px;flex-shrink:0; }
.sdot   { width:8px;height:8px;border-radius:3px;flex-shrink:0; }
.strack { flex:1;height:7px;background:#f1f5f9;border-radius:999px;overflow:hidden; }
.sfill  { height:100%;border-radius:999px;transition:width .6s cubic-bezier(.34,1.56,.64,1); }
.scnt   { font-size:12px;font-weight:800;color:var(--ink);width:26px;text-align:right;flex-shrink:0; }

/* ── TABLE ── */
.dtable { width:100%;border-collapse:collapse; }
.dtable th {
    padding:9px 16px;font-size:10px;font-weight:800;text-transform:uppercase;
    letter-spacing:.08em;color:#94a3b8;text-align:left;
    background:#f8fafc;border-bottom:1px solid var(--border);
}
.dtable td { padding:11px 16px;font-size:12px;color:#475569;border-bottom:1px solid #f8fafc;vertical-align:middle; }
.dtable tr:last-child td { border-bottom:none; }
.dtable tr:hover td { background:#f8fafc; }
.oid  { font-family:'DM Mono',monospace;font-size:10px;color:#94a3b8; }
.onam { font-weight:700;color:var(--ink);font-size:12px; }
.oamt { font-family:'DM Mono',monospace;font-weight:700;color:var(--ink); }

.badge2 { display:inline-flex;align-items:center;gap:3px;padding:3px 9px;border-radius:999px;font-size:10px;font-weight:800;border:1px solid; }
.badge2.ok  { background:#f0fdf4;color:#166534;border-color:#bbf7d0; }
.badge2.pr  { background:#eff6ff;color:#1e40af;border-color:var(--blue-m); }
.badge2.pe  { background:#fffbeb;color:#92400e;border-color:#fde68a; }
.badge2.ca  { background:#fef2f2;color:#991b1b;border-color:#fecaca; }

/* ── TOP PRODUCTS ── */
.trow { display:flex;align-items:center;gap:10px;margin-bottom:14px; }
.trow:last-child { margin-bottom:0; }
.rbadge { width:27px;height:27px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:900;flex-shrink:0;border:1.5px solid; }
.r1 { background:#fef9c3;color:#854d0e;border-color:#fde68a; }
.r2 { background:#f1f5f9;color:#475569;border-color:#cbd5e1; }
.r3 { background:#fff7ed;color:#9a3412;border-color:#fed7aa; }
.r4,.r5 { background:#f8fafc;color:#94a3b8;border-color:var(--border); }
.tname  { font-size:12px;font-weight:700;color:var(--ink);line-height:1.3; }
.ttrack { height:4px;background:#f1f5f9;border-radius:999px;overflow:hidden;margin-top:4px; }
.tfill  { height:100%;border-radius:999px;background:linear-gradient(90deg,#a78bfa,#7c3aed); }
.tcnt   { font-family:'DM Mono',monospace;font-size:11px;font-weight:700;color:#64748b;flex-shrink:0; }

/* ── RATING ── */
.rstar { font-size:18px; }
.rstar.on { color:#f59e0b; } .rstar.off { color:#e2e8f0; }
.rbrow { display:flex;align-items:center;gap:5px;margin-bottom:5px; }
.rbtrack { flex:1;height:5px;background:#f1f5f9;border-radius:999px;overflow:hidden; }
.rbfill  { height:100%;border-radius:999px;background:linear-gradient(90deg,#fde68a,#f59e0b); }

/* ── FIN TILES ── */
.fg { display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px; }
.ft { border-radius:11px;padding:13px 15px;border:1.5px solid; }
.ft.gr { background:var(--green-l);border-color:#bbf7d0; }
.ft.rd { background:var(--red-l);border-color:#fecaca; }
.ft.bl { background:var(--blue-l);border-color:var(--blue-m); }
.ft-lbl { font-size:10px;font-weight:800;text-transform:uppercase;letter-spacing:.07em;margin-bottom:5px; }
.ft.gr .ft-lbl { color:var(--green); }  .ft.rd .ft-lbl { color:var(--red); }  .ft.bl .ft-lbl { color:var(--blue); }
.ft-val { font-size:15px;font-weight:900;font-family:'DM Mono',monospace; }
.ft.gr .ft-val { color:#166534; }  .ft.rd .ft-val { color:#991b1b; }  .ft.bl .ft-val { color:#1e40af; }

/* ── SUMMARY TILES ── */
.sg { display:grid;grid-template-columns:repeat(3,1fr);gap:8px; }
.st {
    border-radius:11px;padding:13px 8px;text-align:center;border:1.5px solid;
    text-decoration:none;transition:transform .15s,box-shadow .15s;display:block;
}
.st:hover { transform:translateY(-2px);box-shadow:0 6px 18px rgba(0,0,0,.07); }
.sv { font-size:20px;font-weight:900;letter-spacing:-.02em;line-height:1; }
.sn { font-size:10px;font-weight:700;margin-top:3px; }

/* ── ANIMATION ── */
.fu { opacity:0;transform:translateY(14px);animation:fadeUp .4s ease forwards; }
@keyframes fadeUp { to { opacity:1;transform:translateY(0); } }
.fu:nth-child(1){animation-delay:.04s} .fu:nth-child(2){animation-delay:.08s}
.fu:nth-child(3){animation-delay:.12s} .fu:nth-child(4){animation-delay:.16s}
</style>

<div class="dash">

    {{-- PAGE HEADER --}}
    <div class="dash-hdr">
        <div>
            <div class="dash-title">Dashboard</div>
            <div class="dash-sub">Selamat datang kembali — berikut ringkasan bisnis Anda hari ini.</div>
        </div>
        <div class="dash-date">
            <i class="fas fa-calendar-alt"></i>
            <span id="live-date"></span>
        </div>
    </div>

    {{-- ALERTS --}}
    @if($pendingOrders > 0 || $lowStockProducts > 0 || $pendingWithdrawals > 0 || $pendingMemberRequests > 0)
    <div class="alert-strip">
        @if($pendingOrders > 0)
        <a href="{{ route('orders.index') }}" class="apill am">
            <span class="adot am"></span> {{ $pendingOrders }} Pesanan Menunggu Konfirmasi
        </a>
        @endif
        @if($lowStockProducts > 0)
        <a href="{{ route('products.index') }}" class="apill rd">
            <span class="adot rd"></span> {{ $lowStockProducts }} Produk Stok Menipis
        </a>
        @endif
        @if($pendingWithdrawals > 0)
        <a href="" class="apill am">
            <span class="adot am"></span> {{ $pendingWithdrawals }} Withdrawal Menunggu
        </a>
        @endif
        @if($pendingMemberRequests > 0)
        <a href="{{ route('member-requests.index') }}" class="apill bl">
            <span class="adot bl"></span> {{ $pendingMemberRequests }} Member Request Baru
        </a>
        @endif
    </div>
    @endif

    {{-- KPI CARDS --}}
    <div class="kpi-grid">
        {{-- Revenue --}}
        <div class="kpi bl fu">
            <div class="kpi-top">
                <div class="kpi-ico bl"><i class="fas fa-chart-line"></i></div>
                @if($revenueGrowth >= 0)
                <span class="kbadge up"><i class="fas fa-arrow-up" style="font-size:8px;"></i> {{ $revenueGrowth }}%</span>
                @else
                <span class="kbadge dn"><i class="fas fa-arrow-down" style="font-size:8px;"></i> {{ abs($revenueGrowth) }}%</span>
                @endif
            </div>
            <div class="kpi-lbl">Total Revenue</div>
            <div class="kpi-val mono" style="font-size:17px;">Rp {{ number_format($totalRevenue,0,',','.') }}</div>
            <div class="kpi-hint">Bulan ini: <b>Rp {{ number_format($revenueThisMonth,0,',','.') }}</b></div>
        </div>

        {{-- Orders --}}
        <div class="kpi am fu">
            <div class="kpi-top">
                <div class="kpi-ico am"><i class="fas fa-shopping-bag"></i></div>
                <span class="kbadge neu">{{ $ordersThisMonth }} bln ini</span>
            </div>
            <div class="kpi-lbl">Total Pesanan</div>
            <div class="kpi-val">{{ number_format($totalOrders) }}</div>
            <div class="kpi-hint"><b style="color:#d97706;">{{ $pendingOrders }} pending</b> · {{ $processingOrders }} diproses</div>
        </div>

        {{-- Users --}}
        <div class="kpi pu fu">
            <div class="kpi-top">
                <div class="kpi-ico pu"><i class="fas fa-users"></i></div>
                @if($userGrowth >= 0)
                <span class="kbadge up"><i class="fas fa-arrow-up" style="font-size:8px;"></i> {{ $userGrowth }}%</span>
                @else
                <span class="kbadge dn"><i class="fas fa-arrow-down" style="font-size:8px;"></i> {{ abs($userGrowth) }}%</span>
                @endif
            </div>
            <div class="kpi-lbl">Total Pengguna</div>
            <div class="kpi-val">{{ number_format($totalUsers) }}</div>
            <div class="kpi-hint">+{{ $newUsersThisMonth }} pengguna baru bulan ini</div>
        </div>

        {{-- Products --}}
        <div class="kpi gr fu">
            <div class="kpi-top">
                <div class="kpi-ico gr"><i class="fas fa-box"></i></div>
                @if($outOfStockProducts > 0)
                <span class="kbadge dn">{{ $outOfStockProducts }} habis</span>
                @else
                <span class="kbadge up"><i class="fas fa-check" style="font-size:8px;"></i> Stok OK</span>
                @endif
            </div>
            <div class="kpi-lbl">Total Produk</div>
            <div class="kpi-val">{{ number_format($totalProducts) }}</div>
            <div class="kpi-hint">{{ $lowStockProducts }} produk stok menipis</div>
        </div>
    </div>

    {{-- ROW 2 — Chart + Status --}}
    <div class="sec-div">Analitik &amp; Distribusi</div>
    <div class="g2">

        {{-- Revenue Chart --}}
        <div class="panel">
            <div class="ph">
                <div class="ph-l">
                    <div class="pico bl"><i class="fas fa-chart-bar"></i></div>
                    <div>
                        <div class="ptitle">Revenue 6 Bulan Terakhir</div>
                        <div class="pdesc">Pendapatan dari pesanan selesai</div>
                    </div>
                </div>
            </div>
            <div class="pbody">
                @php $maxRev = collect($revenueChart)->max('revenue') ?: 1; @endphp
                <div style="display:flex;justify-content:space-between;margin-bottom:8px;padding:0 2px;">
                    <span style="font-size:10px;color:#cbd5e1;font-weight:600;">Rp {{ number_format($maxRev/1000000,1) }}jt</span>
                    <span style="font-size:10px;color:#cbd5e1;font-weight:600;">0</span>
                </div>
                <div class="chart-outer">
                    @foreach($revenueChart as $rc)
                    <div class="chart-col">
                        <div class="chart-bw">
                            <div class="chart-bar" style="height:{{ max(4, ($rc['revenue']/$maxRev)*130) }}px;">
                                <span class="ctt">Rp {{ number_format($rc['revenue'],0,',','.') }}</span>
                            </div>
                        </div>
                        <span class="chart-mo">{{ \Illuminate\Support\Str::substr($rc['month'],0,3) }}</span>
                        <span class="chart-cnt">{{ $rc['orders'] }}x</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Status Pesanan --}}
        <div class="panel">
            <div class="ph">
                <div class="ph-l">
                    <div class="pico am"><i class="fas fa-chart-pie"></i></div>
                    <div>
                        <div class="ptitle">Status Pesanan</div>
                        <div class="pdesc">Distribusi semua pesanan</div>
                    </div>
                </div>
            </div>
            <div class="pbody">
                @php $tot = max(1,$totalOrders); @endphp
                <div class="srow">
                    <div class="slabel"><span class="sdot" style="background:#22c55e;"></span>Selesai</div>
                    <div class="strack"><div class="sfill" style="width:{{ round(($completedOrders/$tot)*100) }}%;background:#22c55e;"></div></div>
                    <div class="scnt">{{ $completedOrders }}</div>
                </div>
                <div class="srow">
                    <div class="slabel"><span class="sdot" style="background:#3b82f6;"></span>Diproses</div>
                    <div class="strack"><div class="sfill" style="width:{{ round(($processingOrders/$tot)*100) }}%;background:#3b82f6;"></div></div>
                    <div class="scnt">{{ $processingOrders }}</div>
                </div>
                <div class="srow">
                    <div class="slabel"><span class="sdot" style="background:#f59e0b;"></span>Pending</div>
                    <div class="strack"><div class="sfill" style="width:{{ round(($pendingOrders/$tot)*100) }}%;background:#f59e0b;"></div></div>
                    <div class="scnt">{{ $pendingOrders }}</div>
                </div>
                <div class="srow" style="margin-bottom:0;">
                    <div class="slabel"><span class="sdot" style="background:#f87171;"></span>Dibatalkan</div>
                    <div class="strack"><div class="sfill" style="width:{{ round(($cancelledOrders/$tot)*100) }}%;background:#f87171;"></div></div>
                    <div class="scnt">{{ $cancelledOrders }}</div>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;padding-top:14px;border-top:1px solid #f1f5f9;margin-top:14px;">
                    <span style="font-size:11px;color:#94a3b8;font-weight:600;">Total Pesanan</span>
                    <span style="font-size:18px;font-weight:900;color:var(--ink);">{{ number_format($totalOrders) }}</span>
                </div>

                <div style="margin-top:10px;background:#f0fdf4;border:1.5px solid #bbf7d0;border-radius:10px;padding:10px 14px;display:flex;align-items:center;justify-content:space-between;">
                    <span style="font-size:11px;font-weight:700;color:#166534;">Completion Rate</span>
                    <span style="font-size:15px;font-weight:900;color:#16a34a;">{{ $totalOrders > 0 ? round(($completedOrders/$tot)*100) : 0 }}%</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ROW 3 — Orders Table + Top Products --}}
    <div class="sec-div">Transaksi &amp; Produk</div>
    <div class="g2">

        {{-- Orders Table --}}
        <div class="panel">
            <div class="ph">
                <div class="ph-l">
                    <div class="pico gr"><i class="fas fa-receipt"></i></div>
                    <div>
                        <div class="ptitle">Pesanan Terbaru</div>
                        <div class="pdesc">Transaksi paling baru</div>
                    </div>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="plink">Lihat semua →</a>
            </div>
            <div style="overflow-x:auto;">
                <table class="dtable">
                    <thead>
                        <tr>
                            <th>ID</th><th>Pelanggan</th><th>Total</th><th>Status</th><th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><span class="oid">#{{ $order->order_id }}</span></td>
                            <td><span class="onam">{{ optional($order->user)->username ?? 'Guest' }}</span></td>
                            <td><span class="oamt">Rp {{ number_format($order->total,0,',','.') }}</span></td>
                            <td>
                                @if($order->status === 'completed')
                                    <span class="badge2 ok"><i class="fas fa-check" style="font-size:8px;"></i> Selesai</span>
                                @elseif($order->status === 'processing')
                                    <span class="badge2 pr"><i class="fas fa-circle-notch fa-spin" style="font-size:8px;"></i> Diproses</span>
                                @elseif($order->status === 'pending')
                                    <span class="badge2 pe"><i class="fas fa-clock" style="font-size:8px;"></i> Pending</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge2 ca"><i class="fas fa-times" style="font-size:8px;"></i> Batal</span>
                                @else
                                    <span class="badge2" style="background:#f8fafc;color:#64748b;border-color:var(--border);">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td style="font-size:11px;color:#94a3b8;">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align:center;padding:36px;color:#94a3b8;">
                                <i class="fas fa-inbox" style="font-size:22px;display:block;margin-bottom:8px;"></i>
                                Belum ada pesanan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Products --}}
        <div class="panel">
            <div class="ph">
                <div class="ph-l">
                    <div class="pico pu"><i class="fas fa-trophy"></i></div>
                    <div>
                        <div class="ptitle">Produk Terlaris</div>
                        <div class="pdesc">Top 5 paling banyak terjual</div>
                    </div>
                </div>
                <a href="{{ route('products.index') }}" class="plink">Lihat →</a>
            </div>
            <div class="pbody">
                @php $maxSold = $topProducts->max('total_sold') ?: 1; @endphp
                @forelse($topProducts as $i => $tp)
                <div class="trow">
                    <div class="rbadge r{{ $i+1 }}">
                        @if($i === 0)<i class="fas fa-trophy" style="font-size:9px;"></i>
                        @elseif($i <= 2)<i class="fas fa-medal" style="font-size:9px;"></i>
                        @else {{ $i+1 }}
                        @endif
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div class="tname">{{ optional($tp->product)->product_name ?? '-' }}</div>
                        <div class="ttrack"><div class="tfill" style="width:{{ ($tp->total_sold/$maxSold)*100 }}%;"></div></div>
                    </div>
                    <div class="tcnt">{{ $tp->total_sold }}</div>
                </div>
                @empty
                <div style="text-align:center;padding:28px 0;color:#94a3b8;">
                    <i class="fas fa-box-open" style="font-size:22px;display:block;margin-bottom:8px;"></i>
                    Belum ada data penjualan
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ROW 4 — Finance + Rating + Summary --}}
    <div class="sec-div">Keuangan, Ulasan &amp; Data</div>
    <div class="g3">

        {{-- Finance --}}
        <div class="panel">
            <div class="ph">
                <div class="ph-l">
                    <div class="pico bl"><i class="fas fa-wallet"></i></div>
                    <div>
                        <div class="ptitle">Keuangan &amp; Saldo</div>
                        <div class="pdesc">Arus kas &amp; penarikan</div>
                    </div>
                </div>
                <a href="" class="plink">Kelola →</a>
            </div>
            <div class="pbody">
                <div class="fg">
                    <div class="ft gr">
                        <div class="ft-lbl">Saldo Masuk</div>
                        <div class="ft-val">Rp {{ number_format($totalSaldoIn/1000000,1) }}jt</div>
                    </div>
                    <div class="ft rd">
                        <div class="ft-lbl">Saldo Keluar</div>
                        <div class="ft-val">Rp {{ number_format($totalSaldoOut/1000000,1) }}jt</div>
                    </div>
                </div>
                <div class="ft bl" style="margin-bottom:10px;">
                    <div class="ft-lbl">Withdrawal Disetujui</div>
                    <div class="ft-val">Rp {{ number_format($totalWithdrawals,0,',','.') }}</div>
                </div>
                @if($pendingWithdrawals > 0)
                <div style="display:flex;align-items:center;gap:8px;background:var(--amber-l);border:1.5px solid #fde68a;border-radius:10px;padding:9px 13px;">
                    <i class="fas fa-exclamation-triangle" style="color:var(--amber);font-size:12px;"></i>
                    <span style="font-size:11px;font-weight:700;color:#92400e;">{{ $pendingWithdrawals }} withdrawal menunggu persetujuan</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Rating --}}
        <div class="panel">
            <div class="ph">
                <div class="ph-l">
                    <div class="pico am"><i class="fas fa-star"></i></div>
                    <div>
                        <div class="ptitle">Rating &amp; Ulasan</div>
                        <div class="pdesc">Kepuasan pelanggan</div>
                    </div>
                </div>
            </div>
            <div class="pbody">
                <div style="display:flex;align-items:flex-start;gap:18px;">
                    <div style="text-align:center;flex-shrink:0;">
                        <div style="font-size:44px;font-weight:900;color:var(--ink);letter-spacing:-.04em;line-height:1;">{{ number_format($avgRating,1) }}</div>
                        <div style="display:flex;gap:2px;justify-content:center;margin:6px 0 3px;">
                            @for($s=1;$s<=5;$s++)
                            <span class="rstar {{ $s <= round($avgRating) ? 'on' : 'off' }}">★</span>
                            @endfor
                        </div>
                        <div style="font-size:11px;color:#94a3b8;font-weight:600;">{{ number_format($totalRatings) }} ulasan</div>
                    </div>
                    <div style="flex:1;">
                        @for($r=5;$r>=1;$r--)
                        @php
                            $cnt = \App\Models\Ratings::where('rating',$r)->count();
                            $pct = $totalRatings > 0 ? ($cnt/$totalRatings)*100 : 0;
                        @endphp
                        <div class="rbrow">
                            <span style="font-size:10px;color:#94a3b8;width:10px;">{{ $r }}</span>
                            <div class="rbtrack"><div class="rbfill" style="width:{{ $pct }}%;"></div></div>
                            <span style="font-size:10px;color:#94a3b8;width:18px;text-align:right;">{{ $cnt }}</span>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary --}}
        <div class="panel">
            <div class="ph">
                <div class="ph-l">
                    <div class="pico gr"><i class="fas fa-th-large"></i></div>
                    <div>
                        <div class="ptitle">Ringkasan Data</div>
                        <div class="pdesc">Jumlah keseluruhan entitas</div>
                    </div>
                </div>
            </div>
            <div class="pbody">
                <div class="sg">
                    <a href="{{ route('categories.index') }}" class="st" style="background:#eff6ff;border-color:#bfdbfe;">
                        <div class="sv" style="color:#1d4ed8;">{{ $totalCategories }}</div>
                        <div class="sn" style="color:#3b82f6;">Kategori</div>
                    </a>
                    <a href="{{ route('services.index') }}" class="st" style="background:#f5f3ff;border-color:#ddd6fe;">
                        <div class="sv" style="color:#6d28d9;">{{ $totalServices }}</div>
                        <div class="sn" style="color:#7c3aed;">Layanan</div>
                    </a>
                    <a href="{{ route('portofolios.index') }}" class="st" style="background:#fdf4ff;border-color:#f0abfc;">
                        <div class="sv" style="color:#a21caf;">{{ $totalPortofolios }}</div>
                        <div class="sn" style="color:#c026d3;">Portfolio</div>
                    </a>
                    <div class="st" style="background:#f0fdf4;border-color:#bbf7d0;cursor:default;">
                        <div class="sv" style="color:#15803d;">{{ $completedOrders }}</div>
                        <div class="sn" style="color:#16a34a;">Selesai</div>
                    </div>
                    <div class="st" style="background:#fffbeb;border-color:#fde68a;cursor:default;">
                        <div class="sv" style="color:#b45309;">{{ $pendingMemberRequests }}</div>
                        <div class="sn" style="color:#d97706;">Req. Member</div>
                    </div>
                    <div class="st" style="background:#fef2f2;border-color:#fecaca;cursor:default;">
                        <div class="sv" style="color:#b91c1c;">{{ $outOfStockProducts }}</div>
                        <div class="sn" style="color:#dc2626;">Stok Habis</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
(function(){
    const d = new Date();
    const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
    document.getElementById('live-date').textContent =
        days[d.getDay()] + ', ' + d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
})();
</script>

@endsection